<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemAssetCondition extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_asset_condition';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'active' => 'int',
    ];

}
