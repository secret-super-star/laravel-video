const {mix} = require('laravel-mix');
// const CleanWebpackPlugin = require('clean-webpack-plugin');

// paths to clean
var pathsToClean = [
    'public/assets/app/js',
    'public/assets/app/css',
    'public/assets/client/gulp',
    'public/assets/client/gulp',
    'public/assets/auth/css',
];

// the clean options to use
var cleanOptions = {};

// mix.webpackConfig({
//     plugins: [
//         new CleanWebpackPlugin(pathsToClean, cleanOptions)
//     ]
// });

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

/*
 |--------------------------------------------------------------------------
 | Core
 |--------------------------------------------------------------------------
 |
 */

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/pace-progress/pace.js',

], 'public/assets/app/js/app.js').version();

mix.styles([
    'node_modules/font-awesome/css/font-awesome.css',
    'node_modules/pace-progress/themes/blue/pace-theme-minimal.css',
], 'public/assets/app/css/app.css').version();

mix.copy([
    'node_modules/font-awesome/fonts/',
], 'public/assets/app/fonts');

/*
 |--------------------------------------------------------------------------
 | Auth
 |--------------------------------------------------------------------------
 |
 */

mix.styles('resources/assets/auth/css/login.css', 'public/assets/auth/css/login.css').version();
mix.styles('resources/assets/auth/css/register.css', 'public/assets/auth/css/register.css').version();
mix.styles('resources/assets/auth/css/passwords.css', 'public/assets/auth/css/passwords.css').version();

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/gentelella/vendors/animate.css/animate.css',
    'node_modules/gentelella/build/css/custom.css',
], 'public/assets/auth/css/auth.css').version();

/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 |
 */

mix.scripts([
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'node_modules/gentelella/build/js/custom.js',
], 'public/assets/admin/js/admin.js').version();

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/gentelella/vendors/animate.css/animate.css',
    'node_modules/gentelella/build/css/custom.css',
], 'public/assets/admin/css/admin.css').version();


mix.copy([
    'node_modules/gentelella/vendors/bootstrap/dist/fonts',
], 'public/assets/admin/fonts');


mix.scripts([
    'node_modules/select2/dist/js/select2.full.js',
    'resources/assets/admin/js/users/edit.js',
], 'public/assets/admin/js/users/edit.js').version();

mix.styles([
    'node_modules/select2/dist/css/select2.css',
], 'public/assets/admin/css/users/edit.css').version();

/*
 |--------------------------------------------------------------------------
 | Frontend
 |--------------------------------------------------------------------------
 |
 */

mix.styles([
  'node_modules/font-awesome/css/font-awesome.css',
  'public/assets/client/css/bootstrap.min.css',
  'public/assets/client/css/main.css',
  'public/assets/client/css/custom.css',
  'public/assets/client/css/jquery-ui.css',
], 'public/assets/client/gulp/client.css');

mix.copy([
  'node_modules/font-awesome/fonts/',
], 'public/assets/client/fonts');

mix.scripts([
  'public/assets/client/js/jquery-2.2.0.min.js',
  'public/assets/client/js/bootstrap.min.js',
  'public/assets/client/js/bootbox.min.js',
  'public/assets/client/js/jquery.scrollTo-min.js',
  'public/assets/client/js/client.js',
  'public/assets/client/js/jquery-ui.js',
  'public/assets/client/js/player.js'
], 'public/assets/client/js/gulp/myclient.js').version();


/*
 |--------------------------------------------------------------------------
 | Themes
 |--------------------------------------------------------------------------
 |
 */



// paths to clean
var pathsToClean = [
	'public/assets/themes/betube/css',
	'public/assets/themes/betube/js'
];

// the clean options to use
var cleanOptions = {};
//
// mix.webpackConfig({
// 	plugins: [
// 		new CleanWebpackPlugin(pathsToClean, cleanOptions)
// 	]
// });


mix.styles([
	'resources/assets/themes/betube/css/app.css',
	'resources/assets/themes/betube/css/theme.css',
	'resources/assets/themes/betube/css/font-awesome.min.css',
	'resources/assets/themes/betube/css/layerslider.css',
	'resources/assets/themes/betube/css/owl.carousel.min.css',
	'resources/assets/themes/betube/css/owl.theme.default.min.css',
	'resources/assets/themes/betube/css/jquery.kyco.easyshare.css',
	'resources/assets/themes/betube/css/responsive.css',
	'resources/assets/themes/betube/css/custom.css'
], 'public/assets/themes/betube/css/betube.css');

mix.scripts([
	'public/assets/client/js/jquery-2.2.0.min.js',
	"resources/assets/themes/betube/js/jquery.js",
	"resources/assets/themes/betube/js/what-input.js",
	"resources/assets/themes/betube/js/foundation.js",
	"resources/assets/themes/betube/js/jquery.showmore.src.js",
	"resources/assets/themes/betube/js/app.js",
	"resources/assets/themes/betube/js/greensock.js",
	"resources/assets/themes/betube/js/layerslider.transitions.js",
	"resources/assets/themes/betube/js/layerslider.kreaturamedia.jquery.js",
	"resources/assets/themes/betube/js/owl.carousel.min.js",
	"resources/assets/themes/betube/js/inewsticker.js",
	"resources/assets/themes/betube/js/jquery.kyco.easyshare.js",
	'public/assets/client/js/client.js',
	'resources/assets/themes/betube/js/custom.js'
], 'public/assets/themes/betube/js/betube.js').version();