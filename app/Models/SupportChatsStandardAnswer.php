<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SupportChatsStandardAnswer extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_chats_standard_answers';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'answer' => 'string',
        'autoClose' => 'int',
        'active' => 'int',
    ];

}
