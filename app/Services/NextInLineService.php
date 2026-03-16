<?php

namespace App\Services;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Settings\GeneralSettings;
use Illuminate\Support\Collection;

class NextInLineService
{
    public function __construct(
        private GeneralSettings $settings,
    ) {}

    /**
     * Resolve the next-in-line scouter for the given role attachment.
     *
     * Walks upward from the reporter's role scope level until a match is found.
     * Returns the SystemUser with a `relevantRole` relation set to the matched
     * SystemUsersOtherRole, or null if nobody is found.
     */
    public function resolve(SystemUsersOtherRole $reporterRole): ?SystemUser
    {
        $levels = $this->levelsForRole($reporterRole);

        foreach ($levels as $level) {
            $match = $this->queryLevel($level, $reporterRole)->first();

            if ($match?->user) {
                return $match->user->setRelation('relevantRole', $match);
            }
        }

        return null;
    }

    /**
     * Resolve all next-in-line scouters at the first matching level.
     *
     * Each returned SystemUser has `relevantRole` set to their matched role attachment.
     *
     * @return Collection<int, SystemUser>
     */
    public function resolveAll(SystemUsersOtherRole $reporterRole): Collection
    {
        $levels = $this->levelsForRole($reporterRole);

        foreach ($levels as $level) {
            $users = $this->queryLevel($level, $reporterRole)->get()
                ->filter(fn (SystemUsersOtherRole $attachment) => $attachment->user !== null)
                ->map(fn (SystemUsersOtherRole $attachment) => $attachment->user->setRelation('relevantRole', $attachment))
                ->unique('id')
                ->values();

            if ($users->isNotEmpty()) {
                return $users;
            }
        }

        return collect();
    }

    /**
     * Resolve email addresses for all active National Adult Support users.
     *
     * @return array<int, string>
     */
    public function resolveNationalSupportEmails(): array
    {
        $roleIds = $this->settings->national_support_role_ids ?? [];

        if (empty($roleIds)) {
            return [];
        }

        return SystemUsersOtherRole::query()
            ->whereIn('roleID', $roleIds)
            ->where('active', 1)
            ->with('user')
            ->get()
            ->map(fn ($attachment) => $attachment->user?->username)
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Build the query for a single escalation level.
     */
    private function queryLevel(array $level, SystemUsersOtherRole $reporterRole): \Illuminate\Database\Eloquent\Builder
    {
        $roleId = $this->settings->{$level['settingKey']};

        if (! $roleId) {
            return SystemUsersOtherRole::query()->whereRaw('0 = 1');
        }

        $query = SystemUsersOtherRole::query()
            ->where('roleID', $roleId)
            ->where('active', 1)
            ->with('user');

        if ($level['fk'] && $reporterRole->{$level['fk']}) {
            $query->where($level['fk'], $reporterRole->{$level['fk']});
        }

        return $query;
    }

    /**
     * Determine the escalation levels based on the reporter's role scope.
     *
     * A national role holder only checks the national level.
     * A regional role holder checks regional then national.
     * A district role holder checks district, regional, then national.
     * A group-level (or lower) role holder walks all four levels.
     *
     * @return array<int, array{settingKey: string, fk: string|null}>
     */
    private function levelsForRole(SystemUsersOtherRole $reporterRole): array
    {
        $allLevels = [
            'group' => ['settingKey' => 'next_in_line_role_group', 'fk' => 'groupID'],
            'district' => ['settingKey' => 'next_in_line_role_district', 'fk' => 'districtID'],
            'regional' => ['settingKey' => 'next_in_line_role_regional', 'fk' => 'regionID'],
            'national' => ['settingKey' => 'next_in_line_role_national', 'fk' => null],
        ];

        $role = $reporterRole->role;

        if (! $role) {
            return array_values($allLevels);
        }

        // Start from the reporter's scope level and walk upward
        if ($role->nationalRole === 1 || $role->sysAdmin === 1) {
            return [$allLevels['national']];
        }

        if ($role->regionalRole === 1) {
            return [
                $allLevels['regional'],
                $allLevels['national'],
            ];
        }

        if ($role->superDistrictRole === 1 || $role->districtRole === 1) {
            return [
                $allLevels['district'],
                $allLevels['regional'],
                $allLevels['national'],
            ];
        }

        // Group-level and below: walk all levels
        return array_values($allLevels);
    }
}
