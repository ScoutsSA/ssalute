<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemUserLogging extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_user_logging';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'userID' => 'int',
        'page' => 'string',
        'IP' => 'string',
        'userAgent' => 'string',
        'post' => 'string',
        'created' => 'datetime',
    ];

}
