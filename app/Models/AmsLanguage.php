<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AmsLanguage extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_languages';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'language' => 'string',
    ];

}
