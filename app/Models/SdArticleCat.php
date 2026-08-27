<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function articles(): HasMany
    {
        return $this->hasMany(SdArticle::class, 'catID');
    }
}
