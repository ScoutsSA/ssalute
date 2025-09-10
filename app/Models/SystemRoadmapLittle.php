<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemRoadmapLittle extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_roadmap_little';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'area' => 'string',
        'text' => 'string',
        'releaseDate' => 'date',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
