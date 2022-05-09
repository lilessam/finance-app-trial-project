<?php

namespace App\Providers;

use App\Repositories\Base;
use App\Repositories\Contracts\CSVsRepository;
use App\Repositories\Contracts\Repository;
use App\Repositories\Contracts\TransactionRepository;
use App\Repositories\CSVS;
use App\Repositories\Transactions;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repository::class, Base::class);
        $this->app->bind(TransactionRepository::class, Transactions::class);
        $this->app->bind(CSVsRepository::class, CSVS::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
