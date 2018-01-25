<?php namespace Jameswmcnab\ConfigDb;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ConfigDbServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/config-db.php' => config_path('config-db.php')
        ], 'config');

        // Publish migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register default Loader
        $this->registerDefaultLoader();

        // Register default Repository
        $this->registerDefaultRepository();

        // Register facade accessor
        $this->app->singleton('config-db', function (Application $app) {
            return $app->make(RepositoryInterface::class);
        });
    }

    /**
     * Register default Loader
     *
     * @return void
     */
    protected function registerDefaultLoader()
    {
        $configPath = __DIR__ . '/../config/config-db.php';
        $this->mergeConfigFrom($configPath, 'config-db');

        $this->app->singleton(LoaderInterface::class, function (Application $app) {
            $tableName = $app['config']['config-db.table'];

            return new DbLoader($app['db'], $tableName);
        });
    }

    /**
     * Register default Repository
     *
     * @return void
     */
    protected function registerDefaultRepository()
    {
        $this->app->singleton(RepositoryInterface::class, function (Application $app) {
            return new Repository($app->make(LoaderInterface::class));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['config-db'];
    }
}
