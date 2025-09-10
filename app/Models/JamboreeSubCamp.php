<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeSubCamp extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_sub_camps';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

}
