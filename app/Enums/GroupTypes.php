<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GroupTypes: string implements HasLabel
{
    use WithOptions;
    case COMMUNITY = '1';
    case NGO = '2';
    case CHURCH = '3';
    case SCHOOL = '4';
    case DSD = '5';
    case UNKNOWN = 'unknown';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::COMMUNITY => 'Community',
            self::NGO => 'NGO',
            self::CHURCH => 'Church',
            self::SCHOOL => 'School',
            self::DSD => 'DSD',
            self::UNKNOWN => 'Unknown',
        };
    }
}
