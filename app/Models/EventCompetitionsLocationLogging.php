<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class EventCompetitionsLocationLogging extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_location_logging';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'groupID' => 'int',
        'districtID' => 'int',
        'regionID' => 'int',
        'roleID' => 'int',
        'userID' => 'int',
        'userAgent' => 'string',
        'accuracy' => 'float',
        'altitude' => 'float',
        'altitudeAccuracy' => 'string',
        'heading' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'speedDone' => 'int',
        'date' => 'date',
        'active' => 'int',
        'created' => 'datetime',
        'used' => 'int',
    ];

}
