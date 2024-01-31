<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Model;

class V2SystemUser extends Model
{
    protected $connection = 'sd_core';
    protected $table = 'system_users';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'int',
        'oldID' => 'int',
        'username' => 'string',
        'password' => 'string',
    ];
}
