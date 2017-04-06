<?php

namespace App\Providers;

use App\Http\ViewCompose\MetaTagComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['index', 'tender.*', 'about', 'contracts.*', 'agency.*', 'goods.*', 'contact', 'search', 'wiki.*', 'admin.*','downloads'],

            MetaTagComposer::class
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
