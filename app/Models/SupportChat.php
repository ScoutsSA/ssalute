<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SupportChat extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_chats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'supportID' => 'int',
        'userID' => 'int',
        'direction' => 'int',
        'chat' => 'string',
        'created' => 'datetime',
        'active' => 'int',
    ];

}
