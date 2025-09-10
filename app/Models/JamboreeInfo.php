<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeInfo extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_info';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'year' => 'int',
        'currency' => 'string',
        'scoutCostExVAT' => 'float',
        'adultCostExVAT' => 'float',
        'kidCostExVAT' => 'float',
        'busDepositExVAT' => 'float',
        'depositPercent' => 'int',
        'active' => 'int',
    ];

}
