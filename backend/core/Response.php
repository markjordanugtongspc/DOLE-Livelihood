<?php
namespace App\core;

/* START: Response — uniform JSON and HTTP response helper */
class Response
{
    /* START: json — sends JSON response with standard envelope format */
    public static function json(
        bool $success,
        string $message,
        mixed $data = null,
        mixed $errors = null,
        int $statusCode = 200
    ): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
            'errors'  => $errors,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        exit;
    }
    /* END: json */

    /* START: success — sends 200 success response */
    public static function success(string $message, mixed $data = null, int $statusCode = 200): void
    {
        self::json(true, $message, $data, null, $statusCode);
    }
    /* END: success */

    /* START: error — sends error response */
    public static function error(string $message, mixed $errors = null, int $statusCode = 400): void
    {
        self::json(false, $message, null, $errors, $statusCode);
    }
    /* END: error */
}
/* END: Response */
