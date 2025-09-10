<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class EventCompetitionsInternalCompetition extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_internal_competitions';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'name' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
