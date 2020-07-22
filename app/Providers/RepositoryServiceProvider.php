<?php

namespace App\Providers;

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
        // DO NOT REMOVE THIS COMMENT AS IT'S USED FOR AUTO-REGISTRATION
        $this->app->singleton(\App\Repositories\UserRepository::class, function ($app) {
            return new \App\Repositories\UserRepository(new \App\Models\User());
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
