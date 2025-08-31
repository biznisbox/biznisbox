<?php

return [
    App\Providers\AliasServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\MailConfigServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,
    Milon\Barcode\BarcodeServiceProvider::class,
    PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
