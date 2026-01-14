const mix = require('laravel-mix');

const publicPath = 'public';

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

mix.setPublicPath(publicPath)
    .js('resources/js/app.js', 'js')
    .vue({ version: 3 })
    .scripts('resources/js/legacy/*', 'public/js/legacy.js') //Combine all the legacy files into one
    .sass('resources/sass/app.scss', 'css')
    .sass('resources/sass/vendor.scss', 'css')
    .options({
        processCssUrls: false,
        postCss: [
            //This lets us use @import on urls
            require('postcss-import')(),
            require('postcss-url')([
                //Preprocessing so we accurately grab url('~packageName/...')
                {
                    filter: (asset) => asset.url.startsWith('~'),
                    url: (asset) => process.cwd() + '/node_modules/' + asset.url.substring(1),
                    multi: true,
                },
                // This lets us inline most CSS images
                {
                    url: 'inline',
                    maxSize: 10,
                },
                //Handle everything pointing to the public folder
                {
                    filter: (asset) => !asset.url.startsWith('~'),
                    url: 'inline',
                    maxSize: 10,
                    ignoreFragmentWarning: true,
                    basePath: process.cwd() + '/' + publicPath,
                }
            ]),
        ]
    });

//Do Hot model reloading on port 3030, so we can test the site on port 8080
mix.options({
    hmrOptions: {
        port: '3030'
    }
});
