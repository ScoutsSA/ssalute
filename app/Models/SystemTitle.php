<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemTitle extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_titles';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'title' => 'string',
    ];

}
