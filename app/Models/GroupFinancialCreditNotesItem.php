<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupFinancialCreditNotesItem extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_financial_credit_notes_items';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'invoiceID' => 'int',
        'creditNoteID' => 'int',
        'assocToGroup' => 'int',
        'accountID' => 'int',
        'financialYearID' => 'int',
        'feeArea' => 'string',
        'name' => 'string',
        'description' => 'string',
        'amount' => 'float',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
