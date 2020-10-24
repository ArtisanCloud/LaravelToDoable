<?php

namespace ArtisanCloud\ToDoable\Providers;

use Illuminate\Support\ServiceProvider;
use ArtisanCloud\ToDoable\Contracts\ToDoServiceContract;
use ArtisanCloud\ToDoable\ToDoService;

/**
 * Class ToDoServiceProvider
 * @package App\Providers
 */
class ToDoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            ToDoServiceContract::class,
            ToDoService::class
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/constant.php','constant'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // config framework router
        $this->configRouter();

        // load translation resource
//        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'todoable');

        if ($this->app->runningInConsole()) {
              // publish config file
//              $this->publishes([
//                  __DIR__ . '/../../config/todo.php' => "/../" . config_path('test/todo.php'),
//              ], ['ArtisanCloud', 'SaaSFramework', 'ToDo-Config']);

              // publish migration file
//              $this->publishes([
//                  __DIR__ . '/../../config/todo.php' => "/../" . config_path('todo.php'),
//              ], ['ArtisanCloud', 'SaaSFramework', 'ToDo-Model']);

              // register artisan command
              if (! class_exists('CreateToDoTable')) {
                $this->publishes([
                  __DIR__ . '/../database/migrations/create_todos_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_todos_table.php'),
                  // you can add any number of migrations here
                ], ['ArtisanCloud', 'SaaSFramework', 'ToDo-Migration']);
              }
            }

    }

    public function configRouter()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

    }
}
