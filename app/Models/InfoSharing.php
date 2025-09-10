<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class InfoSharing extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'region' => 'int',
        'type' => 'int',
        'name' => 'string',
        'description' => 'string',
        'contactPerson' => 'string',
        'email' => 'string',
        'tel' => 'string',
        'website' => 'string',
        'address' => 'string',
        'gpsLat' => 'string',
        'gpsLon' => 'string',
        'active' => 'int',
        'approved' => 'int',
        'approvedby' => 'int',
        'approvedDate' => 'datetime',
        'declined' => 'int',
        'declinedby' => 'int',
        'declinedDate' => 'datetime',
        'declinedReason' => 'string',
        'declinedNotes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
