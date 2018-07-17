var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var imagemin = require('gulp-imagemin');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');

gulp.task('sass', function () {

    var onError = function(err) {
        notify.onError({
                    title:    "Gulp",
                    subtitle: "Failure!",
                    message:  "Error: <%= error.message %>",
                })(err);

        this.emit('end');
    };
    gulp.src(['src/scss/**/[^_]*.scss', '!src/scss/single/**/*.scss'])
      .pipe(plumber({errorHandler: onError}))
      .pipe(concat('style.css'))
      .pipe(sass({outputStyle: 'compressed'}))
      .pipe(autoprefixer({
        browsers: ['last 3 versions'],
        cascade: false
      }))
      .pipe(gulp.dest('dist/css'))
      .pipe(notify({ // Add gulpif here
        title: 'Gulp',
        subtitle: 'success',
        message: 'Sass compiled successfully'
      }));
      gulp.src(['src/scss/single/**/[^_]*.scss'])
        .pipe(plumber({errorHandler: onError}))
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({
          browsers: ['last 3 versions'],
          cascade: false
        }))
        .pipe(gulp.dest('dist/css/single'))
        .pipe(notify({ // Add gulpif here
          title: 'Gulp',
          subtitle: 'success',
          message: 'Sass compiled successfully'
        }));
});

gulp.task('scripts', function () {
  gulp.src(['src/js/**/*.js', '!src/js/single/**/*.js'])
    .pipe(uglify())
    .pipe(concat('script.js'))
    .pipe(gulp.dest('dist/js'));
  gulp.src(['src/js/single/**/*.js'])
    .pipe(uglify())
    .pipe(gulp.dest('dist/js/single'));
});

gulp.task('img', function() {
  gulp.src(['src/img/**/*'])
    .pipe(imagemin())
    .pipe(gulp.dest('dist/img'));
});

gulp.task('fonts', function() {
  gulp.src(['src/fonts/**/*'])
    .pipe(gulp.dest('dist/fonts'));
});

gulp.task('watch', ['default'], function() {
  gulp.watch('src/js/**/*.js', ['scripts']);
  gulp.watch('src/scss/**/*.scss', ['sass']);
  gulp.watch('src/img/**/*', ['img']);
  gulp.watch('src/fonts/**/*', ['fonts']);
});

gulp.task('default', ['img', 'sass', 'scripts', 'fonts']);
