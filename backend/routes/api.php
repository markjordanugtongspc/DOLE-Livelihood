<?php
/* START: ApiRoutes — register all backend API endpoints */

use App\core\Router;

// Authentication routes
Router::post('/auth/login', 'AuthController@login');
Router::post('/auth/logout', 'AuthController@logout');
Router::get('/auth/me', 'AuthController@me');

// Future OTP endpoints (placeholders)
Router::post('/auth/otp/request', 'AuthController@requestOtp');
Router::post('/auth/otp/verify', 'AuthController@verifyOtp');

// Ping test route
Router::get('/ping', function () {
    \App\core\Response::success('Livelihood API is healthy', [
        'timestamp' => date('Y-m-d H:i:s'),
        'version'   => '1.0.0'
    ]);
});

/* END: ApiRoutes */
