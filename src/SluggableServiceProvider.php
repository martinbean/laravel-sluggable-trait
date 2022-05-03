<?php

namespace MartinBean\Database\Eloquent;

use Illuminate\Support\ServiceProvider;

class SluggableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sluggable.php',
            'sluggable'
        );

        $this->publishes([
            __DIR__ . '/../config/sluggable.php' => $this->app->configPath() . '/sluggable.php',
        ], 'sluggable-config');
    }
}
