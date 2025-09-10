<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemUsersPasswordsEmailed extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_passwords_emailed';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'username' => 'string',
        'date' => 'datetime',
        'emailed' => 'string',
    ];

}
