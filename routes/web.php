<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SwaggerController;

use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderProcessController;

// master
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;




if (! function_exists('page') )
{
    function page($route, $class, $name = false)
    {
        if (!$name) $name = $route;
        if (strpos($name, '/')) $name = str_replace('/', '.', $name);
        Route::get   ($route.'', $class)->name($name);
        Route::get   ($route.'/{id}', [$class, 'show'   ])->name($name.'.show');
        Route::post  ($route.'',      [$class, 'store'  ])->name($name.'.store');
        Route::put   ($route.'/{id}', [$class, 'update' ])->name($name.'.update');
        Route::delete($route.'/{id}', [$class, 'destroy'])->name($name.'.destroy');
    }
}


if (! function_exists('crudPage') )
{
    function crudPage($route, $class, $name = false)
    {
        if (!$name) $name = $route;
        if (strpos($name, '/')) $name = str_replace('/', '.', $name);
        Route::get   ($route.'',                [$class, 'index'  ])->name($name.'.index');
        Route::get   ($route.'/create',         [$class, 'create' ])->name($name.'.create');
        Route::get   ($route.'/{id}',         [$class, 'show'   ])->name($name.'.show');
        Route::get   ($route.'/{id}/edit',    [$class, 'edit'   ])->name($name.'.edit');
        Route::post  ($route.'',                [$class, 'store'  ])->name($name.'.store');
        Route::put   ($route.'/{id}',         [$class, 'update' ])->name($name.'.update');
        Route::delete($route.'/{id}',         [$class, 'destroy'])->name($name.'.destroy');
    }
}


/**
 * Admin
 */
Route::group(['middleware' => ['auth', 'can:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function ()
{
    Route::put('session/{project}', [SessionController::class, 'put_project'])->name('session.put_project');
    Route::delete('session', [SessionController::class, 'delete_project'])->name('session.delete_project');

    Route::get('/', DashboardController::class)->name('dashboard');
    page('project', ProjectController::class);
    Route::put('project/{project}/to_task',  [ProjectController::class, 'to_task' ])->name('project.to_task');
    page('task', TaskController::class);
    Route::put('task/{id}/duplicate', [TaskController::class, 'duplicate'])->name('task.duplicate');
    Route::put('task/{id}/seq_decrease', [TaskController::class, 'seq_decrease'])->name('task.seq_decrease');
    Route::put('task/{id}/seq_increase', [TaskController::class, 'seq_increase'])->name('task.seq_increase');

    /*
    Route::get   ('task/{project}',  TaskController::class           )->name('task');
    Route::get   ('task/{id}',      [TaskController::class, 'show'   ])->name('task.show');
    Route::post  ('task/{project}', [TaskController::class, 'store'  ])->name('task.store');
    Route::put   ('task/{id}',      [TaskController::class, 'update' ])->name('task.update');
    Route::delete('task/{id}',      [TaskController::class, 'destroy'])->name('task.destroy');
    */


    page('order', OrderController::class);
    page('user', UserController::class);
    page('material', MaterialController::class);
    page('customer', CustomerController::class);
    page('product', ProductController::class);


    Route::post('order_process/order/{order}', [OrderProcessController::class, 'order'])->name('order_process.order');
    Route::post('order_process/cancel/{order}', [OrderProcessController::class, 'cancel'])->name('order_process.cancel');
    Route::post('order_process/delivered/{order}', [OrderProcessController::class, 'delivered'])->name('order_process.delivered');

    // csv
    Route::get ('csv/customer', App\Http\Controllers\Admin\Csv\CustomerController::class)->name('csv.customer');
    Route::post('csv/customer', [App\Http\Controllers\Admin\Csv\CustomerController::class, 'store'])->name('csv.customer.store');
    Route::get ('csv/user', App\Http\Controllers\Admin\Csv\UserController::class)->name('csv.user');
    Route::post('csv/user', [App\Http\Controllers\Admin\Csv\UserController::class, 'store'])->name('csv.user.store');


    // setting
    Route::get   ('setting/{key}', [App\Http\Controllers\Admin\SettingController::class, 'get'    ])->name('setting.get');
    Route::post  ('setting/{key}', [App\Http\Controllers\Admin\SettingController::class, 'update' ])->name('setting.update');
    Route::delete('setting/{key}', [App\Http\Controllers\Admin\SettingController::class, 'destroy' ])->name('setting.destroy');
});


Route::group(['middleware' => ['auth'], 'prefix' => 'supplier', 'as' => 'supplier.'], function ()
{
    Route::get('dashboard', \App\Http\Controllers\Supplier\DashboardController::class)->name('dashboard');
    Route::post('dashboard/{orderDetail}', [\App\Http\Controllers\Supplier\DashboardController::class, 'store'])->name('dashboard.store');


    Route::get('product', \App\Http\Controllers\Supplier\ProductController::class)->name('product');
    Route::post('product', [\App\Http\Controllers\Supplier\ProductController::class, 'store'])->name('product.store');
    Route::post('update/{item}', [\App\Http\Controllers\Supplier\ProductController::class, 'update'])->name('product.update');
    Route::post('delete/{item}', [\App\Http\Controllers\Supplier\ProductController::class, 'destroy'])->name('product.destroy');
});


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
