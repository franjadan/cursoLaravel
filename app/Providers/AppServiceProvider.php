<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Sortable;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Sortable::class, function($app) {
            return new Sortable(request()->url());
        });
    }
}
