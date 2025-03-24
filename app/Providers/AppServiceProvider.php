<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Knuckles\Scribe\Scribe;
use Knuckles\Camel\Extraction\ExtractedEndpointData;

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
        // Trust the X-Forwarded-For header (for getting client IP address)
        Request::setTrustedProxies(['REMOTE_ADDR'], Request::HEADER_X_FORWARDED_FOR);

        // For generating API documentation
        if (class_exists(\Knuckles\Scribe\Scribe::class)) {
            Scribe::beforeResponseCall(function (Request $request, ExtractedEndpointData $endpointData) {
                // Add a header to all requests
                $token = 'your-token-here';
                $request->headers->set('Authorization', 'Bearer ' . $token);
                Log::info('Endpoint hit: ' . $endpointData->metadata->title);
            });
        }
    }
}
