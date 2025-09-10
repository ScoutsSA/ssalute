<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemBadgeCubsFirst extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_badge_cubs_first';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'type' => 'string',
        'note' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
