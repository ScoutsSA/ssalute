<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class StarAward extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'star_awards';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'year' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'denID' => 'int',
        'packID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'crewID' => 'int',
        'scouterAskedAward' => 'string',
        'scouterAskedAwardDate' => 'datetime',
        'scouterAskedAwardUserID' => 'int',
        'scouterMotivation' => 'string',
        'nptmRecommended' => 'string',
        'nptmAskedAwardDate' => 'datetime',
        'nptmAskedAwardUserID' => 'int',
        'nptmMotivation' => 'string',
        'rtcRecommended' => 'string',
        'rtcRecommendedDate' => 'datetime',
        'rtcRecommendedUserID' => 'int',
        'rtcMotivation' => 'string',
        'chairAwarded' => 'int',
        'chairAwardedDate' => 'datetime',
        'chairAwardedUserID' => 'int',
        'active' => 'int',
    ];

}
