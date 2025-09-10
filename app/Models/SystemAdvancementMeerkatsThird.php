<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAdvancementMeerkatsThird extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_meerkats_third';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'secondID' => 'int',
        'challenge' => 'int',
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
