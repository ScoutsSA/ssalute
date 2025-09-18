<?php

namespace App\Models\Forms;

use App\Enums\Forms\Aam\AamStatuses;
use App\Enums\SystemDefinedRoles;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantApprovedEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantDeclinedEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantInitialEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApproverInitialEmail;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use App\Settings\FormSettings;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApplicationAdultMembershipRequest extends Model
{
    use HasFactory;

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'forms_aam_requests';
    protected $guarded = [];

    protected $casts = [
        'region_id' => 'int',
        'district_id' => 'int',
        'group_id' => 'int',
        'id' => 'int',
        'status' => AamStatuses::class,
        'email' => 'string',
        'first_name' => 'string',
        'other_names' => 'string',
        'surname' => 'string',
        'nickname' => 'string',
        'title' => UserTitle::class,
        'sex' => UserSex::class,
        'has_south_african_id' => 'boolean',
        'id_number' => 'string',
        'id_document' => 'string',
        'criminal_record' => 'string',
        'date_of_birth' => 'date',
        'passport_country' => 'string',
        'passport_date_of_issue' => 'date',
        'phone_number' => 'string',
        'residential_address' => 'string',
        'emergency_contact_name' => 'string',
        'emergency_contact_phone_number' => 'string',

        'medical_conditions' => 'string',
        'medical_aid_scheme_name' => 'string',
        'medical_aid_number' => 'string',
        'medical_aid_principal_member' => 'string',

        'has_given_public_media_consent' => 'boolean',
        'action_slug' => 'string',
        'view_slug' => 'string',

        'actioned_at' => 'datetime',
        'actioned_by' => 'int',
        'actioned_notes_internal' => 'string',
        'actioned_reason_external' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function (ApplicationAdultMembershipRequest $applicationAdultMembershipRequest) {
            $applicationAdultMembershipRequest->action_slug = Str::uuid();
            $applicationAdultMembershipRequest->view_slug = Str::uuid();
            $applicationAdultMembershipRequest->status ??= AamStatuses::PENDING->value;
            $applicationAdultMembershipRequest->medical_conditions ??= 'None';
        });
    }

    /*****************
     *  Relations
     *****************/

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function actionedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'actioned_by');
    }

    /*****************
     *  Attributes
     *****************/
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->surname,
        );
    }

    public function locationName(): Attribute
    {
        return Attribute::make(
            get: fn () => (($this->district?->name ?? 'No District') . ' | ' . ($this->group?->name ?? 'No Group'))
        );
    }

    public function actionableLink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('forms.aam.action', ['aamRequest' => $this->action_slug]),
        );
    }

    public function viewableLink(): Attribute
    {
        return Attribute::make(
            get: fn () => route('forms.aam.view', ['aamRequest' => $this->view_slug]),
        );
    }

    public function nextInLineScouter(): Attribute
    {
        return Attribute::make(
            get: function () {
                // National => National Adult Support Chair
                if ($this->region_id === null && $this->district_id === null && $this->group_id === null) {
                    $scouter = SystemUser::whereHas('activeRoles', static fn ($query) => $query->where('name', SystemDefinedRoles::NationalAdultSupport))->first();
                }

                // Regional => Regional Adult Support
                elseif ($this->district_id === null && $this->group_id === null) {
                    $regionId = $this->region_id ?? 0;
                    $scouter = SystemUser::whereHas('activeRoles', static function ($query) use ($regionId) {
                        $query->where('name', SystemDefinedRoles::RegionalAdultSupportCoordinator->value);
                        $query->where('system_users_other_roles.regionID', $regionId);
                    })->first();
                }

                // District => District Commissioner
                elseif ($this->group_id === null) {
                    $districtId = $this->district_id ?? 0;
                    $scouter = SystemUser::whereHas('activeRoles', static function ($query) use ($districtId) {
                        $query->where('name', SystemDefinedRoles::DistrictCommissioner->value);
                        $query->where('system_users_other_roles.districtID', $districtId);
                    })->first();
                }

                // Group => Group Scouter
                else {
                    $groupId = $this->group_id;
                    $scouter = SystemUser::whereHas('activeRoles', static function ($query) use ($groupId) {
                        $query->where('name', SystemDefinedRoles::ScoutGroupLeader->value);
                        $query->where('system_users_other_roles.groupID', $groupId);
                    })->first();
                }

                // If no scouter found, default to National Adult Support Chair and log a warning
                if (! $scouter) {
                    Log::warning('AAM Request - No NextInLineScouter Found, Defaulting to National Chair', ['aamRequestID' => $this->id, 'regionID' => $this->region_id, 'districtID' => $this->district_id, 'groupID' => $this->group_id]);
                    $scouter = SystemUser::whereHas('activeRoles', fn ($query) => $query->where('name', SystemDefinedRoles::NationalAdultSupport))->first();
                }

                return $scouter;
            },
        );
    }

    public function scoutersWhoCanApprove(): Attribute
    {
        return Attribute::make(
            get: function () {
                $scouters = collect();
                // National => National Adult Support Chair
                $scouters->add(SystemUser::whereHas('activeRoles', static fn ($query) => $query->where('name', SystemDefinedRoles::NationalAdultSupport))->first());

                // Regional => Regional Adult Support Team
                if ($this->region_id !== null) {
                    $regionId = $this->region_id;
                    foreach (SystemUser::whereHas('activeRoles', static function ($query) use ($regionId) {
                        $query->whereIn('name',
                            [
                                SystemDefinedRoles::RegionalAdultSupportCoordinator->value,
                                SystemDefinedRoles::RegionalAdultSupportTeamMember->value,
                                SystemDefinedRoles::RegionalAdultSupportTeamMemberGroup->value,
                            ]);
                        $query->where('system_users_other_roles.regionID', $regionId);
                    })->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                // District => District Commissioner(s)
                if ($this->district_id !== null) {
                    $districtId = $this->district_id;
                    foreach (SystemUser::whereHas('activeRoles', static function ($query) use ($districtId) {
                        $query->whereIn('name', [
                            SystemDefinedRoles::DistrictCommissioner->value,
                            SystemDefinedRoles::DistrictGroupManager->value,
                            SystemDefinedRoles::DistrictManager->value,
                        ]);
                        $query->where('system_users_other_roles.districtID', $districtId);
                    })->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                // Group => Group Scouter(s)
                if ($this->group_id !== null) {
                    $groupId = $this->group_id;
                    foreach (SystemUser::whereHas('activeRoles', static function ($query) use ($groupId) {
                        $query->where('name', SystemDefinedRoles::ScoutGroupLeader->value);
                        $query->where('system_users_other_roles.groupID', $groupId);
                    })->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                return $scouters;
            },
        );
    }

    public function sendEmailsInitial()
    {
        if ($this->status !== AamStatuses::PENDING) {
            return;
        }

        // Email applicant
        Mail::to($this->email)
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApplicantInitialEmail($this));

        // Email NextInLine (Group/District/Region)
        Mail::to($this->nextInLineScouter->username)
            ->cc($this->scoutersWhoCanApprove->map(fn (SystemUser $user) => $user->username)->toArray())
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApproverInitialEmail($this));
    }

    public function sendEmailsApproved()
    {
        if ($this->status !== AamStatuses::APPROVED) {
            return;
        }
        Mail::to($this->email)
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApplicantApprovedEmail($this));
    }

    public function sendEmailsDeclined()
    {
        if ($this->status !== AamStatuses::DECLINED) {
            return;
        }
        // Email applicant
        Mail::to($this->email)
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApplicantDeclinedEmail($this));
    }

    public function approve(SystemUser $actionedBy, string $externalReason, ?CarbonInterface $actionedAt = null, ?string $internalNotes = null)
    {
        if ($this->status !== AamStatuses::PENDING) {
            Log::warning('AAM Request - Attempt to Approve Non-Pending Request', ['aamRequestID' => $this->id, 'status' => $this->status, 'user_id' => auth()->id()]);

            return;
        }

        if (! $actionedAt) {
            $actionedAt = now();
        }
        $this->update([
            'actioned_by' => $actionedBy->getKey(),
            'actioned_at' => $actionedAt,
            'actioned_notes_internal' => $internalNotes,
            'actioned_reason_external' => $externalReason,
            'status' => AamStatuses::APPROVED,
        ]);

        $this->sendEmailsApproved();
        // ToDo - create system_user and maybe a user on our end
    }

    public function decline(SystemUser $actionedBy, string $externalReason, ?CarbonInterface $actionedAt = null, ?string $internalNotes = null)
    {
        if ($this->status !== AamStatuses::PENDING) {
            Log::warning('AAM Request - Attempt to Decline Non-Pending Request', ['aamRequestID' => $this->id, 'status' => $this->status, 'user_id' => auth()->id()]);

            return;
        }

        if (! $actionedAt) {
            $actionedAt = now();
        }

        $this->update([
            'actioned_by' => $actionedBy->getKey(),
            'actioned_at' => $actionedAt,
            'actioned_notes_internal' => $internalNotes,
            'actioned_reason_external' => $externalReason,
            'status' => AamStatuses::DECLINED,
        ]);

        $this->sendEmailsDeclined();
    }
}
