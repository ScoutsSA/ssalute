<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupsPropertyOwnershipType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_property_ownership_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'owned' => 'int',
        'rented' => 'int',
        'active' => 'int',
    ];

}
