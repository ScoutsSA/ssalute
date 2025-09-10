<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ServicesPurchasedSpreadsheetsReceived extends Model
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
