<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupEquipment extends Model
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

}
