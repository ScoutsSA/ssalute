<?php

namespace App\Constants;

class SsaRoleRelatedOptions
{
    public const NATIONAL = 'national';
    public const REGIONAL = 'regional';
    public const DISTRICT = 'district';
    public const GROUP = 'group';
    public const SECTION = 'section';
    public const NONE = 'none';

    public const READ = [
        self::NATIONAL => 'National',
        self::REGIONAL => 'Regional',
        self::DISTRICT => 'V3District',
        self::GROUP => 'V3Group',
        self::SECTION => 'V3Section',
        self::NONE => 'General',
    ];
}
