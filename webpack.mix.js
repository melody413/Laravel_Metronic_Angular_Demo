let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/assets/frontend/js');


/*mix.sass('resources/assets/sass/doctorak.scss', 'public/assets/frontend/css')
    .sourceMaps()
;*/

mix.options({
    sourcemaps: 'inline-source-map'
});

//mix.copyDirectory('resources/assets/images', 'public/assets/frontend/images');
//mix.copyDirectory('resources/assets/fonts', 'public/assets/frontend/fonts');
