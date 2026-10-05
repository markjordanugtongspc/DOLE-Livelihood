<?php
namespace App\services;

/* START: PhoneService — normalizes and validates Philippine mobile numbers */
class PhoneService
{
    /* START: normalize — converts 09XXXXXXXXX or 639XXXXXXXXX into standard +639XXXXXXXXX */
    public static function normalize(string $phone): ?string
    {
        // Strip non-digits except leading plus
        $clean = preg_replace('/[^\d+]/', '', trim($phone));

        if (str_starts_with($clean, '+63')) {
            $digits = substr($clean, 3);
        } elseif (str_starts_with($clean, '63')) {
            $digits = substr($clean, 2);
        } elseif (str_starts_with($clean, '09')) {
            $digits = substr($clean, 1);
        } else {
            $digits = $clean;
        }

        // Must be exactly 10 digits starting with 9
        if (preg_match('/^9\d{9}$/', $digits)) {
            return '+63' . $digits;
        }

        return null;
    }
    /* END: normalize */

    /* START: isValid — validates Philippine mobile number format */
    public static function isValid(string $phone): bool
    {
        return self::normalize($phone) !== null;
    }
    /* END: isValid */
}
/* END: PhoneService */
