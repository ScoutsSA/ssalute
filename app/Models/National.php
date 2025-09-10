<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class National extends Model
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
