<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class EventCompetitionScoreAdjudication extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competition_score_adjudication';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'teamID' => 'int',
        'scoringAreaID' => 'int',
        'adjudicationScore' => 'int',
        'active' => 'int',
        'notes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
