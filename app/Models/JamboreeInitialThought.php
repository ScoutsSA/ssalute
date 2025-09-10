<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeInitialThought extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_initial_thoughts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'userID' => 'int',
        'thought' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
