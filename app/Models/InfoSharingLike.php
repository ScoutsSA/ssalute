<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class InfoSharingLike extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing_likes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'infoID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
