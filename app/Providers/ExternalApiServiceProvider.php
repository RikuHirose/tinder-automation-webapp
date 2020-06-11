<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ExternalApiServiceProvider extends ServiceProvider
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
        // write

        // TinderExternalApi
        $this->app->singleton(
            \packages\Infrastructure\ExternalApi\Tinder\TinderExternalApiInterface::class,
            \packages\Infrastructure\ExternalApi\Tinder\TinderExternalApi::class
        );
    }
}
