<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeActivityCenterBase extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_activity_center_bases';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'centerID' => 'int',
        'name' => 'string',
        'active' => 'int',
        'concurrentPatrols' => 'int',
        'hoursLong' => 'float',
        'slots' => 'int',
    ];

}
