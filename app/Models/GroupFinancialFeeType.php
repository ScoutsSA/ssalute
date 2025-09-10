<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupFinancialFeeType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_financial_fee_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'name' => 'string',
        'description' => 'string',
        'canBeProrated' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
