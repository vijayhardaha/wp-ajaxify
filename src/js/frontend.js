/* global wp_ajaxify_params, Ajaxify */
'use strict';
( function( wap ) {
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
		elements: wap.ajaxify.elements,
		selector: wap.ajaxify.selector,
		forms: wap.ajaxify.forms,
		canonical: wap.ajaxify.canonical,
		refresh: wap.ajaxify.refresh,
		requestDelay: parseInt( wap.ajaxify.requestDelay, 10 ),
		scrolltop: wap.ajaxify.scrolltop,
		scrollDelay: parseInt( wap.ajaxify.scrollDelay, 10 ),
		bodyClasses: wap.ajaxify.bodyClasses,
		deltas: wap.ajaxify.deltas,
		asyncdef: wap.ajaxify.asyncdef,
		alwayshints: wap.ajaxify.alwayshints,
		inline: wap.ajaxify.inline,
		inlinehints: wap.ajaxify.inlinehints,
		inlineskip: wap.ajaxify.inlineskip,
		inlineappend: wap.ajaxify.inlineappend,
		intevents: wap.ajaxify.intevents,
		style: wap.ajaxify.style,
		prefetchoff: wap.ajaxify.prefetchoff,
		verbosity: wap.ajaxify.verbosity,
		memoryoff: wap.ajaxify.memoryoff,
		passCount: wap.ajaxify.passCount,
		pluginon: true,
	};

	new Ajaxify( args );

	if ( wap.loader.enable ) {
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
}( wp_ajaxify_params ) );
