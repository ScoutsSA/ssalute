<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemUsersOtherRole extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_other_roles';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'superDistrictID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'roleID' => 'int',
        'defaultRole' => 'int',
        'active' => 'int',
        'creationNotes' => 'string',
        'actionCountryID' => 'int',
        'actionRegionID' => 'int',
        'actionSuperDistrictID' => 'int',
        'actionDistrictID' => 'int',
        'actionGroupID' => 'int',
        'retired' => 'int',
        'resigned' => 'int',
        'suspended' => 'int',
        'multiID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
