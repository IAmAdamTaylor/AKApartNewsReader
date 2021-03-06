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
        in: 'src/js',
        out: 'public/js',
        lintFolders: [ 'main', 'search' ]
      },
      images: {
        in: 'src/images/**/*',
        out: 'public/images'
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
     * Get subfolders of a parent folder.
     * @param  string dir
     * @return array (I think? :P)
     */
    getFolders = function( dir ) {
      return fs.readdirSync(dir)
        .filter( function(file) {
          return fs.statSync( nodePath.join( dir, file ) ).isDirectory();
        } );
    };


/**
 * Process all Sass files into CSS.
 * Uses autoprefixer for browser prefixes:
 *   Last 2 major versions of browsers,
 *   Any browser that has more than 5% global usage
 *   IE 9 specifically
 * Creates:
 *     Main .css file
 *     Minified .css file
 *     Sourcemap for minified file
 */
gulp.task('styles', function() {
  return sass( paths.sass.in, { style: 'expanded', require: 'sass-globbing', sourcemap: true } )
    .pipe( autoprefixer( {
        browsers: ['last 2 versions', '> 1%', 'IE 9', 'IE 8']
    } ) )
    .pipe( gulp.dest( paths.sass.out ) )
    .pipe( rename( {suffix: '.min'} ) )
    .pipe( cssnano( {autoprefixer: false} ) )
    .pipe( gulp.dest( paths.sass.out ) )
    // .pipe( sourcemaps.write( 'maps', {
    //     includeContent: false,
    //     sourceRoot: rootDir( stripBasePath( paths.sass.in ) )
    // } ) )
    // .pipe( gulp.dest( paths.sass.out ) )
    .pipe( notify( { message: 'Styles task complete', onLast: true } ) );
});

/**
 * Process all script files, into combined .js files.
 * Creates:
 *     2 files per subfolder in src/scripts folder, main .js file and minified
 *     Sourcemap for each minified file created
 */
gulp.task('scripts', function() {
  return getFolders( paths.scripts.in ).map( function( folder ) {
    return gulp.src( nodePath.join( paths.scripts.in, folder, '/**/*.js' ) )
    .pipe( gulpIf( ( -1 !== paths.scripts.lintFolders.indexOf( folder ) ), jshint() ) )
    .pipe( jshint.reporter('default') )
    .pipe( sourcemaps.init() )
    .pipe( concat( folder + '.js' ) )
    .pipe( gulp.dest( paths.scripts.out ) )
    .pipe( rename( {suffix: '.min'} ) )
    .pipe( uglify() )
    .pipe( gulp.dest( paths.scripts.out ) )
    .pipe( notify( { message: 'Scripts task [' + folder + '] complete', onLast: true } ) );
  } );
});

/**
 * Process any images and optimise them.
 */
gulp.task('images', function() {
  return gulp.src( paths.images.in )
    .pipe( cache( imagemin( { optimizationLevel: 5, progressive: true, interlaced: true } ) ) )
    .pipe( gulp.dest( paths.images.out ) )
    .pipe( notify( { message: 'Images task complete', onLast: true } ) );
});

/**
 * Clean up the production folders.
 * Deletes the specified directories, leaving the folder clean for next run.
 */
gulp.task('clean', function() {
  return del( ['public/css', 'public/js', 'public/images'] );
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
  gulp.start( 'styles', 'scripts', 'images' );
});

gulp.task('not-images', function() {
  gulp.start( 'styles', 'scripts' );
});
