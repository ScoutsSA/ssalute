<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemCountryName extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_country_names';

    protected $guarded = [];

    protected $casts = [
        'country_id' => 'int',
        'country_code' => 'string',
        'country_name' => 'string',
        'continent_name' => 'string',
        'region_name' => 'string',
        'usingSD' => 'int',
        'associationName' => 'string',
        'branch1Name' => 'string',
        'branch1ID' => 'int',
        'branch1StartingAge' => 'float',
        'branch1EndingAge' => 'float',
        'branch2Name' => 'string',
        'branch2ID' => 'int',
        'branch2StartingAge' => 'float',
        'branch2EndingAge' => 'float',
        'branch3Name' => 'string',
        'branch3ID' => 'int',
        'branch3StartingAge' => 'float',
        'branch3EndingAge' => 'float',
        'branch4Name' => 'string',
        'branch4ID' => 'int',
        'branch4StartingAge' => 'float',
        'branch4EndingAge' => 'float',
        'branch5Name' => 'string',
        'branch5ID' => 'int',
        'branch5StartingAge' => 'float',
        'branch5EndingAge' => 'float',
    ];

}
