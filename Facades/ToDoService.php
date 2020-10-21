<?php

namespace ArtisanCloud\ToDoable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ToDoService
 * @package ArtisanCloud\ToDoable
 */
class ToDoService extends Facade
{
    //
    protected static function getFacadeAccessor()
    {
        return ToDoService::class;
    }
}
