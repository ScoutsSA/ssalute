<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemUsersPasswordsEmailed extends Model
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
