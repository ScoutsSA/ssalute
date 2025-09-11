<?php

namespace App\Models\Forms;

use App\Enums\Forms\Aam\AamStatuses;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApplicationAdultMembershipRequest extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'forms_aam_requests';
    protected $guarded = [];

    protected $casts = [
        'region_id' => 'int',
        'district_id' => 'int',
        'group_id' => 'int',
        'id' => 'int',
        'status' => 'string',
        'email' => 'string',
        'first_name' => 'string',
        'other_names' => 'string',
        'surname' => 'string',
        'nickname' => 'string',
        'title' => 'string',
        'sex' => 'string',
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
        'approval_id' => 'string',

        'has_group_been_notified' => 'boolean',
        'has_district_been_notified' => 'boolean',
        'has_regional_been_notified' => 'boolean',
        'has_national_been_notified' => 'boolean',

        'approved_at' => 'datetime',
        'approved_by' => 'int',

        'declined_at' => 'datetime',
        'declined_by' => 'int',
        'declined_notes_internal' => 'string',
        'declined_reason' => 'string',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($query) {
            $query->action_slug = Str::random(90);
            $query->status = $query->status ?? AamStatuses::PENDING->value;
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

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'approved_by');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declined_by');
    }

    /*****************
     *  Attributes
     *****************/
    public function name(): Attribute
    {
        return Attribute::make(function () {
            return $this->first_name . ' ' . $this->surname;
        });
    }

    public function actionableLink(): Attribute
    {
        return Attribute::make(function () {
            return route('forms.register.adult.aam.view', ['aam_actionable_slug' => $this->action_slug]);
        });
    }
}
