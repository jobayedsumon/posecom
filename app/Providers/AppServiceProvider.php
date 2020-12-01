<?php

namespace App\Providers;

use App\Charts\SampleChart;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
     * @param SampleChart $chart
     * @return void
     */
    public function boot()
    {

    }
}
