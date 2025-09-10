<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class DirectoryProfessionalLike extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'directory_professional_likes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'directoryID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
