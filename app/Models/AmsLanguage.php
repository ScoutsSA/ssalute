<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsLanguage extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_languages';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'language' => 'string',
    ];

}
