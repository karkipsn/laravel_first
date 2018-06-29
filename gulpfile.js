 var gulp = require('gulp');

gulp.task('cssg', function() {
   return gulp.src('app/css/style.css')
              .pipe(gulp.dest('public/css'));
});

var cleanCSS = require('gulp-clean-css');

gulp.task('css1', function() {
   return gulp.src('app/css/style.css')
               .pipe(cleanCSS({compatibility: 'ie8'}))
               .pipe(gulp.dest('public/css'));
});

var sass = require('gulp-sass'),
    less = require('gulp-less'),
    elixir = require('laravel-elixir');

gulp.task('sass', function() {
   return gulp.src('app/css/style.scss')
               .pipe(sass())
               .pipe(cleanCSS({compatibility: 'ie8'}))
               .pipe(gulp.dest('public/css'));
});

//var gulp = require('gulp');
    // sass = require('gulp-ruby-sass'),           // compiles sass to CSS
   // var minify = require('gulp-minify-css'),        // minifies CSS
    concat = require('gulp-concat'),            // concat files
    uglify = require('gulp-uglify');           // uglifies JS
    // rename = require('gulp-rename'),            // rename files
    // notify = require('gulp-notify'),            // notify using MAC
   var bower = require('gulp-bower');             // bower update tasks
    // phpunit = require('gulp-phpunit');          // PHP unit test
    // livereload = require('gulp-livereload');    // reload browser
    // sourcemaps = require('gulp-sourcemaps');    // debug tool by showing file reference

// Include plugins
var plugins = require("gulp-load-plugins")({
	pattern: ['gulp-*', 'gulp.*', 'main-bower-files'],
	replaceString: /\bgulp[\-.]/
});

//Define default destination folder
//var src = 'src/';
var dest = 'www/public/';

// Paths variables

// gulp.task('test', function(done) {

// console.log(plugins);
// done();

// });


gulp.task('js', function() {

	var jsFiles = ['src/js/*'];

	gulp.src(plugins.mainBowerFiles().concat(jsFiles).on ('error',errorhandler))
		.pipe(plugins.filter('**/*.js'))
		.pipe(plugins.concat('main.js'))
		.pipe(plugins.uglify())
		.pipe(gulp.dest(dest + 'js'));

});

var paths = {
    'resources': {
        'sass'  : './public/sass/',
        'scss'  : './public/scss/',
        'js'    : './public/js/',
        'vendor': './public/vendor/',
        'fonts' : './public/fonts/',
        'css'   : './public/css/',
    },
    'assets': {
        'css'  : './public/assets/css/',
        'js'   : './public/assets/js/',
        'bower': './public/assets/bower_components/',
    },
    'app': {
          'tests': './app/tests',
    }
};

gulp.task('bower', function() {
  return bower();
});
/**
 * Run bower update on assets.bower folder
 */
gulp.task('bower', function() {
  return bower({ cmd: 'update' });
});

gulp.task('css', function() {
   return gulp.src('app/sass/style.scss')
               .pipe(sass())
               .pipe(cleanCSS({compatibility: 'ie8'}))
               .pipe(gulp.dest('public/css'));
});

gulp.task('lessCss', function() {
   return gulp.src('app/less/style.less')
               .pipe(less())
               .pipe(cleanCSS({compatibility: 'ie8'}))
               .pipe(gulp.dest('public/css'));
});

gulp.task('watch:less', function() {
   gulp.watch('app/less/*.less', ['lessCss']);
});

gulp.task('jsMinify2', function() {
   return gulp.src('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js')
               .pipe(uglify())
               .pipe(gulp.dest('public/js'));
});

// elixir(function(mix) {
//     'bootstrap-datepicker.js'
// });