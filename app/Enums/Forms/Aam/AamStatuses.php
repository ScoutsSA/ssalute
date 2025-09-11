<?php

namespace App\Enums\Forms\Aam;

use App\Enums\Concerns\WithOptions;
use Filament\Support\Contracts\HasLabel;

enum AamStatuses: string implements HasLabel
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
}
