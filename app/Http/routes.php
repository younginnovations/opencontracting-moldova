<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//$app->get('/', function () use ($app) {
//    return dd(config('database.default'));
//});

$app->get('/home', function () use ($app) {
    return view('landing-page');
});

$app->get('/contractDetail', function () use ($app) {
    return view('contract-detail');
});

$app->get(
    '/',
    ['as' => '/', 'uses' => 'HomeController@index']
);

$app->get(
    '/datatable',
    ['as' => '/datatable', 'uses' => 'HomeController@datatable']
);

$app->get(
    '/contractor/{name}',
    [
        'as'   => 'contractor',
        'uses' => 'ContractController@show'
    ]
);

$app->get(
    '/procuring-agency/{name}',
    [
        'as'   => 'procuring-agency',
        'uses' => 'ProcuringAgencyController@show'
    ]
);

$app->get(
    '/goods/{name}',
    [
        'as'   => 'goods',
        'uses' => 'GoodsController@show'
    ]
);

$app->get(
    '/filter',
    [
        'as'   => 'filter',
        'uses' => 'HomeController@filter'
    ]
);

$app->get(
    '/api/data',
    [
        'as' => 'api.data',
        'uses' => 'HomeController@getdata'
    ]
);
