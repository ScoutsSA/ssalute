<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class ScouterReviewsLike extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'scouter_reviews_likes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'reviewID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
