<?php

namespace App\Models\Forms;

use App\Enums\Forms\Aam\AamStatuses;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
            get: fn () => ($this->title->value . ' ' . $this->first_name . ' ' . $this->surname)
        );
    }

    public function locationName(): Attribute
    {
        return Attribute::make(
            get: fn () => (($this->region?->name ?? 'No Region') . ' | ' . ($this->district?->name ?? 'No District') . ' | ' . ($this->group?->name ?? 'No Group'))
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
                    return SystemUser::whereHas('role', 'like', '%national%')
                        ->first();
                }
                // Regional => Regional Adult Support
                // District => District Commissioner
                // Group => Group Scouter

                return SystemUser::inRandomOrder()->first();
            },
        );
    }
}
