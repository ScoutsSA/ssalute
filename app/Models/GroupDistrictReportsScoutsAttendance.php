<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupDistrictReportsScoutsAttendance extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_district_reports_scouts_attendance';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
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
