<?php
namespace App\controllers;

use App\core\Request;
use App\core\Response;
use App\services\AuthService;
use App\services\OtpService;

/* START: AuthController — handles authentication API requests */
class AuthController extends BaseController
{
    /* START: login — processes PIN login request */
    public function login(): void
    {
        $this->validateCsrf();

        $phone = (string)Request::json('phone', '');
        $pin   = (string)Request::json('pin', '');
        $meta  = (array)Request::json('meta', []);

        $errors = $this->validate(
            ['pin' => $pin],
            ['pin' => 'required']
        );

        if ($errors) {
            Response::error('Validation failed', $errors, 422);
            return;
        }

        $result = AuthService::loginWithPin($phone, $pin, $meta);

        if (!$result['success']) {
            Response::json(false, $result['message'], $result['attempts_left'] ?? null, null, $result['status'] ?? 400);
            return;
        }

        $redirectUrl = './frontend/pages/dashboard/';

        Response::json(true, $result['message'], [
            'redirect'     => $redirectUrl,
            'redirect_url' => $redirectUrl,
            'user'         => $result['user']
        ], null, 200);
    }
    /* END: login */

    /* START: logout — terminates user session */
    public function logout(): void
    {
        AuthService::logout();
        $base = \App\core\Vite::getBaseDir();
        $redirectUrl = $base !== '' ? $base . '/' : '/';
        Response::success('Signed out successfully', [
            'redirect'     => $redirectUrl,
            'redirect_url' => $redirectUrl,
        ]);
    }
    /* END: logout */

    /* START: me — returns current authenticated user */
    public function me(): void
    {
        $user = AuthService::user();
        if (!$user) {
            Response::error('Unauthenticated', null, 401);
            return;
        }

        Response::success('User details', ['user' => $user]);
    }
    /* END: me */

    /* START: requestOtp — placeholder endpoint for requesting OTP */
    public function requestOtp(): void
    {
        $this->validateCsrf();
        $phone = (string)Request::json('phone', '');

        if (empty($phone)) {
            Response::error('Phone number is required', null, 422);
            return;
        }

        $result = OtpService::request($phone);
        if (!$result['success']) {
            Response::error($result['message'], null, 400);
            return;
        }

        Response::success($result['message'], $result);
    }
    /* END: requestOtp */

    /* START: verifyOtp — placeholder endpoint for verifying OTP */
    public function verifyOtp(): void
    {
        $this->validateCsrf();
        $phone = (string)Request::json('phone', '');
        $code  = (string)Request::json('code', '');

        $result = OtpService::verify($phone, $code);
        if (!$result['success']) {
            Response::error($result['message'], null, 400);
            return;
        }

        Response::success($result['message'], $result);
    }
    /* END: verifyOtp */
}
/* END: AuthController */
