<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemRoverTask extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_rover_tasks';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

}
