<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdminBadLogon extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'admin_bad_logons';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'username' => 'string',
        'password' => 'string',
        'date' => 'datetime',
        'ip' => 'string',
        'userAgent' => 'string',
        'usingMobile' => 'int',
    ];

}
