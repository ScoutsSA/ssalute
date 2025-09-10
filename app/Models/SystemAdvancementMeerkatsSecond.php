<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAdvancementMeerkatsSecond extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_meerkats_second';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'advancementArea' => 'string',
        'name' => 'string',
        'short' => 'string',
        'description' => 'string',
        'badgeTask' => 'int',
        'theme' => 'int',
        'active' => 'int',
    ];

}
