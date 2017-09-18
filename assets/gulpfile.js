/**
 * init gulp plugins
 */
var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var wiredep = require('wiredep').stream;
var exec = require('child_process').exec;
var map = require('map-stream');
var events = require('events');
var emitter = new events.EventEmitter();
var path = require('path');
var gutil = require('gulp-util');
var currentTask = '';

/**
 * error reporter object (for plugins)
 */
var reportError = function (error) {
	var lineNumber = (error.lineNumber) ? 'LINE ' + error.lineNumber + ' -- ' : '';
	var pluginName = (error.plugin) ? ': ['+error.plugin+']' : '['+currentTask+']';

	plugins.notify({
		title: 'Task Failed '+pluginName,
		message: lineNumber + 'See console.'
	}).write(error);

	gutil.beep();

	var report = '';
	var chalk = gutil.colors.white.bgRed;

	report += chalk('TASK:') + pluginName+'\n';
	report += chalk('ERROR:') + ' ' + error.message + '\n';
	if (error.lineNumber) { report += chalk('LINE:') + ' ' + error.lineNumber + '\n'; }
	if (error.fileName)   { report += chalk('FILE:') + ' ' + error.fileName + '\n'; }

	console.error(report);

	this.emit('end');
}

/**
 * custom reporter for jshint-stylish
 */
var jsHintErrorReporter = function(file, cb) {

	return map(function (file, cb) {
		if (!file.jshint.success) {
			file.jshint.results.forEach(function (err) {
			if (err) {
				var msg = [
					path.basename(file.path),
					'LINE: ' + err.error.line,
					'ERROR: ' + err.error.reason
				];

				emitter.emit('error', new Error(msg.join(" - ")));
			}
		});
		}
		cb(null, file);
	});

};

/**
 * sourcemap/globs sass to css
 */
gulp.task('sass', function () {
	currentTask = 'sass';
	return gulp.src('styles/sass/screen.scss')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sassGlob())
		.pipe(plugins.sass())
		.pipe(plugins.autoprefixer({
			browsers: ['last 3 version', 'ie 9', '> 1%'],
			cascade: false
		}))
		.pipe(plugins.sourcemaps.write())
		.pipe(gulp.dest('styles'))
		.pipe(plugins.livereload());
});

/**
 * minifies css
 */
gulp.task('cssmin', function () {
	currentTask = 'cssmin';
	return gulp.src('styles/screen.css')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.cleanCss())
		.pipe(plugins.rename({suffix: '.min'}))
		.pipe(gulp.dest('styles'))
});

/**
 * collects /images/sprites/*.png into retina sprite maps
 */
gulp.task('sprites', function generateSpritesheets () {
	currentTask = 'sprites';
	var spriteData = gulp.src('images/sprites/*.png')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.spritesmith({
			retinaSrcFilter: 'images/sprites/*@2x.png',
			imgName: '../images/spritesheet.png',
			retinaImgName: '../images/spritesheet@2x.png',
			cssName: 'sprites.scss'
		}));
	spriteData.img.pipe(gulp.dest('images'));
	spriteData.css.pipe(gulp.dest('styles/sass/utility'));
});

/**
 * jshints js/modules/*.js
 */
gulp.task('jshint', function() {
	return gulp.src(['js/app.init.js','js/modules/**/*.js'])
		.pipe(plugins.jshint('.jshintrc'))
		.pipe(plugins.jshint.reporter('jshint-stylish'))
		.pipe(jsHintErrorReporter())
			.on('error', plugins.notify.onError(function (error) {
				return error.message;
			}
		))
		.pipe(plugins.livereload());
});

/**
 * compiles /js/bower/ main js -> libraries.js
 */
gulp.task('bower', ['exec'], function() {
	var filterJS = plugins.filter('**/*.js');
	currentTask = 'bower';
	return gulp.src('bower.json')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.mainBowerFiles())
		.pipe(filterJS)
		.pipe(plugins.concat('libraries.js'))
		.pipe(plugins.uglify())
		.pipe(gulp.dest('js'));
});

/**
 * compiles js/libraries.js with js/vendor/*.js & js/app.init.js
 */
gulp.task('compile-js', ['exec','bower'], function() { // needs to wait for bower
	currentTask = 'compile-js';
	return gulp.src(['js/libraries.js','js/vendor/**/*.js','js/app.init.js','js/modules/**/*.js'])
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.concat('app.min.js'))
		.pipe(plugins.uglify({
			compress: {
				drop_console: true
			}
		}))
		.pipe(gulp.dest('js'));
});

