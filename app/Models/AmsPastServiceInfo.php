<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AmsPastServiceInfo extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_past_service_info';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'userID' => 'int',
        'pastServiceType' => 'int',
        'assocToGroup' => 'int',
        'startDate' => 'date',
        'endDate' => 'date',
        'otherRegionName' => 'string',
        'otherDistrictName' => 'string',
        'otherGroupName' => 'string',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'toBeFixed' => 'int',
    ];

}
