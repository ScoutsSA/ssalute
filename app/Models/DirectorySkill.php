<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class DirectorySkill extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'directory_skills';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'skill' => 'string',
        'timesUsed' => 'int',
        'active' => 'int',
    ];

}
