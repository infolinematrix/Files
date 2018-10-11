<?php

namespace Reactor\Files\Provider;


use Illuminate\Support\ServiceProvider;

class FilesServiceProvider extends ServiceProvider {

    const version = '2.0.4';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['files.model_determiner'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModelDeterminer();

        $this->registerCommands();
    }

    /**
     * Registers the model determiner
     */
    protected function registerModelDeterminer()
    {
        $this->app->singleton(
            'files.model_determiner',
            'Reactor\Files\Determine\ModelDeterminer'
        );
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if ( ! $this->app->environment('production'))
        {
            // This is for model and migration templates
            // we use blade engine to generate these files
            $this->loadViewsFrom(dirname(__DIR__) . '/resources/templates', '_files');

            $this->publishes([
                dirname(__DIR__) . '/resources/config.php' => config_path('files.php')
            ]);
        }
    }

    /**
     * Registers Files helper commands
     */
    protected function registerCommands()
    {
        if ( ! $this->app->environment('production'))
        {
            $this->commands([
                'Reactor\Files\Console\CreateMigrationCommand'
            ]);
        }
    }
}