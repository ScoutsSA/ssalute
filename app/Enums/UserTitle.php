<?php

namespace App\Enums;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum UserTitle: string implements HasLabel
{
    use WithOptions;

    case Mr = 'mr';
    case Mrs = 'mrs';
    case Ms = 'ms';
    case Miss = 'miss';
    case Dr = 'dr';
    case Prof = 'prof';
    case Rev = 'rev';
    case Hon = 'hon';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Mr => 'Mr',
            self::Mrs => 'Mrs',
            self::Ms => 'Ms',
            self::Miss => 'Miss',
            self::Dr => 'Dr',
            self::Prof => 'Prof',
            self::Rev => 'Rev',
            self::Hon => 'Hon',
            self::Other => 'Other',
        };
    }
}
