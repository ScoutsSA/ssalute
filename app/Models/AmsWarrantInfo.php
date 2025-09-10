<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsWarrantInfo extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_warrant_info';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'roleID' => 'int',
        'warrantTypeID' => 'int',
        'warrantNr' => 'string',
        'warrantName' => 'string',
        'limited' => 'int',
        'appointment' => 'int',
        'PDFLocation' => 'string',
        'issueDate' => 'date',
        'expireDate' => 'date',
        'cancellationTypeID' => 'int',
        'cancelationNotes' => 'string',
        'expireEmailCount' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
