<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ApiUsage extends Model
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
