<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeBedsAllocation extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_beds_allocations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'subcampID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'bedID' => 'int',
        'active' => 'int',
    ];

}
