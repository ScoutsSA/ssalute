<?php

namespace App\Constants;

class SectionTypes
{
    public const DEN = 'den';
    public const PACK = 'pack';
    public const TROOP = 'troop';
    public const CREW = 'crew';

    public const READ = [
        self::DEN => 'Den',
        self::PACK => 'Pack',
        self::TROOP => 'Troop',
        self::CREW => 'Crew',
    ];
}
