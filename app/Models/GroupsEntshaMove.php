<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupsEntshaMove extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_entsha_move';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
