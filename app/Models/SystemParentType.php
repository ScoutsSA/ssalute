<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemParentType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_parent_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];

}
