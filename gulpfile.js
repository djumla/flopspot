var gulp = require('gulp'),
  less = require('gulp-less'),
  livereload = require('gulp-livereload'),
  plumber = require('gulp-plumber'),
  gutil = require('gulp-util');

var onError = function(err) {
  gutil.beep();
  console.log(err);
};

gulp.task('less', function() {
  return gulp.src('./public/*.less')
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(less())
    .pipe(gulp.dest('./dist/'))
    .pipe(livereload());
});

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch(['./public/*.less',
    './public/*/*.less'
  ], ['less']);
});

// 04.12
