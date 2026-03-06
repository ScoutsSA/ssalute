<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupFinancialPaymentsMade extends BaseModel
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

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(GroupFinancialInvoice::class, 'invoiceID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'assocToDistrict');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'accountID');
    }
}
