<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SwaggerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// '/' は json *
// '/yaml' は yaml
// '/swagger.yaml' は yaml download
// '/swagger.json' は json download

if (! function_exists('crud') )
{
    function crud($route, $class, $name = false)
    {
        if (!$name) $name = $route;
        if (strpos($name, '/')) $name = str_replace('/', '.', $name);
        Route::get   ($route.'',      [$class, 'index'  ])->name($name.'.index');
        Route::get   ($route.'/{id}', [$class, 'show'   ])->name($name.'.show');
        Route::post  ($route.'',      [$class, 'store'  ])->name($name.'.store');
        Route::put   ($route.'/{id}', [$class, 'update' ])->name($name.'.update');
        Route::delete($route.'/{id}', [$class, 'destroy'])->name($name.'.destroy');
    }
}


Route::get('/', SwaggerController::class);
Route::get('/json', [SwaggerController::class, 'json']);
Route::get('/yaml', [SwaggerController::class, 'yaml']);
/*
Route::get('/download/json', [SwaggerController::class, 'download_json']);
*/
Route::get('/download/yaml', [SwaggerController::class, 'download_yaml']);


// TODO: env で分ける
Route::group(['middleware' => ['auth:sanctum', 'can:admin'], 'prefix' => 'admin', 'as' => 'api.admin.'], function ()
{
    crud('project', ProjectController::class, 'project');
    crud('material', MaterialController::class, 'material');
    crud('user', UserController::class, 'user');
    crud('order', OrderController::class, 'order');

    // Route::get('/', [TodoController::class, 'index']);
    // Route::post('/test/{id}', [TodoController::class, 'store']);
});