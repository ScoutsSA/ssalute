<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemUsersForcedLogout extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_forced_logouts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'date' => 'datetime',
        'userID' => 'int',
        'fromURL' => 'string',
        'toURL' => 'string',
        'IPAddress' => 'string',
        'extended' => 'string',
        'userAgent' => 'string',
    ];

}
