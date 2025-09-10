<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class DirectoryProfessionalLike extends BaseModel
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
