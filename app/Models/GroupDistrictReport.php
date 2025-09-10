<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupDistrictReport extends Model
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
