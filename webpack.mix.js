const mix = require("laravel-mix");

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

mix.js(
    [
        "resources/assets/js/theme1/custom-jquery-plugins.js",
        // 'resources/assets/js/theme1/jquery.menu.js',
        "resources/assets/js/theme1/front.js"
    ],
    "public/js/front.js"
)

    .js(
        [
            "resources/assets/js/theme1/custom-jquery-plugins.js",
            "resources/assets/js/theme1/jquery-ui.min.js",
            "resources/assets/js/theme1/front.js",
            "resources/assets/js/theme1/back.js"
        ],
        "public/js/back.js"
    )

    .js(
        [
            "resources/assets/js/question-entry/1.search-hint.js",
            "resources/assets/js/question-entry/2.search-source.js",
            "resources/assets/js/question-entry/3.mold.js",
            "resources/assets/js/question-entry/4.save.js",
            "resources/assets/js/question-entry/5.visual-helper.js"
        ],
        "public/js/exam-question-entry.js"
    )

    .js(
        ["resources/assets/js/theme1/exam-screen.js"],
        "public/js/exam-screen.js"
    )
    .js(["resources/assets/js/theme1/exam.js"], "public/js/exam.js");

mix.sass("resources/assets/sass/theme1/front.sass", "public/css/front.css");

// mix.sass('resources/assets/sass/theme1/back.sass', 'public/css/back.css');
