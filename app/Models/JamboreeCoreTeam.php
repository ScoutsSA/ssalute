<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeCoreTeam extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_core_team';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'userID' => 'int',
        'canAdmin' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
