<?php

namespace Wikichua\LaravelBread;

use File;
use Illuminate\Support\ServiceProvider;

class LaravelBreadServiceProvider extends ServiceProvider
{
    protected $defer = false;
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->publishes([
            __DIR__ . '/../publish/Middleware/' => app_path('Http/Middleware'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/migrations/' => database_path('migrations'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/Model/' => app_path(),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/Controllers/' => app_path('Http/Controllers'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/resources/' => base_path('resources'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/crudgenerator.php' => config_path('crudgenerator.php'),
        ]);

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/laravel-bread'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-bread');

        $menus = json_decode(json_encode(config('menus')));
        view()->share('laravelAdminMenus', $menus);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'Wikichua\LaravelBread\LaravelBreadCommand'
        );

        $this->app->bind('Setting', \Wikichua\LaravelBread\Setting::class);
    }
}
