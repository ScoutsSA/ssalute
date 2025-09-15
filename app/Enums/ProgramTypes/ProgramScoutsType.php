<?php

namespace App\Enums\ProgramTypes;

use App\Enums\Concerns\HasActive;
use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProgramScoutsType: string implements HasActive, HasLabel
{
    use WithOptions;
    case STANDARD = '1';
    case ENTSHA = '2';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::STANDARD => 'Pre-2019 Program',
            self::ENTSHA => 'Scout 2019 Program (Entsha)',
        };
    }

    public function getActive(): bool
    {
        return match ($this) {
            self::STANDARD => true,
            self::ENTSHA => true,
        };
    }
}
