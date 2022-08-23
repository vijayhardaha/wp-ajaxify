/* eslint-disable no-console */
const gulp = require( 'gulp' ),
	autoprefixer = require( 'autoprefixer' ),
	cleanCSS = require( 'gulp-clean-css' ),
	clone = require( 'gulp-clone' ),
	concat = require( 'gulp-concat' ),
	del = require( 'del' ),
	discardDuplicates = require( 'postcss-discard-duplicates' ),
	gcmq = require( 'gulp-group-css-media-queries' ),
	merge = require( 'merge-stream' ),
	plumber = require( 'gulp-plumber' ),
	postcss = require( 'gulp-postcss' ),
	rename = require( 'gulp-rename' ),
	sass = require( 'gulp-sass' )( require( 'sass' ) ),
	strip = require( 'gulp-strip-css-comments' ),
	uglify = require( 'gulp-terser' );

const config = {
	destPath: 'assets',
	destPathCSS: 'assets/css/',
	destPathJS: 'assets/js/',
	cssOutputStyle: 'expanded', // compressed, expanded,
	cssFormatStyle: 'beautify',
};

/**
 * Build CSS Files.
 *
 * @param {Function} done
 */
const buildCSS = ( done ) => {
	const styles = {
		dashboard: [ 'src/scss/dashboard.scss' ],
		frontend: [ 'src/scss/frontend.scss' ],
	};

	for ( const [ name, path ] of Object.entries( styles ) ) {
		const baseSource = gulp
			.src( path )
			.pipe( plumber() )
			.pipe( sass( { outputStyle: config.cssOutputStyle } ) )
			.pipe( strip() )
			.pipe( gcmq() )
			.pipe( concat( 'merged.css' ) )
			.pipe( postcss( [ discardDuplicates(), autoprefixer() ] ) )
			.pipe( cleanCSS( { format: config.cssFormatStyle } ) )
			.pipe(
				rename( {
					basename: name,
				} )
			);

		const minified = baseSource
			.pipe( clone() )
			.pipe( cleanCSS() )
			.pipe( rename( { suffix: '.min' } ) );

		merge( baseSource, minified ).pipe( gulp.dest( config.destPathCSS ) );
	}

	done();
};

/**
 * Build JS Files.
 *
 * @param {Function} done
 */
const buildJS = ( done ) => {
	const styles = {
		dashboard: [ 'src/js/dashboard.js' ],
		ajaxify: [ 'src/js/ajaxify.js' ],
		frontend: [ 'src/js/frontend.js' ],
	};

	for ( const [ name, path ] of Object.entries( styles ) ) {
		const baseSource = gulp
			.src( path )
			.pipe( plumber() )
			.pipe( concat( 'merged.js' ) )
			.pipe(
				rename( {
					basename: name,
				} )
			);

		const minified = baseSource
			.pipe( clone() )
			.pipe( uglify() )
			.pipe( rename( { suffix: '.min' } ) );

		merge( baseSource, minified ).pipe( gulp.dest( config.destPathJS ) );
	}

	done();
};

/**
 * Clean the build directory.
 *
 * @param {Function} done
 */
function cleanBuild( done ) {
	del.sync( config.destPath );
	done();
}

/**
 * Runs parallel tasks for .js compiling with webpack and .scss compiling
 *
 * @param {Function} done
 */
const watchAssets = ( done ) => {
	gulp.watch( 'src/**/*.scss', gulp.series( buildCSS ) );
	gulp.watch( 'src/**/*.js', gulp.series( buildJS ) );

	done();
};

gulp.task( 'build', gulp.series( cleanBuild, buildCSS, buildJS ) );
gulp.task( 'watch', gulp.series( cleanBuild, buildCSS, buildJS, watchAssets ) );
