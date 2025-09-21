<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum UserBranchTypes: string implements HasLabel
{
    use WithOptions;

    case Land = 'Land';
    case Air = 'Air';
    case Sea = 'Sea';
    case Ranger = 'Ranger';
    case Guide = 'Guide';

    public function getLabel(): string
    {
        return match ($this) {
            self::Land => 'Land',
            self::Air => 'Air',
            self::Sea => 'Sea',
            self::Ranger => 'Ranger',
            self::Guide => 'Guide',
        };
    }
}
