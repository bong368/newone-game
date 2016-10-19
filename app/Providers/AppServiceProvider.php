<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Lsrur\Inspector\InspectorServiceProvider::class);
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Inspector', \Lsrur\Inspector\Facade\Inspector::class);
        }
    }
}
