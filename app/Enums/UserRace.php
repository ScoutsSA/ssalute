<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum UserRace: string implements HasLabel
{
    use WithOptions;
    case Caucasian = 'Caucasian';
    case African = 'African';
    case Indian = 'Indian';
    case Asian = 'Asian';
    case Coloured = 'Coloured';
    case Other = 'Other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Caucasian => 'Caucasian',
            self::African => 'African',
            self::Indian => 'Indian',
            self::Asian => 'Asian',
            self::Coloured => 'Coloured',
            self::Other => 'Other / Prefer not to say',
        };
    }
}
