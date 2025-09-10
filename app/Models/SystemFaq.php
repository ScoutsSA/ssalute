<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemFaq extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_faq';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'catID' => 'int',
        'targetID' => 'int',
        'q' => 'string',
        'a' => 'string',
        'active' => 'int',
        'position' => 'int',
    ];

}
