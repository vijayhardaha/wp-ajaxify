<?php
/**
 * Class for Dashboard Page.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * WP Ajaxify Dashboard Class.
 *
 * @class Dashboard
 */
class Dashboard {

	/**
	 * Field class instance.
	 *
	 * @since 1.0.0
	 * @var Field
	 */
	private $field;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->field = wp_ajaxify()->field();

		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue assets.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$prefix  = wp_ajaxify()->info()->prefix();
		$version = wp_ajaxify()->info()->version();

		if ( 'settings_page_wp-ajaxify' === $screen_id ) {
			// Styles.
			wp_enqueue_style( $prefix . '-dashboard', wp_ajaxify()->info()->plugin_url( 'assets/css/dashboard' . $suffix . '.css' ), array(), $version );

			// Scripts.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( $prefix . '-dashboard', wp_ajaxify()->info()->plugin_url( 'assets/js/dashboard' . $suffix . '.js' ), array( 'jquery', 'wp-color-picker' ), $version, true );
		}
	}

	/**
	 * Return settings groups.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_settings_groups() {
		return array(
			'general'    => __( 'General', 'wp-ajaxify' ),
			'appearance' => __( 'Appearance', 'wp-ajaxify' ),
			'misc'       => __( 'Misc', 'wp-ajaxify' ),
		);
	}

	/**
	 * Register settings page.
	 *
	 * @since 1.0.0
	 */
	public function register_page() {
		add_submenu_page(
			'options-general.php',
			esc_html_x( 'WP Ajaxify', 'Settings page title', 'wp-ajaxify' ),
			esc_html_x( 'Ajaxify', 'Settings page title(in menu)', 'wp-ajaxify' ),
			'manage_options',
			'wp-ajaxify',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Return tab url.
	 *
	 * @since 1.0.0
	 * @param string $tab Tab ID.
	 * @return string
	 */
	public function get_tab_url( $tab = 'general' ) {
		return add_query_arg(
			array(
				'page' => 'wp-ajaxify',
				'tab'  => $tab,
			),
			admin_url( 'options-general.php' )
		);
	}

	/**
	 * Return active tab ID.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	private function get_active_tab_id() {
		// phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$tab_param_isset = isset( $_GET['tab'] ) && array_key_exists( sanitize_key( $_GET['tab'] ), $this->get_settings_groups() );
		// phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		return $tab_param_isset ? sanitize_key( $_GET['tab'] ) : 'general';
	}

	/**
	 * Render settings page.
	 *
	 * @since 1.0.0
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$active_tab_id   = $this->get_active_tab_id();
		$settings_groups = $this->get_settings_groups();

		?>
		<div class="wp-ajaxify-settings-page wrap">

			<h1 class="wp-ajaxify-settings-page__title"><?php echo esc_html( get_admin_page_title() . ' ' . wp_ajaxify()->info()->version() ); ?></h1>

			<div class="wp-ajaxify-settings-page__desc">
				<p>
					<?php
					printf(
						/* translators: %s Github Link */
						esc_html__( 'Thank you for using this plugin! If you are happy with plugin, please star us on %s.', 'wp-ajaxify' ),
						'<a href="https://github.com/vijayhardaha/wp-ajaxify" aria-label="' . esc_attr__( 'Github', 'wp-ajaxify' ) . '" target="_blank">' . esc_html__( 'Github', 'wp-ajaxify' ) . '</a>'
					);
					?>
				</p>

				<p class="links">
					<span>
						<a href="<?php echo esc_url( 'https://github.com/vijayhardaha/wp-ajaxify/issues' ); ?>" target="_blank">
							<?php esc_html_e( 'Support', 'wp-ajaxify' ); ?>
						</a>
					</span>
					<span>
						<a href="<?php echo esc_url( 'https://github.com/vijayhardaha/wp-ajaxify/blob/master/docs/documentation.md' ); ?>" aria-label="<?php esc_attr_e( 'Documentation', 'wp-ajaxify' ); ?>" target="_blank">
							<?php esc_html_e( 'Documentation', 'wp-ajaxify' ); ?>
						</a>
					</span>
					<span>
						<a href="<?php echo esc_url( 'https://github.com/vijayhardaha/wp-ajaxify/blob/master/CHANGELOG.md' ); ?>" aria-label="<?php esc_attr_e( 'Changelog', 'wp-ajaxify' ); ?>" target="_blank">
							<?php esc_html_e( 'Changelog', 'wp-ajaxify' ); ?>
						</a>
					</span>
					<span>
						<a href="<?php echo esc_url( 'https://4nf.org/' ); ?>" aria-label="<?php esc_attr_e( 'Ajaxify @4nf.org', 'wp-ajaxify' ); ?>" target="_blank">
							<?php esc_html_e( 'Ajaxify @4nf.org', 'wp-ajaxify' ); ?>
						</a>
					</span>
				</p>
			</div>

			<!-- .wp-header-end class helps fixing the notice position. -->
			<hr class="wp-header-end">

			<div class="wp-ajaxify-settings-page__nav">
				<h2 class="nav-tab-wrapper">
					<?php
					foreach ( $settings_groups as $tab_id => $tab_title ) :
						$active_tab_class = $tab_id === $active_tab_id ? 'nav-tab-active' : '';
						?>
						<a href="<?php echo esc_url( $this->get_tab_url( $tab_id ) ); ?>" class="nav-tab <?php echo esc_attr( $active_tab_class ); ?>">
							<?php echo esc_html( $tab_title ); ?>
						</a>
						<?php
					endforeach;
					?>
				</h2>
			</div>

			<div class="wp-ajaxify-settings-page__content">
				<?php $this->render_active_tab(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render active tab content.
	 *
	 * @since 1.0.0
	 */
	private function render_active_tab() {
		$active_tab = $this->get_active_tab_id();

		switch ( $active_tab ) {
			case 'appearance':
				$this->render_appearance_tab();
				break;
			case 'misc':
				$this->render_misc_tab();
				break;
			case 'general':
			default:
				$this->render_general_tab();
				break;
		}
	}

	/**
	 * Render general tab content.
	 *
	 * @since 1.0.0
	 */
	private function render_general_tab() {
		?>
		<form method="post" action="options.php">
			<table class="form-table">
				<?php
				$this->field->heading_field(
					array(
						'label' => __( 'Basic', 'wp-ajaxify' ),
						'desc'  => __( 'Basic settings for the Ajaxify.', 'wp-ajaxify' ),
					)
				);

				$this->field->yes_no_field(
					array(
						'name'  => '_wp_ajaxify_enable',
						'label' => __( 'Enable Ajaxify', 'wp-ajaxify' ),
						'desc'  => __( 'Quickly Enable or Disable Ajaxify on the website.', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'        => '_wp_ajaxify_elements',
						'class'       => 'large-text',
						'label'       => __( 'Element IDs', 'wp-ajaxify' ),
						'desc'        => __( 'Selector for element IDs that are going to be swapped (e.g. <code>#page, #wpadminbar</code>)', 'wp-ajaxify' ),
						'placeholder' => __( 'e.g. #page, #wpadminbar', 'wp-ajaxify' ),
						'required'    => true,
					)
				);

				$this->field->text_field(
					array(
						'name'        => '_wp_ajaxify_selector',
						'class'       => 'large-text',
						'label'       => __( 'Links Selectors', 'wp-ajaxify' ),
						'desc'        => __( 'Selector for links to trigger swapping - not elements to be swapped - i.e. a selection of links (e.g. <code>#page a:not(.no-ajaxy, a[href*=logout])</code>)', 'wp-ajaxify' ),
						'placeholder' => __( 'e.g. #page a:not(.no-ajaxy, a[href*=logout])', 'wp-ajaxify' ),
						'required'    => true,
					)
				);

				$this->field->text_field(
					array(
						'name'        => '_wp_ajaxify_forms',
						'class'       => 'large-text',
						'label'       => __( 'Forms Selectors', 'wp-ajaxify' ),
						'desc'        => __( 'Selector for ajaxifying forms (e.g. <code>form:not(.no-ajaxy)</code>), Leave empty to disable all forms.', 'wp-ajaxify' ),
						'placeholder' => __( 'e.g. form:not(.no-ajaxy)', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_canonical',
						'label' => __( 'Canonical', 'wp-ajaxify' ),
						'desc'  => __( 'Fetch current URL from "canonical" link if given, updating the History API.  In case of a re-direct.', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_refresh',
						'label' => __( 'Refresh', 'wp-ajaxify' ),
						'desc'  => __( 'Refresh the page even if link clicked is current page.', 'wp-ajaxify' ),
					)
				);

				$this->field->heading_field(
					array(
						'label' => __( 'Visual Effects', 'wp-ajaxify' ),
						'desc'  => __( 'Settings for the Visual Effects of the Ajaxify.', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'        => '_wp_ajaxify_requestdelay',
						'type'        => 'number',
						'label'       => __( 'Request Delay', 'wp-ajaxify' ),
						'desc'        => __( 'In Milliseconds - Delay of Pronto request.', 'wp-ajaxify' ),
						'placeholder' => __( '(e.g. 1000)', 'wp-ajaxify' ),
						'attributes'  => array(
							'step' => 10,
							'min'  => 0,
						),
					)
				);

				$this->field->dropdown_field(
					array(
						'name'    => '_wp_ajaxify_scrolltop',
						'label'   => __( 'Scroll Top', 'wp-ajaxify' ),
						'options' => array(
							's'     => __( 'Smooth Scroll', 'wp-ajaxify' ),
							'true'  => __( 'Always Scroll', 'wp-ajaxify' ),
							'false' => __( 'No Scroll', 'wp-ajaxify' ),
						),
					)
				);

				$this->field->text_field(
					array(
						'name'        => '_wp_ajaxify_scrolldelay',
						'type'        => 'number',
						'label'       => __( 'Scroll Delay', 'wp-ajaxify' ),
						'desc'        => __( 'Minimal delay on all scroll effects in Milliseconds, useful in case of e.g. smooth scroll', 'wp-ajaxify' ),
						'placeholder' => __( '(e.g. 1000)', 'wp-ajaxify' ),
						'attributes'  => array(
							'step' => 10,
							'min'  => 0,
						),

					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_bodyclasses',
						'label' => __( 'Body Classes', 'wp-ajaxify' ),
						'desc'  => __( 'Copy body attributes from target page, set to "false" to disable.', 'wp-ajaxify' ),
					)
				);

				$this->field->heading_field(
					array(
						'label' => __( 'Scripts & Styles', 'wp-ajaxify' ),
						'desc'  => __( 'Scripts, Styles & Prefetch handling configurations.', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_deltas',
						'label' => __( 'Deltas', 'wp-ajaxify' ),
						'desc'  => __( 'True = deltas loaded, False = all scripts loaded', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_asyncdef',
						'label' => __( 'Async', 'wp-ajaxify' ),
						'desc'  => __( 'Default async value for dynamically inserted external scripts, False = synchronous / True = asynchronous', 'wp-ajaxify' ),
					)
				);

				$this->field->textarea_field(
					array(
						'name'        => '_wp_ajaxify_alwayshints',
						'label'       => __( 'Always Hints', 'wp-ajaxify' ),
						'desc'        => __( 'If matched in any external script URL - these are always loaded on every page load. Leave empty to disable it.', 'wp-ajaxify' ),
						'placeholder' => __( 'Write one script url per line.', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_inline',
						'label' => __( 'Inline', 'wp-ajaxify' ),
						'desc'  => __( 'True = all inline scripts loaded, False = only specific inline scripts are loaded.', 'wp-ajaxify' ),
					)
				);

				$this->field->textarea_field(
					array(
						'name'        => '_wp_ajaxify_inlinehints',
						'label'       => __( 'Inline Hints', 'wp-ajaxify' ),
						'desc'        => __( 'If matched in any inline scripts - only these are executed - set "inline" to false beforehand.', 'wp-ajaxify' ),
						'placeholder' => __( 'Write one value per line.', 'wp-ajaxify' ),
					)
				);

				$this->field->textarea_field(
					array(
						'name'        => '_wp_ajaxify_inlineskip',
						'label'       => __( 'Inline Skip', 'wp-ajaxify' ),
						'desc'        => __( 'If matched in any inline scripts - these are NOT are executed - set "inline" to true beforehand.', 'wp-ajaxify' ),
						'placeholder' => __( 'Write one value per line.', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_inlineappend',
						'label' => __( 'Inline Append', 'wp-ajaxify' ),
						'desc'  => __( 'Append scripts to the main content element, instead of "eval"-ing them', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_intevents',
						'label' => __( 'Intercept Events', 'wp-ajaxify' ),
						'desc'  => __( 'Intercept events that are fired only on classic page load and simulate their trigger on ajax page load ("DOMContentLoaded")', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_style',
						'label' => __( 'Style', 'wp-ajaxify' ),
						'desc'  => __( 'True = all style tags in the head loaded, False = style tags on target page ignored.', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'  => '_wp_ajaxify_prefetchoff',
						'label' => __( 'Prefetch Off', 'wp-ajaxify' ),
						'desc'  => __( 'Plugin pre-fetches pages on hoverIntent - true = set off completely // strings - separated by ", " - hints to select out.', 'wp-ajaxify' ),
					)
				);

				$this->field->heading_field(
					array(
						'label' => __( 'Debugging & Advanced', 'wp-ajaxify' ),
						'desc'  => __( 'Debugging and Advanced settings for the Ajaxify.', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_verbosity',
						'label' => __( 'Debugging', 'wp-ajaxify' ),
						'desc'  => __( 'Enable/Disable logs in console for debugging.', 'wp-ajaxify' ),
					)
				);

				$this->field->true_false_field(
					array(
						'name'  => '_wp_ajaxify_passcount',
						'label' => __( 'Passcount', 'wp-ajaxify' ),
						'desc'  => __( 'Show number of pass for debugging.', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'  => '_wp_ajaxify_memoryoff',
						'label' => __( 'Memory Off', 'wp-ajaxify' ),
						'desc'  => __( 'Separated by ", " - if matched in any URLs - only these are NOT executed - set to "true" to disable memory completely.', 'wp-ajaxify' ),
					)
				);

				$this->field->submit_field( 'wp_ajaxify_settings' );
				?>
			</table>
		</form>
		<?php
	}

	/**
	 * Render appearance tab content.
	 *
	 * @since 1.0.0
	 */
	private function render_appearance_tab() {
		?>
		<form method="post" action="options.php">
			<table class="form-table">
				<?php
				$this->field->heading_field(
					array(
						'label' => __( 'Loader', 'wp-ajaxify' ),
						'desc'  => __( 'Settings for the Ajaxify loader.', 'wp-ajaxify' ),
					)
				);

				$this->field->yes_no_field(
					array(
						'name'  => '_wp_ajaxify_loader_enable',
						'label' => __( 'Enable Loader', 'wp-ajaxify' ),
						'desc'  => __( 'If Enabled, Selected Loader type will appear on each page before Pronto Request.', 'wp-ajaxify' ),
					)
				);

				$this->field->dropdown_field(
					array(
						'name'    => '_wp_ajaxify_loader_type',
						'label'   => __( 'Loader Type', 'wp-ajaxify' ),
						'desc'    => __( 'Choose the loader type. If you choose Custom Loader then put your loader HTML in Loader HTML field.', 'wp-ajaxify' ),
						'options' => array(
							'type-1' => __( 'Type 1', 'wp-ajaxify' ),
							'type-2' => __( 'Type 2', 'wp-ajaxify' ),
							'type-3' => __( 'Type 3', 'wp-ajaxify' ),
							'type-4' => __( 'Type 4', 'wp-ajaxify' ),
							'custom' => __( 'Custom Loader', 'wp-ajaxify' ),
						),
					)
				);

				$this->field->textarea_field(
					array(
						'name'  => '_wp_ajaxify_loader_html',
						'label' => __( 'Loader HTML', 'wp-ajaxify' ),
						'desc'  => __( 'Put your custom loader HTML here. Write CSS for loader separatly in theme files or in WordPress Additional CSS.', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'  => '_wp_ajaxify_loader_primary_color',
						'class' => 'wp-ajaxify-color-picker',
						'label' => __( 'Primary Color', 'wp-ajaxify' ),
						'desc'  => __( 'Primary color for loader usage. Default: #2872fa', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'  => '_wp_ajaxify_loader_overlay_color',
						'class' => 'wp-ajaxify-color-picker',
						'label' => __( 'Overlay Color', 'wp-ajaxify' ),
						'desc'  => __( 'Overlay background color for loader usage. Default: #000000', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'       => '_wp_ajaxify_loader_overlay_opacity',
						'type'       => 'number',
						'label'      => __( 'Overlay Opacity', 'wp-ajaxify' ),
						'desc'       => __( 'Control the overlay opacity. Default: 0.35', 'wp-ajaxify' ),
						'attributes' => array(
							'step' => 0.05,
							'min'  => 0,
							'max'  => 1,
						),
					)
				);

				$this->field->submit_field( 'wp_ajaxify_appearance' );
				?>
			</table>
		</form>
		<?php
	}

	/**
	 * Render misc tab content.
	 *
	 * @since 1.0.0
	 */
	private function render_misc_tab() {
		?>
		<form method="post" action="options.php">
			<table class="form-table">
				<?php
				$this->field->heading_field(
					array(
						'label' => __( 'Version Integration', 'wp-ajaxify' ),
						'desc'  => __( 'Settings for different Ajaxify.js version Integration & Testing.', 'wp-ajaxify' ),
					)
				);

				$this->field->text_field(
					array(
						'name'  => '_wp_ajaxify_cdn_url',
						'label' => __( 'Ajaxify JS URL', 'wp-ajaxify' ),
						'desc'  => sprintf(
							'%s<br/>%s.',
							__( 'If you want to use or test a different version of Ajaxify.js then you can use a CDN or External Url to be used in frontend.', 'wp-ajaxify' ),
							__( 'You can find Ajaxify.js cdn urls', 'wp-ajaxify' ) . ' <a href="https://cdnjs.com/libraries/ajaxify" target="_blank">' . __( 'here', 'wp-ajaxify' ) . '</a>'
						),
					)
				);

				$this->field->heading_field(
					array(
						'label' => __( 'Extras', 'wp-ajaxify' ),
						'desc'  => __( 'Other plugin settings.', 'wp-ajaxify' ),
					)
				);

				$this->field->yes_no_field(
					array(
						'name'  => '_wp_ajaxify_uninstall',
						'label' => __( 'Uninstall WP Ajaxify', 'wp-ajaxify' ),
						'desc'  => __( 'Remove ALL WP Ajaxify data upon plugin deletion. All settings will be unrecoverable.', 'wp-ajaxify' ),
					)
				);

				$this->field->submit_field( 'wp_ajaxify_misc' );
				?>
			</table>
		</form>
		<?php
	}
}
