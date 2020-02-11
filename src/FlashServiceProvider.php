<?php namespace CodeZero\Flash;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->setPublishPaths();
        $this->mergeConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSessionStore();
        $this->registerFlasher();
        $this->registerFlash();
    }

    /**
     * Register the SessionStore binding.
     *
     * @return void
     */
    private function registerSessionStore()
    {
        $this->app->bind(
            'CodeZero\Flash\SessionStore\SessionStore',
            'CodeZero\Flash\SessionStore\LaravelSessionStore'
        );
    }

    /**
     * Register the Flasher binding.
     *
     * @return void
     */
    private function registerFlasher()
    {
        $this->app->bind(
            'CodeZero\Flash\Flasher',
            'CodeZero\Flash\Flash'
        );
    }

    /**
     * Register the Flash binding.
     *
     * @return void
     */
    private function registerFlash()
    {
        $this->app->singleton('CodeZero\Flash\Flash', function () {
            $config = config('flash');
            $session = app()->make('CodeZero\Flash\SessionStore\SessionStore');

            return new Flash($config, $session);
        });
    }

    /**
     * Load views.
     *
     * @return void
     */
    private function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'flash');
    }

    /**
     * Set publish paths.
     *
     * @return void
     */
    private function setPublishPaths()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('flash.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/codezero/flash')
        ], 'views');
    }

    /**
     * Merge configuration files.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'flash');
    }
}
