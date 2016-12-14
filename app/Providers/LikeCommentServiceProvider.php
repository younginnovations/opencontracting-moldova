<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LikeCommentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/laravelLikeComment'),
            __DIR__.'/migrations' => database_path('migrations'),
            __DIR__.'/public/assets' => public_path('vendor/laravelLikeComment'),
            __DIR__.'/config/laravelLikeComment.php' => config_path('laravelLikeComment.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Route
        include app_path().'/Http/routes.php';

        $this->app['LaravelLikeComment'] = $this->app->share(function($app) {
            return new LaravelLikeComment;
        });

        // Config
        $this->mergeConfigFrom( config_path().'/laravelLikeComment.php', 'laravelLikeComment');

        // View
        $this->loadViewsFrom(resource_path().'/views', 'laravelLikeComment');
    }
}
