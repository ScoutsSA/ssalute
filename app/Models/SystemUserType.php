<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    // This is only usable when eager loading the pivot relationship
    public function roleTypePivot(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (true) {
                    $this->regionalRole === 1 => $this->pivot->region,
                    $this->districtRole === 1 => $this->pivot->district,
                    $this->groupRole === 1 => $this->pivot->group,
                    default => null,
                };
            }
        );
    }

    // This is only usable when eager loading the pivot relationship
    public function roleTypePivotName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->roleTypeName . (is_null($this->roleTypePivot) ? '' : (': ' . $this->roleTypePivot->name));
            }
        );
    }
}
