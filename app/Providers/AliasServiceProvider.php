<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Milon\Barcode\Facades\DNS2DFacade;
use Milon\Barcode\Facades\DNS1DFacade;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Barcode1D', DNS2DFacade::class);
        $loader->alias('Barcode2D', DNS1DFacade::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
