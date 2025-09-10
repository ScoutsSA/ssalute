<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeAdultAllocation extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_adult_allocations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'subCampID' => 'int',
        'activityCenterID' => 'int',
        'baseID' => 'int',
        'roleID' => 'int',
        'userID' => 'int',
        'notes' => 'string',
        'active' => 'int',
        'position' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
