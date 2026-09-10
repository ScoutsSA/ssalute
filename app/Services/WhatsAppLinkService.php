<?php

namespace App\Services;

/**
 * A wa.me link for a South African cell number: local 0XX numbers become 27XX, numbers already
 * in 27 form stay, and anything else gets no link. Mirrors the helper in the support bot so both
 * apps open the same chat for the same stored number.
 */
class WhatsAppLinkService
{
    public static function for(?string $cellNr): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $cellNr) ?? '';

        if (strlen($digits) === 10 && str_starts_with($digits, '0')) {
            return 'https://wa.me/27' . substr($digits, 1);
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '27')) {
            return "https://wa.me/{$digits}";
        }

        return null;
    }
}
