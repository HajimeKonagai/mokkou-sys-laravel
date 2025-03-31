<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SwaggerController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\EstimateController;
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
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    page('project', ProjectController::class);
    page('order', OrderController::class);
    page('user', UserController::class);
    page('material', MaterialController::class);
    page('estimate', EstimateController::class);
    page('customer', CustomerController::class);
    page('product', ProductController::class);


    Route::post('order_process/order/{order}', [OrderProcessController::class, 'order'])->name('order_process.order');
    Route::post('order_process/cancel/{order}', [OrderProcessController::class, 'cancel'])->name('order_process.cancel');
    Route::post('order_process/delivered/{order}', [OrderProcessController::class, 'delivered'])->name('order_process.delivered');
});


Route::group(['middleware' => ['auth'], 'prefix' => 'supplier', 'as' => 'supplier.'], function ()
{
    Route::get('dashboard', \App\Http\Controllers\Supplier\DashboardController::class)->name('dashboard');
    Route::post('dashboard/{orderDetail}', [\App\Http\Controllers\Supplier\DashboardController::class, 'store'])->name('dashboard.store');
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
