<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SupportChatsStart extends Model
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
