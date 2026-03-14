<?php

namespace App\Models\Forms;

use App\Enums\Forms\Aam\AamStatuses;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantApprovedEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantDeclinedEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantInitialEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApproverActionedEmail;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApproverInitialEmail;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use App\Settings\FormSettings;
use App\Settings\GeneralSettings;
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
                $generalSettings = resolve(GeneralSettings::class);

                // National => National Adult Support Chair
                if ($this->region_id === null && $this->district_id === null && $this->group_id === null) {
                    $scouter = SystemUser::active()->whereHas('activeRoles', fn ($query) => $query->where('system_users_other_roles.roleID', $generalSettings->next_in_line_role_national))->first();
                }

                // Regional => Regional Adult Support
                elseif ($this->district_id === null && $this->group_id === null && $generalSettings->next_in_line_role_regional) {
                    $scouter = SystemUser::active()->whereHas('activeRoles', fn ($query) => $query
                        ->where('system_users_other_roles.roleID', $generalSettings->next_in_line_role_regional)
                        ->where('system_users_other_roles.regionID', $this->region_id)
                    )->first();
                }

                // District => District Commissioner
                elseif ($this->group_id === null && $generalSettings->next_in_line_role_district) {
                    $scouter = SystemUser::active()->whereHas('activeRoles', fn ($query) => $query
                        ->where('system_users_other_roles.roleID', $generalSettings->next_in_line_role_district)
                        ->where('system_users_other_roles.districtID', $this->district_id)
                    )->first();
                }

                // Group => Group Scouter
                elseif ($generalSettings->next_in_line_role_group) {
                    $scouter = SystemUser::active()->whereHas('activeRoles', fn ($query) => $query
                        ->where('system_users_other_roles.roleID', $generalSettings->next_in_line_role_group)
                        ->where('system_users_other_roles.groupID', $this->group_id)
                    )->first();
                }

                // If no scouter found, default to National Adult Support Chair and log a warning
                if (! $scouter) {
                    Log::warning('AAM Request - No NextInLineScouter Found, Defaulting to National Chair', ['aamRequestID' => $this->id, 'regionID' => $this->region_id, 'districtID' => $this->district_id, 'groupID' => $this->group_id]);
                    $scouter = SystemUser::active()->whereHas('activeRoles', fn ($query) => $query->where('system_users_other_roles.roleID', $generalSettings->next_in_line_role_national))->first();
                }

                return $scouter;
            },
        );
    }

    public function scoutersWhoCanApprove(): Attribute
    {
        return Attribute::make(
            get: function () {
                $formSettings = resolve(FormSettings::class);
                $scouters = collect();
                // National => National Adult Support Chair
                if (! empty($formSettings->aam_approval_role_national)) {
                    foreach (SystemUser::active()->whereHas('activeRoles', fn ($query) => $query->whereIn('system_users_other_roles.roleID', $formSettings->aam_approval_role_national))->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                // Regional => Regional Adult Support Team
                if ($this->region_id !== null && ! empty($formSettings->aam_approval_role_regional)) {
                    foreach (SystemUser::active()->whereHas('activeRoles', fn ($query) => $query
                        ->where('system_users_other_roles.regionID', $this->region_id)
                        ->whereIn('system_users_other_roles.roleID', $formSettings->aam_approval_role_regional)
                    )->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                // District => District Commissioner(s)
                if ($this->district_id !== null && ! empty($formSettings->aam_approval_role_district)) {
                    foreach (SystemUser::active()->whereHas('activeRoles', fn ($query) => $query
                        ->where('system_users_other_roles.districtID', $this->district_id)
                        ->whereIn('system_users_other_roles.roleID', $formSettings->aam_approval_role_district)
                    )->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                // Group => Group Scouter(s)
                if ($this->group_id !== null && ! empty($formSettings->aam_approval_role_group)) {
                    foreach (SystemUser::active()->whereHas('activeRoles', fn ($query) => $query
                        ->where('system_users_other_roles.groupID', $this->group_id)
                        ->whereIn('system_users_other_roles.roleID', $formSettings->aam_approval_role_group)
                    )->get() as $scouter) {
                        $scouters->add($scouter);
                    }
                }

                // Remove potential Duplicates
                $scouters = $scouters->unique('id');

                return $scouters;
            },
        );
    }

    public function sendEmailsInitial(): void
    {
        if ($this->status !== AamStatuses::PENDING) {
            return;
        }

        // Email applicant
        Mail::to($this->email)
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApplicantInitialEmail($this));

        // Email NextInLine (Group/District/Region)
        $nextInLineScouter = $this->nextInLineScouter;

        if ($nextInLineScouter) {
            Mail::to($nextInLineScouter->username)
                ->cc($this->scoutersWhoCanApprove
                    ->map(fn (SystemUser $user) => $user->username)
                    ->reject(fn ($email) => $email === $nextInLineScouter->username)
                    ->toArray())
                ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
                ->queue(new ApplicationAdultMembershipApproverInitialEmail($this));
        } else {
            Log::warning('AAM Request - No NextInLineScouter found, skipping approver initial email', ['aamRequestID' => $this->id]);
        }
    }

    public function sendEmailsApproved(): void
    {
        if ($this->status !== AamStatuses::APPROVED) {
            return;
        }
        // Email applicant
        Mail::to($this->email)
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApplicantApprovedEmail($this));

        // Email Approval Scouters
        Mail::to($this->scoutersWhoCanApprove
            ->map(fn (SystemUser $user) => $user->username)
            ->toArray())
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApproverActionedEmail($this));
    }

    public function sendEmailsDeclined(): void
    {
        if ($this->status !== AamStatuses::DECLINED) {
            return;
        }
        // Email applicant
        Mail::to($this->email)
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApplicantDeclinedEmail($this));

        // Email Approval Scouters
        Mail::to($this->scoutersWhoCanApprove
            ->map(fn (SystemUser $user) => $user->username)
            ->toArray())
            ->bcc(resolve(FormSettings::class)->aam_national_support_emails)
            ->queue(new ApplicationAdultMembershipApproverActionedEmail($this));
    }

    public function approve(SystemUser $actionedBy, string $externalReason, ?CarbonInterface $actionedAt = null, ?string $internalNotes = null): void
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

    public function decline(SystemUser $actionedBy, string $externalReason, ?CarbonInterface $actionedAt = null, ?string $internalNotes = null): void
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
