<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsAdultLeaderMove extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_adult_leader_moves';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'userID' => 'int',
        'fromPosition' => 'int',
        'ToPosition' => 'int',
        'fromGroup' => 'int',
        'toGroup' => 'int',
        'fromDistrict' => 'int',
        'toDistrict' => 'int',
        'effectiveDate' => 'date',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
