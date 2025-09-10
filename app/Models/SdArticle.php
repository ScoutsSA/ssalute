<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SdArticle extends Model
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
