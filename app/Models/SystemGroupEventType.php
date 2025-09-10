<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemGroupEventType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_group_event_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'active' => 'int',
        'groupType' => 'int',
        'districtType' => 'int',
        'regionalType' => 'int',
        'nationalType' => 'int',
    ];

}
