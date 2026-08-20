<?php

namespace App\Services\SystemFixes;

use App\Filament\Admin\Clusters\DataFixes\Pages\PrimaryRoles;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Ensures a deactivated role is never primary, and that a user with active roles
 * has exactly one active role as primary.
 *
 * The invariant enforced per active user that holds at least one role:
 *   - a deactivated role is never flagged primary (`defaultRole = 1`);
 *   - if the user has any active roles, exactly one active role is primary;
 *   - if the user has no active roles, no role is primary (this is allowed).
 *
 * When an active primary is needed, an existing active primary is preserved to
 * minimise churn. Otherwise the most recently created active role is promoted
 * (highest `created`, then highest `id` as a tiebreaker), mirroring the
 * reconciliation used during user merges.
 */
class EnsureEachUserHasOnlyOnePrimaryRole implements ReportsFindings, SystemFix
{
    public function label(): string
    {
        return 'Ensure each active user has one active primary role (never a deactivated one)';
    }

    public function settingKey(): string
    {
        return 'ensure_each_user_has_only_one_primary_role_enabled';
    }

    public function notificationSettingKey(): string
    {
        return 'ensure_each_user_has_only_one_primary_role_notifications';
    }

    /**
     * Members whose roles break the single-primary invariant right now.
     *
     * This fix repairs everything it finds, so between nightly runs this page is where a pending
     * violation shows up, and after a run it is empty. Nothing here is left for an admin to fix by
     * hand — it is a view of what the next run will correct.
     *
     * @return Collection<int, SystemFixFinding>
     */
    public function findings(): Collection
    {
        $userIds = $this->usersNeedingReconciliation();

        if ($userIds->isEmpty()) {
            return collect();
        }

        $users = SystemUser::query()->whereIn('id', $userIds)->get()->keyBy('id');

        return $userIds
            ->map(function (int $userId) use ($users): SystemFixFinding {
                $name = trim((string) $users->get($userId)?->name);

                return new SystemFixFinding(
                    title: $name !== '' ? sprintf('#%d %s', $userId, $name) : "#{$userId}",
                    detail: 'Roles break the single-primary rule: either a deactivated role is marked primary, or the member does not have exactly one active primary. The next nightly run will correct this.',
                    url: UserResource::getUrl('edit', ['record' => $userId], panel: 'admin'),
                    linkLabel: 'Edit member',
                    group: 'Pending correction',
                );
            })
            ->values();
    }

    public function findingsUrl(): ?string
    {
        return PrimaryRoles::getUrl(panel: 'admin');
    }

    public function run(): SystemFixResult
    {
        $reconciliations = $this->usersNeedingReconciliation()
            ->map(fn (int $userId): ?array => $this->reconcileUser($userId))
            ->filter()
            ->values();

        $changes = $reconciliations
            ->map(fn (array $reconciliation): string => $reconciliation['summary'])
            ->all();

        $rolesChanged = $reconciliations->sum(fn (array $reconciliation): int => $reconciliation['roles_changed']);

        $summary = $reconciliations->isEmpty()
            ? 'Every active user already has exactly one primary role.'
            : sprintf(
                'Reconciled %d %s (%d role %s changed).',
                $reconciliations->count(),
                Str::plural('user', $reconciliations->count()),
                $rolesChanged,
                Str::plural('flag', $rolesChanged),
            );

        return new SystemFixResult($this->label(), $summary, $changes);
    }

    /**
     * Active users whose roles violate the invariant: a deactivated role is
     * flagged primary, or the user has active roles but not exactly one active
     * primary. A user with no active roles and no primary is already valid.
     *
     * @return Collection<int, int>
     */
    private function usersNeedingReconciliation(): Collection
    {
        return SystemUsersOtherRole::query()
            ->whereIn('userID', SystemUser::query()->active()->select('id'))
            ->select('userID')
            ->groupBy('userID')
            ->havingRaw('SUM(defaultRole = 1 AND active = 0) > 0 OR (SUM(active = 1) > 0 AND SUM(active = 1 AND defaultRole = 1) <> 1)')
            ->pluck('userID')
            ->map(fn ($userId): int => (int) $userId);
    }

