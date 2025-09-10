<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAccountType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_account_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'active' => 'int',
    ];

}
