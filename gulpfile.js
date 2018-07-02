// var elixir = require('laravel-elixir');

//     elixir(function(mix) {
//     mix.less('app.less');
// });

var gulp = require('gulp'),
 uglify = require('gulp-uglify'),
 gulpIf = require('gulp-if'),
 imagemin = require('gulp-imagemin');
const changed = require('gulp-changed');
  var bower = require('gulp-bower'), 
   minify = require('gulp-minify-css'),        // minifies CSS
    concat = require('gulp-concat'),            // concat files
    uglify = require('gulp-uglify'),
     phpunit = require('gulp-phpunit');


var browserSync = require('browser-sync').create('s1');
var browserSync1 = require('browser-sync').create('s2');
var browserSync2 = require('browser-sync').create('s3');

// Static server
gulp.task('browser-sync', function(done) {
    browserSync.init({
    proxy: "localhost:8000/api/users"
    
   }) 
});
gulp.task('browser-sync1', function(done) {
    browserSync.init({
    proxy: "localhost:8000/api/users"
  
   }) 
});
gulp.task('browser-sync2', function() {
    browserSync.init({
    proxy: "localhost:8000/api/users"
   }) 
});




gulp.task('useref', function(){
  return gulp.src('/resources/views/employees/*.php')
    //.pipe(useref())
    // Minifies only if it's a JavaScript file
    .pipe(gulpIf('*.js', uglify()))
    .pipe(gulp.dest('public/js'))

    gulp.watch('/resources/views/employees/*.php', function() {
      // run styles upon changes
      gulp.run('useref');
   });
});

gulp.task('imagemin', function() {
   var img_src = 'storage/app/avatars/*', img_dest = 'public/images';
   
   gulp.src(img_src)
   .pipe(changed(img_dest))
   .pipe(imagemin())
   .pipe(gulp.dest(img_dest));
});

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

gulp.task('js', function() {

	var jsFiles = ['src/js/*'];

	gulp.src(plugins.mainBowerFiles().concat(jsFiles).on ('error',errorhandler))
		.pipe(plugins.filter('**/*.js'))
		.pipe(plugins.concat('main.js'))
		.pipe(plugins.uglify())
		.pipe(gulp.dest(dest + 'js'));

});


gulp.task('watch:less', function() {
   gulp.watch('app/less/*.less', ['lessCss']);
});

gulp.task('jsMinify2', function() {
   return gulp.src('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js')
               .pipe(uglify())
               .pipe(gulp.dest('public/js'));
});

 
gulp.task('phpunit', function() {
  gulp.src('phpunit.xml')
   // .pipe(phpunit('.\\path\\to\\phpunit'));
    .pipe(phpunit('.\\vendor\\bin\\phpunit'));
});
// gulp.task('default', ['imagemin', 'useref','browser-sync'], function() {

// });