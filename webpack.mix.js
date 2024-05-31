const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/sass/custom.scss', 'public/css');