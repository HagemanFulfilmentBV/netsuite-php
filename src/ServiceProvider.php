<?php

namespace Hageman\NetSuite;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/netsuite.php', 'netsuite');
        }
    }

    /**
     * @return void
     */
    public function register(): void
    {
        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/netsuite.php' => config_path('netsuite.php'),
            ], 'netsuite-config');
        }
    }
}
