<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemSetting extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_settings';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'maintenance' => 'int',
    ];

}
