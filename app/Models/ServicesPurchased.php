<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ServicesPurchased extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'services_purchased';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'emailAddress' => 'string',
        'paymentType' => 'string',
        'amountInclVAT' => 'float',
        'serviceName' => 'string',
        'productDescription' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'processed' => 'int',
        'processedDate' => 'datetime',
        'cancelled' => 'int',
        'cancelledDate' => 'datetime',
        'groupID' => 'int',
        'associatedToGroupDate' => 'datetime',
        'associatedToGroupBy' => 'int',
        'startDate' => 'date',
        'endDate' => 'date',
    ];

}
