<?php

use Illuminate\Support\Facades\Route;
use Modules\Rbac\app\Http\Controllers\NavigationManagementController;
use Modules\Rbac\app\Http\Controllers\RoleManagementController;
use Modules\Rbac\app\Http\Controllers\UserManagementController;

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

Route::group(['middleware' => ['auth', 'checkAccess'], 'prefix' => 'rbac'], function () {
    Route::resource('navigation-management', NavigationManagementController::class)->names('rbac.nav')->parameters([
        'navigation-management' => 'menu'
    ])->only(['index', 'create', 'edit']);

    Route::resource('role-management', RoleManagementController::class)->names('rbac.role')->parameters([
        'role-management' => 'role'
    ])->only(['index','create','edit']);
    
    Route::resource('user-management', UserManagementController::class)->names('rbac.user')->parameters([
        'user-management' => 'user'
    ])->only(['index','create','edit']);
});
