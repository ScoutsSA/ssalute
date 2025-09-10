<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemFinancialFeeType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_financial_fee_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'canBeProrated' => 'int',
        'active' => 'int',
    ];

}
