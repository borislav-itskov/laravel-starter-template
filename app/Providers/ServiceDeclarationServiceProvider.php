<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceDeclarationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // DO NOT REMOVE THIS COMMENT AS IT'S USED FOR AUTO-REGISTRATION
        $this->app->singleton(\App\Services\UserService::class, function ($app) {
            return new \App\Services\UserService(app(\App\Repositories\UserRepository::class));
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
