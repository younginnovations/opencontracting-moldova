<?php

use Monolog\Handler\LogglyHandler;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->register('Jenssegers\Mongodb\MongodbServiceProvider');
//$app->register('Maatwebsite\Excel\ExcelServiceProvider');

$app->withFacades();
class_alias('Illuminate\Support\Facades\Request', 'Request');
class_alias('Illuminate\Support\Facades\Response', 'Response');
class_alias('Maatwebsite\Excel\Facades\Excel', 'Excel');


$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\RepositoryServiceProvider::class);
$app->register(App\Providers\DevelopmentServiceProvider::class);
$app->register(Maatwebsite\Excel\ExcelServiceProvider::class);


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . '/../app/Http/routes.php';

});

if (getenv('APP_ENV') == "local") {
    $app->get('logs', 'Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}


$app->configure('database');

if (getenv('APP_ENV') != "local") {
    $app->configureMonologUsing(function ($monolog) {
        $monolog->pushHandler(new LogglyHandler(getenv('LOGGLY_TOKEN')));

        return $monolog;
    });
}

//function request()
//{
//    return app('request');
//}

return $app;
