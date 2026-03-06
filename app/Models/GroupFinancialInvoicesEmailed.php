<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'accountID');
    }

    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(GroupFinancialYear::class, 'financialYearID');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(GroupFinancialInvoice::class, 'invoiceID');
    }
}
