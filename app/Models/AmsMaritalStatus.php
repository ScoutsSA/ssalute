<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AmsMaritalStatus extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_marital_status';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];

}
