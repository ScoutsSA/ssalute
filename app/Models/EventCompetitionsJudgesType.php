<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class EventCompetitionsJudgesType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_judges_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'canAdmin' => 'int',
        'canCaptureScores' => 'int',
        'canAdminJudges' => 'int',
        'canAdminFinances' => 'int',
        'canAdminTeams' => 'int',
        'medical' => 'int',
        'seaWorthiness' => 'int',
        'active' => 'int',
    ];

}
