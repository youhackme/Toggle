const {mix} = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
  'resources/assets/js/app.js',
  'resources/assets/js/typed.js'
], 'public/js')
  .version();

mix.sass('resources/assets/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false
  }).version();

mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('node_modules/bootstrap-sass/assets/fonts', 'public/fonts');
mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts/font-awesome');
