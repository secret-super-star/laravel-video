var Elixir = require('laravel-elixir');
require('laravel-elixir-minify-html');

Elixir(function(mix) {
  mix.html('storage/framework/views/*', 'storage/framework/views/', {collapseWhitespace: true, removeAttributeQuotes: true, removeComments: true, minifyJS: true});
});