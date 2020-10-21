<?php

namespace ArtisanCloud\LaravelToDoable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ToDoService
 * @package ArtisanCloud\LaravelToDoable
 */
class ToDoService extends Facade
{
    //
    protected static function getFacadeAccessor()
    {
        return ToDoService::class;
    }
}
