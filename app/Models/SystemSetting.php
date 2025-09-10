<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_settings';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'maintenance' => 'int',
    ];

}
