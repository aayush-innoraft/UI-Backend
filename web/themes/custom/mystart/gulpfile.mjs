// Importing using ESM syntax
import gulp from 'gulp';
import gulpSass from 'gulp-sass';
import dartSass from 'sass';
import autoprefixer from 'gulp-autoprefixer';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import browserSync from 'browser-sync';

// Initialize sass with Dart Sass
const sass = gulpSass(dartSass);

// File paths
const paths = {
  scss: './scss/**/*.scss',
  js: './js/**/*.js',
  cssDest: './css',
  jsDest: './js/min',
};

// Compile SCSS
export function compileScss() {
  return gulp
    .src(paths.scss)
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(gulp.dest(paths.cssDest))
    .pipe(browserSync.stream());
}

// Compile and minify JS
export function compileJs() {
  return gulp
    .src(paths.js)
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.jsDest))
    .pipe(browserSync.stream());
}

// Watch task
export function watchFiles() {
  browserSync.init({
    proxy: 'http://uibackend.lando.site.test', 
  });
  gulp.watch(paths.scss, compileScss);
  gulp.watch(paths.js, compileJs);
  gulp.watch('**/*.twig').on('change', browserSync.reload);
}

// Default task
export default gulp.series(compileScss, compileJs, watchFiles);
