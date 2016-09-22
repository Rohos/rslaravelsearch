<?php

namespace Rohos\Rslaravelsearch;

use Illuminate\Support\ServiceProvider;

class RslaravelsearchServiceProvider extends ServiceProvider
{
    protected function path()
    {
        return __DIR__ .'/config/rslaravelsearch.php';
    }
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([$this->path() => config_path('rslaravelsearch.php')], 'rslaravelsearch_config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->path(), 'rslaravelsearch');
    }
}
