<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupAccount extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_accounts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'accountName' => 'string',
        'accountType' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'nationalAccount' => 'int',
        'regionalAccount' => 'int',
        'districtAccount' => 'int',
        'groupAccount' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

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

    public function invoices(): HasMany
    {
        return $this->hasMany(GroupFinancialInvoice::class, 'accountID', 'id');
    }

    public function creditNotes(): HasMany
    {
        return $this->hasMany(GroupFinancialCreditNote::class, 'accountID', 'id');
    }

    public function paymentsMade(): HasMany
    {
        return $this->hasMany(GroupFinancialPaymentsMade::class, 'accountID', 'id');
    }
}
