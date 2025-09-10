<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupFinancialInvoicesEmailed extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_financial_invoices_emailed';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'accountID' => 'int',
        'financialYearID' => 'int',
        'invoiceID' => 'int',
        'sentDate' => 'datetime',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
