<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
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
