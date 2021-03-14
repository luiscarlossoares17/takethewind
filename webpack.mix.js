const mix = require('laravel-mix');



mix.options({
    processCssUrls: false,
    optimization: {
        concatenateModules: false,
        provideExports: false,
        usedExports: false
    }
});

mix.sourceMaps(true);
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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();


mix.extract();
mix.version();