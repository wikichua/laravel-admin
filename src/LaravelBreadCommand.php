<?php

namespace Wikichua\LaravelBread;

use File;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LaravelBreadCommand extends Command
{
    protected $signature = 'bread:install {--refresh=false}';
    protected $description = 'Install the Laravel Bread.';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {   
        $refresh = $this->option('refresh');
        try {
            if ($refresh === 'false') {
                $this->call('migrate');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->error($e->getMessage());
            exit();
        }

        if (\App::VERSION() >= '5.2') {
            if ($refresh === 'false') {
                $this->info("Generating the authentication scaffolding");
                $this->call('make:auth',['--force' => true]);
            }
        }

        $this->info("Publishing the assets");
        $this->call('vendor:publish', ['--provider' => 'Wikichua\LaravelBread\LaravelBreadServiceProvider', '--force' => true]);
        if ($refresh === 'false') {
            $this->call('vendor:publish', ['--provider' => 'Spatie\Activitylog\ActivitylogServiceProvider', '--tag' => 'migrations']);
        }
        $this->call('vendor:publish', ['--provider' => 'Yajra\DataTables\DataTablesServiceProvider', '--force' => true]);

        $this->info("Dumping the composer autoload");
        (new Process('composer dump-autoload'))->run();

        $this->info("Migrating the database tables into your application");
        if ($refresh === 'true') {
            $this->call('migrate:fresh');
        } else {
            $this->call('migrate');
        }


        if ($refresh === 'false') {
            $this->info("Adding the routes");
            $routeFile = app_path('Http/routes.php');
            if (\App::VERSION() >= '5.3') {
                $routeFile = base_path('routes/web.php');
            }

            $routes =
            <<<EOD
Route::group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'can:browse-admin']], function () {
    Route::get('/', 'AdminController@index');
    Route::resource('/roles', 'RolesController');
    Route::resource('/permissions', 'PermissionsController');
    Route::resource('/users', 'UsersController');
    Route::resource('/activitylogs', 'ActivityLogsController')->only([
        'index', 'show', 'destroy'
    ]);
    Route::resource('/settings', 'SettingsController');\
    Route::get('/generator', ['as' => 'generator.get','uses' => '\Wikichua\LaravelBread\Controllers\BreadController@getGenerator']);
    Route::post('/generator', ['as' => 'generator.post','uses' => '\Wikichua\LaravelBread\Controllers\BreadController@postGenerator']);

    #%%newRoute%%
});
EOD;
            File::append($routeFile, "\n" . $routes);
        }
        $this->info("Overriding the AuthServiceProvider");
        $contents = File::get(__DIR__ . '/../publish/Providers/AuthServiceProvider.php');
        File::put(app_path('Providers/AuthServiceProvider.php'), $contents);
        $content = File::get(app_path('User.php'));
        $content = str_replace('use Notifiable;', 'use Notifiable, HasRoles;', $content);
        File::put(app_path('User.php'), $content);
        $this->info("Successfully installed Laravel Bread!");
    }
}
