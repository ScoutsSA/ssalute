<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SupportChatsStart extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_chats_start';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'area' => 'int',
        'topic' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'closed' => 'int',
        'closedDate' => 'datetime',
        'closedBy' => 'int',
    ];

}
