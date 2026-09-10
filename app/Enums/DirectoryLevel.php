<?php

namespace App\Enums;

enum DirectoryLevel: string
{
    case National = 'national';
    case Regional = 'regional';
    case District = 'district';
    case Group = 'group';

    /**
     * The system_user_types flag that puts a role on this level's team, matching the legacy
     * directory queries (nationalRole, regionalRole, districtRole, groupRole).
     */
    public function roleFlagColumn(): string
    {
        return match ($this) {
            self::National => 'nationalRole',
            self::Regional => 'regionalRole',
            self::District => 'districtRole',
            self::Group => 'groupRole',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::National => 'National Team',
            self::Regional => 'Regional Team',
            self::District => 'District Team',
            self::Group => 'Group Team',
        };
    }
}
