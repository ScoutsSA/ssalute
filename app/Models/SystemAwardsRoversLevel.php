<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAwardsRoversLevel extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_awards_rovers_levels';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'description' => 'string',
        'htmlColor' => 'string',
    ];

}
