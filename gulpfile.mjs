/**
 * Import required packages.
 */
import gulp from 'gulp'; // Import Gulp for task automation.
import { deleteSync } from 'del'; // Import deleteSync from del package for asset cleanup.
import * as dartSass from 'sass'; // Import Dart Sass for SCSS compilation.
import autoprefixer from 'autoprefixer'; // Import autoprefixer for CSS autoprefixing.
import cleancss from 'gulp-clean-css'; // Import gulp-clean-css for CSS minification.
import clone from 'gulp-clone'; // Import gulp-clone for cloning streams.
import concat from 'gulp-concat'; // Import gulp-concat for concatenating files.
import duplicates from 'postcss-discard-duplicates'; // Import postcss-discard-duplicates for removing duplicate CSS rules.
import gcmq from 'gulp-group-css-media-queries'; // Import gulp-group-css-media-queries for grouping CSS media queries.
import gulpSass from 'gulp-sass'; // Import gulp-sass for SCSS compilation.
import merge from 'merge-stream'; // Import merge-stream for merging streams.
import plumber from 'gulp-plumber'; // Import gulp-plumber for error handling.
import postcss from 'gulp-postcss'; // Import gulp-postcss for PostCSS processing.
import rename from 'gulp-rename'; // Import gulp-rename for file renaming.
import terser from 'gulp-terser'; // Import gulp-terser for JavaScript minification.

const sass = gulpSass( dartSass ); // Initialize Sass compiler.

/**
 * Paths to base asset directories. With trailing slashes.
 * - `paths.src` - Path to the source files. Default: `src/`
 * - `paths.dest` - Path to the build directory. Default: `assets/`
 */
const paths = {
	src: 'src/',
	dest: 'assets/',
	scss: {
		src: {
			dashboard: [ 'src/scss/dashboard.scss' ],
			frontend: [ 'src/scss/frontend.scss' ],
		},
		dest: 'assets/css',
	},
	js: {
		src: {
			ajaxify: [ 'src/js/ajaxify.min.js' ],
			dashboard: [ 'src/js/dashboard.js' ],
			frontend: [ 'src/js/frontend.js' ],
		},
		dest: 'assets/js',
	},
};

/**
 * Build CSS.
 *
 * @param {Function} done - Callback function to signal completion.
 */
const buildCSS = ( done ) => {
	for ( const [ name, path ] of Object.entries( paths.scss.src ) ) {
		const baseSource = gulp
			.src( path )
			.pipe( plumber() )
			.pipe( sass( { outputStyle: 'expanded' } ) ) // Compile SCSS to expanded CSS.
			.pipe( gcmq() ) // Group CSS media queries.
			.pipe( concat( 'merged.css' ) ) // Concatenate CSS files.
			.pipe( postcss( [ duplicates(), autoprefixer() ] ) ) // Run PostCSS plugins.
			.pipe( cleancss( { format: 'beautify' } ) ) // Beautify the CSS.
			.pipe( rename( { basename: name } ) ); // Rename output file.

		const minified = baseSource
			.pipe( clone() ) // Clone the stream to create a minified version.
			.pipe( cleancss() ) // Minify the CSS.
			.pipe( rename( { suffix: '.min' } ) ); // Rename minified file.

		merge( baseSource, minified ).pipe( gulp.dest( paths.scss.dest ) ); // Merge and output CSS files.
	}

	done();
};

/**
 * Build JavaScript.
 *
 * @param {Function} done - Callback function to signal completion.
 */
const buildJS = ( done ) => {
	for ( const [ name, path ] of Object.entries( paths.js.src ) ) {
		const baseSource = gulp
			.src( path )
			.pipe( plumber() )
			.pipe( concat( 'merged.js' ) ) // Concatenate JavaScript files.
			.pipe( rename( { basename: name } ) ); // Rename output file.

		const minified = baseSource
			.pipe( clone() ) // Clone the stream to create a minified version.
			.pipe( terser() ) // Minify the JavaScript.
			.pipe( rename( { suffix: '.min' } ) ); // Rename minified file.

		merge( baseSource, minified ).pipe( gulp.dest( paths.js.dest ) ); // Merge and output JavaScript files.
	}

	done();
};

/**
 * Clean the build directory.
 *
 * @param {Function} done - Callback function to signal completion.
 */
const cleanAssets = ( done ) => {
	deleteSync( paths.dest ); // Delete build directory.

	done();
};

/**
 * Watch for changes in assets and trigger corresponding build tasks.
 *
 * @param {Function} done - Callback function to signal completion.
 */
const watchAssets = ( done ) => {
	gulp.watch( paths.src + 'scss/**/*.scss', gulp.series( buildCSS ) ); // Watch SCSS files.
	gulp.watch( paths.src + 'js/**/*.js', gulp.series( buildJS ) ); // Watch JavaScript files.

	done();
};

// Define Gulp tasks.
const css = gulp.series( buildCSS );
const js = gulp.series( buildJS );
const build = gulp.series( cleanAssets, buildCSS, buildJS );
const watcher = gulp.series( watchAssets );

// Export tasks for usage.
export { css, js, build };
export { watcher as watch };
