<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemCommitteeType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_committee_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}
