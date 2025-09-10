<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsWarrantApplication extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_warrant_applications';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'warrantTypeID' => 'int',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'awardDate' => 'datetime',
        'awardedBy' => 'int',
        'declinedDate' => 'datetime',
        'declinedBy' => 'int',
        'awardType' => 'string',
        'awardDescription' => 'string',
    ];

}
