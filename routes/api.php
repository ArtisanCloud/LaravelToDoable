<?php
declare(strict_types=1);


use ArtisanCloud\ToDoable\Http\Controllers\API\ToDoAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$_methodAll = config('artisancloud.framework.router.methodAll', ['options', 'get', 'post', 'put', 'delete']);
$_methodGet = config('artisancloud.framework.router.methodGet', ['options', 'get']);
$_methodPost = config('artisancloud.framework.router.methodPost', ['options', 'post']);
$_methodPut = config('artisancloud.framework.router.methodPut', ['options', 'put']);
$_methodDelete = config('artisancloud.framework.router.methodDelete', ['options', 'delete']);
$_api_version = config('artisancloud.framework.api_version');

$_domain_tenant = config('artisancloud.framework.domain.tenant');

/** Tenant **/
Route::group(
    [

        'prefix' => "api/{$_api_version}",
        'domain' => $_domain_tenant,
        'middleware' => ['checkLandlord', 'checkHeader', 'checkUser']
    ], function () use ($_methodGet, $_methodPost, $_methodPut, $_methodDelete) {

});


Route::group(
    [

        'prefix' => "api/{$_api_version}",
        'domain' => $_domain_tenant,
        'middleware' => ['checkLandlord', 'checkHeader', 'auth:api', 'checkUser']
    ], function () use ($_methodGet, $_methodPost, $_methodPut, $_methodDelete) {

    Route::match($_methodPost, 'todo/create', [ToDoAPIController::class, 'apiCreate'])->name('todo.write.create');
    Route::match($_methodGet, 'todo/read/item', [ToDoAPIController::class, 'apiReadItem'])->name('todo.read.item');
    Route::match($_methodGet, 'todo/read/list', [ToDoAPIController::class, 'apiReadList'])->name('todo.read.list');
    Route::match($_methodPut, 'todo/update', [ToDoAPIController::class, 'apiUpdate'])->name('todo.write.update');
    Route::match($_methodDelete, 'todo/delete', [ToDoAPIController::class, 'apiDelete'])->name('todo.write.Delete');

});