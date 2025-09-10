<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemUserType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_user_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'sysAdmin' => 'int',
        'nationalRole' => 'int',
        'regionalRole' => 'int',
        'superDistrictRole' => 'int',
        'districtRole' => 'int',
        'groupRole' => 'int',
        'denRole' => 'int',
        'packRole' => 'int',
        'troopRole' => 'int',
        'crewRole' => 'int',
        'adultLeaderRole' => 'int',
        'parentHelperRole' => 'int',
        'alumniRole' => 'int',
        'warrantedRole' => 'int',
        'appointmentRole' => 'int',
        'requiresCriminalClearance' => 'int',
        'signsLeft' => 'int',
        'signsRight' => 'int',
        'chargeRole' => 'int',
        'active' => 'int',
        'position' => 'int',
        'canAdminAlumni' => 'int',
        'canSeeAlumni' => 'int',
        'canAdminNational' => 'int',
        'canSeeNational' => 'int',
        'canAdminRegion' => 'int',
        'canSeeRegion' => 'int',
        'canAdminRegionKids' => 'int',
        'canAdminRegionTraining' => 'int',
        'canAdminSuperDistrict' => 'int',
        'canSeeSuperDistrict' => 'int',
        'canAdminDistrict' => 'int',
        'canSeeDistrict' => 'int',
        'canAdminDistrictKids' => 'int',
        'canAdminGroup' => 'int',
        'canSeeGroup' => 'int',
        'canAdminGroupAdults' => 'int',
        'canAwardGroupMeerkats' => 'int',
        'canAwardGroupCubs' => 'int',
        'canAwardGroupScouts' => 'int',
        'canAwardGroupRovers' => 'int',
        'canSeeSupport' => 'int',
        'canAdminSupport' => 'int',
        'canAddWarrants' => 'int',
        'canAdminProperty' => 'int',
        'canSignWarrants' => 'int',
        'canAdminForm29' => 'int',
        'canAdminPoliceClearance' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}
