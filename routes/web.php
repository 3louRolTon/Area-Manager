<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('firstUser', [\App\Http\Controllers\Auth\RegisterController::class, 'createSuperAdmin']);

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::group(['prefix' => 'auth'], function() {
    Route::get('login', function () { return view('auth.login'); });
    Route::get('logout', function () {
        Auth::logout();
        return Redirect::to('auth/login');
    })->name('logout');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['role:super-admin|admin']], function() {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index']);
    Route::get('register', [\App\Http\Controllers\AdminController::class, 'showRegisterForm']);
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'create']);
//    Route::get('update', [\App\Http\Controllers\AdminController::class, 'showUpdateForm']);
});



Route::group(['prefix' => 'user', 'middleware' => ['role:super-admin|admin|user']], function() {
    Route::get('/', [\App\Http\Controllers\UserController::class, 'showBindForm']);
    Route::get('unbind', [\App\Http\Controllers\UserController::class, 'showUnbindForm']);
    Route::get('bindSpot', [\App\Http\Controllers\UserController::class, 'showSpotBindForm']);
    Route::get('unbindSpot', [\App\Http\Controllers\UserController::class, 'showSpotUnbindForm']);

    Route::group(['prefix' => 'create'], function(){
        Route::get('area', [\App\Http\Controllers\UserController::class, 'showAreaCreateForm']);
        Route::get('district', [\App\Http\Controllers\UserController::class, 'showDistrictCreateForm']);
        Route::get('city', [\App\Http\Controllers\UserController::class, 'showCityCreateForm']);
        Route::get('street', [\App\Http\Controllers\UserController::class, 'showStreetCreateForm']);
        Route::get('house', [\App\Http\Controllers\UserController::class, 'showHouseCreateForm']);
        Route::get('spot', [\App\Http\Controllers\UserController::class, 'showSpotCreateForm']);
//        Route::get('deputat', [\App\Http\Controllers\UserController::class, 'showDeputatCreateForm']);
//        Route::get('helper', [\App\Http\Controllers\UserController::class, 'showHelperCreateForm']);
    });

    Route::group(['prefix' => 'update'], function() {
        Route::get('area', [\App\Http\Controllers\UserController::class, 'showAreaUpdateForm']);
        Route::get('district', [\App\Http\Controllers\UserController::class, 'showDistrictUpdateForm']);
        Route::get('city', [\App\Http\Controllers\UserController::class, 'showCityUpdateForm']);
        Route::get('street', [\App\Http\Controllers\UserController::class, 'showStreetUpdateForm']);
        Route::get('house', [\App\Http\Controllers\UserController::class, 'showHouseUpdateForm']);
        Route::get('spot', [\App\Http\Controllers\UserController::class, 'showSpotUpdateForm']);
//        Route::get('deputat', [\App\Http\Controllers\UserController::class, 'showDeputatUpdateForm']);
//        Route::get('helper', [\App\Http\Controllers\UserController::class, 'showHelperUpdateForm']);
    });
});

//Route::group(['prefix' => 'validate', 'middleware' => ['role:super-admin|admin|user|validate']], function() {
//
//});
