<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Handler\LogglyHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $log =$this->app['log'];
        $handler = new LogglyHandler(getenv('LOGGLY_TOKEN'));
        $handler->setTag('Moldocds' .strtolower(app()->environment()));
        $log->pushHandler($handler);
    }
}
