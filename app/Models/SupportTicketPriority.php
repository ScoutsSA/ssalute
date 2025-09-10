<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SupportTicketPriority extends Model
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
