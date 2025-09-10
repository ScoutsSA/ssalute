<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdminGoodLogon extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'admin_good_logons';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'username' => 'string',
        'password' => 'string',
        'date' => 'datetime',
        'ip' => 'string',
        'roleID' => 'int',
        'fromSD' => 'int',
        'groupID' => 'int',
        'districtID' => 'int',
        'regionID' => 'int',
        'countryID' => 'int',
        'userAgent' => 'string',
        'usingMobile' => 'int',
    ];

}
