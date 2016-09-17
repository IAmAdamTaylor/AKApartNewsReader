var cwd = process.cwd(),
  
    // Require all gulp modules
    fs = require('fs'),
    nodePath = require('path'),
    gulp = require('gulp'),
    gulpIf = require('gulp-if'),
    sass = require('gulp-ruby-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    del = require('del'),

    // Source and destination paths
    paths = {
      sass: {
        in: 'src/sass/*.scss',
        out: 'public/css'
      },
      scripts: {
        in: 'src/js/*.js',
        out: 'public/js'
      }
    },

    /**
     * Get the base path of a folder path.
     * E.g. src/styles/sass/ -> sass
     * @param  string path
     * @return string
     */
    basePath = function( path ) {
      return path.split(/[\\/]/).pop();
    }

    /**
     * Strip the base path from a folder path.
     * E.g. src/styles/sass/ -> src/styles
     * @param  string path
     * @return string
     */
    stripBasePath = function( path ) {
      var parts = path.split(/[\\/]/);

      parts.pop();
      return parts.join('/');
    },
 
    /**
     * Get a file path, relative to the root folder. 
     * @param  string path
     * @return string
     */
    rootDir = function( path ) {
      return '/' + cwd.split(/[\\/]/).pop() + '/' + path;
    },


/**
 * Process all Sass files into CSS.
 * Uses autoprefixer for browser prefixes:
 *   Last 2 major versions of browsers,
 *   Any browser that has more than 1% global usage
 *   IE 9 specifically
 * Creates:
 *     Main .css file
 *     Minified .css file
 *     Sourcemap for minified file
 */
gulp.task('styles', function() {
  return sass( paths.sass.in, { style: 'expanded', require: 'sass-globbing', sourcemap: true } )
    .pipe( autoprefixer( {
        browsers: ['last 2 versions', '> 1%', 'IE 9']
    } ) )
    .pipe( gulp.dest( paths.sass.out ) )
    .pipe( rename( {suffix: '.min'} ) )
    .pipe( cssnano( {autoprefixer: false} ) )
    .pipe( gulp.dest( paths.sass.out ) )
    .pipe( sourcemaps.write( 'maps', {
        includeContent: false,
        sourceRoot: rootDir( stripBasePath( paths.sass.in ) )
    } ) )
    .pipe( gulp.dest( paths.sass.out ) )
    .pipe( notify( { message: 'Styles task complete', onLast: true } ) );
});

/**
 * Process all script files, into combined .js files.
 * Creates:
 *     2 files per subfolder in src/scripts folder, main .js file and minified
 *     Sourcemap for each minified file created
 */
gulp.task('scripts', function() {
  return gulp.src( paths.scripts.in )
    .pipe( jshint() )
    .pipe( jshint.reporter('default') )
    .pipe( sourcemaps.init() )
    .pipe( concat( 'all.js' ) )
    .pipe( gulp.dest( paths.scripts.out ) )
    .pipe( rename( {suffix: '.min'} ) )
    .pipe( uglify() )
    .pipe( gulp.dest( paths.scripts.out ) )
    .pipe( sourcemaps.write( 'maps', {
      includeContent: false,
      sourceRoot: rootDir( paths.scripts.in )
    } ) )
    .pipe( gulp.dest( paths.scripts.out ) )
    .pipe( notify( { message: 'Scripts task complete', onLast: true } ) );
});

/**
 * Clean up the production folders.
 * Deletes the specified directories, leaving the folder clean for next run.
 */
gulp.task('clean', function() {
  return del( ['public/css', 'public/js'] );
});

/**
 * Watch for any changes to the src files, and run tasks needed.
 */
gulp.task('watch', function() {
  // Watch .scss files
  gulp.watch( 'src/sass/**/*.scss', ['styles'] );
  
  // Watch .js files
  gulp.watch( 'src/js/**/*.js', ['scripts'] );
});

/**
 * Default task, run with: $ gulp
 * Cleans the destination directory, then runs each task async.
 */
gulp.task('default', ['clean'], function() {
  gulp.start( 'styles', 'scripts' );
});
