<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupEditRecord extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_edit_record';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'fromData' => 'string',
        'toData' => 'string',
        'created' => 'datetime',
        'createdByID' => 'int',
    ];

}
