<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class Project extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'projects';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'projectForID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'typeID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'aim' => 'string',
        'startDate' => 'date',
        'endDate' => 'date',
        'document' => 'string',
        'contactPerson' => 'string',
        'contactEmail' => 'string',
        'contactCell' => 'string',
        'contactWebsite' => 'string',
        'active' => 'int',
        'approved' => 'int',
        'approvedby' => 'int',
        'approveddate' => 'datetime',
        'declined' => 'int',
        'declinedby' => 'int',
        'declineddate' => 'datetime',
        'declinedReason' => 'string',
        'declinedNotes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
