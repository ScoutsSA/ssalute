<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class ApiUsage extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'api_usage';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'IPAddress' => 'string',
        'APICalled' => 'string',
        'userAgent' => 'string',
        'keyUsed' => 'string',
        'presented' => 'string',
        'response' => 'string',
        'created' => 'datetime',
    ];

}
