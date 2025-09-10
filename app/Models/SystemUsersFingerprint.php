<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemUsersFingerprint extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_fingerprint';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'agent' => 'string',
        'ipAddress' => 'string',
        'created' => 'datetime',
    ];

}
