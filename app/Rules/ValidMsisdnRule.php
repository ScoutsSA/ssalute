<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Throwable;

class ValidMsisdnRule implements ValidationRule
{
    public ?string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cleanMsisdn = $this->cleanMsisdn($value);

        if (! $cleanMsisdn) {
            $fail($this->message ?? "The :attribute doesn't appear to be valid.");
        }
    }

    public function cleanMsisdn(string $msisdn): bool|string
    {
        try {
            if ($msisdn[0] === '0') {
                $this->defaultZeroInFrontToSouthAfrica($msisdn); // From format 07338196139 ==> +27 73 819 6139
            } elseif (strlen($msisdn) === 13) {
                $this->handle13CharNumbers($msisdn); // From format 2347048130055 ==> +234 70 4813 0055
            } elseif (strlen($msisdn) === 12) {
                $this->handle12CharNumbers($msisdn); // From format 254725272052 ==> +25 47 2527 2052
            } elseif (strlen($msisdn) === 11) {
                $this->handle11CharNumbers($msisdn); // From format 27738196139 ==> +27 73 819 6139
            }
            $phoneNumberUtil = PhoneNumberUtil::getInstance();
            $phoneNumberObject = $phoneNumberUtil->parse($msisdn);
            // Use Google's phone number library to check if the supplied number is legit
            if ($phoneNumberUtil->isPossibleNumber($phoneNumberObject)) {
                return $phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::E164);
            }
        } catch (Throwable $throwable) {
            return false;
        }

        return false;
    }

    public function handle13CharNumbers(&$msisdn): void
    {
        // From format 2347048130055 ==> +234 70 4813 0055
        $msisdn = '+' . substr($msisdn, 0, 3) . ' ' . substr($msisdn, 3, 2) . ' ' . substr($msisdn, 5,
            4) . ' ' . substr($msisdn, 9, 4);
    }

    public function handle12CharNumbers(&$msisdn): void
    {
        // From format 254725272052 ==> +25 47 2527 2052
        $msisdn = '+' . substr($msisdn, 0, 2) . ' ' . substr($msisdn, 2, 2) . ' ' . substr($msisdn, 4,
            4) . ' ' . substr($msisdn, 8, 4);
    }

    public function handle11CharNumbers(&$msisdn): void
    {
        // From format 277338196139 ==> +27 73 819 6139
        $msisdn = '+' . substr($msisdn, 0, 2) . ' ' . substr($msisdn, 2, 2) . ' ' . substr($msisdn, 4,
            3) . ' ' . substr($msisdn, 7, 4);
    }

    public function defaultZeroInFrontToSouthAfrica(&$msisdn): void
    {
        // From format 0738196139 ==> +27 73 819 6139
        $msisdn = '+27' . ' ' . substr($msisdn, 1, 2) . ' ' . substr($msisdn, 3, 3) . ' ' . substr($msisdn, 6, 4);
    }
}
