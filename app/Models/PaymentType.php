<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'payment_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];

}
