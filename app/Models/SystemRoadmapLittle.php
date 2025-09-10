<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemRoadmapLittle extends Model
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
