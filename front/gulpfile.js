/*global -$ */
'use strict';
// generated on 2015-04-29 using generator-sgtheme 0.0.1
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

gulp.task('css', function () {

  return gulp.src([
      // 'app/assets/styles/plugins.less',
      // 'app/assets/styles/app.less',
      'assets/less/theme.less'
    ])
    .pipe($.debug())
    .pipe($.plumber({
        errorHandler: function (err) {
            console.log(err);
            this.emit('end');
        }
    }))
    .pipe($.less())
    .pipe($.postcss([
      require('autoprefixer-core')({browsers: ['last 1 version']})
    ]))
    // .pipe($.sourcemaps.write())
    .pipe(gulp.dest('assets/css')); 
});


gulp.task('js', function () {
  return gulp.src([
      'assets/js/plugins.js', 
    ])
    .pipe($.debug())
    .pipe($.plumber({
        errorHandler: function (err) {
            console.log(err);
            this.emit('end');
        }
    }))
    .pipe($.fileInclude({
      prefix: '@@',
      basepath: '@file'
    }))
    .pipe($.uglify())
    .pipe($.rename(function(path){
      path.extname = ".min.js";
    }))
    .pipe(gulp.dest('assets/js')); 
});
