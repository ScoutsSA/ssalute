<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class ApiKey extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'api_keys';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'key' => 'string',
        'issuedToUserID' => 'int',
        'information' => 'string',
        'active' => 'int',
        'created' => 'datetime',
    ];

}
