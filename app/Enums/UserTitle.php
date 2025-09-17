<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum UserTitle: string implements HasLabel
{
    use WithOptions;

    case Master = 'Master';
    case Miss = 'Miss';

    case Mr = 'Mr';
    case Mrs = 'Mrs';
    case Ms = 'Ms';
    case Dr = 'Dr';
    case Prof = 'Prof';
    case Rev = 'Rev';
    case Hon = 'Hon';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Master => 'Master',
            self::Miss => 'Miss',
            self::Mr => 'Mr',
            self::Mrs => 'Mrs',
            self::Ms => 'Ms',
            self::Dr => 'Dr',
            self::Prof => 'Prof',
            self::Rev => 'Rev',
            self::Hon => 'Hon',
            self::Other => 'Other',
        };
    }
}
