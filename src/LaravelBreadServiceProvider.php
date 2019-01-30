<?php

namespace Wikichua\LaravelBread;

use File;
use Illuminate\Support\ServiceProvider;

class LaravelBreadServiceProvider extends ServiceProvider
{
    protected $defer = false;
    public function boot(\Illuminate\Routing\Router $router)
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('DataTables', Yajra\DataTables\Facades\DataTables::class);
        $this->publishes([
            __DIR__ . '/../publish/migrations/' => database_path('migrations'),
            __DIR__ . '/../publish/Model/' => app_path(),
            __DIR__ . '/../publish/Controllers/' => app_path('Http/Controllers'),
            __DIR__ . '/../publish/resources/' => base_path('resources'),
            __DIR__ . '/../publish/crudgenerator.php' => config_path('crudgenerator.php'),
            __DIR__ . '/../publish/menus.php' => config_path('menus.php'),
            __DIR__ . '/views' => base_path('resources/views/vendor/laravel-bread'),
        ], 'views');
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-bread');
        view()->share('laravelAdminMenus', config('menus'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'Wikichua\LaravelBread\LaravelBreadCommand',
            'Wikichua\LaravelBread\Commands\CrudCommand',
            'Wikichua\LaravelBread\Commands\CrudControllerCommand',
            'Wikichua\LaravelBread\Commands\CrudModelCommand',
            'Wikichua\LaravelBread\Commands\CrudMigrationCommand',
            'Wikichua\LaravelBread\Commands\CrudViewCommand',
            'Wikichua\LaravelBread\Commands\CrudLangCommand',
            'Wikichua\LaravelBread\Commands\CrudApiCommand',
            'Wikichua\LaravelBread\Commands\CrudApiControllerCommand'
        );

        $this->app->bind('Setting', \Wikichua\LaravelBread\Setting::class);
    }
}
