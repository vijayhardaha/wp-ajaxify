/**
 * Define required packages.
 */
const gulp = require( 'gulp' );
const autoprefixer = require( 'autoprefixer' );
const cleancss = require( 'gulp-clean-css' );
const clone = require( 'gulp-clone' );
const concat = require( 'gulp-concat' );
const del = require( 'del' );
const duplicates = require( 'postcss-discard-duplicates' );
const gcmq = require( 'gulp-group-css-media-queries' );
const merge = require( 'merge-stream' );
const plumber = require( 'gulp-plumber' );
const postcss = require( 'gulp-postcss' );
const rename = require( 'gulp-rename' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const terser = require( 'gulp-terser' );

/**
 * Paths to base asset directories. With trailing slashes.
 * - `paths.src` - Path to the source files. Default: `src/`
 * - `paths.dist` - Path to the build directory. Default: `assets/`
 */
const paths = {
	src: 'src/',
	dist: 'assets/',
};

/**
 * Build CSS.
 *
 * @param {Function} done
 */
const buildCSS = ( done ) => {
	const entries = {
		dashboard: [ 'src/scss/dashboard.scss' ],
		frontend: [ 'src/scss/frontend.scss' ],
	};

	for ( const [ name, path ] of Object.entries( entries ) ) {
		const baseSource = gulp
			.src( path )
			.pipe( plumber() )
			.pipe( sass( { outputStyle: 'expanded' } ) )
			.pipe( gcmq() )
			.pipe( concat( 'merged.css' ) )
			.pipe( postcss( [ duplicates(), autoprefixer() ] ) )
			.pipe( cleancss( { format: 'beautify' } ) )
			.pipe( rename( { basename: name } ) );

		const minified = baseSource
			.pipe( clone() )
			.pipe( cleancss() )
			.pipe( rename( { suffix: '.min' } ) );

		merge( baseSource, minified ).pipe( gulp.dest( paths.dist + 'css' ) );
	}

	done();
};

/**
 * Build JS.
 *
 * @param {Function} done
 */
const buildJS = ( done ) => {
	const entries = {
		ajaxify: [ 'node_modules/ajaxify/ajaxify.js' ],
		dashboard: [ 'src/js/dashboard.js' ],
		frontend: [ 'src/js/frontend.js' ],
	};

	for ( const [ name, path ] of Object.entries( entries ) ) {
		const baseSource = gulp
			.src( path )
			.pipe( plumber() )
			.pipe( concat( 'merged.js' ) )
			.pipe( rename( { basename: name } ) );

		const minified = baseSource
			.pipe( clone() )
			.pipe( terser() )
			.pipe( rename( { suffix: '.min' } ) );

		merge( baseSource, minified ).pipe( gulp.dest( paths.dist + 'js' ) );
	}

	done();
};

/**
 * Clean the build directory.
 *
 * @param {Function} done
 */
const cleanAssets = ( done ) => {
	del.sync( paths.dist );

	done();
};

/**
 * Runs parallel tasks for .js compiling with webpack and .scss compiling
 *
 * @param {Function} done
 */
const watchAssets = ( done ) => {
	gulp.watch( 'src/scss/**/*.scss', gulp.series( buildCSS ) );
	gulp.watch( 'src/js/**/*.js', gulp.series( buildJS ) );

	done();
};

gulp.task( 'css', gulp.series( buildCSS ) );
gulp.task( 'js', gulp.series( buildJS ) );
gulp.task( 'build', gulp.series( cleanAssets, buildCSS, buildJS ) );
gulp.task( 'watch', gulp.series( watchAssets ) );
