<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeBedsAllocation extends Model
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
