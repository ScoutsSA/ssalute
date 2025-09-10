<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdvancementScout extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_scouts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'scoutProgramTypeID' => 'int',
        'scoutID' => 'int',
        'userID' => 'int',
        'themeID' => 'int',
        'advancementID' => 'int',
        'advancement2ID' => 'int',
        'advancementDate' => 'date',
        'notes' => 'string',
        'PDFLocation' => 'string',
        'latest' => 'int',
        'instructorsName' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'approvedDate' => 'datetime',
        'approvedBy' => 'int',
    ];

}
