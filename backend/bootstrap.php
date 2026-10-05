<?php
/* START: Bootstrap — application initialization, autoloader, environment and session */

$rootPath = dirname(__DIR__);

// Load Composer autoloader
if (file_exists($rootPath . '/vendor/autoload.php')) {
    require_once $rootPath . '/vendor/autoload.php';
}

// Load .env configuration
if (class_exists(\Dotenv\Dotenv::class) && file_exists($rootPath . '/config/.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable($rootPath . '/config');
    $dotenv->safeLoad();
}

// Configure error reporting based on APP_DEBUG
$debug = filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN);
if ($debug) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

// Start secure session if not CLI
if (php_sapi_name() !== 'cli') {
    \App\core\Session::start();
}

/* END: Bootstrap */
