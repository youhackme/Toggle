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


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('website.index');
});

Route::get('/home2', function () {
    return view('website.index2');
});


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
Route::get('/site/', 'SiteController@detect');

Route::post('/site/ScanOfflineMode/', 'SiteController@detectTechnologyOfflineMode');

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

    Route::post('/scan', 'ExtensionController@scan');
    // Route::post('/scanv2', 'ExtensionController@scanv2');
    Route::match(['get', 'post'], '/scanv2', 'ExtensionController@scanv2');


});


Route::get('/cache', 'SiteController@cache');