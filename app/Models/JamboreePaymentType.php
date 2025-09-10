<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreePaymentType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_payment_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'name' => 'string',
    ];

}
