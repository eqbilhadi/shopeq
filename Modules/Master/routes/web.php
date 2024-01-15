<?php

use Illuminate\Support\Facades\Route;
use Modules\Master\app\Http\Controllers\CategoryController;
use Modules\Master\app\Http\Controllers\ImageController;
use Modules\Master\app\Http\Controllers\ProductController;

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
    Route::resource('category', CategoryController::class)->names('master.category')->parameters([
        'category' => 'mstcategory'
    ])->only(['index', 'create', 'edit']);

    Route::resource('product', ProductController::class)->names('master.product')->parameters([
        'product' => 'mstproduct'
    ])->only(['index', 'create', 'edit']);
    
    Route::resource('image', ImageController::class)->names('master.image')->parameters([
        'image' => 'mstimage'
    ])->only(['index', 'create', 'edit']);
});
