<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(SystemUser::class, 'system_users_other_roles', 'roleID', 'userID', 'id', 'id')
            ->using(SystemUsersOtherRole::class)
            ->withPivot(
                [
                    'id',
                    'regionID',
                    'superDistrictID',
                    'districtID',
                    'groupID',
                    'roleID',
                    'defaultRole',
                    'active',
                    'creationNotes',
                    'actionCountryID',
                    'actionRegionID',
                    'actionSuperDistrictID',
                    'actionDistrictID',
                    'actionGroupID',
                    'retired',
                    'resigned',
                    'suspended',
                    'multiID',
                    'created',
                    'createdby',
                    'modified',
                    'modifiedby',
                ]);
    }

    public function activeUsers(): BelongsToMany
    {
        return $this->users()
            ->wherePivot('active', 1);
        /* There seems to be a lot of bad data here, the below query SHOULD be correct but it filters out too many records
        ->wherePivot('retired', 0)
        ->wherePivot('resigned', 0)
        ->wherePivot('suspended', 0)*/
    }

    public function pastUsers()
    {
        return $this->users()
            ->wherePivot('active', 0);
        /* There seems to be a lot of bad data here, the below query SHOULD be correct but it filters out too many records
         ->where(function ($query) {
            $query->where('system_users_other_roles.retired', 1)
                ->orWhere('system_users_other_roles.resigned', 1)
                ->orWhere('system_users_other_roles.suspended', 1);
        })*/
    }

    public function roleTypeName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (true) {
                    $this->sysAdmin === 1 => 'System Administrator',
                    $this->nationalRole === 1 => 'National',
                    $this->regionalRole === 1 => 'Regional',
                    $this->superDistrictRole === 1 => 'Super District',
                    $this->districtRole === 1 => 'District',
                    $this->groupRole === 1 => 'Group',
                    $this->denRole === 1 => 'Den',
                    $this->packRole === 1 => 'Pack',
                    $this->troopRole === 1 => 'Troop',
                    $this->crewRole === 1 => 'Crew',
                    $this->adultLeaderRole === 1 => 'Adult Leader',
                    $this->parentHelperRole === 1 => 'Parent Helper',
                    $this->alumniRole === 1 => 'Alumni',
                    default => 'Unknown',
                };
            }
        );
    }
}
