<?php

namespace App\Models;

use App\Models\Concerns\IsAuditable;
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
use OwenIt\Auditing\Contracts\Auditable;

class SystemUsersOtherRole extends Pivot implements Auditable, HasAvatar, HasCurrentTenantLabel, HasName
{
    use HasFactory;
    use IsAuditable;
    use MightHaveCreatedBy;
    use MightHaveModifiedBy;

    const ?string CREATED_AT = 'created';
    const ?string UPDATED_AT = 'modified';

    public const int DEFAULT_COUNTRY_ID = 196;

    /**
     * Legacy `NOT NULL` columns and the value Scouts Digital writes when the level is "not set".
     * The legacy schema has no nulls in these columns: an unscoped level is 0, and the country
     * defaults to South Africa.
     *
     * @var array<string, int>
     */
    private const LEGACY_NOT_NULL_DEFAULTS = [
        'countryID' => self::DEFAULT_COUNTRY_ID,
        'regionID' => 0,
        'districtID' => 0,
        'groupID' => 0,
        'roleID' => 0,
        'defaultRole' => 0,
        'actionCountryID' => 0,
        'actionRegionID' => 0,
        'actionSuperDistrictID' => 0,
        'actionDistrictID' => 0,
        'actionGroupID' => 0,
        'retired' => 0,
        'resigned' => 0,
        'suspended' => 0,
        'multiID' => 0,
    ];

    /**
     * The legacy system writes each scope column into its `action*` twin when a role is attached,
     * and the warrant lookup reads the `action*` side, so a new attachment mirrors them.
     *
     * @var array<string, string>
     */
    private const ACTION_SCOPE_COLUMNS = [
        'countryID' => 'actionCountryID',
        'regionID' => 'actionRegionID',
        'superDistrictID' => 'actionSuperDistrictID',
        'districtID' => 'actionDistrictID',
        'groupID' => 'actionGroupID',
    ];

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

    protected static function booted(): void
    {
        static::saving(static function (self $roleAttachment): void {
            if (! $roleAttachment->exists) {
                $roleAttachment->mirrorScopeIntoActionScope();
            }

            $roleAttachment->coerceNullLegacyColumnsToDefaults();
        });
    }

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

    public function superDistrict(): BelongsTo
    {
        return $this->belongsTo(DistrictsSuper::class, 'superDistrictID');
    }

    public function actionRegion(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'actionRegionID');
    }

    public function actionSuperDistrict(): BelongsTo
    {
        return $this->belongsTo(DistrictsSuper::class, 'actionSuperDistrictID');
    }

    public function actionDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'actionDistrictID');
    }

    public function actionGroup(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'actionGroupID');
    }

    public function requiresWarrantOrAppointment(): bool
    {
        return $this->role->warrantedRole > 0 || $this->role->appointmentRole > 0;
    }

    public function hasValidWarrantOrAppointment(): bool
    {
        if (! $this->requiresWarrantOrAppointment()) {
            return true;
        }

        return AmsWarrantInfo::query()
            ->where('userID', $this->userID)
            ->where('countryID', $this->actionCountryID ?? 0)
            ->where('assocToRegion', $this->actionRegionID ?? 0)
            ->where('assocToDistrict', $this->actionDistrictID ?? 0)
            ->where('assocToGroup', $this->actionGroupID ?? 0)
            ->where('roleID', $this->roleID)
            ->where('active', 1)
            ->exists();
    }

    /**
     * The region this attachment sits in, walking up from a district or group scoped role and
     * falling back to the member's home region for roles with no area scope (national roles).
     */
    public function effectiveRegionId(): ?int
    {
        return $this->regionID
            ?: $this->district?->regionID
            ?: $this->group?->assoc_to_region
            ?: $this->user?->assoc_to_region
            ?: null;
    }

    public function effectiveDistrictId(): ?int
    {
        return $this->districtID
            ?: $this->group?->assoc_to_district
            ?: $this->user?->assoc_to_district
            ?: null;
    }

    public function effectiveGroupId(): ?int
    {
        return $this->groupID
            ?: $this->user?->assoc_to_group
            ?: null;
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

    /**
     * Filament posts null for a scope select left as "None"; the legacy schema rejects that, so
     * every null in a legacy NOT NULL column becomes the value Scouts Digital itself would write.
     */
    protected function coerceNullLegacyColumnsToDefaults(): void
    {
        foreach (self::LEGACY_NOT_NULL_DEFAULTS as $column => $default) {
            if (array_key_exists($column, $this->attributes) && $this->attributes[$column] === null) {
                $this->setAttribute($column, $default);
            }
        }
    }

    protected function mirrorScopeIntoActionScope(): void
    {
        foreach (self::ACTION_SCOPE_COLUMNS as $scopeColumn => $actionColumn) {
            if (($this->attributes[$actionColumn] ?? null) !== null) {
                continue;
            }

            $scope = $this->attributes[$scopeColumn] ?? null;

            $this->setAttribute($actionColumn, $scope ?? self::LEGACY_NOT_NULL_DEFAULTS[$scopeColumn] ?? 0);
        }
    }
}
