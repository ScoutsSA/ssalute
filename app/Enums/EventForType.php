<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum EventForType: int implements HasLabel
{
    use WithOptions;

    case Groups = 1;
    case AdultLeaders = 2;

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Groups => 'Groups',
            self::AdultLeaders => 'Adult Leaders',
        };
    }
}
