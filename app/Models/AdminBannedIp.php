<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdminBannedIp extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'admin_banned_ips';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'ip' => 'string',
        'date' => 'datetime',
        'page' => 'string',
    ];

}
