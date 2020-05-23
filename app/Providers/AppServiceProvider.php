<?php

namespace App\Providers;

use App\Util\DB;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GuzzleHttp\Client', function($app) {
            return new Client([
                'base_uri' => config('app.destiny_api_uri'),
                'headers' => ['X-API-Key' => config('app.destiny_api_key')],
                'curl' => [CURLOPT_SSL_VERIFYPEER => false]
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
