<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SupportTicketStatus extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_ticket_status';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
    ];

}
