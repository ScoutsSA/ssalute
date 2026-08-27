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
    /**
     * The tags the legacy display pipeline keeps when it strip_tags content.
     * Content restricted to these renders identically before and after
     * normalisation, because the whitelist only bites on decoded values.
     *
     * @var list<string>
     */
    public const array LEGACY_DISPLAY_TAG_WHITELIST = ['b', 'strong', 'u', 'i', 'br', 'p', 'div', 'ul', 'ol', 'li'];

    public static function usesOnlyLegacyWhitelistedTags(?string $value): bool
    {
        if ($value === null || $value === '') {
            return true;
        }

        preg_match_all('/<\s*\/?\s*([a-zA-Z][a-zA-Z0-9]*)/', $value, $matches);

        $tags = array_unique(array_map(strtolower(...), $matches[1]));

        return array_diff($tags, self::LEGACY_DISPLAY_TAG_WHITELIST) === [];
    }

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
