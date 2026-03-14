<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(SdArticleCat::class, 'catID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }
}
