<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeInvoicesItem extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_invoices_items';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'invoiceID' => 'int',
        'applicantID' => 'int',
        'description' => 'string',
        'number' => 'int',
        'unitAmount' => 'float',
        'totalAmount' => 'float',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
