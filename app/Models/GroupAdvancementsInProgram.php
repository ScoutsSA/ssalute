<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupAdvancementsInProgram extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_advancements_in_programs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'scoutProgramTypeID' => 'int',
        'type' => 'string',
        'programID' => 'int',
        'firstID' => 'int',
        'secondID' => 'int',
        'thirdID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
