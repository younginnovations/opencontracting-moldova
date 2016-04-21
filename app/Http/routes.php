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
    '/contracts',
    [
        'as'   => 'contracts',
        'uses' => 'ContractController@index'
    ]
);

$app->get(
    '/contracts/contractor/{name}',
    [
        'as'   => 'contracts.contractor',
        'uses' => 'ContractController@show'
    ]
);

$app->get(
    '/contracts/{id}',
    [
        'as'   => 'contracts.view',
        'uses' => 'ContractController@view'
    ]
);

$app->get(
    '/procuring-agency/{name}',
    [
        'as'   => 'procuring-agency.show',
        'uses' => 'ProcuringAgencyController@show'
    ]
);

$app->get(
    '/procuring-agency',
    [
        'as'   => 'procuring-agency.index',
        'uses' => 'ProcuringAgencyController@index'
    ]
);

$app->get(
    '/api/procuring-agency',
    [
        'as'   => 'procuring-agency.api',
        'uses' => 'ProcuringAgencyController@getProcuringAgency'
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
    '/goods',
    [
        'as'   => 'goods.index',
        'uses' => 'GoodsController@index'
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
        'as'   => 'api.data',
        'uses' => 'HomeController@getData'
    ]
);

$app->get(
    '/search',
    [
        'as'   => 'search',
        'uses' => 'HomeController@search'
    ]
);

$app->get(
    '/tenders',
    [
        'as'   => 'tenders.index',
        'uses' => 'TenderController@index'
    ]
);

$app->get(
    '/api/tenders',
    [
        'as'   => 'tenders.api',
        'uses' => 'TenderController@getTenders'
    ]
);

$app->get(
    '/tenders/{tender}',
    [
        'as'   => 'tenders.show',
        'uses' => 'TenderController@show'
    ]
);

$app->get(
    '/api/goods',
    [
        'as'   => 'goods.api',
        'uses' => 'GoodsController@getAllGoods'
    ]
);

$app->get('/about',function(){
    return view('about');
});

$app->get('/contact',function(){
    return view('contact');
});
