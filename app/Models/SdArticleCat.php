<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SdArticleCat extends Model
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
