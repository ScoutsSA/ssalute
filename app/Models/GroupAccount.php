<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupAccount extends Model
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

}
