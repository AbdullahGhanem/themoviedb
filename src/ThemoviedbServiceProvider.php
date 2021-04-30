<?php

namespace Ghanem\Themoviedb;

use Ghanem\Themoviedb\Console\InstallThemoviedb;
use Ghanem\Themoviedb\Console\ThemoviedbSeed;
use Ghanem\Themoviedb\Facades\Themoviedb;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ThemoviedbServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/themoviedb.php', 'themoviedb');

        $this->app->bind('themoviedb', function($app) {
            return new Themoviedb();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->registerRoutes();

        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallThemoviedb::class,
                ThemoviedbSeed::class,
            ]);

            $this->publishes([
              __DIR__.'/../config/themoviedb.php' => config_path('themoviedb.php'),
            ], 'config');
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('themoviedb.prefix'),
            'middleware' => config('themoviedb.middleware'),
        ];
    }
}