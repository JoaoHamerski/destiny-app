<?php

namespace App\Providers;

use App\Util\Helper;
use App\Util\Resolve;
use Illuminate\Support\ServiceProvider;

class UtilServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('helper', function() {
            return new Helper();
        });

        $this->app->bind('resolve', function() {
            return new Resolve();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
