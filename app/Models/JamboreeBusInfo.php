<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeBusInfo extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_bus_info';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'regionID' => 'int',
        'provider' => 'string',
        'totalBusCost' => 'float',
        'perSeatInvoiceAmountExVAT' => 'float',
        'busNr' => 'string',
        'availableSeats' => 'int',
        'departureLocation' => 'string',
        'departureDate' => 'date',
        'departureTime' => 'string',
        'arrivalLocation' => 'string',
        'arrivalDate' => 'date',
        'arrivalTime' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
