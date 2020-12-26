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
var terser      	= require('gulp-terser');
var concat      	= require('gulp-concat');
var sourcemaps  	= require('gulp-sourcemaps');
var jshint      	= require('gulp-jshint');
var download 		= require("gulp-download");

// grabs external JS
// (reduces # of hits for performance)
gulp.task('external-js', function(){
	return download([
		"https://s7.addthis.com/js/300/addthis_widget.js",
	]).pipe(gulp.dest("js/vendor/"));
});

// grabs external CSS (including WP core scripts)
// (reduces # of hits for performance)
// CHANGE WPX.TEST TO YOUR LOCAL ENVIRONMET
gulp.task('external-css', function(){
	return download([
		"http://wpx.test/wp-includes/css/dashicons.min.css",
		"http://wpx.test/wp-includes/css/admin-bar.min.css",
		"http://wpx.test/wp-includes/css/dist/block-library/style.min.css",
		"http://wpx.test/wp-includes/css/dist/block-library/theme.min.css",
		"http://wpx.test/wp-content/plugins/contact-form-7/includes/css/styles.css"
	])
	.pipe(rename({
		extname: ".scss"
	}))
	.pipe(gulp.dest("styles/sass/vendor/"));
});

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
		.pipe(sourcemaps.init())
		.pipe(sassglob())
		.pipe(sass())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(cleancss({
			compatibility: '*',
			format: 'beautify',
			sourceMap: true
		}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('styles'))
		.pipe(livereload());
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
			format: 'beautify',
			sourceMap: true
		}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('styles'))
		.pipe(livereload());
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

// minifies SVGs
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
		.pipe(gulp.dest('images/'))
});

// minifies PNG, GIF, JPEG, and JPG
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
		.pipe(gulp.dest('images/'))
});

// checks app.init and modules for js errors
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

// compiles vendor JS and app/modules JS
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

// preps JS for prod
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
	gulp.watch(['styles/gutenberg/**/*.scss','styles/**/**/**/*.scss'], {usePolling: true}, gulp.series(['sass','sass-gutenberg']));
	gulp.watch(['js/modules/*.js','js/vendor/*.js'], {usePolling: true}, gulp.series(['jshint','js']));
	gulp.watch(['../*.php','../templates/**/*.php','../partials/**/*.php']).on('change', livereload.changed);
})

gulp.task('external', gulp.series('external-js','external-css'));
gulp.task('default', gulp.series('jshint', gulp.parallel(['sass','js','sass-gutenberg']), 'watch'));
gulp.task('fontello', gulp.series('fontello','fontello-acf'));
gulp.task('build', gulp.series('jshint',gulp.parallel(['sass-build','jsmin','sprites','fontello'],'imagemin','svgmin','sass-gutenberg-build')));