<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ErrorLogging extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'error_logging';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'page' => 'string',
        'POST' => 'string',
        'errorsFound' => 'string',
        'userID' => 'int',
        'roleID' => 'int',
        'nationalID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'created' => 'datetime',
    ];

}
