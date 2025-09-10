<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupFinancialPaymentsMade extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_financial_payments_made';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'invoiceID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'accountID' => 'int',
        'amount' => 'float',
        'payment_date' => 'date',
        'paymentType' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
