<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupDistrictReport extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_district_reports';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'reportMonth' => 'date',
        'area' => 'string',
        'boys' => 'int',
        'girls' => 'int',
    ];

}
