<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Symfony\Component\HttpFoundation\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Trusting the proxy to get the real IP address
        Request::setTrustedProxies(
            ['REMOTE_ADDR'],
            Request::HEADER_X_FORWARDED_FOR
        );
    }
}
