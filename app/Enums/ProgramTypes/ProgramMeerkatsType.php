<?php

namespace App\Enums\ProgramTypes;

use App\Enums\Concerns\HasActive;
use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProgramMeerkatsType: string implements HasActive, HasLabel
{
    use WithOptions;
    case STANDARD = '1';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::STANDARD => 'Meerkat 2018 Program',
        };
    }

    public function getActive(): bool
    {
        return match ($this) {
            self::STANDARD => true,
        };
    }
}
