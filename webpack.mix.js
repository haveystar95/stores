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

mix.copy('resources/assets/images', 'public/images', false)
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
mix.extract([
    "axios",
    "lodash",
    "nprogress",
    "popper.js",
    "v-click-outside",
    "vue",
    "vue-js-modal",
    "vue-moment",
    "vue-notification",
    "vue-router",
    "vue-social-sharing",
    "vue2-editor",
    "vuejs-paginate",
    "vuejs-paginator",
    "vue-resource",
    "vuex",
    "vuex-router-sync"
]);

if (!mix.inProduction()) {
    mix.sourceMaps(true, 'source-map');

    if (process.env.npm_lifecycle_event !== 'hot') {
        mix.version();
    }
} else {
    mix.version();
}
