<?php

namespace App\Enums\Forms\Aam;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AamStatuses: string implements HasColor, HasLabel
{
    use WithOptions;
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DECLINED = 'declined';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::DECLINED => 'Declined',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => Color::Blue,
            self::APPROVED => Color::Green,
            self::DECLINED => Color::Red,
        };
    }
}
