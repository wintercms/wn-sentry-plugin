const mix = require('laravel-mix');

mix.setPublicPath(__dirname);

mix.js(
    './assets/js/src/sentry.js',
    './assets/js/dist/sentry.js'
);


