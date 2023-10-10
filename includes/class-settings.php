<?php
/**
 * Class for Settings Page.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * WP Ajaxify Settings Class.
 *
 * @class Settings
 */
class Settings {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Install WP Ajaxify.
	 *
	 * @since 1.0.0
	 */
	public static function install() {
		$options = self::get_options_args();

		foreach ( $options as $opt ) {
			add_option( $opt['key'], $opt['default'], '', 'yes' );
		}
	}

	/**
	 * Return plugin options args.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_options_args() {
		$args = array(
			array(
				'key'      => '_wp_ajaxify_enable',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_elements',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => 'body',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_selector',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => 'a:not(.no-ajaxy, a[href*=logout])',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_forms',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_canonical',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '0',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_refresh',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '0',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_requestdelay',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'number',
				'default'  => 10,
				'callback' => 'absint',
			),
			array(
				'key'      => '_wp_ajaxify_scrolltop',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => 'true',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_scrolldelay',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'number',
				'default'  => 0,
				'callback' => 'absint',
			),
			array(
				'key'      => '_wp_ajaxify_bodyclasses',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_deltas',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_asyncdef',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '0',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_alwayshints',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '',
				'callback' => 'sanitize_textarea_field',
			),
			array(
				'key'      => '_wp_ajaxify_inline',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_inlinehints',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '',
				'callback' => 'sanitize_textarea_field',
			),
			array(
				'key'      => '_wp_ajaxify_inlineskip',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => 'adsbygoogle',
				'callback' => 'sanitize_textarea_field',
			),
			array(
				'key'      => '_wp_ajaxify_inlineappend',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_intevents',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_style',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_prefetchoff',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => 'true',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_verbosity',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '0',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_passcount',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => '0',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_memoryoff',
				'group'    => 'wp_ajaxify_settings',
				'type'     => 'string',
				'default'  => 'false',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_loader_enable',
				'group'    => 'wp_ajaxify_appearance',
				'type'     => 'string',
				'default'  => '1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_loader_type',
				'group'    => 'wp_ajaxify_appearance',
				'type'     => 'string',
				'default'  => 'type-1',
				'callback' => 'sanitize_text_field',
			),
			array(
				'key'      => '_wp_ajaxify_loader_html',
				'group'    => 'wp_ajaxify_appearance',
				'type'     => 'string',
				'default'  => '',
				'callback' => 'wp_kses_post',
			),
			array(
				'key'      => '_wp_ajaxify_loader_primary_color',
				'group'    => 'wp_ajaxify_appearance',
				'type'     => 'string',
				'default'  => '#2872fa',
				'callback' => 'sanitize_hex_color',
			),
			array(
				'key'      => '_wp_ajaxify_loader_overlay_color',
				'group'    => 'wp_ajaxify_appearance',
				'type'     => 'string',
				'default'  => '#000000',
				'callback' => 'sanitize_hex_color',
			),
			array(
				'key'      => '_wp_ajaxify_loader_overlay_opacity',
				'group'    => 'wp_ajaxify_appearance',
				'type'     => 'number',
				'default'  => 0.45,
				'callback' => 'floatval',
			),
			array(
				'key'      => '_wp_ajaxify_cdn_url',
				'group'    => 'wp_ajaxify_misc',
				'type'     => 'string',
				'default'  => '',
				'callback' => 'esc_url_raw',
			),
			array(
				'key'      => '_wp_ajaxify_uninstall',
				'group'    => 'wp_ajaxify_misc',
				'type'     => 'string',
				'default'  => '0',
				'callback' => 'sanitize_text_field',
			),
		);

		return $args;
	}

	/**
	 * Register settings fields.
	 *
	 * @since 1.0.0
	 */
	public static function register_settings() {
		// Get plugin options args.
		$options = self::get_options_args();

		foreach ( $options as $opt ) {
			register_setting(
				$opt['group'],
				$opt['key'],
				array(
					'type'              => $opt['type'],
					'default'           => $opt['default'],
					'sanitize_callback' => $opt['callback'],
				)
			);
		}
	}
}
