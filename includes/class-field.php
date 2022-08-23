<?php
/**
 * Class for Field Page.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

/**
 * WP Ajaxify Field Class.
 *
 * @class Field
 */
class Field {

	/**
	 * Render submit button row.
	 *
	 * @since 1.0.0
	 * @param string $setting_group Settings group.
	 */
	public function submit_row( $setting_group = 'wp_ajaxify_settings' ) {
		?>
		<tr class="submit">
			<th colspan="2">
				<?php settings_fields( $setting_group ); ?>
				<?php submit_button(); ?>
			</th>
		</tr>
		<?php
	}

	/**
	 * Render text input field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function text_field( string $field_name, array $field_args = array() ) {
		if ( empty( $field_name ) ) {
			return;
		}

		$default_args = array(
			'id'          => sanitize_title( str_replace( '_', '-', join( '-', array( 'setting-field', $field_name ) ) ) ),
			'label'       => __( 'Field Label', 'wp-ajaxify' ),
			'placeholder' => '',
			'desc'        => '',
			'required'    => false,
		);

		$args = wp_parse_args( $field_args, $default_args );

		$required = rest_sanitize_boolean( $args['required'] ) ? 'required' : '';

		// Fetch option value.
		$value = get_option( $field_name );
		?>
		<tr id="<?php echo esc_attr( join( '-', array( 'setting-row', $args['id'] ) ) ); ?>">
			<th><?php echo esc_html( $args['label'] ); ?></th>
			<td>
				<input type="text" name="<?php echo esc_attr( $field_name ); ?>" class="regular-text" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" <?php echo esc_attr( $required ); ?> />

				<?php if ( ! empty( $args['desc'] ) ) : ?>
					<div class="description"><?php echo wp_kses_post( $args['desc'] ); ?></div>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render number input field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function number_field( string $field_name, array $field_args = array() ) {
		if ( empty( $field_name ) ) {
			return;
		}

		$default_args = array(
			'id'          => sanitize_title( str_replace( '_', '-', join( '-', array( 'setting-field', $field_name ) ) ) ),
			'label'       => __( 'Field Label', 'wp-ajaxify' ),
			'placeholder' => '',
			'desc'        => '',
			'required'    => false,
			'step'        => 'any',
			'min'         => '',
			'max'         => '',
		);

		$args = wp_parse_args( $field_args, $default_args );

		$required = rest_sanitize_boolean( $args['required'] ) ? 'required' : '';

		// Fetch option value.
		$value = get_option( $field_name );
		?>
		<tr id="<?php echo esc_attr( join( '-', array( 'setting-row', $args['id'] ) ) ); ?>">
			<th><?php echo esc_html( $args['label'] ); ?></th>
			<td>
				<input type="number" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" <?php echo esc_attr( $required ); ?> min="<?php echo esc_attr( $args['min'] ); ?>" max="<?php echo esc_attr( $args['max'] ); ?>" step="<?php echo esc_attr( $args['step'] ); ?>" />

				<?php if ( ! empty( $args['desc'] ) ) : ?>
					<div class="description"><?php echo wp_kses_post( $args['desc'] ); ?></div>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render textarea input field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function textarea_field( string $field_name, array $field_args = array() ) {
		if ( empty( $field_name ) ) {
			return;
		}

		$default_args = array(
			'id'          => sanitize_title( str_replace( '_', '-', join( '-', array( 'setting-field', $field_name ) ) ) ),
			'label'       => __( 'Field Label', 'wp-ajaxify' ),
			'placeholder' => '',
			'desc'        => '',
			'rows'        => 4,
			'required'    => false,
		);

		$args = wp_parse_args( $field_args, $default_args );

		$required = rest_sanitize_boolean( $args['required'] ) ? 'required' : '';

		// Fetch option value.
		$value = get_option( $field_name );
		?>
		<tr id="<?php echo esc_attr( join( '-', array( 'setting-row', $args['id'] ) ) ); ?>">
			<th><?php echo esc_html( $args['label'] ); ?></th>
			<td>
				<textarea type="text" name="<?php echo esc_attr( $field_name ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" <?php echo esc_attr( $required ); ?> rows="<?php echo esc_attr( $args['rows'] ); ?>" ><?php echo esc_attr( $value ); ?></textarea>

				<?php if ( ! empty( $args['desc'] ) ) : ?>
					<div class="description"><?php echo wp_kses_post( $args['desc'] ); ?></div>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render color input field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function color_field( string $field_name, array $field_args = array() ) {
		if ( empty( $field_name ) ) {
			return;
		}

		$default_args = array(
			'id'    => sanitize_title( str_replace( '_', '-', join( '-', array( 'setting-field', $field_name ) ) ) ),
			'label' => __( 'Field Label', 'wp-ajaxify' ),
			'desc'  => '',
		);

		$args = wp_parse_args( $field_args, $default_args );

		// Fetch option value.
		$value = get_option( $field_name );
		?>
		<tr id="<?php echo esc_attr( join( '-', array( 'setting-row', $args['id'] ) ) ); ?>">
			<th><?php echo esc_html( $args['label'] ); ?></th>
			<td>
				<input type="text" name="<?php echo esc_attr( $field_name ); ?>" class="wp-ajaxify-color-picker" value="<?php echo esc_attr( $value ); ?>" />

				<?php if ( ! empty( $args['desc'] ) ) : ?>
					<div class="description"><?php echo wp_kses_post( $args['desc'] ); ?></div>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render dropdown field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function dropdown_field( string $field_name, array $field_args = array() ) {
		if ( empty( $field_name ) ) {
			return;
		}

		$default_args = array(
			'id'      => sanitize_title( str_replace( '_', '-', $field_name ) ),
			'label'   => __( 'Field Label', 'wp-ajaxify' ),
			'options' => array(),
			'desc'    => '',
			'sb'      => false,
		);

		$args = wp_parse_args( $field_args, $default_args );

		if ( empty( $args['options'] ) ) {
			return;
		}

		// Fetch option value.
		$value = get_option( $field_name );
		?>
		<tr id="<?php echo esc_attr( join( '-', array( 'setting-row', $args['id'] ) ) ); ?>">
			<th><?php echo esc_html( $args['label'] ); ?></th>
			<td>
				<select name="<?php echo esc_attr( $field_name ); ?>">
					<?php
					foreach ( $args['options'] as $option_value => $option_name ) {
						$check_value = true === $args['sb'] ? rest_sanitize_boolean( $option_value ) : $option_value;
						printf(
							'<option value="%1$s" %3$s>%2$s</option>',
							esc_html( $option_value ),
							esc_html( $option_name ),
							selected( $check_value, $value, false )
						);
					}
					?>
				</select>

				<?php if ( ! empty( $args['desc'] ) ) : ?>
					<div class="description"><?php echo wp_kses_post( $args['desc'] ); ?></div>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render yes/no dropdown field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function yes_no_field( string $field_name, array $field_args = array() ) {
		$field_args['options'] = array(
			true  => __( 'Yes', 'wp-ajaxify' ),
			false => __( 'No', 'wp-ajaxify' ),
		);

		$field_args['sb'] = true;

		$this->dropdown_field( $field_name, $field_args );
	}

	/**
	 * Render true/false dropdown field.
	 *
	 * @since 1.0.0
	 * @param string $field_name    Field name.
	 * @param array  $field_args    Field options.
	 */
	public function true_false_field( string $field_name, array $field_args = array() ) {
		$field_args['options'] = array(
			true  => __( 'True', 'wp-ajaxify' ),
			false => __( 'False', 'wp-ajaxify' ),
		);

		$field_args['sb'] = true;

		$this->dropdown_field( $field_name, $field_args );
	}
}
