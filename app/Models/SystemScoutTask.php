<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemScoutTask extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_scout_tasks';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

}
