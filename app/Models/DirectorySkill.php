<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class DirectorySkill extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'directory_skills';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'skill' => 'string',
        'timesUsed' => 'int',
        'active' => 'int',
    ];

}
