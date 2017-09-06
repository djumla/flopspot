var gulp = require('gulp'),
  less = require('gulp-less'),
  livereload = require('gulp-livereload');

gulp.task('less', function() {
  return gulp.src('./public/*.less')
    .pipe(less())
    .pipe(gulp.dest('./dist/'))
    .pipe(livereload());
});

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch('./public/*.less', ['less']);
});

// 04.12
