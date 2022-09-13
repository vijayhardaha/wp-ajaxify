/* eslint-disable no-nested-ternary */
/* global wp_ajaxify_params, Ajaxify */

'use strict';
( function( $, wap ) {
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
				loader_html += '<div class="wp-ajaxify-loader__content">' + wap.loader.html + '</div>';
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
		const type = wap.loader.type;
		return 'custom' === type && 0 === wap.loader.html.length ? 'type-1' : type;
	}

	const args = {
		elements: wap.elements,
		selector: wap.selector,
		forms: wap.forms === '' ? false : wap.forms,
		canonical: wap.canonical ? true : false,
		refresh: wap.refresh ? true : false,
		requestDelay: parseInt( wap.requestDelay, 10 ),
		scrolltop: wap.scrolltop === 's' ? 's' : ( wap.scrolltop ? true : false ),
		scrollDelay: parseInt( wap.scrollDelay, 10 ),
		bodyClasses: wap.bodyClasses ? true : false,
		deltas: wap.deltas ? true : false,
		asyncdef: wap.asyncdef ? true : false,
		alwayshints: wap.alwayshints,
		inline: wap.inline ? true : false,
		inlinehints: wap.inlinehints,
		inlineskip: wap.inlineskip,
		inlineappend: wap.inlineappend ? true : false,
		intevents: wap.intevents ? true : false,
		style: wap.style ? true : false,
		prefetchoff: wap.prefetchoff === '1' ? true : ( wap.prefetchoff === '' ? false : wap.prefetchoff ),
		verbosity: wap.verbosity ? true : false,
		memoryoff: wap.memoryoff === '1' ? true : ( wap.memoryoff === '' ? false : wap.memoryoff ),
		passCount: wap.passCount ? true : false,
		pluginon: true,
	};

	new Ajaxify( args );

	if ( wap.loader && wap.loader.enable ) {
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
}( jQuery, wp_ajaxify_params ) );
