<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class InfoSharingLike extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing_likes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'infoID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
