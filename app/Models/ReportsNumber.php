<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ReportsNumber extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'reports_numbers';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'month' => 'date',
        'meerkatsM' => 'int',
        'meerkatsF' => 'int',
        'cubsM' => 'int',
        'cubsF' => 'int',
        'scoutsM' => 'int',
        'scoutsF' => 'int',
        'roversM' => 'int',
        'roversF' => 'int',
        'adultsDenM' => 'int',
        'adultsDenF' => 'int',
        'adultsPackM' => 'int',
        'adultsPackF' => 'int',
        'adultsTroopM' => 'int',
        'adultsTroopF' => 'int',
        'adultsCrewM' => 'int',
        'adultsCrewF' => 'int',
        'adultsGroupM' => 'int',
        'adultsGroupF' => 'int',
        'committee' => 'int',
        'helpers' => 'int',
        'created' => 'datetime',
    ];

}
