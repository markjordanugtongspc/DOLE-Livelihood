<?php
namespace App\core;

/* START: Session — secure session management wrapper */
class Session
{
    /* START: start — starts and configures secure cookie session */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $sessionName = $_ENV['SESSION_NAME'] ?? 'LVHSESSID';
            session_name($sessionName);

            $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'domain'   => '',
                'secure'   => $isSecure,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            session_start();

            // Check idle expiration
            self::checkIdle();
        }
    }
    /* END: start */

    /* START: checkIdle — enforces session idle expiration */
    private static function checkIdle(): void
    {
        $idleMinutes = (int)($_ENV['SESSION_IDLE_MINUTES'] ?? 30);
        $maxIdleSeconds = $idleMinutes * 60;

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $maxIdleSeconds)) {
            self::destroy();
            return;
        }

        $_SESSION['last_activity'] = time();
    }
    /* END: checkIdle */

    /* START: set — sets a session key-value pair */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }
    /* END: set */

    /* START: get — retrieves a session key value or fallback */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    /* END: get */

    /* START: has — checks whether a session key exists */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }
    /* END: has */

    /* START: remove — unsets a session key */
    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }
    /* END: remove */

    /* START: regenerate — regenerates session id to prevent fixation */
    public static function regenerate(): void
    {
        self::start();
        session_regenerate_id(true);
    }
    /* END: regenerate */

    /* START: destroy — completely terminates the session */
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }
            session_destroy();
        }
    }
    /* END: destroy */
}
/* END: Session */
