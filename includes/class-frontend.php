<?php
/**
 * Class for Frontend Implemention.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

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
		/**
		 * Disable ajaxify on customizer preview.
		 */
		if ( is_customize_preview() ) {
			return;
		}

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
		$primary_color   = $this->setting( 'loader_primary_color' );
		$overlay_color   = $this->setting( 'loader_overlay_color' );
		$overlay_opacity = $this->setting( 'loader_overlay_opacity' );

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
		$cdn_url    = $this->setting( 'cdn_url' );

		$url = empty( $cdn_url ) ? $plugin_url : $cdn_url;

		return $url;
	}

	/**
	 * Converts a string (e.g. 'yes' or 'no') to a bool.
	 *
	 * @since 1.1.0
	 * @param string|bool $string String to convert. If a bool is passed it will be returned as-is.
	 * @return bool
	 */
	private function str_to_bool( $string ) {
		return is_bool( $string ) ? $string : ( 'yes' === strtolower( $string ) || 1 === $string || 'true' === strtolower( $string ) || '1' === $string );
	}

	/**
	 * Return plugin setting by key.
	 *
	 * @since 1.1.0
	 * @param string $key       Option key without plugin option prefix.
	 * @param bool   $make_bool Convert to bool.
	 * @param bool   $convert   Convert value to a special format (Default: 0 - None)
	 *                          1: Convert input value to either true/false or return string.
	 *                          2: Convert textarea values to either false or in comma separated values.
	 * @return mixed
	 */
	private function setting( $key, $make_bool = false, $convert = 0 ) {
		$option_key = '_wp_ajaxify_' . trim( $key );
		$value      = get_option( $option_key );
		$convert    = absint( $convert );

		if ( ! empty( $convert ) ) {
			$value = (string) $value;
			if ( 1 === $convert ) {
				$value = ( 'true' === strtolower( $value ) || '1' === $value ) ? true : ( ( empty( $value ) || 'false' === $value ) ? false : $value );
			}

			if ( 2 === $convert ) {
				$value = empty( $value ) ? false : join( ', ', array_filter( explode( PHP_EOL, str_replace( "\r", '', $value ) ) ) );
			}
		}

		if ( ! empty( $make_bool ) ) {
			$value = $this->str_to_bool( $value );
		}

		return $value;
	}

	/**
	 * Returns Ajaxify Settings.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function get_ajaxify_params() {
		$settings = array(
			'ajaxify' => array(
				'elements'     => $this->setting( 'elements' ),
				'selector'     => $this->setting( 'selector' ),
				'forms'        => $this->setting( 'forms', false, 1 ),
				'canonical'    => $this->setting( 'canonical', true ),
				'refresh'      => $this->setting( 'refresh', true ),
				'requestDelay' => absint( $this->setting( 'requestdelay' ) ),
				'scrolltop'    => $this->setting( 'scrolltop', false, 1 ),
				'scrollDelay'  => absint( $this->setting( 'scrolldelay' ) ),
				'bodyClasses'  => $this->setting( 'bodyclasses', true ),
				'deltas'       => $this->setting( 'deltas', true ),
				'asyncdef'     => $this->setting( 'asyncdef', true ),
				'alwayshints'  => $this->setting( 'alwayshints', false, 2 ),
				'inline'       => $this->setting( 'inline', true ),
				'inlinehints'  => $this->setting( 'inlinehints', false, 2 ),
				'inlineskip'   => $this->setting( 'inlineskip', false, 2 ),
				'inlineappend' => $this->setting( 'inlineappend', true ),
				'intevents'    => $this->setting( 'intevents', true ),
				'style'        => $this->setting( 'style', false, 1 ),
				'prefetchoff'  => $this->setting( 'prefetchoff', false, 1 ),
				'verbosity'    => $this->setting( 'verbosity', true ),
				'passCount'    => $this->setting( 'passcount', true ),
				'memoryoff'    => $this->setting( 'memoryoff', false, 1 ),
			),
			'loader'  => array(
				'enable' => $this->setting( 'loader_enable', true ),
				'type'   => $this->setting( 'loader_type' ),
				'html'   => trim( $this->setting( 'loader_html' ) ),
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
		return $this->setting( 'enable', true );
	}

	/**
	 * Check is saved selectors are valid or not?
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	private function has_valid_selectors() {
		return ( ! empty( $this->setting( 'elements' ) ) && ! empty( $this->setting( 'selector' ) ) );
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
