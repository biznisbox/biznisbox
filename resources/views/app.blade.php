<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @vite('resources/css/app.css')
        @if (config('app.installed'))
            <link rel="apple-touch-icon" sizes="180x180" href="{{ settings('company_logo_path') }}" />
            <link rel="icon" type="image/x-icon" href="{{ settings('company_logo_path') }}" />
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
            <strong>We're sorry but this app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app"></div>
        @vite('resources/js/app.js')
    </body>
</html>
