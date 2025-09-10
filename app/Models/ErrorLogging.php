<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class ErrorLogging extends BaseModel
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
