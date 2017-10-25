var elixir = require('laravel-elixir');
var less = require('gulp-less');
var path = require('path');
var gulp = require('gulp'),
  bundle = require('gulp-bundle-assets');

require('laravel-elixir-vue-2');

elixir(function(mix) {
  mix.webpack('app.js');
  mix.less(['styles.less', 'variables.less', '/base/*.less', '/layouts/*.less', '/base/*.less']);
})



// 04.12
