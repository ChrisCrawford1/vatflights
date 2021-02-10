const mix = require('laravel-mix');
require('laravel-mix-tailwind');
const tailwindcss = require('tailwindcss');

if (mix.inProduction()) {
    mix
        .version();
}

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    // .copyDirectory('resources/images', 'public/images')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.config.js')
        ],
    });
