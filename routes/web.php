<?php

use Illuminate\Support\Facades\Route;

// Fix for redirecting to login page when user is not authenticated
Route::get('/health', function () {
    return dockerHealthResponse();
});

Route::get('/auth/login', function () {
    return view('app');
})->name('login');

// Install route
Route::get('/install', function () {
    return view('app');
})->name('install');

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
