<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

        <!-- BiznisBox intranet is not for search engines -->
        @vite('resources/css/app.css')
        @if (isAppInstalled())
            @if (settings('company_logo'))
                <link rel="icon" href="{{ url('storage/' . settings('company_logo')) }}" />
            @endif

            <script>
                window.App = {!!
                    json_encode([
                        'settings' => \getPublicSettings(),
                    ])
                !!}
            </script>
        @endif
    </head>

    <body>
        <noscript>
            <strong>{{ __('responses.enable_js_to_use_app') }}</strong>
        </noscript>
        <div id="app"></div>
        @vite('resources/js/app.js')
    </body>
</html>
