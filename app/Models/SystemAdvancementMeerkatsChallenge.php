<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAdvancementMeerkatsChallenge extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_meerkats_challenges';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'name' => 'string',
    ];

}
