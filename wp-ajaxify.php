<?php
/**
 * Plugin Name: WP Ajaxify
 * Plugin URI: https://github.com/vijayhardaha/wp-ajaxify/
 * Description: This is a simple plugin to easily implement Ajaxify.js by the <a href="https://4nf.org/">Ajaxify @4nf.org</a> in the WordPress.
 * Version: 1.1.7
 * Author: Vijay Hardaha
 * Author URI: https://github.com/vijayhardaha/
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-ajaxify
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.0
 * Tested up to: 6.0
 *
 * @package WP_Ajaxify
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

if ( ! class_exists( 'WP_Ajaxify' ) ) {

	if ( ! defined( 'WP_AJAXIFY_PLUGIN_FILE' ) ) {
		define( 'WP_AJAXIFY_PLUGIN_FILE', __FILE__ );
	}
	if ( ! defined( 'WP_AJAXIFY_PLUGIN_DIR' ) ) {
		define( 'WP_AJAXIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); // The path with trailing slash.
	}
	if ( ! defined( 'WP_AJAXIFY_PLUGIN_BASENAME' ) ) {
		define( 'WP_AJAXIFY_PLUGIN_BASENAME', plugin_basename( WP_AJAXIFY_PLUGIN_FILE ) );
	}
	if ( ! defined( 'WP_AJAXIFY_DEBUG' ) ) {
		define( 'WP_AJAXIFY_DEBUG', false );
	}

	include_once WP_AJAXIFY_PLUGIN_DIR . 'includes/class-ajaxify.php';

	/**
	 * Main Instance Function.
	 *
	 * @since 1.0.0
	 * @return WP_Ajaxify
	 */
	function wp_ajaxify() {
		return \WP_Ajaxify\Ajaxify::get_instance();
	}

	// Init WP Ajaxify.
	wp_ajaxify();
}
