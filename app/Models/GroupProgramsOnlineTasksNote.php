<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupProgramsOnlineTasksNote extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs_online_tasks_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programID' => 'int',
        'taskID' => 'int',
        'userID' => 'int',
        'note' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
