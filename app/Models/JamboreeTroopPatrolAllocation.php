<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeTroopPatrolAllocation extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_troop_patrol_allocations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'roleID' => 'int',
        'active' => 'int',
        'notes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
