<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum SectionTypes: string implements HasLabel
{
    use WithOptions;
    case DEN = 'den';
    case PACK = 'pack';
    case TROOP = 'troop';
    case CREW = 'crew';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::DEN => 'Den',
            self::PACK => 'Pack',
            self::TROOP => 'Troop',
            self::CREW => 'Crew',
        };
    }
}
