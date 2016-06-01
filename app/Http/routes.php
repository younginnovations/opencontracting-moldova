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
    '/contracts/contractor',
    [
        'as'   => 'contracts.contractorIndex',
        'uses' => 'ContractController@contractorIndex'
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
    '/contracts/{id}/json',
    [
        'as'   => 'contracts.jsonView',
        'uses' => 'ContractController@jsonView'
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
    '/api/contactorData',
    [
        'as'   => 'api.contactorData',
        'uses' => 'HomeController@getContractorData'
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

$app->post(
    '/subscriptions/add',
    [
        'as'   => 'subscriptions.add',
        'uses' => 'SubscriptionsController@add'
    ]
);

$app->get('/about',function(){
    return view('about');
});

$app->get('/error',function(){
    return view('error_404');
});

$app->get('/contact', function () {
    return view('contact');
});

$app->post(
    '/contact',
    [
        'as'   => 'home.contact',
        'uses' => 'HomeController@sendMessage'
    ]
);

$app->post(
    '/contracts',
    [
        'as'   => 'contracts.feedback',
        'uses' => 'ContractController@sendMessage'
    ]
);
$app->get('/export', ['as' => 'home.export', 'uses' => 'HomeController@export']);
$app->get('contractor-detail/export/{name}', ['as' => 'contractorDetail.export', 'uses' => 'ContractController@contractorDetailExport']);
$app->get('agency-detail/export/{name}', ['as' => 'agencyDetail.export', 'uses' => 'ProcuringAgencyController@agencyDetailExport']);
$app->get('goods-detail/export/{name}', ['as' => 'goodsDetail.export', 'uses' => 'GoodsController@goodsDetailExport']);

$app->get('goods/export', ['as' => 'goods.export', 'uses' => 'GoodsController@exportGoods']);
$app->get('agency/export', ['as' => 'agency.export', 'uses' => 'ProcuringAgencyController@exportAgencies']);
$app->get('contractor/export', ['as' => 'contractor.export', 'uses' => 'ContractController@exportContractors']);
$app->get('tender/export', ['as' => 'tender.export', 'uses' => 'TenderController@exportTenders']);
$app->get('tender-goods/export/{id}', ['as' => 'tenderGoods.export', 'uses' => 'TenderController@exportTenderGoods']);
$app->get('tender-contracts/export/{id}', ['as' => 'tenderContracts.export', 'uses' => 'TenderController@exportTenderContracts']);

$app->get(
    '/goods/{name}',
    [
        'as'   => 'goods',
        'uses' => 'GoodsController@show'
    ]
);