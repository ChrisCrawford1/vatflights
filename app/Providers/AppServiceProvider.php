<?php

namespace App\Providers;

use App\Services\Contracts\IStatsService;
use App\Services\FlightStatisticsDataService;
use App\Services\VatsimDataService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\IDataService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IDataService::class, VatsimDataService::class);
        $this->app->bind(IStatsService::class, FlightStatisticsDataService::class);
    }
}
