<?php

namespace App\Models\V3;

use App\Constants\AamStatuses;
use App\Models\V2\V2District;
use App\Models\V2\V2Group;
use App\Models\V2\V2Region;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class V3ApplicationAdultMembershipRequest extends Model
{
    protected $connection = 'v3_core';
    protected $table = 'application_adult_membership_requests';
    protected $guarded = [];

    protected $casts = [
        'sd_region_id' => 'int',
        'sd_district_id' => 'int',
        'sd_group_id' => 'int',
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
            $query->status = $query->status ?? AamStatuses::PENDING;
        });
    }

    /*****************
     *  Relations
     *****************/

    public function v2Region(): BelongsTo
    {
        return $this->belongsTo(V2Region::class, 'sd_region_id');
    }

    public function v2District(): BelongsTo
    {
        return $this->belongsTo(V2District::class, 'sd_district_id');
    }

    public function v2Group(): BelongsTo
    {
        return $this->belongsTo(V2Group::class, 'sd_group_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(V3User::class, 'approved_by');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(V3User::class, 'declined_by');
    }

    /*****************
     *  Attributes
     *****************/
    public function name(): Attribute
    {
        return new Attribute(function () {
            return $this->first_name . ' ' . $this->surname;
        });
    }

    public function actionableLink(): Attribute
    {
        return new Attribute(function () {
            return route('register.adult.aam.view', ['aam_actionable_slug' => $this->action_slug]);
        });
    }
}
