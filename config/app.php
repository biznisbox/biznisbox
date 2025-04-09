<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'BiznisBox'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application installed
    |--------------------------------------------------------------------------
    | This value determines if the application is installed.
    | This value is automatically set to true when the application is installed.
    */

    'installed' => env('APP_INSTALLED', false),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'available_locales' => [
        ['locale' => 'Slovenian', 'code' => 'sl'],
        ['locale' => 'English', 'code' => 'en'],
        ['locale' => 'German', 'code' => 'de'],
        ['locale' => 'Spanish', 'code' => 'es'],
        ['locale' => 'French', 'code' => 'fr'],
        ['locale' => 'Italian', 'code' => 'it'],
        ['locale' => 'Portuguese', 'code' => 'pt'],
        ['locale' => 'Russian', 'code' => 'ru'],
        ['locale' => 'Chinese', 'code' => 'zh'],
        ['locale' => 'Dutch', 'code' => 'nl'],
        ['locale' => 'Norwegian', 'code' => 'no'],
        ['locale' => 'Danish', 'code' => 'da'],
        ['locale' => 'Swedish', 'code' => 'sv'],
        ['locale' => 'Finnish', 'code' => 'fi'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [...array_filter(explode(',', env('APP_PREVIOUS_KEYS', '')))],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    | This value determines if the application is in demo mode. In demo mode,
    | the application will have limited functionality and will not allow
    | certain actions, such as creating or deleting records. This is useful
    | for demonstration purposes or for testing the application without
    | affecting the production data.
    |
    */
    'demo' => [
        'enabled' => env('APP_DEMO_MODE', false),
        'username' => env('APP_DEMO_USERNAME', 'demo@example.com'),
        'password' => env('APP_DEMO_PASSWORD', 'password'),
    ],
];
