<?php
/**
 * Helper class for dashboard fields.
 *
 * @package WP_Ajaxify
 */

namespace WP_Ajaxify;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * WP Ajaxify Field Class.
 *
 * @class Field
 */
class Field {

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
	 * Return the html selected attribute if stringified $value is found in array of stringified $options
	 * or if stringified $value is the same as scalar stringified $options.
	 *
	 * @since 1.1.0
	 * @param string|int       $value   Value to find within options.
	 * @param string|int|array $options Options to go through when looking for value.
	 * @return string
	 */
	private function selected( $value, $options ) {
		if ( is_array( $options ) ) {
			$options = array_map( 'strval', $options );
			return selected( in_array( (string) $value, $options, true ), true, false );
		}

		return selected( $value, $options, false );
	}

	/**
	 * Implode and escape HTML attributes for output.
	 *
	 * @since 1.0.0
	 * @param array $raw_attributes Attribute name value pairs.
	 */
	private function html_attrs( $raw_attributes ) {
		$field_attributes = array();
		foreach ( $raw_attributes as $name => $value ) {
			$field_attributes[] = esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}

		echo implode( ' ', $field_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Build id attribute as a sanitized slug.
	 *
	 * @since 1.1.3
	 * @param string $string Field name or label.
	 * @return string
	 */
	private function build_id( $string = '' ) {
		// Replace underscore with space first.
		$string = preg_replace( '/_/', ' ', $string );
		return sanitize_title( $string );
	}

	/**
	 * Output submit field row.
	 *
	 * @since 1.0.0
	 * @param string $setting_group Settings group.
	 */
	public function submit_field( $setting_group = 'wp_ajaxify_settings' ) {
		?>
		<tr class="submit-row">
			<th colspan="2">
				<?php settings_fields( $setting_group ); ?>
				<?php submit_button(); ?>
			</th>
		</tr>
		<?php
	}

	/**
	 * Output heading field row.
	 *
	 * @since 1.0.0
	 * @param array $field Field data.
	 */
	public function heading_field( array $field ) {
		$field = wp_parse_args(
			$field,
			array(
				'label'         => '',
				'desc'          => '',
				'wrapper_class' => '',
			)
		);

		$field_id = $this->build_id( 'wp-ajaxify-' . $field['label'] );

		$wrapper_attributes = array(
			'class' => join( ' ', array_filter( array( $field['wrapper_class'], 'heading-row', $field_id . '-heading' ) ) ),
			'id'    => $field_id . '-heading-row',
		);

		?>
		<tr <?php $this->html_attrs( $wrapper_attributes ); ?>>
			<th><?php echo wp_kses_post( $field['label'] ); ?></th>
			<td><?php echo wp_kses_post( $field['desc'] ); ?></td>
		</tr>
		<?php
	}

	/**
	 * Output a text input field row.
	 *
	 * @since 1.0.0
	 * @param array $field Field data.
	 */
	public function text_field( array $field ) {
		$args = array(
			'attributes'    => array(),
			'class'         => 'regular-text',
			'desc'          => '',
			'id'            => $this->build_id( $field['name'] ),
			'placeholder'   => '',
			'required'      => false,
			'style'         => '',
			'type'          => 'text',
			'value'         => '',
			'wrapper_class' => '',
		);

		$field = wp_parse_args( $field, $args );

		$wrapper_attributes = array(
			'class' => join( ' ', array_filter( array( $field['wrapper_class'], 'setting-row', $field['id'] . '-setting-row' ) ) ),
			'id'    => $field['id'] . '-setting-row',
		);

		$label_attributes = array(
			'for' => $field['id'],
		);

		$field_attributes                = (array) $field['attributes'];
		$field_attributes['class']       = $field['class'];
		$field_attributes['id']          = $field['id'];
		$field_attributes['name']        = $field['name'];
		$field_attributes['placeholder'] = $field['placeholder'];
		$field_attributes['style']       = $field['style'];
		$field_attributes['type']        = $field['type'];
		$field_attributes['value']       = get_option( $field['name'] );

		if ( isset( $field['required'] ) && $this->str_to_bool( $field['required'] ) ) {
			$field_attributes['required'] = 'required';
		}

		$description = ! empty( $field['desc'] ) ? $field['desc'] : '';

		?>
		<tr <?php $this->html_attrs( $wrapper_attributes ); ?>>
			<th>
				<label <?php $this->html_attrs( $label_attributes ); ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			</th>
			<td>
				<input <?php $this->html_attrs( $field_attributes ); ?> />

				<?php if ( ! empty( $description ) ) : ?>
					<p class="description"><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Output a textarea input field row.
	 *
	 * @since 1.0.0
	 * @param array $field Field data.
	 */
	public function textarea_field( array $field ) {
		$args = array(
			'attributes'    => array(),
			'class'         => 'regular-text',
			'cols'          => 20,
			'desc'          => '',
			'id'            => $this->build_id( $field['name'] ),
			'placeholder'   => '',
			'required'      => false,
			'rows'          => 5,
			'style'         => '',
			'value'         => '',
			'wrapper_class' => '',
		);

		$field = wp_parse_args( $field, $args );

		$wrapper_attributes = array(
			'class' => join( ' ', array_filter( array( $field['wrapper_class'], 'setting-row', $field['id'] . '-setting-row' ) ) ),
			'id'    => $field['id'] . '-setting-row',
		);

		$label_attributes = array(
			'for' => $field['id'],
		);

		$field_attributes                = (array) $field['attributes'];
		$field_attributes['class']       = $field['class'];
		$field_attributes['cols']        = $field['cols'];
		$field_attributes['id']          = $field['id'];
		$field_attributes['name']        = $field['name'];
		$field_attributes['placeholder'] = $field['placeholder'];
		$field_attributes['rows']        = $field['rows'];
		$field_attributes['style']       = $field['style'];

		if ( isset( $field['required'] ) && $this->str_to_bool( $field['required'] ) ) {
			$field_attributes['required'] = 'required';
		}

		$description = ! empty( $field['desc'] ) ? $field['desc'] : '';
		$field_value = get_option( $field['name'] );

		?>
		<tr <?php $this->html_attrs( $wrapper_attributes ); ?>>
			<th>
				<label <?php $this->html_attrs( $label_attributes ); ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			</th>
			<td>
				<textarea <?php $this->html_attrs( $field_attributes ); ?>><?php echo esc_textarea( $field_value ); ?></textarea>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="description"><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Output a select dropdown field row.
	 *
	 * @since 1.0.0
	 * @param array $field Field data.
	 */
	public function dropdown_field( array $field ) {
		$args = array(
			'attributes'    => array(),
			'class'         => 'select',
			'desc'          => '',
			'id'            => $this->build_id( $field['name'] ),
			'options'       => array(),
			'required'      => false,
			'style'         => '',
			'value'         => '',
			'wrapper_class' => '',
		);

		$field = wp_parse_args( $field, $args );

		$wrapper_attributes = array(
			'class' => join( ' ', array_filter( array( $field['wrapper_class'], 'setting-row', $field['id'] . '-setting-row' ) ) ),
			'id'    => $field['id'] . '-setting-row',
		);

		$label_attributes = array(
			'for' => $field['id'],
		);

		$field_attributes          = (array) $field['attributes'];
		$field_attributes['class'] = $field['class'];
		$field_attributes['id']    = $field['id'];
		$field_attributes['name']  = $field['name'];
		$field_attributes['style'] = $field['style'];

		if ( isset( $field['required'] ) && $this->str_to_bool( $field['required'] ) ) {
			$field_attributes['required'] = 'required';
		}

		$description = ! empty( $field['desc'] ) ? $field['desc'] : '';
		$field_value = get_option( $field['name'] );

		?>
		<tr <?php $this->html_attrs( $wrapper_attributes ); ?>>
			<th>
				<label <?php $this->html_attrs( $label_attributes ); ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			</th>
			<td>
				<select <?php $this->html_attrs( $field_attributes ); ?>>
					<?php
					foreach ( $field['options'] as $key => $value ) {
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo '<option value="' . esc_attr( $key ) . '"' . $this->selected( $key, $field_value ) . '>' . esc_html( $value ) . '</option>';
					}
					?>
				</select>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="description"><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render yes/no dropdown field row.
	 *
	 * @since 1.0.0
	 * @param array $field Field data.
	 */
	public function yes_no_field( array $field ) {
		$field['options'] = array(
			'1' => __( 'Yes', 'wp-ajaxify' ),
			'0' => __( 'No', 'wp-ajaxify' ),
		);

		$this->dropdown_field( $field );
	}

	/**
	 * Render true/false dropdown field.
	 *
	 * @since 1.0.0
	 * @param array $field Field data.
	 */
	public function true_false_field( array $field ) {
		$field['options'] = array(
			'1' => __( 'True', 'wp-ajaxify' ),
			'0' => __( 'False', 'wp-ajaxify' ),
		);

		$this->dropdown_field( $field );
	}
}
