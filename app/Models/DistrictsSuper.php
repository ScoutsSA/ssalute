<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class DistrictsSuper extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'districts_super';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'active' => 'int',
        'accountID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
