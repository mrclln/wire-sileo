<?php

declare(strict_types=1);

namespace Sileo;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class SileoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/wire-sileo.php',
            'wire-sileo'
        );

        $this->app->singleton(Sileo::class, function ($app) {
            return new Sileo(null);
        });

        $this->app->singleton('sileo', function ($app) {
            return new Sileo(null);
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wire-sileo');

        if (class_exists(Livewire::class)) {
            Livewire::component('wire-sileo', Components\WireSileo::class);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/wire-sileo.php' => config_path('wire-sileo.php'),
            ], 'wire-sileo-config');

            $this->publishes([
                __DIR__ . '/../resources/js/wire-sileo.js' => resource_path('js/wire-sileo.js'),
            ], 'wire-sileo-js');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/wire-sileo'),
            ], 'wire-sileo-views');

            $this->publishes([
                __DIR__ . '/../config/wire-sileo.php' => config_path('wire-sileo.php'),
                __DIR__ . '/../resources/js/wire-sileo.js' => resource_path('js/wire-sileo.js'),
                __DIR__ . '/../resources/views' => resource_path('views/vendor/wire-sileo'),
            ], 'wire-sileo');
        }
    }

    protected function currentLivewireComponent($app): ?\Livewire\Component
    {
        if (! $app->bound('livewire')) {
            return null;
        }

        $component = $app['livewire']->current();

        return $component instanceof \Livewire\Component ? $component : null;
    }
}