/**
 * injects js/bower/ main js into footer.php
 */
gulp.task('wire', ['exec'], function () { // we need to wait for exec
	currentTask = 'wire';
	gulp.src('../footer.php')
	.pipe(plugins.plumber({
		errorHandler: reportError
	}))
	.pipe(wiredep({
		fileTypes: {
			html: {
				replace: {
					js: '<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/{{filePath}}"></script>'
				}
			}
		},
	}))
	.pipe(gulp.dest('..'))
	.pipe(plugins.livereload());
});

/**
 * injects js/modules/*.js, js/vendor/*.js, and js/app.init.js into footer.php 
 */
gulp.task('inject', function () {
	currentTask = 'inject';
	gulp.src('../footer.php')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.inject(gulp.src('js/app.init.js', {read: false}), {
			starttag: '<!-- inject:init:{{ext}} -->',
			transform: function (filepath) {
				return '<script src="<?php echo assets_url(); ?>'+filepath+'"></script>';
			}
		}))
		.pipe(plugins.inject(gulp.src(['js/vendor/*.js'], {read: false}), {
			starttag: '<!-- inject:vendor:{{ext}} -->',
			transform: function (filepath) {
				return '<script src="<?php echo assets_url(); ?>'+filepath+'"></script>';
			}
		}))
		.pipe(plugins.inject(gulp.src(['js/modules/*.js'], {read: false}), {
			starttag: '<!-- inject:modules:{{ext}} -->',
			transform: function (filepath) {
				return '<script src="<?php echo assets_url(); ?>'+filepath+'"></script>';
			}
		}))
		.pipe(gulp.dest('..'))
		.pipe(plugins.livereload());
});

/**
 * uses fontello.json to create font/ files and /styles/sass/vendor/icon *.scss
 */
gulp.task('fontello', function () {
	currentTask = 'fontello';
	return gulp.src('fontello.json')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.fontello({
			font: 'fonts/icons',
			css: 'styles/sass/vendor/icons'
		}))
		.pipe(plugins.rename(function(file) { // we need to rename css files to scss
			if (file.extname == '.css') {
				file.extname = '.scss';
			}
		}))
		.pipe(gulp.dest('../assets/'))
});

/**
 * minifies /images/*
 */
gulp.task('imagemin', function () {
	currentTask = 'imagemin';
	gulp.src('images/*')
		.pipe(plugins.plumber({
			errorHandler: reportError
		}))
		.pipe(plugins.imagemin())
		.pipe(gulp.dest('images'))
});

/**
 * runs bower install
 */
gulp.task('exec', function(cb) {
	exec('bower install', function (err, stdout, stderr) {
		console.log(stdout);
		console.log(stderr);
		cb(err);
	});
});

/**
 * gulp watch:
 * - listens for changed .scss files in /styles/sass, then converts sass partials into css
 * - listens for changed .js files in /js/modules/, /js/vendor, and /js/, then runs bower install, wires bower files, and injects app.init.js, vendor files, and modules
 * - listens for changed .php files in theme root, /templates/, and /partials/ and refreshes page
 */
gulp.task('watch', function() {
	plugins.livereload.listen();
	gulp.watch('styles/sass/**/**/**/*.scss', ['sass']);
	gulp.watch(['js/modules/*.js','js/vendor/*.js','js/*.js'], ['exec','wire','inject','jshint']);
	gulp.watch(['../*.php','../templates/**/*.php','../partials/**/*.php']).on('change', plugins.livereload.changed);
});

/**
 * gulp build:
 * - sprites: takes sprites in /images/sprites and creates retina/non-retina sprite map
 * - fontello: uses fontello.json to create icon fonts and collect scss
 * - sass: compiles sass partials into css
 * - cssmin: minifies css
 * - jshints the js modules
 * - exec: runs bower install
 * - bower: merges bower js into libraries.js
 * - compile-js: merges libraries.js with vendor, modules, app.init & uglifies
 * - imagemin: shrinks images
 */
gulp.task('build', ['sprites','fontello','sass','cssmin','jshint','exec','bower','compile-js','imagemin']);

/**
 * gulp:
 * - runs bower install (wire and inject wait on the exec)
 * - creates sass
 * - jshints the custom modules
 * - wires bower js into footer.php, then injects vendor, app.init, & modules
 * - kicks off gulp watch
 */
gulp.task('default', ['sprites','fontello','sass','exec','wire','inject','jshint','watch']);