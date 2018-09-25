var gulp = require('gulp'),
	autoprefixer  = require('gulp-autoprefixer'),
	browserSync   = require('browser-sync'),
	sass = require('gulp-sass');

gulp.task('browser-sync', function() {
	browserSync({
		server: {
			baseDir: './'
		},
		notify: false,
		// open: false,
		// online: false, // Work Offline Without Internet Connection
		// tunnel: true, tunnel: "projectname", // Demonstration page: http://projectname.localtunnel.me
	})
});

gulp.task('js', function() {
	return gulp.src('script.js')
	.pipe(browserSync.reload({ stream: true }))
});

gulp.task('sass', function () {
  return gulp.src('sass/**/*.sass')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer(['last 15 versions']))
    .pipe(gulp.dest('css'))
    .pipe(browserSync.stream());
});

gulp.task('watch', ['sass', 'js', 'browser-sync'], function() {
	gulp.watch('sass/main.sass', ['sass']);
	gulp.watch(['script.js'], ['js']);
	gulp.watch('index.html', browserSync.reload);
});
 
/*gulp.task('sass:watch', function () {
  gulp.watch('sass/**//*.scss', ['sass']);
});*/
gulp.task('default', ['watch']);