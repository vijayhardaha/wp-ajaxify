<?php
/**
 * Uninstall all WP Ajaxify data.
 *
 * @package WP_Ajaxify
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

$plugin_options = array(
	'_wp_ajaxify_enable',
	'_wp_ajaxify_elements',
	'_wp_ajaxify_selector',
	'_wp_ajaxify_forms',
	'_wp_ajaxify_canonical',
	'_wp_ajaxify_refresh',
	'_wp_ajaxify_requestdelay',
	'_wp_ajaxify_scrolltop',
	'_wp_ajaxify_scrolldelay',
	'_wp_ajaxify_bodyclasses',
	'_wp_ajaxify_deltas',
	'_wp_ajaxify_asyncdef',
	'_wp_ajaxify_alwayshints',
	'_wp_ajaxify_inline',
	'_wp_ajaxify_inlinehints',
	'_wp_ajaxify_inlineskip',
	'_wp_ajaxify_inlineappend',
	'_wp_ajaxify_intevents',
	'_wp_ajaxify_style',
	'_wp_ajaxify_prefetchoff',
	'_wp_ajaxify_verbosity',
	'_wp_ajaxify_passcount',
	'_wp_ajaxify_memoryoff',
	'_wp_ajaxify_loader_enable',
	'_wp_ajaxify_loader_type',
	'_wp_ajaxify_loader_html',
	'_wp_ajaxify_loader_primary_color',
	'_wp_ajaxify_loader_overlay_color',
	'_wp_ajaxify_loader_overlay_opacity',
	'_wp_ajaxify_cdn_url',
	'_wp_ajaxify_uninstall',
);

if ( is_multisite() ) {
	$sites = get_sites();

	foreach ( $sites as $site ) {
		$site_blog_id = $site->blog_id;

		$settings = get_blog_option( $site_blog_id, '_wp_ajaxify_uninstall', false );

		// Confirm user has decided to remove all data, otherwise skip.
		if ( empty( $should_remove ) ) {
			continue;
		}

		switch_to_blog( $site_blog_id );

		foreach ( $plugin_options as $option ) {
			delete_option( $option );
		}

		restore_current_blog();
	}
} else {

	// Confirm user has decided to remove all data, otherwise stop.
	$should_remove = get_option( '_wp_ajaxify_uninstall', false );

	if ( empty( $should_remove ) ) {
		return;
	}

	foreach ( $plugin_options as $option ) {
		delete_option( $option );
	}
}

// All done.
