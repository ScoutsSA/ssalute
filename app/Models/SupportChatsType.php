<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SupportChatsType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_chats_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

}
