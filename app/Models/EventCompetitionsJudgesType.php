<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class EventCompetitionsJudgesType extends Model
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
