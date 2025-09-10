<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemUsersEmergencyContact extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_emergency_contacts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'contact1Title' => 'string',
        'contact1FirstName' => 'string',
        'contact1Surname' => 'string',
        'contact1Cell' => 'string',
        'contact1Home' => 'string',
        'contact1Work' => 'string',
        'contact1Relationship' => 'int',
        'contact2Title' => 'string',
        'contact2FirstName' => 'string',
        'contact12urname' => 'string',
        'contact2Cell' => 'string',
        'contact2Home' => 'string',
        'contact2Work' => 'string',
        'contact2Relationship' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
