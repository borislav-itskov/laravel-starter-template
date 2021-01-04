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
        $this->app->singleton(\App\Repositories\TrapRepository::class, function ($app) {
            return new \App\Repositories\TrapRepository(new \App\Models\Trap());
        });
        $this->app->singleton(\App\Repositories\SpellRepository::class, function ($app) {
            return new \App\Repositories\SpellRepository(new \App\Models\Spell());
        });
        $this->app->singleton(\App\Repositories\MonsterRepository::class, function ($app) {
            return new \App\Repositories\MonsterRepository(new \App\Models\Monster());
        });
        $this->app->singleton(\App\Repositories\CardRepository::class, function ($app) {
            return new \App\Repositories\CardRepository(new \App\Models\Card());
        });
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
