<?php
namespace App\services;

use App\services\sms\SmsApiDriver;

/* START: OtpService — placeholder service for phone OTP generation and verification */
class OtpService
{
    /* START: isEnabled — checks if OTP login functionality is toggled on */
    public static function isEnabled(): bool
    {
        return filter_var($_ENV['OTP_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN);
    }
    /* END: isEnabled */

    /* START: request — placeholder for generating and dispatching SMS OTP */
    public static function request(string $phone): array
    {
        if (!self::isEnabled()) {
            return [
                'success' => false,
                'message' => 'OTP login is currently disabled. Please sign in with your PIN.'
            ];
        }

        // Future OTP logic goes here
        return [
            'success' => true,
            'message' => 'OTP code requested successfully (placeholder)',
            'resend_in' => 60
        ];
    }
    /* END: request */

    /* START: verify — placeholder for validating submitted OTP code */
    public static function verify(string $phone, string $code): array
    {
        if (!self::isEnabled()) {
            return [
                'success' => false,
                'message' => 'OTP login is currently disabled.'
            ];
        }

        // Future OTP validation goes here
        return [
            'success' => false,
            'message' => 'OTP functionality is not yet active.'
        ];
    }
    /* END: verify */
}
/* END: OtpService */
