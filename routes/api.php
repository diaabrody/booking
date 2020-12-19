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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('user')->middleware('auth:api')->group(function (){
    Route::get('/user/history' , 'UserHistoryController@index');
    Route::get('chalet-reservation', 'UserChaletReservationController@index');

});

Route::prefix('auth')->middleware(['api'])->group(function ($router){
    Route::post('login'  , 'AuthController@login');
    Route::post('register' , 'AuthController@register');
    Route::get('me' , 'AuthController@me');
    Route::post('logout'  , 'AuthController@logout');
    Route::post('refresh' , 'AuthController@refresh');
    Route::post('forget' , 'AuthController@forget');
    Route::post('reset' , 'AuthController@doReset');
});

Route::prefix('chalets')->middleware(['api'])->group(function (){
    Route::get('/' , 'ChaletController@index');
    Route::get('/{id}' , 'ChaletController@show')->where(["id"=>"[0-9]+"]);
    Route::post('/' , 'ChaletController@store');

    Route::prefix('{id}/rates')->where(["id"=>"[0-9]+"])->group(function (){
        Route::get('/' , 'ChaletRatesController@index');
        Route::post('/' , 'ChaletRatesController@store');
        Route::delete('/' , 'ChaletRatesController@destroy');
    });
});

Route::prefix('city')->middleware(['api'])->group(function ($router){
    Route::get('/' , 'CityController@index');
});


Route::get('/suggest/{query}', 'SuggestController@index');
