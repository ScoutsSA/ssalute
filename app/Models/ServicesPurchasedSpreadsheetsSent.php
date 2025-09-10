<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ServicesPurchasedSpreadsheetsSent extends Model
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
