<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class Admin404Page extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'admin_404_pages';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'refURL' => 'string',
        'actualURL' => 'string',
        'created' => 'datetime',
    ];

}
