<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAdvancementRoversSecond extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_rovers_second';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'theme' => 'int',
        'name' => 'string',
        'description' => 'string',
        'short' => 'string',
        'campingTask' => 'int',
        'badgeTask' => 'int',
        'active' => 'int',
    ];

}
