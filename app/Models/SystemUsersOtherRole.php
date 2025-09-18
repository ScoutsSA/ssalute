<?php

namespace App\Models;

use App\Models\Concerns\MightHaveCreatedBy;
use App\Models\Concerns\MightHaveModifiedBy;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SystemUsersOtherRole extends Pivot
{
    use MightHaveCreatedBy;
    use MightHaveModifiedBy;

    const ?string CREATED_AT = 'created';
    const ?string UPDATED_AT = 'modified';

    public $incrementing = true;

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_other_roles';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'superDistrictID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'roleID' => 'int',
        'defaultRole' => 'int',
        'active' => 'int',
        'creationNotes' => 'string',
        'actionCountryID' => 'int',
        'actionRegionID' => 'int',
        'actionSuperDistrictID' => 'int',
        'actionDistrictID' => 'int',
        'actionGroupID' => 'int',
        'retired' => 'int',
        'resigned' => 'int',
        'suspended' => 'int',
        'multiID' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(SystemUserType::class, 'roleID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'regionID');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function roleTypeName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (true) {
                    $this->role->sysAdmin === 1 => 'System Administrator',
                    $this->role->nationalRole === 1 => 'National',
                    $this->role->regionalRole === 1 => 'Regional',
                    $this->role->superDistrictRole === 1 => 'Super District',
                    $this->role->districtRole === 1 => 'District',
                    $this->role->groupRole === 1 => 'Group',
                    $this->role->denRole === 1 => 'Den',
                    $this->role->packRole === 1 => 'Pack',
                    $this->role->troopRole === 1 => 'Troop',
                    $this->role->crewRole === 1 => 'Crew',
                    $this->role->adultLeaderRole === 1 => 'Adult Leader',
                    $this->role->parentHelperRole === 1 => 'Parent Helper',
                    $this->role->alumniRole === 1 => 'Alumni',
                    default => 'Unknown',
                };
            }
        );
    }

    public function roleScopedModel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (true) {
                    $this->role->regionalRole === 1 => $this->region,
                    $this->role->districtRole === 1 => $this->district,
                    $this->role->groupRole === 1 => $this->group,
                    default => null,
                };
            }
        );
    }

    // This is only usable when eager loading the pivot relationship
    public function roleScopedLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->roleTypeName . (is_null($this->roleScopedModel) ? '' : (': ' . $this->roleScopedModel->name));
            }
        );
    }

    public function roleAttachmentScopedLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->groupID !== 0) {
                    return 'Group: ' . $this->group->name;
                }
                if ($this->districtID !== 0) {
                    return 'District: ' . $this->district->name;
                }
                if ($this->regionID !== 0) {
                    return 'Region: ' . $this->region->name;
                }

                return 'Not Scoped';
            }
        );
    }
}
