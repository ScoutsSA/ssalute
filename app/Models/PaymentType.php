<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class PaymentType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'payment_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];

}
