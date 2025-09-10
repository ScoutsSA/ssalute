<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SupportChatsType extends Model
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
