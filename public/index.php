<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';


// Check if the .env file exists and create it if it doesn't
if(!file_exists(__DIR__.'/../.env')) {
    copy(__DIR__.'/../.env.example', __DIR__.'/../.env');
}

if(file_exists(__DIR__.'/../.env') && !file_exists(__DIR__.'/../install.lock')) {
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/install') === false && strpos($_SERVER['REQUEST_URI'], '/countries?') === false) {
        header('Location: /install');
        exit;
    }
}

// Bootstrap Laravel and handle the request...
// prettier-ignore
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
