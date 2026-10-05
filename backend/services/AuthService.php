<?php
namespace App\services;

use App\core\Session;
use App\models\User;
use App\models\Role;

/* START: AuthService — authentication, PIN validation, lockout and session lifecycle */
class AuthService
{
    /* START: loginWithPin — verifies credentials and logs in the user */
    public static function loginWithPin(string $phoneInput, string $pin, array $meta = []): array
    {
        $normalizedPhone = PhoneService::normalize($phoneInput);
        if (!$normalizedPhone) {
            return [
                'success' => false,
                'status'  => 422,
                'message' => 'Invalid Philippine mobile number format (e.g. 0917 123 4567)'
            ];
        }

        $minLen = (int)($_ENV['PIN_MIN_LENGTH'] ?? 4);
        $maxLen = (int)($_ENV['PIN_MAX_LENGTH'] ?? 6);
        $pinLen = strlen($pin);

        if ($pinLen < $minLen || $pinLen > $maxLen || !ctype_digit($pin)) {
            return [
                'success' => false,
                'status'  => 422,
                'message' => "PIN must be between {$minLen} and {$maxLen} numeric digits"
            ];
        }

        $user = User::findByPhone($normalizedPhone);
        if (!$user) {
            ActivityLogger::log('login_failed_unknown_phone', null, 'Phone not found: ' . $normalizedPhone, $meta);
            return [
                'success' => false,
                'status'  => 401,
                'message' => 'Invalid phone number or PIN entered'
            ];
        }

        if (($user['status'] ?? 'active') !== 'active') {
            ActivityLogger::log('login_failed_inactive', (int)$user['id'], 'Account inactive', $meta);
            return [
                'success' => false,
                'status'  => 403,
                'message' => 'Your account is currently inactive. Please contact your administrator.'
            ];
        }

        // Check if locked
        if (!empty($user['locked_until'])) {
            $lockTime = strtotime($user['locked_until']);
            if ($lockTime > time()) {
                $minutesRemaining = ceil(($lockTime - time()) / 60);
                ActivityLogger::log('login_blocked_locked', (int)$user['id'], 'Account locked until ' . $user['locked_until'], $meta);
                return [
                    'success' => false,
                    'status'  => 423,
                    'message' => "Account is temporarily locked due to too many failed attempts. Try again in {$minutesRemaining} minute(s)."
                ];
            }
        }

        // Verify PIN hash
        if (!password_verify($pin, $user['pin_hash'])) {
            $maxAttempts = (int)($_ENV['PIN_MAX_ATTEMPTS'] ?? 5);
            $lockMinutes = (int)($_ENV['PIN_LOCK_MINUTES'] ?? 15);
            $attempts = User::recordFailedAttempt((int)$user['id'], (int)$user['failed_pin_attempts'], $maxAttempts, $lockMinutes);
            $remaining = max(0, $maxAttempts - $attempts);

            ActivityLogger::log('login_failed_wrong_pin', (int)$user['id'], "Failed attempt #{$attempts}", $meta);

            if ($remaining === 0) {
                return [
                    'success' => false,
                    'status'  => 423,
                    'message' => "Account has been locked for {$lockMinutes} minutes due to {$maxAttempts} consecutive failed attempts."
                ];
            }

            return [
                'success' => false,
                'status'  => 401,
                'message' => "Incorrect PIN. You have {$remaining} attempt(s) remaining.",
                'attempts_left' => $remaining
            ];
        }

        // PIN is valid: update login record & session
        User::updateLastLogin((int)$user['id']);

        $role = Role::find((int)$user['role_id']);
        $redirectPath = $role['redirect_path'] ?? '/dashboard/';

        Session::regenerate();
        Session::set('user_id', (int)$user['id']);
        Session::set('user_name', $user['full_name']);
        Session::set('user_phone', $user['phone']);
        Session::set('role_id', (int)$user['role_id']);
        Session::set('role_slug', $role['slug'] ?? 'admin');

        ActivityLogger::log('login_success', (int)$user['id'], 'PIN login successful', $meta);

        return [
            'success'  => true,
            'status'   => 200,
            'message'  => 'Sign in successful',
            'redirect' => $redirectPath,
            'user'     => [
                'id'    => (int)$user['id'],
                'name'  => $user['full_name'],
                'phone' => $user['phone'],
                'role'  => $role['slug'] ?? 'admin'
            ]
        ];
    }
    /* END: loginWithPin */

    /* START: logout — terminates active user session */
    public static function logout(): void
    {
        $userId = Session::get('user_id');
        if ($userId) {
            ActivityLogger::log('logout', (int)$userId, 'User signed out');
        }
        Session::destroy();
    }
    /* END: logout */

    /* START: user — returns current authenticated session user data */
    public static function user(): ?array
    {
        if (!Session::has('user_id')) {
            return null;
        }

        return [
            'id'    => Session::get('user_id'),
            'name'  => Session::get('user_name'),
            'phone' => Session::get('user_phone'),
            'role'  => Session::get('role_slug'),
        ];
    }
    /* END: user */

    /* START: check — checks if a valid authenticated session exists */
    public static function check(): bool
    {
        return Session::has('user_id');
    }
    /* END: check */
}
/* END: AuthService */
