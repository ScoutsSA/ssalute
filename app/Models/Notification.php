<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'notifications';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'groupID' => 'int',
        'districtID' => 'int',
        'regionID' => 'int',
        'countryID' => 'int',
        'title' => 'string',
        'description' => 'string',
        'extended' => 'string',
        'colour' => 'string',
        'active' => 'int',
        'doNotShowBefore' => 'date',
        'doNotShowAfter' => 'date',
        'forType' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'shown' => 'int',
        'dismissDate' => 'datetime',
    ];

}
