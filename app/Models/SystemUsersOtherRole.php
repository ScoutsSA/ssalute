<?php

namespace App\Models;

use App\Models\Concerns\MightHaveCreatedBy;
use App\Models\Concerns\MightHaveModifiedBy;
use App\Providers\AppServiceProvider;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SystemUsersOtherRole extends Pivot implements HasAvatar, HasCurrentTenantLabel, HasName
{
    use HasFactory;
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
                    default => '',
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
    public function roleScopedFullLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->roleTypeName . (is_null($this->roleScopedModel) ? '' : (': ' . $this->roleScopedModel->name));
            }
        );
    }

    public function roleScopedLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->roleScopedModel->name ?? null;
            }
        );
    }

    // Filament tenant display — shown in the sidebar tenant switcher list
    public function getFilamentName(): string
    {
        $scope = $this->roleScopedLabel;

        return $scope === null
            ? $this->role->name
            : $this->role->name . ' — ' . $scope;
    }

    // Filament tenant display — shown as the "current tenant" label above the switcher
    public function getCurrentTenantLabel(): string
    {
        return $this->roleTypeName;
    }

    // Filament tenant display — avatar shown in the sidebar tenant switcher
    public function getFilamentAvatarUrl(): ?string
    {
        [$abbreviation, $color] = match (true) {
            $this->role->sysAdmin === 1 => ['SYS',  '#7C3AED'],
            $this->role->nationalRole === 1 => ['NAT',  '#B91C1C'],
            $this->role->regionalRole === 1 => ['REG',  '#B45309'],
            $this->role->superDistrictRole === 1 => ['SD',   '#047857'],
            $this->role->districtRole === 1 => ['DIST', '#0369A1'],
            $this->role->groupRole === 1 => ['GRP',  '#1D4ED8'],
            $this->role->denRole === 1 => ['DEN',  '#6D28D9'],
            $this->role->packRole === 1 => ['PACK', '#0F766E'],
            $this->role->troopRole === 1 => ['TROOP', '#15803D'],
            $this->role->crewRole === 1 => ['CREW', '#B45309'],
            $this->role->adultLeaderRole === 1 => ['AL',   '#0E7490'],
            $this->role->parentHelperRole === 1 => ['PH',   '#7C3AED'],
            $this->role->alumniRole === 1 => ['ALU',  '#9D174D'],
            default => [':)',    '#6B7280'],
        };

        $svg = <<<SVG
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                <rect width="48" height="48" rx="6" fill="{$color}"/>
                <text x="24" y="24" font-family="ui-sans-serif,system-ui,sans-serif"
                      font-size="13" font-weight="700" text-anchor="middle"
                      dominant-baseline="central" fill="white">{$abbreviation}</text>
            </svg>
            SVG;

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
