<?php

use Illuminate\Support\Facades\Route;
use Modules\Master\app\Http\Controllers\CategoryController;
use Modules\Master\app\Http\Controllers\ImageController;
use Modules\Master\app\Http\Controllers\ProductController;
use Modules\Master\app\Http\Controllers\SupplierController;
use Modules\Master\app\Http\Controllers\UnitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'checkAccess'], 'prefix' => 'master'], function () {
    Route::resource('supplier', SupplierController::class)->names('master.supplier')->only(['index']);

    Route::resource('category', CategoryController::class)->names('master.category')->only(['index']);
    
    Route::resource('unit', UnitController::class)->names('master.unit')->only(['index']);

    Route::resource('product', ProductController::class)->names('master.product')->only(['index', 'create', 'edit']);
    
    Route::resource('image', ImageController::class)->names('master.image')->only(['index', 'create', 'edit']);
});
