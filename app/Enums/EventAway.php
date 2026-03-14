<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum EventAway: int implements HasLabel
{
    use WithOptions;

    case NotApplicable = 0;
    case Away = 1;
    case AtScoutHall = 2;

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::NotApplicable => 'N/A',
            self::Away => 'Away',
            self::AtScoutHall => 'At Scout Hall',
        };
    }
}
