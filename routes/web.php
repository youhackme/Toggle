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

/**
 * Website pages
 */
Route::get('/', function () {
    return view('website.index');
});

Route::get('/result', 'SiteController@scanFromWeb');


/*
 * Scrape plugins from different providers
 */
Route::get('/scrape/tf/plugin/page/{page}', 'PluginController@scrapeThemeForest');
Route::get('/scrape/wp/plugin', 'PluginController@scrapeWordPress');

/*
 * Scrape themes from different providers
 */
Route::get('/scrape/tf/theme/page/{page}', 'ThemeController@scrapeThemeForest');
Route::get('/scrape/wp/theme', 'ThemeController@scrapeWordPress');

/*
 * Scrape theme alias from different providers
 */
Route::get('/scrape/tf/theme/alias', 'ThemeController@scrapeThemeAlias');


/*
 * Scrape themes from different providers
 */

Route::group(['namespace' => 'Admin'], function () {

    Route::get('/admin/theme', function () {
        return view('admin/theme');
    });

    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::post('/admin/theme/add', 'ThemeController@add');

    Route::get('/admin/plugin/list/{plugin}', 'PluginController@show');

    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::post('/admin/plugin/add', 'PluginController@add');

});


Route::group(['namespace' => 'Extension'], function () {

    Route::match(['get', 'post'], '/extension', 'ExtensionController@scan')->middleware('legitOrigin');

});


Route::get('/cache', 'SiteController@cache');

