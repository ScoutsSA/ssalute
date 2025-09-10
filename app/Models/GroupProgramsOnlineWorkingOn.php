<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupProgramsOnlineWorkingOn extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs_online_working_on';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programID' => 'int',
        'userID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
