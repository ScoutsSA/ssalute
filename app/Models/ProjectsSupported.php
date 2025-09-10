<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ProjectsSupported extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'projects_supported';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'projectID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
