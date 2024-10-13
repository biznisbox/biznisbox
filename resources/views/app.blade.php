<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />
        <!-- BiznisBox intranet is not for search engines -->
        @vite('resources/css/app.css')
        @if (config('app.installed'))
            @if (settings('company_logo_path'))
                <link
                    rel="icon"
                    type="{{ mime_content_type(settings('company_logo_path')) }}"
                    href="{{ settings('company_logo_path') }}"
                />
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
            <strong>We're sorry but this app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app"></div>
        @vite('resources/js/app.js')
    </body>
</html>
