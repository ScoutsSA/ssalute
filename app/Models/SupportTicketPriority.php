<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SupportTicketPriority extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_ticket_priorities';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
    ];

}
