<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupEditRecord extends BaseModel
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
