var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.sass('./resources/assets/css/custom/app.scss', './public/css/app.css');

    mix.sass([
        './resources/assets/css/vendor/foundation.min.css',
        './resources/assets/css/vendor/responsive-tables.css',
        './resources/assets/css/vendor/cs-skin-elastic.css',
        './resources/assets/css/vendor/cs-select.css',
        './resources/assets/css/vendor/jquery.json-viewer.css'
    ], './public/css/vendors.css');

    mix.scripts([
        './resources/assets/js/custom/api.js',
        './resources/assets/js/custom/ui.js'
    ], './public/js/app.js');

    mix.scripts([
        './resources/assets/js/custom/contracts.js'
    ], './public/js/contracts.js');

    mix.scripts([
        './resources/assets/js/custom/login.js',
        './resources/assets/js/vendor/autosize.min.js'
    ], './public/js/comment.js');

    mix.scripts([

        './resources/assets/js/charts/custom/lineChart-homepage.js',
        './resources/assets/js/charts/custom/lineChart-rest.js',
        './resources/assets/js/charts/custom/horizontal-barChart.js',
        './resources/assets/js/charts/custom/barChart-contract.js',
        './resources/assets/js/charts/custom/lineChart-header.js',
        './resources/assets/js/charts/custom/range-slider.js',
    ], './public/js/customChart.js');

    mix.scripts([
        './resources/assets/js/charts/vendor/d3.min.js'
    ], './public/js/vendorChart.js');

    mix.scripts([
        './resources/assets/js/vendor/jquery-2.2.2.min.js',
        './resources/assets/js/datatable/jquery.dataTables.min.js',
        './resources/assets/js/vendor/moment.min.js',
        './resources/assets/js/vendor/number-format.js',
        './resources/assets/js/vendor/classie.js',
        './resources/assets/js/vendor/selectFx.js',
        './resources/assets/js/vendor/jquery.json-viewer.js'

    ], './public/js/vendor.js');

    mix.scripts([
        './resources/assets/js/vendor/jquery.ui.widget.js',
        './resources/assets/js/vendor/jquery.iframe-transport.js',
        './resources/assets/js/vendor/jquery.fileupload.js',
        './resources/assets/js/vendor/jquery.fileupload-process.js',
        './resources/assets/js/vendor/jquery.fileupload-validate.js'
    ], './public/js/vendorFileUpload.js');

    mix.scripts([
        './resources/assets/js/custom/wiki.js'
    ], './public/js/wiki.js');

    mix.scripts([
        './resources/assets/js/vendor/markdown-it.js'
    ], './public/js/vendorMarkdown.js');
});
