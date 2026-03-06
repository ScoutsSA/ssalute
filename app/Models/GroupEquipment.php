<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupEquipment extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_equipment';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'name' => 'string',
        'description' => 'string',
        'locationID' => 'int',
        'purchased' => 'int',
        'purchaseCost' => 'int',
        'replacementCost' => 'int',
        'totalPurchaseCost' => 'int',
        'totalReplacementCost' => 'int',
        'purchaseDate' => 'date',
        'purchaseLocation' => 'string',
        'qty' => 'int',
        'insured' => 'int',
        'expectedLifeFromPurchaseDate' => 'string',
        'assetCondition' => 'string',
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

    public function location(): BelongsTo
    {
        return $this->belongsTo(GroupEquipmentStore::class, 'locationID');
    }
}
