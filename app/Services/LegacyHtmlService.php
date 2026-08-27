<?php

namespace App\Services;

/**
 * Normalises HTML stored by the legacy app, whose editors re-encoded entities
 * on every save. Decoding until stable mirrors what the legacy display
 * pipeline (html_entity_decode, htmlspecialchars_decode, stripslashes)
 * produces, so the BackOffice editors show the content as members see it.
 */
class LegacyHtmlService
{
    public static function decode(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        for ($pass = 0; $pass < 5; $pass++) {
            $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            if ($decoded === $value) {
                break;
            }

            $value = $decoded;
        }

        return stripslashes($value);
    }

    /**
     * Decoded value with tags removed, for table column previews.
     */
    public static function preview(?string $value): ?string
    {
        $decoded = self::decode($value);

        return $decoded === null ? null : trim(strip_tags($decoded));
    }
}
