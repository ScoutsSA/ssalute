<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeEoi extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_eoi';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'userID' => 'int',
        'roleID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
