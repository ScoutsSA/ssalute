<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AmsAdultLeaderMove extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_adult_leader_moves';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'userID' => 'int',
        'fromPosition' => 'int',
        'ToPosition' => 'int',
        'fromGroup' => 'int',
        'toGroup' => 'int',
        'fromDistrict' => 'int',
        'toDistrict' => 'int',
        'effectiveDate' => 'date',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
