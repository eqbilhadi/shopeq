<?php

use Illuminate\Support\Facades\Route;
use Modules\Purchasing\app\Http\Controllers\InvoiceController;
use Modules\Purchasing\app\Http\Controllers\ReturController;

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

Route::group(['middleware' => ['auth', 'checkAccess'], 'prefix' => 'purchasing'], function () {
    Route::resource('invoice', InvoiceController::class)->names('purchasing.invoice')->only(['index', 'create', 'edit']);
    Route::resource('retur', ReturController::class)->names('purchasing.retur')->only(['index', 'create', 'edit']);
});