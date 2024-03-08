<?php
/**
 * Main WP Ajaxify class.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Ajaxify Main Class.
 */
final class Ajaxify {

	/**
	 * This class instance.
	 *
	 * @since 1.0.0
	 * @var Ajaxify
	 */
	private static $instance = null;

	/**
	 * Info class object.
	 *
	 * @since 1.0.0
	 * @var Info
	 */
	private $info;

	/**
	 * Settings class object.
	 *
	 * @since 1.0.0
	 * @var Settings
	 */
	private $settings;

	/**
	 * Field class object.
	 *
	 * @since 1.0.0
	 * @var Field
	 */
	private $field;

	/**
	 * Dashboard class object.
	 *
	 * @since 1.0.0
	 * @var Dashboard
	 */
	private $dashboard;

	/**
	 * Frontend class object.
	 *
	 * @since 1.0.0
	 * @var Frontend
	 */
	private $frontend;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		require_once WP_AJAXIFY_PLUGIN_DIR . 'includes/class-info.php';
		require_once WP_AJAXIFY_PLUGIN_DIR . 'includes/class-settings.php';
		require_once WP_AJAXIFY_PLUGIN_DIR . 'includes/class-field.php';
		require_once WP_AJAXIFY_PLUGIN_DIR . 'includes/class-dashboard.php';
		require_once WP_AJAXIFY_PLUGIN_DIR . 'includes/class-frontend.php';
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {
		register_activation_hook( WP_AJAXIFY_PLUGIN_FILE, array( '\WP_Ajaxify\Settings', 'install' ) );
		add_action( 'init', array( $this, 'init' ), 0 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		add_filter( 'plugin_action_links_' . WP_AJAXIFY_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Init WP_Ajaxify when WordPress Initialises.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		$this->info      = new Info();
		$this->settings  = new Settings();
		$this->field     = new Field();
		$this->dashboard = new Dashboard();
		$this->frontend  = new Frontend();
	}

	/**
	 * Return Info class object.
	 *
	 * @since 1.0.0
	 * @return Info
	 */
	public function info() {
		return $this->info;
	}

	/**
	 * Return Field class object.
	 *
	 * @since 1.0.0
	 * @return Field
	 */
	public function field() {
		return $this->field;
	}

	/**
	 * Return Dashboard class object.
	 *
	 * @since 1.0.0
	 * @return Dashboard
	 */
	public function dashboard() {
		return $this->dashboard;
	}

	/**
	 * Return Frontend class object.
	 *
	 * @since 1.0.0
	 * @return Frontend
	 */
	public function frontend() {
		return $this->frontend;
	}

	/**
	 * Main Ajaxify Instance.
	 * Ensures only one instance of Ajaxify is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @return Ajaxify
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @since 1.0.0
	 * @param array  $links Plugins meta links.
	 * @param string $file  Plugin basename.
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( WP_AJAXIFY_PLUGIN_BASENAME === $file ) {

			$row_meta = array(
				'support'       => '<a href="' . esc_url( 'https://github.com/vijayhardaha/wp-ajaxify/issues' ) . '" aria-label="' . esc_attr__( 'Support', 'wp-ajaxify' ) . '">' . esc_html__( 'Support', 'wp-ajaxify' ) . '</a>',
				'documentation' => '<a href="' . esc_url( 'https://github.com/vijayhardaha/wp-ajaxify/blob/master/docs/documentation.md' ) . '" aria-label="' . esc_attr__( 'Documentation', 'wp-ajaxify' ) . '">' . esc_html__( 'Documentation', 'wp-ajaxify' ) . '</a>',
				'changelog'     => '<a href="' . esc_url( 'https://github.com/vijayhardaha/wp-ajaxify/blob/master/changelog.txt' ) . '" aria-label="' . esc_attr__( 'Changelog', 'wp-ajaxify' ) . '">' . esc_html__( 'Changelog', 'wp-ajaxify' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	/**
	 * Show settings link on plugin action links.
	 *
	 * @since 1.0.0
	 * @param array $actions Plugin action links.
	 * @return array
	 */
	public function plugin_action_links( $actions ) {
		if ( current_user_can( 'manage_options' ) ) {

			$settings_url = $this->dashboard->get_tab_url( 'general' );

			array_unshift(
				$actions,
				sprintf( '<a href="%s">%s</a>', $settings_url, __( 'Settings', 'wp-ajaxify' ) )
			);
		}

		return $actions;
	}
}
