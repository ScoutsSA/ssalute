<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class Wsm16Expression extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'wsm16_expression';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'roleID' => 'int',
        'active' => 'int',
        'passportCountryID' => 'int',
        'passportChecked' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'applyRoleID' => 'int',
        'invested' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
