<?php

/**
 * Provide a public-facing view for the True/False step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.2.1
 *
 * @package    Staggs
 * @subpackage Staggs/public/partials
 */

global $sanitized_step, $sgg_minus_button, $sgg_plus_button;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$option_name    = staggs_sanitize_title( $sanitized_step['title'] );
$option_price   = 0;
$price_type     = isset( $sanitized_step['calc_price_type'] ) ? $sanitized_step['calc_price_type'] : '';
$formula        = isset( $sanitized_step['price_formula'] ) ? $sanitized_step['price_formula'] : '';
$matrix_table   = isset( $sanitized_step['price_table'] ) ? $sanitized_step['price_table'] : '';
$price_label_position = isset( $sanitized_step['calc_price_label_pos'] ) ? $sanitized_step['calc_price_label_pos'] : '';

$classes = '';
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

if ( 'above' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	if ( $formula != '' || $matrix_table != '' ) {
		staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
	}
}

echo '<div class="option-group-options measurements' . esc_attr( $classes ) . '"';
if ( function_exists( 'staggs_output_attribute_pricing_details' ) ) {
	staggs_output_attribute_pricing_details( $sanitized_step, $price_type );
}
echo '>';

if ( $formula != '' || $matrix_table != '' ) {
	echo '<input type="hidden" id="' . esc_attr( $option_name ) . '" value="' . esc_attr( $option_price ) . '">';
}

