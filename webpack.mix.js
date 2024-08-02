const mix = require("laravel-mix");
const path = require("path");

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .webpackConfig({
        resolve: {
            alias: {
                vue$: path.resolve(
                    __dirname,
                    "node_modules/vue/dist/vue.esm-bundler.js"
                ),
            },
        },
    });
