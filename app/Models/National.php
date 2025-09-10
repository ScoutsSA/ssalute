<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class National extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'national';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'countryID' => 'int',
        'active' => 'int',
    ];

}
