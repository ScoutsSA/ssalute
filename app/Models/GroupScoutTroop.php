<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupScoutTroop extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_scout_troops';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'name' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
