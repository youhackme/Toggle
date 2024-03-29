<?php

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


Route::group(['middleware' => 'throttle'], function () {

    Route::match(['get', 'post'], 'analyze', 'SiteController@detectTechnologyGodMode');
    Route::get('analyzeOnline', 'SiteController@detectTechnologyOnlineMode');
    Route::match(['get', 'post'], 'analyzeOffline', 'SiteController@detectTechnologyOfflineMode');
    Route::get('analyzeHistoricalMode', 'SiteController@detectTechnologyHistoricalMode');

});


