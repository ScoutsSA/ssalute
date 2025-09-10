<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeBusesUser extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_buses_users';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'userID' => 'int',
        'busID' => 'int',
        'notes' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
