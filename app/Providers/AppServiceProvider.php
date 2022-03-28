<?php

namespace App\Providers;

use App\Support\Mockend\Fields\SequenceGenerator;
use App\Support\Mockend\Mockend;
use App\Support\Mockend\RouteRegistrar;
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
        $this->app->singleton(Mockend::class);
        $this->app->singleton(RouteRegistrar::class);
        $this->app->singleton(SequenceGenerator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!$this->app->runningUnitTests()) {
            $this->app->make(Mockend::class)->init();
        }
    }
}
