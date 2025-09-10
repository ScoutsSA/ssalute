<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class InfoSharingType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

}
