<?php

namespace App\Enums\Concerns;

trait WithOptions
{
    /**
     * Returns an associative array suitable for Filament Select options: [value => label].
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->getLabel();
        }

        return $options;
    }
}
