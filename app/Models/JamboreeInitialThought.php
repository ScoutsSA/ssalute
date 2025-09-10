<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeInitialThought extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_initial_thoughts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'userID' => 'int',
        'thought' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
