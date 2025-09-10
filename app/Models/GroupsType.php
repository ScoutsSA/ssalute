<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupsType extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
    ];

}
