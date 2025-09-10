<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class EventCompetitionsGp extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_gps';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'GPSLong' => 'float',
        'GPSLat' => 'float',
        'position' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
