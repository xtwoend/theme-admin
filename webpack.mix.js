const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/app.less', 'public/css')
   .js('resources/assets/admin/js/app.js', 'public/admin/js')
   .less('resources/assets/admin/less/print.less', 'public/css')
   .sass('resources/assets/admin/sass/other.scss', 'public/admin/css')
   .less('resources/assets/admin/less/app.less', 'public/admin/css');

