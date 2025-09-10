<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SdArticle extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'sd_articles';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'catID' => 'int',
        'groupID' => 'int',
        'title' => 'string',
        'slug' => 'string',
        'intro' => 'string',
        'article' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'string',
        'views' => 'int',
    ];

}
