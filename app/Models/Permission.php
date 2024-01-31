<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    protected $casts = [
        'system_name' => 'string',
        'display_name' => 'string',
        'description' => 'string',
    ];
}
