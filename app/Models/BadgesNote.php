<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class BadgesNote extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'badges_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'type' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'note' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'firstID' => 'int',
        'secondID' => 'int',
        'thirdID' => 'int',
        'active' => 'int',
    ];

}
