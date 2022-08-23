/* global wp_ajaxify_params, Ajaxify */

'use strict';
( function( ) {
	/**
	 * Return Loader html.
	 *
	 * @return {string} Loader HTML.
	 */
	function wp_ajaxify_loader() {
		const type = wp_ajaxify_get_loader_type();
		let loader_html = '<div class="wp-ajaxify-loader__overlay"></div>';

		switch ( type ) {
			case 'type-4':
			case 'type-3':
			case 'type-2':
				loader_html += '<div class="wp-ajaxify-loader__content"><div></div></div>';
				break;
			case 'custom':
				loader_html += '<div class="wp-ajaxify-loader__content">' + wp_ajaxify_params.loader.html + '</div>';
				break;
			case 'type-1':
			default:
				loader_html += '<div class="wp-ajaxify-loader__progress-bar"></div>';
				break;
		}

		return '<div class="wp-ajaxify-loader" data-type="' + type + '">' + loader_html + '</div>';
	}

	/**
	 * Validate Custom html and then return loader type.
	 *
	 * @return {string} Loader type.
	 */
	function wp_ajaxify_get_loader_type() {
		const type = wp_ajaxify_params.loader.type;
		return 'custom' === type && 0 === wp_ajaxify_params.loader.html.length ? 'type-1' : type;
	}

	new Ajaxify( {
		elements: wp_ajaxify_params.elements,
		selector: wp_ajaxify_params.selector,
		forms: wp_ajaxify_params.forms,
		canonical: wp_ajaxify_params.canonical,
		refresh: wp_ajaxify_params.refresh,
		requestDelay: wp_ajaxify_params.requestDelay,
		scrolltop: wp_ajaxify_params.scrolltop,
		scrollDelay: wp_ajaxify_params.scrollDelay,
		bodyClasses: wp_ajaxify_params.bodyClasses,
		deltas: wp_ajaxify_params.deltas,
		asyncdef: wp_ajaxify_params.asyncdef,
		alwayshints: wp_ajaxify_params.alwayshints,
		inline: wp_ajaxify_params.inline,
		inlinehints: wp_ajaxify_params.inlinehints,
		inlineskip: wp_ajaxify_params.inlineskip,
		inlineappend: wp_ajaxify_params.inlineappend,
		intevents: wp_ajaxify_params.intevents,
		style: wp_ajaxify_params.style,
		prefetchoff: wp_ajaxify_params.prefetchoff,
		verbosity: wp_ajaxify_params.verbosity,
		memoryoff: wp_ajaxify_params.memoryoff,
		passCount: wp_ajaxify_params.passCount,
		pluginon: true,
	} );

	if ( wp_ajaxify_params.loader && wp_ajaxify_params.loader.enable ) {
		window.addEventListener( 'pronto.request', function() {
			document.querySelector( 'body' ).insertAdjacentHTML( 'afterbegin', wp_ajaxify_loader( ) );
		} );

		window.addEventListener( 'pronto.render', function() {
			const preloaderElem = document.querySelector( 'body .wp-ajaxify-loader' );
			if ( preloaderElem !== null ) {
				preloaderElem.remove();
			}
		} );
	}
}( jQuery ) );
