<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum EventFor: int implements HasLabel
{
    use WithOptions;

    case All = 0;
    case CubsOnly = 1;
    case ScoutsOnly = 2;
    case RoversOnly = 3;
    case AdultsOnly = 4;
    case Group = 5;
    case MeerkatsOnly = 6;

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::All => 'All',
            self::CubsOnly => 'Cubs Only',
            self::ScoutsOnly => 'Scouts Only',
            self::RoversOnly => 'Rovers Only',
            self::AdultsOnly => 'Adults Only',
            self::Group => 'Group',
            self::MeerkatsOnly => 'Meerkats Only',
        };
    }
}
