<?php

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

Route::middleware('api')->group( function () {
    Route::resource('areas', \App\Http\Controllers\API\AreaController::class);

    Route::resource('districts', \App\Http\Controllers\API\DistrictController::class);
    Route::get('districts/{field}/{id}', [\App\Http\Controllers\API\DistrictController::class, 'field']);

    Route::resource('cities', \App\Http\Controllers\API\CityController::class);
    Route::get('cities/{field}/{id}', [\App\Http\Controllers\API\CityController::class, 'field']);
    Route::post('cities/bind', [\App\Http\Controllers\API\CityController::class, 'bind']);
    Route::post('cities/unbind', [\App\Http\Controllers\API\CityController::class, 'unbind']);

    Route::resource('streets', \App\Http\Controllers\API\StreetController::class);
    Route::get('streets/{field}/{id}', [\App\Http\Controllers\API\StreetController::class, 'field']);

    Route::resource('houses', \App\Http\Controllers\API\HouseController::class);
    Route::get('houses/{field}/{id}', [\App\Http\Controllers\API\HouseController::class, 'field']);
    Route::post('houses/bind', [\App\Http\Controllers\API\HouseController::class, 'bind']);
    Route::post('houses/unbind', [\App\Http\Controllers\API\HouseController::class, 'unbind']);

    Route::resource('spots', \App\Http\Controllers\API\SpotController::class);
    Route::get('spots/getBind/{spot_id}', [\App\Http\Controllers\API\SpotController::class, 'getBind']);
    Route::get('spots/{field}/{id}', [\App\Http\Controllers\API\SpotController::class, 'field']);
    Route::post('spots/bind', [\App\Http\Controllers\API\SpotController::class, 'bind']);
    Route::post('spots/unbind', [\App\Http\Controllers\API\SpotController::class, 'unbind']);

//    Route::resource('deputats', \App\Http\Controllers\API\DeputatController::class);
//    Route::get('deputats/{field}/{id}', [\App\Http\Controllers\API\DeputatController::class, 'field']);

//    Route::get('users/{user}', [\App\Http\Controllers\API\UserController::class, 'show']);
    Route::post('user', [\App\Http\Controllers\API\UserController::class, 'create']);

//    Route::resource('helpers', \App\Http\Controllers\API\HelperController::class);
//    Route::get('helpers/{field}/{id}', [\App\Http\Controllers\API\HelperController::class, 'field']);
});
