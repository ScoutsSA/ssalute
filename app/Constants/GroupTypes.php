<?php

namespace App\Constants;

class GroupTypes
{
    public const COMMUNITY = 'community';
    public const NGO = 'ngo';
    public const CHURCH = 'church';
    public const SCHOOL = 'school';
    public const UNKNOWN = 'unknown';

    public const READ = [
        self::COMMUNITY => 'Community V3Group',
        self::NGO => 'NGO V3Group',
        self::CHURCH => 'Church V3Group',
        self::SCHOOL => 'School V3Group',
        self::UNKNOWN => '!Unknown! V3Group',
    ];
}
