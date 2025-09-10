<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdminBannedIp extends Model
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
