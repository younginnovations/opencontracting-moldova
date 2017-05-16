<?php

namespace App\Providers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Goods;
use App\Moldova\Service\ProcuringAgency;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Contracts       $contracts
     * @param ProcuringAgency $procuringAgency
     *
     * @return void
     */
    public function boot(Contracts $contracts, ProcuringAgency $procuringAgency, Goods $goods_services)
    {
        $goods      = $goods_services->allGoods();
        $contracts  = $contracts->getAllContractTitle();
        $procurings = $procuringAgency->getAllProcuringAgencyTitle();
        // share data between views
        view()->share(['all_contracts' => $contracts, 'procurings' => $procurings, 'goodsList' => $goods]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
