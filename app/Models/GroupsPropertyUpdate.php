<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupsPropertyUpdate extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_property_updates';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'updatedby' => 'int',
        'updatedDate' => 'datetime',
    ];

}
