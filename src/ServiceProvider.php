<?php
namespace Hasob\FoundationCore;

use Hasob\FoundationCore\Facades;
use Hasob\FoundationCore\Providers\FoundationCoreEventServiceProvider;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Engines\EngineResolver;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
    * Publishes configuration file.
    *
    * @return  void
    */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/hasob-foundation-core.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'hasob-foundation-core');

        // Publish view files
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/hasob-foundation-core'),
        ], 'views');

        // Publish assets
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('hasob-foundation-core'),
        ], 'assets');

        // Publish view components
        $this->publishes([
            __DIR__.'/../src/View/Components/' => app_path('View/Components'),
            __DIR__.'/../resources/views/components/' => resource_path('views/components'),
        ], 'view-components');

        $this->publishes([
            __DIR__ . '/../database/seeders/FoundationCoreSeeder.php' => database_path('seeders/FoundationCoreSeeder.php'),
        ], 'seeders');

        
        Blade::componentNamespace('Hasob\\FoundationCore\\View\\Components', 'hasob-foundation-core');
    }

    /**
    * Make config publishing optional by merging the config from the package.
    *
    * @return  void
    */
    public function register()
    {
        $configPath = __DIR__ . '/../config/hasob-foundation-core.php';
        $this->mergeConfigFrom($configPath, 'hasob-foundation-core');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->app->bind('FoundationCore', function($app) {
            return new FoundationCore();
        });

        $this->app->register(FoundationCoreEventServiceProvider::class);

    }

        /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('hasob-foundation-core.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('hasob-foundation-core.php')], 'config');
    }

    /**
     * Register a Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }
}