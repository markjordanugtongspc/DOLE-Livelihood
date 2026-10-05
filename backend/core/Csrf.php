<?php
namespace App\core;

/* START: Csrf — Cross-Site Request Forgery protection */
class Csrf
{
    /* START: token — gets or creates the active session CSRF token */
    public static function token(): string
    {
        Session::start();
        $token = Session::get('csrf_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            Session::set('csrf_token', $token);
        }
        return $token;
    }
    /* END: token */

    /* START: verify — validates an incoming token against the stored session token */
    public static function verify(?string $token): bool
    {
        Session::start();
        $stored = Session::get('csrf_token');
        if (!$token || !$stored) {
            return false;
        }
        return hash_equals($stored, $token);
    }
    /* END: verify */
}
/* END: Csrf */
