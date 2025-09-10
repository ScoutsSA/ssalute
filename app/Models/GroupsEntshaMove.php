<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupsEntshaMove extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_entsha_move';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
