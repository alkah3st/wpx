var gulp        	= require('gulp');
var sass        	= require('gulp-sass');
var livereload  	= require('gulp-livereload');
var cleancss    	= require('gulp-clean-css');
var rename      	= require('gulp-rename');
var fontello      	= require('gulp-fontello');
var notify      	= require('gulp-notify');
var plumber      	= require('gulp-plumber');
var autoprefixer 	= require('gulp-autoprefixer');
var imagemin    	= require('gulp-imagemin');
var spritesmith 	= require('gulp.spritesmith');
var sassglob    	= require('gulp-sass-glob');
var uglify      	= require('gulp-uglify');
var concat      	= require('gulp-concat');
var sourcemaps  	= require('gulp-sourcemaps');
var jshint      	= require('gulp-jshint');

gulp.task('sass', function(){
	return gulp.src('styles/sass/screen.scss')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(sourcemaps.init())
		.pipe(sassglob())
		.pipe(sass())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(cleancss({
			compatibility: '*',

		}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('styles'))
		.pipe(livereload());
});

gulp.task('sass-build', function(){
	return gulp.src('styles/sass/screen.scss')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(sassglob())
		.pipe(sass())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(cleancss({
			compatibility: '*',

		}))
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('styles'))
});

gulp.task('sass-gutenberg', function () {
	return gulp.src('styles/gutenberg/gutenberg.scss')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass-gutenberg]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(sourcemaps.init())
		.pipe(sassglob())
		.pipe(sass())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(cleancss({
			compatibility: '*',

		}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('styles'))
		.pipe(livereload());
});

gulp.task('sass-gutenberg-build', function(){
	return gulp.src('styles/gutenberg/gutenberg.scss')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(sassglob())
		.pipe(sass())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(cleancss({
			compatibility: '*',

		}))
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('styles'))
});

gulp.task('sprites', function generateSpritesheets (done) {
	var spriteData = gulp.src('images/sprites/*.png')
	.pipe(plumber({errorHandler: function(err) {
		notify.onError({
					title:    "Gulp: [sass-spritesmith]",
					subtitle: "Error",
					message:  "<%= error.message %>",
					sound:    false
				})(err);

		this.emit('end');
	}}))
	.pipe(spritesmith({
		retinaSrcFilter: 'images/sprites/*@2x.png',
		imgName: '../images/spritesheet.png',
		retinaImgName: '../images/spritesheet@2x.png',
		cssName: 'sprites.scss'
	}))
	spriteData.img.pipe(gulp.dest('images'));
	spriteData.css.pipe(gulp.dest('styles/sass/utility'));
	done();
});

gulp.task('svgmin', function(){
	return gulp.src('images/**/*.{svg}')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass-svgmin]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(imagemin([imagemin.svgo({plugins: [{removeViewBox: true}]})]))
		.pipe(rename({dirname: ''}))
		.pipe(gulp.dest('assets/images/'))
});

gulp.task('imagemin', function(){
	return gulp.src('images/**/*.{png,gif,jpg,jpeg}')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass-imagemin]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(imagemin())
		.pipe(rename({dirname: ''}))
		.pipe(gulp.dest('assets/images/'))
});

gulp.task('jshint', function() {
	return gulp.src(['js/app.init.js','js/modules/**/*.js'])
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [jshint]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(jshint('.jshintrc'))
		.pipe(jshint.reporter('jshint-stylish'))
		.pipe(jshint.reporter('fail'));
});

gulp.task('js', function() {
	return gulp.src(['js/vendor/**/*.js','js/app.init.js','js/modules/**/*.js'])
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [js]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(concat('app.js'))
		.pipe(gulp.dest('js'))
		.pipe(livereload());
});

gulp.task('jsmin', function() {
	return gulp.src(['js/vendor/**/*.js','js/app.init.js','js/modules/**/*.js'])
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [js]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(concat('app.min.js'))
		.pipe(uglify({
			compress: {
				drop_console: true
			}
		}))
		.pipe(gulp.dest('js'))
		.pipe(livereload());
});

gulp.task('fontello', function () {
	return gulp.src('fontello.json')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [fontello]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(fontello({
			font: 'fonts/icons',
			css: 'styles/sass/vendor/icons'
		}))
		.pipe(rename(function(file) { // we need to rename css files to scss
			if (file.extname == '.css') {
				file.extname = '.scss';
			}
		}))
		.pipe(gulp.dest('../assets/'))
});

// renders css for acf-icon-picker
gulp.task('fontello-acf', function () {
	return gulp.src('styles/sass/vendor/icons/fontello.scss')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [fontello-acf]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(sourcemaps.init())
		.pipe(sassglob())
		.pipe(sass())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('../assets/styles/'))
});

gulp.task('watch', function(){
	livereload({ start: true });
	gulp.watch(['styles/**/**/**/*.scss'], {usePolling: true}, gulp.series(['sass']));
	gulp.watch(['js/modules/*.js','js/vendor/*.js'], {usePolling: true}, gulp.series(['jshint','js']));
	gulp.watch(['../*.php','../templates/**/*.php','../partials/**/*.php']).on('change', livereload.changed);
})

gulp.task('watch-gutenberg', function(){
	livereload({ start: true });
	gulp.watch(['styles/gutenberg/**/*.scss'], {usePolling: true}, gulp.series(['sass-gutenberg']));
	gulp.watch(['../*.php','../templates/**/*.php','../partials/**/*.php'], {usePolling: true}).on('change', livereload.changed);
})

gulp.task('default', gulp.series('jshint',gulp.parallel(['sass','js']), 'watch'));
gulp.task('fontello', gulp.series('fontello','fontello-acf'));
gulp.task('gutenberg', gulp.series(gulp.parallel(['sass-gutenberg']), 'watch-gutenberg'));
gulp.task('build', gulp.series('jshint',gulp.parallel(['sass-build','jsmin','sprites','fontello'],'imagemin','svgmin','sass-gutenberg-build')));