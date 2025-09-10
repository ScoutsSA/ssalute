<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupScoutsCharge extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_scouts_charges';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'scoutID' => 'int',
        'chargeID' => 'int',
        'chargeNr' => 'string',
        'awardDate' => 'date',
        'expireDate' => 'date',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
