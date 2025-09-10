<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupProgram extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'programAreaName' => 'string',
        'multiID' => 'int',
        'denID' => 'int',
        'packID' => 'int',
        'troopID' => 'int',
        'crewID' => 'int',
        'programType' => 'int',
        'meerkatProgramTypeID' => 'int',
        'cubProgramTypeID' => 'int',
        'scoutProgramTypeID' => 'int',
        'roverProgramTypeID' => 'int',
        'responsibleScouter' => 'int',
        'dutyPatrol' => 'int',
        'title' => 'string',
        'description' => 'string',
        'date' => 'date',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'document' => 'string',
        'active' => 'int',
        'shared' => 'int',
        'sharedby' => 'int',
        'sharedDate' => 'date',
        'roverProgramType' => 'int',
        'online' => 'int',
        'onlineActive' => 'int',
        'onlineEndDate' => 'date',
    ];

}
