<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\Chart;

/**
 * This is the Chart Service Provider class
 */
class ChartServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the contract to concert Chart() class
        $this->app->bind('App\Helpers\Contracts\ChartContract', function() {
            return new Chart();
        });
    }
}
