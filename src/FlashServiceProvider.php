<?php

namespace CodeZero\Flash;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * The package name.
     *
     * @var string
     */
    protected $name = 'flash';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->registerPublishableFiles();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacade();
        $this->mergeConfig();
    }

    /**
     * Load package views.
     *
     * @return void
     */
    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->name);
    }

    /**
     * Register the facade.
     *
     * @return void
     */
    protected function registerFacade()
    {
        $this->app->bind('flash', Flash::class);
    }

    /**
     * Register the publishable files.
     *
     * @return void
     */
    protected function registerPublishableFiles()
    {
        $this->publishes([
            __DIR__ . "/../config/{$this->name}.php" => config_path("{$this->name}.php"),
        ], 'config');

        $this->publishes([
            __DIR__."/../resources/views" =>  resource_path("views/vendor/{$this->name}"),
        ], 'views');
    }

    /**
     * Merge published configuration file with
     * the original package configuration file.
     *
     * @return void
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/{$this->name}.php", $this->name);
    }
}