foreach ( $sanitized_step['options'] as $key => $option ) {
	$option_id    = staggs_sanitize_title( $sanitized_step['id'] . '_' . $key . '_' . $option['name'] );
	$option_price = '';
	$price        = $option['price'];
	$sale         = $option['sale_price'];

	$supported_attributes = array(
		'sku'           => 'data-sku',
		'preview_top'   => 'data-preview-top',
		'preview_left'  => 'data-preview-left',
		'preview_width' => 'data-preview-width',
		'preview_overflow'     => 'data-preview-overflow',
		'preview_top_mobile'   => 'data-preview-top-xs',
		'preview_left_mobile'  => 'data-preview-left-xs',
		'preview_width_mobile' => 'data-preview-width-xs',
		'preview_ref_selector' => 'data-preview-selector',
		'field_key'      => 'data-field-key',
		'field_unit'     => 'data-unit',
		'field_min'      => 'min',
		'field_max'      => 'max',
		'field_placeholder' => 'placeholder',
	);

	if ( 'no' === $option['base_price'] ) {
		$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
	}
	?>
	<label for="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>" class="input-field-wrapper">
		<?php if ( ! isset( $sanitized_step['show_input_labels'] ) || 'hide' !== $sanitized_step['show_input_labels'] ) : ?>
			<span class="input-heading">
				<p class="input-title">
					<?php 
					echo esc_attr( $option['name'] );

					if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
						echo ' <span class="required-indicator">*</span>';
					}
					?>
				</p>
				<?php
				if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
					echo '<span class="input-price">' . get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) . '</span>';	
				}
				?>
			</span>
			<?php 
		endif;

		if ( isset( $option['note'] ) && $option['note'] ) {
			$note = '<p class="option-note">' . $option['note'] . '</p>';
		}
		?>
		<span class="input-field">
			<span class="input-field-inner">
				<?php 
				if ( 'number' === $option['field_type'] && $sgg_minus_button && '' !== $sgg_minus_button ) {
					echo '<a href="#0" class="button-minus">' . wp_kses( $sgg_minus_button, staggs_get_icon_kses_args() ) . '</a>';
				}
				?>
				<input 
					id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
					name="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
					type="number"
					value="<?php echo isset( $option['field_value'] ) ? esc_attr( $option['field_value'] ) : ''; ?>"
					data-option-id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
					data-step-id="<?php echo esc_attr( $sanitized_step['id'] ); ?>"
					<?php
					foreach ( $supported_attributes as $field_key => $data_attribute ) {
						if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] ) {
							echo ' ' . esc_attr( $data_attribute ) . '="' . esc_attr( $option[ $field_key ] ) . '"';
						}
					}

					if ( 'no' === $option['base_price'] ) {
						if ( 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
							echo ' data-unit-price="' . esc_attr( $option['unit_price'] ) . '"';
						} else if ( 'table' === $option['price_type'] && isset( $option['price_table'] ) && '' !== $option['price_table'] ) {
							echo ' data-table-price="' . esc_attr( $option['price_table'] ) . '"';
						} else if ( $option_price ) {
							echo ' data-price="' . esc_attr( $option_price ) . '"';
						}
					}

					if ( $sanitized_step['preview_index'] && 'yes' === $option['enable_preview'] ) {
						echo ' data-preview-index="' . esc_attr( $sanitized_step['preview_index'] ) . '"';
					}
					if ( isset( $option['range_increments'] ) ) {
						echo ' step="' . esc_attr( $option['range_increments'] ) . '"';
					}
					if ( isset( $option['field_value'] ) && '' !== $option['field_value'] ) {
						echo ' data-default="' . esc_attr( $option['field_value'] ) . '"';
					}
					if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
						echo ' required="required"';
					}
					
					if ( 'range' === $option['field_type'] ) {
						echo ' data-type="range"';

						$increments = 1;
						if ( isset( $option['range_increments'] ) ) {
							$increments = $option['range_increments'];
						}

						if ( isset( $option['range_bubble'] ) && 'yes' == $option['range_bubble'] ) {
							echo ' data-range-bubble="1"';
						}

						echo ' data-range-increments="' . esc_attr( $increments ) . '" readonly';
					}
					?>>
				<?php 
				if ( 'number' === $option['field_type'] && $sgg_plus_button && '' !== $sgg_plus_button ) {
					echo '<a href="#0" class="button-plus">' . wp_kses( $sgg_plus_button, staggs_get_icon_kses_args() ) . '</a>';
				}
				?>
			</span>
			<?php
			if ( 'range' === $option['field_type'] ) {
				echo '<div id="range-slider-' . esc_attr( $option_id ) . '" class="range-slider"></div>';
				echo '<div class="range-value"><span class="name">' . esc_attr( $option['name'] ) . ':</span><span class="value"></span></div>';
			}

			if ( isset( $option['field_unit'] ) && '' !== $option['field_unit'] && $option['field_type'] !== 'range' ) {
				echo '<span class="unit">' . esc_attr( $option['field_unit'] ) . '</span>';
			}
			?>
		</span>
		<?php
		$unit = ( isset( $option['field_unit'] ) && '' !== $option['field_unit'] ) ? ' ' . $option['field_unit'] : '';
		$comment = '';
		
		if ( isset( $sanitized_step[ 'field_info' ] ) && 'yes' === $sanitized_step[ 'field_info' ] ) {
			if ( isset( $option[ 'field_min' ] ) && '' !== $option[ 'field_min' ] && isset( $option[ 'field_max' ] ) && '' !== $option[ 'field_max' ] ) {
				$comment = '<small>' . __( 'Min: ', 'staggs' ) . $option[ 'field_min' ] . __( ' and max: ', 'staggs' ) . $option[ 'field_max' ] . $unit . '</small>';
			} else if ( isset( $option[ 'field_min' ] ) && '' !== $option[ 'field_min' ] ) {
				$comment = '<small>' . __( 'Min: ', 'staggs' ) . $option[ 'field_min' ] . $unit . '</small>';
			} else if ( isset( $option[ 'field_max' ] ) && '' !== $option[ 'field_max' ] ) {
				$comment = '<small>' . __( 'Max: ', 'staggs' ) . $option[ 'field_max' ] . $unit . '</small>';
			}
		}

		echo wp_kses_post( $comment );
		?>
	</label>
	<?php
}

if ( 'below' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	if ( $formula != '' || $matrix_table != '' ) {
		staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
	}
}

echo '</div>';
