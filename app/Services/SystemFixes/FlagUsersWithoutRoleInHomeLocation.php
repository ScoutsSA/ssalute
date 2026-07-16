<?php

namespace App\Services\SystemFixes;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Flags active users whose active roles have drifted away from their home location.
 *
 * Members are moved between groups/districts/regions on the user record (assoc_to_group / assoc_to_district
 * / assoc_to_region), but a role that carries its own area is not always moved with them. A member may
 * legitimately hold roles across several areas, so a single off-home role is not itself a problem; the
 * invariant is weaker: a user should have at least one active role anchored at their home location. When
 * none of a user's active area-scoped roles sit at home, the member has effectively no role where they now
 * are, and support needs to reconcile it.
 *
 * "Anchored" is tier-aligned: a group or section role anchors when its group is the user's assoc_to_group,
 * a district role when its district is the user's assoc_to_district, a region role when its region is the
 * user's assoc_to_region. Roles that carry no area of their own (national, self, adult-leader, etc.) are
 * ignored, as are users with no home location at all (nothing to anchor to).
 *
 * This fix only reports: whether to move a stale role or correct the user's location is a judgement call,
 * so every finding is raised for admin attention and no data is changed.
 */
class FlagUsersWithoutRoleInHomeLocation implements SystemFix
{
    /**
     * Cap on the number of findings rendered into the Slack alert. Every finding is logged individually
     * regardless, so the full set is always recoverable; this only keeps the alert body readable.
     */
    private const ALERT_SAMPLE_LIMIT = 25;

    /** @var array<string, array<int, ?string>> */
    private array $areaNameCache = [];

    public function label(): string
    {
        return 'Flag active users with no active role in their home location';
    }

    public function settingKey(): string
    {
        return 'flag_users_without_role_in_home_location_enabled';
    }

    public function notificationSettingKey(): string
    {
        return 'flag_users_without_role_in_home_location_notifications';
    }

    public function run(): SystemFixResult
    {
        $userIds = $this->usersNeedingAttention();

        if ($userIds->isEmpty()) {
            return new SystemFixResult(
                $this->label(),
                'Every active user with area-scoped roles has at least one role in their home location.',
            );
        }

        $descriptions = $this->describe($userIds);

        $summary = sprintf(
            'Flagged %d %s with no active role in their home location.',
            $descriptions->count(),
            Str::plural('user', $descriptions->count()),
        );

        return new SystemFixResult($this->label(), $summary, [], $this->sampleForAlert($descriptions));
    }

    /**
     * Ids of active users who hold at least one active area-scoped role, have a home location, yet have no
     * active role anchored to that home. Detected in one aggregate query so we never scan every attachment.
     *
     * @return Collection<int, int>
     */
    private function usersNeedingAttention(): Collection
    {
        $anchored = <<<'SQL'
            (
                (t.regionalRole = 1 AND u.assoc_to_region <> 0 AND r.regionID = u.assoc_to_region)
                OR (t.districtRole = 1 AND u.assoc_to_district <> 0 AND r.districtID = u.assoc_to_district)
                OR (
                    (t.groupRole = 1 OR t.denRole = 1 OR t.packRole = 1 OR t.troopRole = 1 OR t.crewRole = 1)
                    AND u.assoc_to_group <> 0 AND r.groupID = u.assoc_to_group
                )
            )
            SQL;

        return SystemUsersOtherRole::query()
            ->from('system_users_other_roles as r')
            ->join('system_user_types as t', 't.id', '=', 'r.roleID')
            ->join('system_users as u', 'u.id', '=', 'r.userID')
            ->where('u.active', 1)
            ->where('r.active', 1)
            ->where('r.retired', 0)
            ->where('r.resigned', 0)
            ->where('r.suspended', 0)
            ->where(function ($query): void {
                $query->where('t.regionalRole', 1)
                    ->orWhere('t.districtRole', 1)
                    ->orWhere('t.groupRole', 1)
                    ->orWhere('t.denRole', 1)
                    ->orWhere('t.packRole', 1)
                    ->orWhere('t.troopRole', 1)
                    ->orWhere('t.crewRole', 1);
            })
            ->groupBy('r.userID')
            ->havingRaw("MAX({$anchored}) = 0 AND (MAX(u.assoc_to_group) <> 0 OR MAX(u.assoc_to_district) <> 0 OR MAX(u.assoc_to_region) <> 0)")
            ->pluck('r.userID')
            ->map(fn ($userId): int => (int) $userId)
            ->values();
    }

