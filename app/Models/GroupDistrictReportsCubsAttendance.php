<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupDistrictReportsCubsAttendance extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_district_reports_cubs_attendance';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'reportMonth' => 'string',
        'nr' => 'int',
        'date' => 'date',
        'strength' => 'int',
        'present' => 'int',
        'percent' => 'int',
        'comments' => 'string',
    ];

}
