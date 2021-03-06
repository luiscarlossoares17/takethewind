const mix = require('laravel-mix');



/*mix.options({
    processCssUrls: false,
    optimization: {
        concatenateModules: false,
        provideExports: false,
        usedExports: false
    }
});

mix.sourceMaps(true);*/
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


mix.js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/datatables.js', 'public/js')
    .js('resources/js/jquery-ui.js', 'public/js')
    .js('resources/js/webpages/loginpage.js', 'public/js')
    .js('resources/js/webpages/teammanager.js', 'public/js')
    .js('resources/js/webpages/users.js', 'public/js')
    .js('resources/js/webpages/teams.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/loginpage.scss', 'public/css')
    .sass('resources/sass/backoffice.scss', 'public/css')
    .sass('resources/sass/teamsmanager.scss', 'public/css')
    .sass('resources/sass/login.scss', 'public/css');



/*mix.extract();
mix.version();*/