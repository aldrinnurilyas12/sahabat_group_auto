const mix = require('laravel-mix');

mix.copy('node_modules/pagedone/src/css/pagedone.css', 'public/css/pagedone.css')
   .copy('node_modules/pagedone/src/js/pagedone.js', 'public/js/pagedone.js');
