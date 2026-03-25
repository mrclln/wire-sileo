<?php

namespace mrclln\WireSileo;

use Illuminate\Support\ServiceProvider;

class WireSileoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package services.
     */
    public function boot(): void
    {
        $this->registerPublishables();
    }

    /**
     * Register the package services.
     */
    public function register(): void
    {
        $this->app->bind(WireSileo::class, function ($app) {
            return new WireSileo($app['livewire']->current());
        });

        $this->app->bind('wire-sileo', function ($app) {
            return new WireSileo($app['livewire']->current());
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/wire-sileo.php',
            'wire-sileo'
        );
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishables(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/wire-sileo.php' => config_path('wire-sileo.php'),
            ], 'wire-sileo:config');
        }
    }
}
