<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum UserEnglishProficiency: int implements HasLabel
{
    use WithOptions;

    case None = 0;
    case Basic = 1;
    case Intermediate = 2;
    case Good = 3;
    case Fluent = 4;
    case MotherTongue = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::None => 'None',
            self::Basic => 'Basic',
            self::Intermediate => 'Intermediate',
            self::Good => 'Good',
            self::Fluent => 'Fluent',
            self::MotherTongue => 'Mother Tongue',
        };
    }
}
