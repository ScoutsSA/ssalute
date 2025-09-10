<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupYouthCharge extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_youth_charges';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'type' => 'string',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'chargeTypeID' => 'int',
        'chargeNr' => 'string',
        'awardDate' => 'date',
        'expireDate' => 'date',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
