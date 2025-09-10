<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class ServicesPurchasedSpreadsheetsReceived extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'services_purchased_spreadsheets_received';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'receivedDate' => 'datetime',
        'location' => 'string',
        'addedBy' => 'int',
        'active' => 'int',
    ];

}
