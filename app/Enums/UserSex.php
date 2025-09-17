<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum UserSex: string implements HasLabel
{
    use WithOptions;
    case Female = 'Female';
    case Male = 'Male';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Female => 'Female',
            self::Male => 'Male',
            self::Other => 'Other',
        };
    }
}
