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

    /**
     * Resolve a race value as stored by the legacy sd-core database.
     *
     * Legacy rows are not written against this enum and carry surrounding whitespace
     * (9,794 rows store `African ` with a trailing space), so a plain enum cast throws
     * a ValueError on read and takes down every surface that touches the attribute.
     * Anything that still does not resolve to a case reads as null rather than fatally.
     */
    public static function fromLegacyValue(?string $value): ?self
    {
        $normalised = trim((string) $value);

        if ($normalised === '') {
            return null;
        }

        return self::tryFrom($normalised);
    }

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
