const mix = require('laravel-mix');

mix.setPublicPath(__dirname);

mix.js(
    './assets/src/js/sentry.js',
    './assets/dist/js/sentry.js'
);
