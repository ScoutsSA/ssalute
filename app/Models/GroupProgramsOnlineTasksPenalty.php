<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupProgramsOnlineTasksPenalty extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs_online_tasks_penalty';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programID' => 'int',
        'taskID' => 'int',
        'userID' => 'int',
        'penalty' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
