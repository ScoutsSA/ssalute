<?php

namespace App\Services\SystemFixes;

use App\Filament\Admin\Clusters\DataFixes\Pages\HomeLocationRoles;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\District;
use App\Models\Group;
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
 *
 * Members whose home group is a ROVER CREW are excluded by design. A Rover's home is their crew
 * while the scouting role they hold sits at an ordinary group, so the mismatch this fix looks for
 * is that member's normal state, not a defect — moving their home would be the wrong correction.
 * A crew is identified by the group's own section flags (hasRovers with no other section) rather
 * than by its name: measured against the live data, the flags and a /rover|crew/i name match agree
 * on 102 of 103 groups, and the flags additionally catch "1st Sidlamafa", a crew whose name does
 * not say so. `roverAssocToGroup` is set on only 12 of them, so it is not a usable signal.
 * The exclusion removes 103 of 179 findings.
 */
class FlagUsersWithoutRoleInHomeLocation implements ReportsFindings, SystemFix
{
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

    /**
     * @return Collection<int, SystemFixFinding>
     */
    public function findings(): Collection
    {
        $userIds = $this->usersNeedingAttention();

        return $userIds->isEmpty() ? collect() : $this->describe($userIds)->values();
    }

    public function findingsUrl(): ?string
    {
        return HomeLocationRoles::getUrl(panel: 'admin');
    }

    /**
     * The distinct locations a member's active area roles sit at, as options for setting their
     * home to one of them.
     *
     * Keyed "tier:id" so one select can offer groups, districts and regions together — most
     * members here hold a single role at a single place, so the list is usually one obvious pick.
     *
     * @return array<string, string>
     */
    public function homeCandidates(int $userId): array
    {
        $roles = SystemUsersOtherRole::query()
            ->with(['role', 'region', 'district', 'group'])
            ->where('userID', $userId)
            ->where('active', 1)
            ->where('retired', 0)
            ->where('resigned', 0)
            ->where('suspended', 0)
            ->get();

        $options = [];

        foreach ($roles as $role) {
            $tier = $this->tierOf($role->role);

            [$id, $name] = match ($tier) {
                'group' => [(int) $role->group?->id, $role->group?->name],
                'district' => [(int) $role->district?->id, $role->district?->name],
                'region' => [(int) $role->region?->id, $role->region?->name],
                default => [0, null],
            };

            if ($tier === null || $id === 0 || $name === null) {
                continue;
            }

            $options["{$tier}:{$id}"] = sprintf('%s: %s (%s)', Str::ucfirst($tier), $name, $role->role?->name ?? 'role');
        }

        return $options;
    }

    /**
     * Move a member's home to one of the candidate locations, keeping the hierarchy consistent:
     * a group implies its district and region, a district implies its region.
     *
     * The member's roles are not touched — this resolves the mismatch by correcting the home,
     * which is the direction that matches how these arose (a member moved, the role stayed).
     */
    public function setHome(int $userId, string $candidate): void
    {
        [$tier, $id] = explode(':', $candidate, 2);
        $id = (int) $id;

        $home = match ($tier) {
            'group' => $this->homeFromGroup($id),
            'district' => $this->homeFromDistrict($id),
            'region' => ['assoc_to_group' => 0, 'assoc_to_district' => 0, 'assoc_to_region' => $id],
            default => null,
        };

        if ($home === null) {
            return;
        }

        SystemUser::query()->whereKey($userId)->update($home);

        Log::info('system_fix.role_in_home_location.home_set', [
            'fix' => static::class,
            'user_id' => $userId,
            'candidate' => $candidate,
            'home' => $home,
        ]);
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

        $findings = $this->describe($userIds);

        $summary = sprintf(
            'Flagged %d %s with no active role in their home location.',
            $findings->count(),
            Str::plural('user', $findings->count()),
        );

        return new SystemFixResult(
            $this->label(),
            $summary,
            [],
            $findings->map(fn (SystemFixFinding $f): string => $f->toLine())->all(),
        );
    }

    /**
     * @return array{assoc_to_group: int, assoc_to_district: int, assoc_to_region: int}|null
     */
    private function homeFromGroup(int $groupId): ?array
    {
        $group = Group::query()->find($groupId);

        if ($group === null) {
            return null;
        }

        return [
            'assoc_to_group' => $groupId,
            'assoc_to_district' => (int) $group->assoc_to_district,
            'assoc_to_region' => (int) $group->assoc_to_region,
        ];
    }

    /**
     * @return array{assoc_to_group: int, assoc_to_district: int, assoc_to_region: int}|null
     */
    private function homeFromDistrict(int $districtId): ?array
    {
        $district = District::query()->find($districtId);

        if ($district === null) {
            return null;
        }

        return [
            'assoc_to_group' => 0,
            'assoc_to_district' => $districtId,
            'assoc_to_region' => (int) $district->regionID,
        ];
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
            ->whereNotExists(fn ($query) => $query
                ->selectRaw('1')
                ->from('groups as hg')
                ->whereColumn('hg.id', 'u.assoc_to_group')
                ->where('hg.hasRovers', 1)
                ->where('hg.hasMeerkats', 0)
                ->where('hg.hasCubs', 0)
                ->where('hg.hasScouts', 0))
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
     * @return Collection<int, SystemFixFinding>
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
            ->map(function (int $userId) use ($users, $rolesByUser): ?SystemFixFinding {
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

                $name = trim((string) $user->name);

                return new SystemFixFinding(
                    title: $name !== '' ? sprintf('#%d %s', $userId, $name) : "#{$userId}",
                    detail: sprintf(
                        'Home is %s, but all %d active area role(s) are elsewhere: %s.',
                        $this->homeLabel($user),
                        $areaRoles->count(),
                        implode(', ', $roleLabels),
                    ),
                    url: UserResource::getUrl('edit', ['record' => $userId], panel: 'admin'),
                    linkLabel: 'Open member',
                    group: $this->homeLabel($user),
                    recordId: $userId,
                    badge: sprintf('%d role%s away', $areaRoles->count(), $areaRoles->count() === 1 ? '' : 's'),
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
}
