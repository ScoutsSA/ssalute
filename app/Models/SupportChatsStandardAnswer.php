<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SupportChatsStandardAnswer extends BaseModel
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
