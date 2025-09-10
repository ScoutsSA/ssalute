<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupDistrictReportsScout extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_district_reports_scouts';

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
        'jttBoys' => 'int',
        'jttGirls' => 'int',
        'lttBoys' => 'int',
        'lttGirls' => 'int',
        'leavingBoys' => 'int',
        'leavingGirls' => 'int',
        'toRoversBoys' => 'int',
        'toRoversGirls' => 'int',
        'usMale' => 'int',
        'usFemale' => 'int',
        'parentHelperMale' => 'int',
        'parentHelperFemale' => 'int',
        'committeeMale' => 'int',
        'committeeFemale' => 'int',
        'membershipBoys' => 'int',
        'membershipGirls' => 'int',
        'pfBoys' => 'int',
        'pfGirls' => 'int',
        'adBoys' => 'int',
        'adGirls' => 'int',
        'fcBoys' => 'int',
        'fcGirls' => 'int',
        'exBoys' => 'int',
        'exGirls' => 'int',
        'spBoys' => 'int',
        'spGirls' => 'int',
        'badgesBoys' => 'int',
        'badgesGirls' => 'int',
        'advBoys' => 'int',
        'advGirls' => 'int',
        'advancement' => 'string',
        'troopActivity' => 'string',
        'groupActivity' => 'string',
    ];

}
