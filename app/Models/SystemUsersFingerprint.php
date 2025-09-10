<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemUsersFingerprint extends BaseModel
{
    public const UPDATED_AT = null;

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
