<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class InfoSharingType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

}
