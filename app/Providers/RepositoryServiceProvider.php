<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Moldova\Repositories\Tenders\TendersRepositoryInterface'                 =>
            'App\Moldova\Repositories\Tenders\TendersRepository',
        'App\Moldova\Repositories\Contracts\ContractsRepositoryInterface'             =>
            'App\Moldova\Repositories\Contracts\ContractsRepository',
        'App\Moldova\Repositories\ProcuringAgency\ProcuringAgencyRepositoryInterface' =>
            'App\Moldova\Repositories\ProcuringAgency\ProcuringAgencyRepository',
        'App\Moldova\Repositories\Goods\GoodsRepositoryInterface'                     =>
            'App\Moldova\Repositories\Goods\GoodsRepository',
        'App\Moldova\Repositories\Subscriptions\SubscriptionsRepositoryInterface'                     =>
            'App\Moldova\Repositories\Subscriptions\SubscriptionsRepository'
    ];

    /**
     * Bind All the repository interface to their respective repository
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}