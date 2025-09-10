<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupDistrictReportsCub extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_district_reports_cubs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'reportMonth' => 'date',
        'LastMonth' => 'date',
        'lastMonthBoys' => 'int',
        'lastMonthGirls' => 'int',
        'thisMonthBoys' => 'int',
        'thisMonthGirls' => 'int',
        'jtpBoys' => 'int',
        'jtpGirls' => 'int',
        'ltpBoys' => 'int',
        'ltpGirls' => 'int',
        'leavingBoys' => 'int',
        'leavingGirls' => 'int',
        'toScoutsBoys' => 'int',
        'toScoutsGirls' => 'int',
        'usMale' => 'int',
        'usFemale' => 'int',
        'parentHelperMale' => 'int',
        'parentHelperFemale' => 'int',
        'committeeMale' => 'int',
        'committeeFemale' => 'int',
        'membershipBoys' => 'int',
        'membershipGirls' => 'int',
        'swBoys' => 'int',
        'swGirls' => 'int',
        'gwBoys' => 'int',
        'gwGirls' => 'int',
        'lwBoys' => 'int',
        'lwGirls' => 'int',
        'badgesBoys' => 'int',
        'badgesGirls' => 'int',
        'advBoys' => 'int',
        'advGirls' => 'int',
        'advancement' => 'string',
        'packActivity' => 'string',
        'groupActivity' => 'string',
    ];

}
