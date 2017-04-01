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


/**
 * Scrape plugins from different providers
 */
Route::get( '/scrape/tf/plugin/page/{page}', 'PluginController@scrapeThemeForest' );
Route::get( '/scrape/wp/plugin', 'PluginController@scrapeWordPress' );

/**
 * Scrape themes from different providers
 */
Route::get( '/scrape/tf/theme/page/{page}', 'ThemeController@scrapeThemeForest' );
Route::get( '/scrape/wp/theme', 'ThemeController@scrapeWordPress' );


