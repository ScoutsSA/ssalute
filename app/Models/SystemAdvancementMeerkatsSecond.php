<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAdvancementMeerkatsSecond extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_meerkats_second';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'advancementArea' => 'string',
        'name' => 'string',
        'short' => 'string',
        'description' => 'string',
        'badgeTask' => 'int',
        'theme' => 'int',
        'active' => 'int',
    ];

}
