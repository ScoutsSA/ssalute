<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupSendLogonDetail extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_send_logon_details';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
