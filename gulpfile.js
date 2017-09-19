var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(function(mix) {
  mix.webpack('app.js');
  mix.less(['styles.less', 'variables.less', '/base/*.less', '/layouts/*.less', '/base/*.less']);
})



// 04.12
