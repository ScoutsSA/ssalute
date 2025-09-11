<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GroupTypes: string implements HasLabel
{
    use WithOptions;
    case COMMUNITY = 'community';
    case NGO = 'ngo';
    case CHURCH = 'church';
    case SCHOOL = 'school';
    case UNKNOWN = 'unknown';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::COMMUNITY => 'Community',
            self::NGO => 'NGO',
            self::CHURCH => 'Church',
            self::SCHOOL => 'School',
            self::UNKNOWN => 'Unknown',
        };
    }
}
