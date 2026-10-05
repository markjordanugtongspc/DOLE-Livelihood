<?php
namespace App\core;

/* START: Request — HTTP request parser and utility wrapper */
class Request
{
    private static ?array $jsonBody = null;

    /* START: method — returns normalized request method */
    public static function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }
    /* END: method */

    /* START: uri — returns normalized path without query string */
    public static function uri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        return rtrim($uri, '/') ?: '/';
    }
    /* END: uri */

    /* START: json — parses and returns JSON payload */
    public static function json(?string $key = null, mixed $default = null): mixed
    {
        if (self::$jsonBody === null) {
            $input = file_get_contents('php://input');
            self::$jsonBody = json_decode($input, true) ?: [];
        }

        if ($key === null) {
            return self::$jsonBody;
        }

        return self::$jsonBody[$key] ?? $default;
    }
    /* END: json */

    /* START: header — retrieves specific request header */
    public static function header(string $name): ?string
    {
        $name = str_replace('-', '_', strtoupper($name));
        return $_SERVER['HTTP_' . $name] ?? null;
    }
    /* END: header */

    /* START: ip — resolves client IP address */
    public static function ip(): string
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($list[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
    /* END: ip */

    /* START: userAgent — retrieves client user agent string */
    public static function userAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }
    /* END: userAgent */
}
/* END: Request */
