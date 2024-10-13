<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />
        <!-- BiznisBox intranet is not for search engines -->
        @vite('resources/css/app.css')
        @if (isAppInstalled())
        @if (settings('company_logo'))
        <link
            rel="icon"
            href="{{'/storage/'.settings('company_logo') }}"
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
            <strong>{{ __('responses.enable_js_to_use_app') }}</strong>
        </noscript>
        <div id="app"></div>
        @vite('resources/js/app.js')
    </body>
</html>
