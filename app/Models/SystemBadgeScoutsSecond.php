<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemBadgeScoutsSecond extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_badge_scouts_second';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'firstID' => 'int',
        'heading' => 'string',
        'task' => 'string',
        'position' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
