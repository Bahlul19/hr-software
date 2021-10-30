var gulp = require('gulp'),
	jslint = require('gulp-jslint'),
	jshint = require('gulp-jshint'),
	cssnano = require('gulp-cssnano'),
	imagemin = require('gulp-imagemin'),
	uglify = require('gulp-uglify'),
	sass = require('gulp-sass'),
	browserSync = require('browser-sync').create(),
	reload      = browserSync.reload;
console.log(jslint);
gulp.task('js', function () {
	return gulp.src('./webroot/src/js/**/*.js')
		.pipe(jshint())
    	.pipe(jshint.reporter('default'))
		.pipe(uglify())
      	.pipe(gulp.dest('./webroot/dist/js'));
});

gulp.task('sass', function () {
  return gulp.src('./webroot/src/sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./webroot/src/css'));
});

gulp.task('cssnano', ['sass'], function() {
    return gulp.src('./webroot/src/css/**/*.css')
        .pipe(cssnano({discardUnused: false, zindex: false}))
        .pipe(gulp.dest('./webroot/dist/css'));
});

gulp.task('js-watch', ['js'], function (done) {
	browserSync.reload();
	done();
});

gulp.task('css-watch', ['cssnano'], function (done) {
	browserSync.reload();
	done();
});

gulp.task('serve', ['js', 'sass', 'cssnano'], function () {
    var files = [

    ];
    browserSync.init(files, {
        //browsersync with a php server
        proxy: "geripsy.sj",
        notify: false
    });

    gulp.watch("webroot/src/js/*.js", ['js-watch']);
    gulp.watch("webroot/src/**/*.scss", ['css-watch']);
});