<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeExprOfInterest extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_expr_of_interest';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
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
        'active' => 'int',
        'offeredPosition' => 'int',
        'offeredPositionDate' => 'datetime',
        'offeredPositionBy' => 'int',
        'declinedPosition' => 'int',
        'declinedPositionDate' => 'datetime',
        'declinedPositionBy' => 'int',
        'declinedReason' => 'string',
    ];

}
