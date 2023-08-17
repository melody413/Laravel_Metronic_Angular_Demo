'use strict';
var gulp            = require('gulp');
var sass            = require('gulp-sass');
var sourcemaps      = require('gulp-sourcemaps');
var concat          = require('gulp-concat');
var rename          = require("gulp-rename");
var addsrc          = require('gulp-add-src');
var gutil           = require('gulp-util');
var bro             = require('gulp-bro');
var uglify          = require('gulp-uglify');
var uglifycss       = require('gulp-uglifycss');
var coffeeify       = require('coffeeify');
var coffeescript = require('gulp-coffeescript');
var coffee = require('gulp-coffee');
var notify = require("gulp-notify");


gulp.task('default', ['build', 'watch']);
gulp.task('build', ['coffeescript', 'sass', 'sass_rtl']);
//gulp.task('mnf', ['sass']);
//.pipe(uglify())

gulp.task('coffeescript', function (done) {
  gulp.src('./resources/assets/js/backend/init.coffee', {read: false})
      .pipe(bro({
        transform: [coffeeify],
        extensions: ['.coffee'],
        debug: true
      }))
      //.pipe(sourcemaps.init())
      //.pipe(sourcemaps.write())
      .pipe(concat('back.js'))
      //.pipe(uglify())
      .pipe(gulp.dest('./public/assets/admin/js/'))
      .on('error', function(err){ gutil.log(err); this.emit('end') })
      .on('end', done);
});

gulp.task('sass', function (done) {
  // Compile the global SASS
  gulp.src('./resources/assets/sass/doctorak.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .on('error', sass.logError)
    .pipe(sourcemaps.write())
    .pipe(concat('doctorak.css'))
    // .pipe(uglifycss({
    //     "maxLineLen": 80,
    //     "uglyComments": true
    // }))
    .pipe(gulp.dest('./public/assets/frontend/css'))
    .on('end', done);
});

gulp.task('sass_rtl', function (done) {
    // Compile the global SASS RTL
    gulp.src('./resources/assets/sass/rtl.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .on('error', sass.logError)
        .pipe(sourcemaps.write())
        .pipe(concat('doctorak_rtl.min.css'))
        // .pipe(uglifycss({
        //     "maxLineLen": 80,
        //     "uglyComments": true
        // }))
        .pipe(gulp.dest('./public/assets/frontend/css'))
        .on('end', done);
});

gulp.task('watch', function () {
  gulp.watch(['./resources/assets/sass/**/*.scss'], ['sass', 'sass_rtl']);
  gulp.watch(['./resources/assets/js/backend/**/*.coffee', './resources/assets/js/backend/**/*.js'], ['coffeescript']);


});

