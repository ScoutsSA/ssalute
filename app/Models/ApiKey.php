<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
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
