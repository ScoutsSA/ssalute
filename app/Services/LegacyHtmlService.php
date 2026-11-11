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
     *
     * @var list<string>
     */
    public const array LEGACY_DISPLAY_TAG_WHITELIST = ['b', 'strong', 'u', 'i', 'br', 'p', 'div', 'ul', 'ol', 'li'];

    /**
     * Every save through a legacy form added a layer, and live rows carry sixteen of them.
     */
    private const int MAX_DECODE_PASSES = 20;

    /**
     * The decoded value when persisting it leaves the legacy pages showing
     * members exactly what they see today, the original value otherwise.
     *
     * This is the only method safe for write paths (the normalisation
     * migrations and editor hydration). Values the legacy display pipeline
     * would truncate, strip or double-unescape once decoded stay untouched:
     * tag-like plain text such as "<3" or "<11" (strip_tags consumes from the
     * bracket onwards), links and other non-whitelisted tags (kept encoded so
     * they keep rendering), and backslash sequences (the legacy render calls
     * stripslashes again on output).
     */
    public static function normalize(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $decoded = self::decode($value);

        if ($decoded === $value) {
            return $value;
        }

        if (self::legacyDisplayText($decoded) !== self::legacyDisplayText($value)) {
            return $value;
        }

        return $decoded;
    }

    /**
     * What members effectively see for a stored value. Display only: the
     * result must never be persisted, because the legacy render applies
     * stripslashes on every output pass, so re-saving a decoded value would
     * strip a further layer. Persist through normalize() instead.
     */
    public static function decode(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return stripslashes(self::decodeEntities($value));
    }

    /**
     * normalize(), extended to values the legacy pages already show broken.
     *
     * A value saved through a legacy form several times displays its leftover layers as visible
     * junk ("Fires &amp;amp; Cooking"). normalize() keeps such a value because decoding it does
     * change what members see; here that change is the point. The decoded value is accepted only
     * when the sole difference is that residue: the text members see today, with its leftover
     * entities decoded, must equal the text they would see afterwards. Everything else
     * normalize() guards against (tag-like text, non-whitelisted tags, backslashes, double
     * quotes the legacy render drops) still keeps the value as it is. Write paths only, like
     * normalize().
     */
    public static function repair(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $normalized = self::normalize($value);

        if ($normalized !== $value) {
            return $normalized;
        }

        $decoded = self::decode($value);

        if ($decoded === $value) {
            return $value;
        }

        if (self::decodeEntities(self::legacyDisplayText($value)) !== self::legacyDisplayText($decoded)) {
            return $value;
        }

        return $decoded;
    }

    /**
     * Decoded value with tags removed, for table column previews.
     */
    public static function preview(?string $value): ?string
    {
        $decoded = self::decode($value);

        return $decoded === null ? null : trim(strip_tags($decoded));
    }

    /**
     * What a member's browser displays for a stored value: the legacy display
     * pipeline (trim, strip_tags with the whitelist, one html_entity_decode
     * and htmlspecialchars_decode pass, stripslashes, double quote removal)
     * followed by the single entity decoding pass the browser itself applies
     * to the resulting markup.
     */
    private static function legacyDisplayText(string $value): string
    {
        $rendered = trim($value);
        $rendered = strip_tags($rendered, self::LEGACY_DISPLAY_TAG_WHITELIST);
        $rendered = html_entity_decode($rendered);
        $rendered = htmlspecialchars_decode($rendered);
        $rendered = stripslashes($rendered);
        $rendered = str_ireplace('"', '', $rendered);

        return html_entity_decode($rendered, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private static function decodeEntities(string $value): string
    {
        for ($pass = 0; $pass < self::MAX_DECODE_PASSES; $pass++) {
            $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            if ($decoded === $value) {
                break;
            }

            $value = $decoded;
        }

        return $value;
    }
}
