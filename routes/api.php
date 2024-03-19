<?php

use App\Enums\Rank\RankGroup;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsPlayer;
use Illuminate\Support\Facades\Route;


Route::post('admin/login', \App\Http\Controllers\Admin\LoginController::class)
    ->name('admin.login');
Route::post('login', \App\Http\Controllers\Player\LoginController::class)
    ->name('player.login');

Route::get('test', function (){
    return \App\Support\Facades\CacheService::generateGroupData(RankGroup::WINNER);
});

/*
 * Admin Routes
 */
Route::group([
    'middleware' => ['auth:sanctum', IsAdmin::class],
    'prefix' => 'admin',
    ], function () {

    // Prize Routes
    Route::post('prizes', \App\Http\Controllers\Prize\StoreController::class);
    Route::put('prizes/{prize}', \App\Http\Controllers\Prize\UpdateController::class);
    Route::delete('prizes/{prize}', \App\Http\Controllers\Prize\DeleteController::class);
    Route::post('prizes/assign/group', \App\Http\Controllers\Prize\AssignPrizeController::class);


    // Rank Routes
    Route::post('ranks/assign/group', \App\Http\Controllers\Rank\AssignGroupController::class);


    // Log Routes
    Route::get('logs', \App\Http\Controllers\Log\IndexController::class);

});



/*
 * Player Routes
 */
Route::group([
        'middleware' => ['auth:sanctum', IsPlayer::class]
    ], function () {

    // Player Routes
    Route::post('logout', \App\Http\Controllers\Player\LogoutController::class);


    // Spinner Route
    Route::post('spinner/trigger', \App\Http\Controllers\Spinner\TriggerController::class);


    // Log Routes
    Route::get('logs', \App\Http\Controllers\Log\IndexController::class);


});