    /**
     * Build one human-readable line per flagged user (and log each with structured context).
     *
     * @param  Collection<int, int>  $userIds
     * @return Collection<int, string>
     */
    private function describe(Collection $userIds): Collection
    {
        $users = SystemUser::query()->whereIn('id', $userIds)->get()->keyBy('id');

        /** @var Collection<int, EloquentCollection<int, SystemUsersOtherRole>> $rolesByUser */
        $rolesByUser = SystemUsersOtherRole::query()
            ->with(['role', 'region', 'district', 'group'])
            ->whereIn('userID', $userIds)
            ->where('active', 1)
            ->where('retired', 0)
            ->where('resigned', 0)
            ->where('suspended', 0)
            ->get()
            ->groupBy('userID');

        return $userIds
            ->map(function (int $userId) use ($users, $rolesByUser): ?string {
                $user = $users->get($userId);

                if ($user === null) {
                    return null;
                }

                $areaRoles = ($rolesByUser->get($userId) ?? new EloquentCollection)
                    ->filter(fn (SystemUsersOtherRole $role): bool => $this->tierOf($role->role) !== null)
                    ->values();

                if ($areaRoles->isEmpty()) {
                    return null;
                }

                $roleLabels = $areaRoles
                    ->map(fn (SystemUsersOtherRole $role): string => $this->roleLabel($role))
                    ->all();

                Log::warning('system_fix.role_in_home_location.flagged', [
                    'fix' => static::class,
                    'user_id' => $userId,
                    'user_name' => trim((string) $user->name),
                    'home' => [
                        'group_id' => (int) $user->assoc_to_group,
                        'district_id' => (int) $user->assoc_to_district,
                        'region_id' => (int) $user->assoc_to_region,
                    ],
                    'active_area_roles' => $areaRoles
                        ->map(fn (SystemUsersOtherRole $role): array => [
                            'id' => (int) $role->id,
                            'role' => $role->role?->name,
                        ])
                        ->all(),
                ]);

                $name = trim((string) $user->name);
                $userLabel = $name !== '' ? sprintf('#%d %s', $userId, $name) : "#{$userId}";

                return sprintf(
                    'User %s — home %s — holds %d active area role(s), none at home: %s.',
                    $userLabel,
                    $this->homeLabel($user),
                    $areaRoles->count(),
                    implode(', ', $roleLabels),
                );
            })
            ->filter()
            ->values();
    }

    /**
     * The role's area tier, or null when the role carries no area of its own.
     */
    private function tierOf(?SystemUserType $role): ?string
    {
        if ($role === null) {
            return null;
        }

        return match (true) {
            $role->regionalRole === 1 => 'region',
            $role->districtRole === 1 => 'district',
            $role->groupRole === 1,
            $role->denRole === 1,
            $role->packRole === 1,
            $role->troopRole === 1,
            $role->crewRole === 1 => 'group',
            default => null,
        };
    }

    private function roleLabel(SystemUsersOtherRole $role): string
    {
        $roleName = $role->role?->name ?? 'unknown role';

        $area = match ($this->tierOf($role->role)) {
            'region' => $role->region?->name,
            'district' => $role->district?->name,
            'group' => $role->group?->name,
            default => null,
        };

        return sprintf('"%s"%s', $roleName, $area !== null ? " @ {$area}" : '');
    }

    private function homeLabel(SystemUser $user): string
    {
        return match (true) {
            (int) $user->assoc_to_group !== 0 => 'group ' . $this->areaLabel('groups', (int) $user->assoc_to_group),
            (int) $user->assoc_to_district !== 0 => 'district ' . $this->areaLabel('districts', (int) $user->assoc_to_district),
            (int) $user->assoc_to_region !== 0 => 'region ' . $this->areaLabel('regions', (int) $user->assoc_to_region),
            default => 'unknown',
        };
    }

    private function areaLabel(string $table, int $id): string
    {
        $name = $this->lookupAreaName($table, $id);

        return $name !== null ? "\"{$name}\"" : "#{$id}";
    }

    private function lookupAreaName(string $table, int $id): ?string
    {
        if ($id === 0) {
            return null;
        }

        if (array_key_exists($id, $this->areaNameCache[$table] ?? [])) {
            return $this->areaNameCache[$table][$id];
        }

        $value = DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table($table)
            ->where('id', $id)
            ->value('name');

        return $this->areaNameCache[$table][$id] = $value !== null ? (string) $value : null;
    }

    /**
     * The alert body is capped for readability; when there are more, a final line points at the logs.
     *
     * @param  Collection<int, string>  $descriptions
     * @return list<string>
     */
    private function sampleForAlert(Collection $descriptions): array
    {
        if ($descriptions->count() <= self::ALERT_SAMPLE_LIMIT) {
            return $descriptions->all();
        }

        $remaining = $descriptions->count() - self::ALERT_SAMPLE_LIMIT;

        return $descriptions
            ->take(self::ALERT_SAMPLE_LIMIT)
            ->push(sprintf('…and %d more — see the logs (system_fix.role_in_home_location.flagged).', $remaining))
            ->all();
    }
}
