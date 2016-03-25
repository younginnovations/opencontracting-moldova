<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Moldova\Repositories\Tenders\TendersRepositoryInterface' =>
            'App\Moldova\Repositories\Tenders\TendersRepository',
        'App\Moldova\Repositories\Contracts\ContractsRepositoryInterface' =>
            'App\Moldova\Repositories\Contracts\ContractsRepository'
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