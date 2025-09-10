<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ScouterReviewsLike extends Model
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
