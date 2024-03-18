<?php

use App\Enums\Rank\RankGroup;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsPlayer;
use Illuminate\Support\Facades\Route;


Route::post('admin/login', \App\Http\Controllers\Admin\LoginController::class)
    ->name('admins.login');
Route::post('login', [\App\Http\Controllers\Player\LoginController::class, 'login'])
    ->name('ss.login');

Route::get('test', function (){
    $group = \App\Models\Group::first();

    return in_array(2,\Illuminate\Support\Facades\Cache::get($group->name)['prizes_win_percentages']);

    $data = [];

    // Set Total Number
    $data['total_number'] = array_sum($group->prizes->pluck('pivot.number')->toArray());
    $data['prizes_win_percentages'] = [];


    foreach ($group->prizes->toArray() as $prize) {
        $percentage =  ($prize['pivot']['number'] / setting('prize-total-number')) * 100;
        $data['prizes_win_percentages'] = array_pad($data['prizes_win_percentages'], $percentage, $prize['pivot']['prize_id']);
    }
    return $data['prizes_win_percentages'];


});

/*
 * Admin Routes
 */
Route::group([
    'middleware' => ['auth:sanctum', IsAdmin::class],
    'prefix' => 'admin',
    ], function () {

//    Route::get('test', 'AdminController@index');


    // Prize Routes
    Route::post('prizes', \App\Http\Controllers\Prize\StoreController::class);
    Route::put('prizes/{prize}', \App\Http\Controllers\Prize\UpdateController::class);
    Route::delete('prizes/{prize}', \App\Http\Controllers\Prize\DeleteController::class);
    Route::post('prizes/assign/group', \App\Http\Controllers\Prize\AssignPrizeController::class);


    // Rank Routes
    Route::post('ranks/assign/group', \App\Http\Controllers\Rank\AssignGroupController::class);

});



/*
 * Player Routes
 */
Route::group([
        'middleware' => ['auth:sanctum', IsPlayer::class]
    ], function () {

    // Spinner Route
    Route::post('spinner/trigger', \App\Http\Controllers\Spinner\TriggerController::class);


//    Route::get('test', 'PlayerController@index');

});


