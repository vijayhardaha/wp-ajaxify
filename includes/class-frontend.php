<?php
/**
 * Class for Frontend Implemention.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * WP Ajaxify Frontend Class.
 *
 * @class Frontend
 */
class Frontend {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue assets.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		// Enqueue nothing is Ajaxify is not enable or selectors are empty.
		if ( ! $this->is_enabled() || ! $this->has_valid_selectors() ) {
			return;
		}

		$suffix  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$prefix  = wp_ajaxify()->info()->prefix();
		$version = wp_ajaxify()->info()->version();

		// Styles.
		wp_enqueue_style( $prefix . '-frontend', wp_ajaxify()->info()->plugin_url( 'assets/css/frontend' . $suffix . '.css' ), array(), $version );
		wp_add_inline_style( $prefix . '-frontend', $this->generate_css() );

		// Scripts.
		wp_enqueue_script( 'ajaxify', $this->get_ajaxify_url(), array( 'jquery' ), $version, true );
		wp_enqueue_script( $prefix . '-frontend', wp_ajaxify()->info()->plugin_url( 'assets/js/frontend' . $suffix . '.js' ), array( 'ajaxify' ), $version, true );
		wp_localize_script( $prefix . '-frontend', 'wp_ajaxify_params', $this->get_ajaxify_params() );
	}

	/**
	 * Generate inline CSS.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	private function generate_css() {
		$primary_color   = get_option( '_wp_ajaxify_loader_primary_color' );
		$overlay_color   = get_option( '_wp_ajaxify_loader_overlay_color' );
		$overlay_opacity = get_option( '_wp_ajaxify_loader_overlay_opacity' );

		$css = ':root {
			--wp-ajaxfy-primary-color: ' . $primary_color . ';
			--wp-ajaxfy-overlay-color: ' . $overlay_color . ';
			--wp-ajaxfy-overlay-opacity: ' . $overlay_opacity . ';
			--wp-ajaxfy-loader-rgb: ' . $this->hex2rgba( $primary_color ) . ';
		}';

		return $css;
	}

	/**
	 * Return ajaxify.js url.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	private function get_ajaxify_url() {
		$suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$plugin_url = wp_ajaxify()->info()->plugin_url( 'assets/js/ajaxify' . $suffix . '.js' );
		$cdn_url    = get_option( '_wp_ajaxify_cdn_url', '' );

		$url = empty( $cdn_url ) ? $plugin_url : $cdn_url;

		return $url;
	}

	/**
	 * Returns Ajaxify Settings.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function get_ajaxify_params() {
		$settings = array(
			'elements'     => get_option( '_wp_ajaxify_elements', '' ),
			'selector'     => get_option( '_wp_ajaxify_selector', '' ),
			'forms'        => get_option( '_wp_ajaxify_forms', '' ),
			'canonical'    => get_option( '_wp_ajaxify_canonical' ),
			'refresh'      => get_option( '_wp_ajaxify_refresh' ),
			'requestDelay' => absint( get_option( '_wp_ajaxify_requestdelay' ) ),
			'scrolltop'    => $this->true_false_format( get_option( '_wp_ajaxify_scrolltop' ) ),
			'scrollDelay'  => absint( get_option( '_wp_ajaxify_scrolldelay' ) ),
			'bodyClasses'  => get_option( '_wp_ajaxify_bodyclasses' ),
			'deltas'       => get_option( '_wp_ajaxify_deltas' ),
			'asyncdef'     => get_option( '_wp_ajaxify_asyncdef' ),
			'alwayshints'  => $this->false_format( get_option( '_wp_ajaxify_alwayshints' ) ),
			'inline'       => get_option( '_wp_ajaxify_inline' ),
			'inlinehints'  => $this->false_format( get_option( '_wp_ajaxify_inlinehints' ) ),
			'inlineskip'   => $this->false_format( get_option( '_wp_ajaxify_inlineskip' ) ),
			'inlineappend' => get_option( '_wp_ajaxify_inlineappend' ),
			'intevents'    => get_option( '_wp_ajaxify_intevents' ),
			'style'        => get_option( '_wp_ajaxify_style' ),
			'prefetchoff'  => $this->true_false_format( get_option( '_wp_ajaxify_prefetchoff' ) ),
			'verbosity'    => get_option( '_wp_ajaxify_verbosity' ),
			'memoryoff'    => $this->true_false_format( get_option( '_wp_ajaxify_memoryoff' ) ),
			'passCount'    => get_option( '_wp_ajaxify_passcount' ),
			'loader'       => array(
				'enable' => get_option( '_wp_ajaxify_loader_enable' ),
				'type'   => get_option( '_wp_ajaxify_loader_type' ),
				'html'   => trim( get_option( '_wp_ajaxify_loader_html' ) ),
			),
		);

		return $settings;
	}

	/**
	 * Check if WP Ajaxify is enabled or not?
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	private function is_enabled() {
		return get_option( '_wp_ajaxify_enable' );
	}

	/**
	 * Check is saved selectors are valid or not?
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	private function has_valid_selectors() {
		return ( ! empty( get_option( '_wp_ajaxify_elements' ) ) && ! empty( get_option( '_wp_ajaxify_selector' ) ) );
	}

	/**
	 * Convert textarea values to either false or in comma separated values.
	 *
	 * @since 1.0.0
	 * @param string $value Textarea value.
	 * @return bool|string
	 */
	private function false_format( $value ) {
		return empty( $value ) ? false : join( ', ', array_filter( explode( PHP_EOL, str_replace( "\r", '', $value ) ) ) );
	}

	/**
	 * Convert input value to either true/false or in comma separated values.
	 *
	 * @since 1.0.0
	 * @param string $value Input value.
	 * @return bool|string
	 */
	private function true_false_format( $value ) {
		return 'true' === $value ? true : ( ( empty( $value ) || 'false' === $value ) ? false : $value );
	}

	/**
	 * Convert hex to rgb.
	 *
	 * @since 1.0.0
	 * @param string $color Color Hex.
	 * @return string
	 */
	private function hex2rgba( $color ) {
		$color = trim( $color, '#' );

		if ( strlen( $color ) === 3 ) {
			$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
			$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
			$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
		} elseif ( strlen( $color ) === 6 ) {
			$r = hexdec( substr( $color, 0, 2 ) );
			$g = hexdec( substr( $color, 2, 2 ) );
			$b = hexdec( substr( $color, 4, 2 ) );
		} else {
			return '';
		}

		return 'rgba(' . join( ', ', array( $r, $g, $b, 0.2 ) ) . ')';
	}
}
