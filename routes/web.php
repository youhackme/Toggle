<?php

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

Route::get( '/', function () {
	return view( 'welcome' );
} );

Route::get( '/scrape/tf/theme/page/{page}', 'ScrapeController@result' );
Route::get( '/scrape/tf/plugin/page/{page}', 'PluginController@result' );


Route::get( '/scrape/wp/plugin', 'PluginController@scrape' );