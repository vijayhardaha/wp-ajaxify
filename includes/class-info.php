<?php
/**
 * Class for Plugin Info.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * WP Ajaxify Plugin Infomation Class.
 *
 * @class Info
 */
class Info {

	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $version;

	/**
	 * Plugin prefix.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $prefix;

	/**
	 * Plugin name.
	 *
	 * @since 1.0.0
	 * @var string.
	 */
	private $name;

	/**
	 * Plugin data.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $data;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$this->data    = get_plugin_data( WP_AJAXIFY_PLUGIN_FILE );
		$this->version = $this->data['Version'];
		$this->prefix  = $this->data['TextDomain'];
		$this->name    = $this->data['Name'];
	}


	/**
	 * Return plugin version.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function version() {
		return $this->version;
	}

	/**
	 * Return plugin prefix.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function prefix() {
		return $this->prefix;
	}

	/**
	 * Return plugin prefix.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Gets plugin's absolute directory path.
	 *
	 * @since 1.0.0
	 * @param string $path Relative path.
	 * @return string
	 */
	public function plugin_path( $path = '' ) {
		return WP_AJAXIFY_PLUGIN_DIR . trim( $path, '/' );
	}

	/**
	 * Gets plugin's URL.
	 *
	 * @since 1.0.0
	 * @param string $path Relative path.
	 * @return string
	 */
	public function plugin_url( $path = '' ) {
		return plugins_url( $path, WP_AJAXIFY_PLUGIN_FILE );
	}
}
