<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemGroupManagementLevel extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_group_management_level';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'type' => 'string',
        'name' => 'string',
        'description' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
