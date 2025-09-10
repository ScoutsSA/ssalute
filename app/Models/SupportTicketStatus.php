<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SupportTicketStatus extends Model
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
