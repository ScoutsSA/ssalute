<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupsPropertyUpdate extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_property_updates';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'updatedby' => 'int',
        'updatedDate' => 'datetime',
    ];

}
