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
var babel	        = require('gulp-babel');
var sassglob    	= require('gulp-sass-glob');
var uglify      	= require('gulp-uglify-es').default;
var concat      	= require('gulp-concat');
var sourcemaps  	= require('gulp-sourcemaps');
var jshint      	= require('gulp-jshint');
var terser 			= require('gulp-terser');
var download 		= require("gulp-download");
var newer 			= require("gulp-newer");
var cached 			= require("gulp-cached");
var dependents 		= require("gulp-dependents");

// compiles SCSS -> CSS
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
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe(sassglob())
		.pipe(sass())
		.pipe(cached('sass_compiled'))
		.pipe(autoprefixer({
			cascade: false,
			flexbox: 'no-2009',
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('styles'))
		.pipe(livereload())
});

// preps CSS for prod
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

// compiles SCSS -> CSS inside gutenberg
gulp.task('sass-gutenberg', function () {
	return gulp.src('styles/gutenberg/gutenberg.scss')
		.pipe(newer({ dest: 'styles', ext: '.css', extra: ['styles/sass/**/**/**/*.scss','styles/gutenberg/**/**/**/*.scss']}))
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass-gutenberg]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(sourcemaps.init({loadMaps: true}))
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
});

// preps gutenberg CSS for prod
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

// compiles icons into a single sprite
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

// minifies PNG, GIF, JPEG, JPG, and SVG
gulp.task('imagemin', function(){
	return gulp.src('images/*.{png,gif,jpg,jpeg,svg}')
		.pipe(plumber({errorHandler: function(err) {
			notify.onError({
						title:    "Gulp: [sass-imagemin]",
						subtitle: "Error",
						message:  "<%= error.message %>",
						sound:    false
					})(err);

			this.emit('end');
		}}))
		.pipe(imagemin([
			imagemin.gifsicle({interlaced: true, optimizationLevel: 3}),
			imagemin.mozjpeg({quality: 85, progressive: true}),
			imagemin.optipng({optimizationLevel: 5}),
			imagemin.svgo({
				plugins: [
					{removeViewBox: true},
					{cleanupIDs: false}
				]
			})
		]))
		.pipe(gulp.dest('images'))
});

// checks app.init and modules for js errors
gulp.task('jshint', function() {
	return gulp.src(['js/app.init.js','js/modules/**/**/*.js'])
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

// compiles vendor JS and app/modules JS
gulp.task('js', function() {
	return gulp.src(['js/vendor/**/*.js','js/app.init.js','js/app.utils.js','js/modules/**/**/*.js'])
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
		.pipe(livereload())
});

// preps JS for prod
gulp.task('jsmin', function() {
	return gulp.src(['js/vendor/**/*.js','js/app.init.js','js/app.utils.js','js/modules/**/**/*.js'])
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
		.pipe(terser())
		.pipe(uglify({
			compress: {
				drop_console: true
			}
		}))
		.on('error', function(err){
			console.log('\x07',err); return this.end();
		})
		.pipe(gulp.dest('js'))
});

// fetches latest icons from fontello based on json
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
			host: 'https://fontello.com',
			font: 'fonts/icons',
			css: 'styles/sass/vendor/icons'
		}))
		.pipe(rename(function(file) { // we need to rename css files to scss
			//file.basename = '_'+file.basename;
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
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe(sassglob())
		.pipe(sass())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('../assets/styles/'))
});

gulp.task('watch', function(){
	livereload.listen();
	gulp.watch(['styles/sass/**/**/**/*.scss'], gulp.series(['sass']));
	gulp.watch(['js/modules/**/**/*.js','js/vendor/*.js'], gulp.series(['jshint','js']));
	gulp.watch(['../*.php','../includes/classes/**/*.php','../templates/**/*.php','../partials/**/*.php']).on('change', livereload.changed);
});

gulp.task('watch-gutenberg', function(){
	livereload.listen();
	gulp.watch(['styles/sass/**/**/**/*.scss','styles/gutenberg/**/**/**/*.scss'], gulp.series(['sass','sass-gutenberg']));
	gulp.watch(['js/modules/**/**/*.js','js/vendor/*.js'], gulp.series(['jshint','js']));
	gulp.watch(['../*.php','../templates/**/*.php','../partials/**/*.php']).on('change', livereload.changed);
});

gulp.task('default', gulp.series('jshint', gulp.parallel(['sass','js']), 'watch'));
gulp.task('gutenberg', gulp.series('jshint', gulp.parallel(['sass','sass-gutenberg']), 'watch-gutenberg'));
gulp.task('fontello', gulp.series('fontello','fontello-acf'));
gulp.task('build', gulp.series('jshint',gulp.parallel(['sass-build','jsmin','fontello'],'imagemin','sass-gutenberg-build')));