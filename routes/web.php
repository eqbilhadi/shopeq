<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Modules\Master\app\Models\MstProduct;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    dd(MstProduct::with('images')->with('units')->get());
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
});