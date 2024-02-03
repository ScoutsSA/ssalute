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
        self::COMMUNITY => 'Community Group',
        self::NGO => 'NGO Group',
        self::CHURCH => 'Church Group',
        self::SCHOOL => 'School Group',
        self::UNKNOWN => '!Unknown! Group',
    ];
}
