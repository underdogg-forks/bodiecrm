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

elixir(function(mix) {
    mix
        .less('app.less')
        .styles(
            [
                'normalize.css/normalize.css',
                'foundation/foundation.css',
                'animate.css/animate.css',
                'prism/prism.css',
                'dropzone/dropzone.min.css',
                
            ],
            'public/css/vendor.css',
            'public/vendor'
        )
        .scripts(
            ['app.js', 'jquery.dataTables.js', 'campaign.js', 'lead.js'],
            'public/js/app.min.js',
            'resources/assets/js'
        )
        .scripts(
            [
                'foundation/foundation.js',
                'prism/prism.js',
                'chartjs/Chart.js',
                'dropzone/dropzone.min.js',
                'chosen/chosen.jquery.min.js'
            ],
            'public/js/vendor.min.js',
            'public/vendor'
        )
        .scripts(
            ['attribution.js'],
            'public/js/attribution.min.js'
        );
});
