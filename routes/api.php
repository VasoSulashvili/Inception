<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin\IsAdmin;
use App\Http\Middleware\Player\IsPlayer;


Route::post('admins/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])
    ->name('admins.login');
Route::post('login', [\App\Http\Controllers\Player\AuthController::class, 'login'])
    ->name('ss.login');

/*
 * Admin Routes
 */
Route::group([
        'middleware' => ['auth:sanctum', IsAdmin::class],
        'prefix' => 'admins',
        'namespace' => 'App\Http\Controllers\Admin'
    ], function () {

    Route::get('test', 'AdminController@index');

});



/*
 * Player Routes
 */
Route::group([
        'middleware' => ['auth:sanctum', IsPlayer::class],
        'namespace' => 'App\Http\Controllers\Player'
    ], function () {

    Route::get('test', 'PlayerController@index');

});


