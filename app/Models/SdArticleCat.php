<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SdArticleCat extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'sd_article_cats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'slug' => 'string',
    ];

}
