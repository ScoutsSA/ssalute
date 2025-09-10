<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemGroupEventType extends BaseModel
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
