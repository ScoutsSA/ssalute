<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreePositionOffered extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_position_offered';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'userID' => 'int',
        'parentID' => 'int',
        'positionID' => 'int',
        'passportCountryID' => 'int',
        'passportCheck' => 'int',
        'notes' => 'string',
        'created' => 'datetime',
        'offeredPosition' => 'int',
        'offeredPositionDate' => 'datetime',
        'offeredPositionBy' => 'int',
    ];

}
