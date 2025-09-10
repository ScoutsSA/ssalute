<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupProgramsOnlineTask extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs_online_tasks';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programID' => 'int',
        'position' => 'int',
        'task' => 'string',
        'needs' => 'string',
        'description' => 'string',
        'PDFLocation' => 'string',
        'advancementID' => 'int',
        'badgeID' => 'int',
        'points' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
