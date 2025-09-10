<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAdvancementCubsThird extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_cubs_third';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'secondID' => 'int',
        'challenge' => 'string',
        'theme' => 'int',
        'note' => 'string',
        'name' => 'string',
        'description' => 'string',
        'short' => 'string',
        'campingTask' => 'int',
        'badgeTask' => 'int',
        'active' => 'int',
    ];

}