    /**
     * Enforce the single-primary invariant for one user, writing only the rows
     * that actually change.
     *
     * @return array{summary: string, roles_changed: int}|null Null when no change was needed.
     */
    private function reconcileUser(int $userId): ?array
    {
        /** @var EloquentCollection<int, SystemUsersOtherRole> $roles */
        $roles = SystemUsersOtherRole::query()
            ->with(['role', 'region', 'district', 'group'])
            ->where('userID', $userId)
            ->orderByDesc('created')
            ->orderByDesc('id')
            ->get();

        if ($roles->isEmpty()) {
            return null;
        }

        $targetRole = $this->chooseTargetPrimaryRole($roles);
        $targetRoleId = $targetRole?->id;

        $promoted = false;
        /** @var list<SystemUsersOtherRole> $demotedRoles */
        $demotedRoles = [];

        foreach ($roles as $role) {
            $shouldBePrimary = $targetRoleId !== null && $role->id === $targetRoleId;
            $isPrimary = (int) $role->defaultRole === 1;

            if ($shouldBePrimary === $isPrimary) {
                continue;
            }

            $role->update(['defaultRole' => $shouldBePrimary ? 1 : 0]);

            if ($shouldBePrimary) {
                $promoted = true;
            } else {
                $demotedRoles[] = $role;
            }
        }

        $rolesChanged = count($demotedRoles) + ($promoted ? 1 : 0);

        if ($rolesChanged === 0) {
            return null;
        }

        $user = SystemUser::query()->find($userId);
        $userName = $user !== null ? trim((string) $user->name) : '';
        $userLabel = $userName !== '' ? sprintf('#%d %s', $userId, $userName) : "#{$userId}";

        $demotedLabels = collect($demotedRoles)
            ->map(fn (SystemUsersOtherRole $role): string => $this->roleLabel($role))
            ->join(', ');

        Log::warning('system_fix.primary_role.reconciled', [
            'fix' => static::class,
            'user_id' => $userId,
            'user_name' => $userName,
            'primary_role_id' => $targetRole !== null ? (int) $targetRole->id : null,
            'primary_role_name' => $targetRole?->role?->name,
            'primary_role_promoted' => $promoted,
            'demoted_roles' => array_map(
                fn (SystemUsersOtherRole $role): array => ['id' => (int) $role->id, 'name' => $role->role?->name],
                $demotedRoles,
            ),
        ]);

        $summary = $targetRole === null
            ? sprintf('User %s: cleared primary (no active roles), demoted %s.', $userLabel, $demotedLabels)
            : sprintf(
                'User %s: %s primary role %s%s.',
                $userLabel,
                $promoted ? 'set' : 'kept',
                $this->roleLabel($targetRole),
                $demotedRoles === [] ? '' : ', demoted ' . $demotedLabels,
            );

        return [
            'summary' => $summary,
            'roles_changed' => $rolesChanged,
        ];
    }

    /**
     * A human-readable label for a role assignment: its id, the role-type name,
     * and the scoped area (group/district/region) name when the role has one.
     */
    private function roleLabel(SystemUsersOtherRole $role): string
    {
        $roleName = $role->role?->name ?? 'unknown role';
        $scope = $role->role !== null ? $role->roleScopedLabel : null;

        return sprintf('#%d "%s"%s', $role->id, $roleName, $scope !== null ? " ({$scope})" : '');
    }

    /**
     * Pick the active role that should be primary, or null when the user has no
     * active roles (in which case no role may be primary). An existing active
     * primary is kept; otherwise the most recently created active role is chosen.
     * Roles are pre-sorted newest first by the caller.
     *
     * @param  EloquentCollection<int, SystemUsersOtherRole>  $roles
     */
    private function chooseTargetPrimaryRole(EloquentCollection $roles): ?SystemUsersOtherRole
    {
        $activeRoles = $roles->where('active', 1);

        if ($activeRoles->isEmpty()) {
            return null;
        }

        return $activeRoles->firstWhere('defaultRole', 1) ?? $activeRoles->first();
    }
}
