<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class EventCompetitionsSurveyResponse extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_survey_responses';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'cookieID' => 'string',
        'userIP' => 'string',
        'teamName' => 'string',
        'initialRegistration' => 'int',
        'improveInitialRegistration' => 'string',
        'communicationPrior' => 'int',
        'improveCommunicationsPrior' => 'string',
        'communicationDuring' => 'int',
        'qualityCommunicationDuring' => 'int',
        'judging' => 'int',
        'judgesEngageWithPL' => 'int',
        'judgingSuggestions' => 'string',
        'improveCommunicationsDuring' => 'string',
        'improveJudging' => 'string',
        'suggestions' => 'string',
        'active' => 'int',
        'created' => 'datetime',
    ];

}
