<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAwardsRoversLevel extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_awards_rovers_levels';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'description' => 'string',
        'htmlColor' => 'string',
    ];

}
