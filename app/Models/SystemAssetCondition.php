<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAssetCondition extends BaseModel
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
