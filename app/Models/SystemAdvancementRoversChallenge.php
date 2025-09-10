<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAdvancementRoversChallenge extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_rovers_challenges';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
    ];

}
