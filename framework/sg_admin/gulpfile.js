/*global -$ */
'use strict';
// generated on 2015-04-29 using generator-sgtheme 0.0.1
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

gulp.task('css', function () {

  return gulp.src([
      // 'app/assets/styles/plugins.less',
      // 'app/assets/styles/app.less',
      'assets/less/sg-framework.less'
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
    // .pipe($.sourcemaps.init())
    .pipe($.less())
    .pipe($.postcss([
      require('autoprefixer-core')({browsers: ['last 1 version']})
    ]))
    // .pipe($.sourcemaps.write())
    .pipe(gulp.dest('assets/css')); 
});


gulp.task('bs', function () {

  return gulp.src('assets/less/sg-bootstrap.less')
    .pipe($.debug())
    .pipe($.plumber({
        errorHandler: function (err) {
            console.log(err);
            this.emit('end');
        }
    }))
    // .pipe($.sourcemaps.init())
    .pipe($.less())
    .pipe($.postcss([
      require('autoprefixer-core')({browsers: ['last 1 version']})
    ]))
    .pipe($.replace(/\./g, '.sgtb-'))
    .pipe($.replace(/\.sgtb-sgtb/g, '.sgtb'))
    .pipe($.replace(/\.sgtb .sgtb .sgtb/g, '.sgtb .sgtb'))
    .pipe($.replace(/\.sgtb html/g, '.sgtb'))
    .pipe($.replace(/\.sgtb body/g, '.sgtb'))
    .pipe($.replace(/\.sgtb .sgtb-/g, '.sgtb-'))
    .pipe($.replace(/\.sgtb-active/g, '.active'))
    .pipe($.replace(/\.sgtb-caret/g, '.caret'))
    .pipe($.replace(/\.sgtb-top/g, '.top'))
    .pipe($.replace(/\.sgtb-bottom/g, '.bottom'))
    .pipe($.replace(/\.sgtb-left/g, '.left'))
    .pipe($.replace(/\.sgtb-right/g, '.right'))
    .pipe($.replace(/\.sgtb-3/g, '.3'))
    .pipe($.replace(/\.sgtb-6/g, '.6'))
    // .pipe($.sourcemaps.write())
    .pipe(gulp.dest('assets/css'));
});

gulp.task('jshint', function () {
  return gulp.src('app/assets/scripts/**/*.js')
    .pipe(reload({stream: true, once: true}))
    .pipe($.jshint())
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.if(!browserSync.active, $.jshint.reporter('fail')));
});


gulp.task('scripts', function () {
  return gulp.src([
      'assets/js/*.js', 
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
    .pipe(gulp.dest('assets/js/min')); 
});
