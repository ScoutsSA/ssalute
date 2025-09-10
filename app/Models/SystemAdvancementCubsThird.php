<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAdvancementCubsThird extends BaseModel
{
    public $timestamps = false;

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_cubs_third';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'secondID' => 'int',
        'challenge' => 'string',
        'theme' => 'int',
        'note' => 'string',
        'name' => 'string',
        'description' => 'string',
        'short' => 'string',
        'campingTask' => 'int',
        'badgeTask' => 'int',
        'active' => 'int',
    ];

}
