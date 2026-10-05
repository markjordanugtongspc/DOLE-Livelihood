<?php
namespace App\middleware;

use App\core\Session;

/* START: AuthGuard — redirects unauthenticated users or active sessions */
class AuthGuard
{
    /* START: requireAuth — enforces authenticated session or redirects to login */
    public static function requireAuth(string $redirectTo = '/'): void
    {
        Session::start();
        if (!Session::has('user_id')) {
            header("Location: {$redirectTo}");
            exit;
        }
    }
    /* END: requireAuth */

    /* START: requireGuest — redirects authenticated users away from login page */
    public static function requireGuest(string $redirectTo = '/dashboard/'): void
    {
        Session::start();
        if (Session::has('user_id')) {
            header("Location: {$redirectTo}");
            exit;
        }
    }
    /* END: requireGuest */
}
/* END: AuthGuard */
