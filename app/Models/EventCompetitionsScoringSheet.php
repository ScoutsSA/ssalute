<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class EventCompetitionsScoringSheet extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_scoring_sheets';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'internalCompetitionID' => 'int',
        'name' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'startDate' => 'date',
        'startTime' => 'string',
        'endDate' => 'date',
        'endTime' => 'string',
        'usesGPS' => 'int',
        'pdf' => 'int',
        'registration' => 'int',
        'medicalScore' => 'int',
        'seaWorthynessScore' => 'int',
    ];

}
