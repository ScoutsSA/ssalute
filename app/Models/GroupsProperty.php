<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupsProperty extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_property';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'districtID' => 'int',
        'regionID' => 'int',
        'countryID' => 'int',
        'ownedRented' => 'int',
        'landlordName' => 'string',
        'landlordContactPerson' => 'string',
        'landlordContactPersonCell' => 'string',
        'landlordContactPersonEmail' => 'string',
        'propertyDescription' => 'string',
        'ERFno' => 'string',
        'ERFSize' => 'string',
        'propertyValuation' => 'int',
        'lastValuationDate' => 'date',
        'improvementValue' => 'int',
        'leaseStartDate' => 'date',
        'leaseEndDate' => 'date',
        'leaseRenewalDate' => 'date',
        'leaseConditions' => 'string',
        'improvementsDescription' => 'string',
        'monthlyRentalAmount' => 'int',
        'monthlyRates' => 'int',
        'monthlyElectricity' => 'int',
        'monthlyWaterSewerage' => 'int',
        'insuranceCompany' => 'string',
        'insuranceContactPerson' => 'string',
        'insuranceContactPersonEmail' => 'string',
        'insuranceContactPersonCell' => 'string',
        'insuranceValue' => 'int',
        'insuranceDetails' => 'string',
        'groupNotes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
