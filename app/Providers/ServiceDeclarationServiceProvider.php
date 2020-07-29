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
        $this->app->singleton(\App\Services\TrapService::class, function ($app) {
            return new \App\Services\TrapService(app(\App\Repositories\TrapRepository::class));
        });
        $this->app->singleton(\App\Services\SpellService::class, function ($app) {
            return new \App\Services\SpellService(app(\App\Repositories\SpellRepository::class));
        });
        $this->app->singleton(\App\Services\MonsterService::class, function ($app) {
            return new \App\Services\MonsterService(app(\App\Repositories\MonsterRepository::class));
        });
        $this->app->singleton(\App\Services\CardService::class, function ($app) {
            return new \App\Services\CardService(app(\App\Repositories\CardRepository::class));
        });
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
