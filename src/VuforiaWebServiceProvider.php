<?php

namespace WKasunSampath\LaravelVuforia;

use Illuminate\Support\ServiceProvider;

class VuforiaWebServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/laravel_vuforia.php', 'laravel_vuforia');

        $this->app->singleton(VuforiaWebService::class, function ($app) {
            return VuforiaWebService::create(config('laravel_vuforia'));
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/laravel_vuforia.php' => config_path('laravel_vuforia.php'),
        ], 'laravel_vuforia');

        $this->publishes([
            __DIR__ . '/stubs/VuforiaJob.stub' => app_path('Jobs/VuforiaJob.php'),
        ], 'jobs');

        $this->publishes([
            __DIR__ . '/stubs/VuforiaNotification.stub' => app_path('Notifications/VuforiaNotification.php'),
        ], 'notifications');
    }
}
