<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_user_types';
    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'sysAdmin' => 'bool',
        'nationalRole' => 'bool',
        'regionalRole' => 'bool',
        'superDistrictRole' => 'bool',
        'districtRole' => 'bool',
        'groupRole' => 'bool',
        'denRole' => 'bool',
        'packRole' => 'bool',
        'troopRole' => 'bool',
        'crewRole' => 'bool',
        'adultLeaderRole' => 'bool',
        'parentHelperRole' => 'bool',
        'alumniRole' => 'bool',
        'warrantedRole' => 'bool',
        'appointmentRole' => 'bool',
        'requiresCriminalClearance' => 'bool',
        'signsLeft' => 'int',
        'signsRight' => 'int',
        'chargeRole' => 'bool',
        'active' => 'bool',
        'position' => 'int',
        'canAdminAlumni' => 'bool',
        'canSeeAlumni' => 'bool',
        'canAdminNational' => 'bool',
        'canSeeNational' => 'bool',
        'canAdminRegion' => 'bool',
        'canSeeRegion' => 'bool',
        'canAdminRegionKids' => 'bool',
        'canAdminRegionTraining' => 'bool',
        'canAdminSuperDistrict' => 'bool',
        'canSeeSuperDistrict' => 'bool',
        'canAdminDistrict' => 'bool',
        'canSeeDistrict' => 'bool',
        'canAdminDistrictKids' => 'bool',
        'canAdminGroup' => 'bool',
        'canSeeGroup' => 'bool',
        'canAdminGroupAdults' => 'bool',
        'canAwardGroupMeerkats' => 'bool',
        'canAwardGroupCubs' => 'bool',
        'canAwardGroupScouts' => 'bool',
        'canAwardGroupRovers' => 'bool',
        'canSeeSupport' => 'bool',
        'canAdminSupport' => 'bool',
        'canAddWarrants' => 'bool',
        'canAdminProperty' => 'bool',
        'canSignWarrants' => 'bool',
        'canAdminForm29' => 'bool',
        'canAdminPoliceClearance' => 'bool',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',

    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
