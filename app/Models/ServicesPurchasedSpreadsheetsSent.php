<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class ServicesPurchasedSpreadsheetsSent extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'services_purchased_spreadsheets_sent';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'dateSent' => 'datetime',
        'sentBy' => 'int',
        'active' => 'int',
    ];

}
