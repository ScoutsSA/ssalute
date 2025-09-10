<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemTitle extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_titles';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'title' => 'string',
    ];

}
