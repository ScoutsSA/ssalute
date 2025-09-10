<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupDistrictReportsScoutsAttendance extends Model
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
