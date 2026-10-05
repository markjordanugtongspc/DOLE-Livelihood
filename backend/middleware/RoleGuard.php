<?php
namespace App\middleware;

use App\core\Session;
use App\core\Response;

/* START: RoleGuard — role-based access control and redirection */
class RoleGuard
{
    /* START: requireRole — checks if current session matches required role(s) */
    public static function requireRole(array|string $roles): void
    {
        Session::start();
        $userRole = Session::get('role_slug');
        $allowed = is_array($roles) ? $roles : [$roles];

        if (!in_array($userRole, $allowed, true)) {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api')) {
                Response::error('Forbidden: insufficient permissions', null, 403);
            } else {
                http_response_code(403);
                echo 'Access Forbidden: Insufficient permissions.';
                exit;
            }
        }
    }
    /* END: requireRole */
}
/* END: RoleGuard */
