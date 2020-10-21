<?php

namespace ArtisanCloud\LaravelToDoable\Providers;

use Illuminate\Support\ServiceProvider;
use ArtisanCloud\LaravelToDoable\Contracts\ToDoServiceContract;
use ArtisanCloud\LaravelToDoable\ToDoService;

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
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
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
                  __DIR__ . '/../../database/migrations/create_todos_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_todos_table.php'),
                  // you can add any number of migrations here
                ], ['ArtisanCloud', 'SaaSFramework', 'ToDo-Migration']);
              }
            }

    }
}
