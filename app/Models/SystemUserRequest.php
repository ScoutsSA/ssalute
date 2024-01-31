<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemUserRequest extends Model
{
    protected $connection = 'mysql';
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'email' => 'string',
        'first_name' => 'string',
        'other_names' => 'string',
        'surname' => 'string',
        'nickname' => 'string',
        'title' => 'string',
        'sex' => 'string',
        'id_number' => 'string',
        'date_of_birth' => 'date',
        'passport_country' => 'string',
        'passport_date_of_issue' => 'date',
        'phone_number' => 'string',
        'residential_address' => 'string',
        'emergency_contact_name' => 'string',
        'emergency_contact_phone_number' => 'string',
        'id_document_file' => 'string',
        'has_given_public_media_consent' => 'boolean',
        'requested_system_user_type_id' => 'int',
        'region_id' => 'int',
        'district_id' => 'int',
        'group_id' => 'int',
    ];
}
