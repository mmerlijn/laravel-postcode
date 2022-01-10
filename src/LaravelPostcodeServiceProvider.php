<?php

namespace mmerlijn\laravelPostcode;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use mmerlijn\laravelHelpers\Classes\Distance;


class LaravelPostcodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/postcode.php', 'postcode'
        );

        //$this->app->bind('distance', function ($app) {
        //    return new Distance();
        //});
    }

    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/postcode.php' => config_path('postcode.php'),
            ], 'config');
        }
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerApiRoutes();

    }

    protected function registerApiRoutes()
    {
        Route::group(config('postcode.route'), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/postcode.php');
        });
    }
}