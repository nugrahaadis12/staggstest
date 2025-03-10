<?php

/**
 * Provide a public-facing view for the Dropdown step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.1.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/partials
 */

global $sanitized_step;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$option_name          = staggs_sanitize_title( $sanitized_step['title'] );
$price_display        = isset( $sanitized_step['show_option_price'] ) ? $sanitized_step['show_option_price'] : 'hide';
$price_type           = isset( $sanitized_step['calc_price_type'] ) ? $sanitized_step['calc_price_type'] : '';
$price_label_position = isset( $sanitized_step['calc_price_label_pos'] ) ? $sanitized_step['calc_price_label_pos'] : '';
$default_values       = array();

if ( isset( $sanitized_step['default_values'] ) ) {
	$default_values = $sanitized_step['default_values'];
}

$classes = '';
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

if ( 'above' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	if ( ( 'formula' === $price_type || 'matrix' === $price_type || 'formula-matrix' === $price_type ) && 'hide' !== $price_display ) {
		staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
	}
}
?>
<div class="option-group-options select<?php echo esc_attr( $classes ); ?>"<?php 
	if ( '' !== $price_label_position ) {
		echo ' data-price-label-pos="' . esc_attr( $price_label_position ) . '"';
	}

	if ( function_exists( 'staggs_output_attribute_pricing_details' ) ) {
		staggs_output_attribute_pricing_details( $sanitized_step, $price_type );
	}
	?>>
	<div class="select-wrapper">
		<select 
			name="<?php echo esc_attr( $option_name ); ?>" 
			id="<?php echo esc_attr( $sanitized_step['id'] ); ?>" 
			data-step-id="<?php echo esc_attr( $sanitized_step['id'] ); ?>"<?php 
			if ( isset( $sanitized_step['required'] ) && 'yes' === $sanitized_step['required'] ) {
				echo ' required';
			}
			
			?>>
			<?php 
			$placeholder = '';
			if ( '' !== staggs_get_post_meta( $sanitized_step['id'], 'sgg_step_field_placeholder' ) ) {
				$placeholder = staggs_get_post_meta( $sanitized_step['id'], 'sgg_step_field_placeholder' );
			}
			if ( ( isset( $sanitized_step['required'] ) && 'yes' === $sanitized_step['required'] ) || staggs_get_theme_option( 'sgg_product_dropdown_disable_placeholder' ) ) :
				if ( $placeholder && '' !== $placeholder ) :
					?>
					<option value=""><?php echo esc_attr( $placeholder ); ?></option>
					<?php
				endif;
			else :
				echo '<option value=""';
				if ( isset( $sanitized_step['options'][0]['preview_node'] ) && '' !== $sanitized_step['options'][0]['preview_node'] ) {
					echo ' data-nodes="-"';
				}
				echo '>';
				if ( '' === $placeholder ) {
					echo '- ' . esc_attr( $sanitized_step['title'] ) . ' -';
				} else {
					echo esc_attr( $placeholder );
				}
				echo '</option>';
			endif;

			foreach ( $sanitized_step['options'] as $key => $option ) {
				// Out of stock and hidden.
				if ( $option['hide_option'] && '' !== $option['stock_qty'] && 0 >= $option['stock_qty'] ) {
					continue;
				}

				$option_id    = staggs_sanitize_title( $sanitized_step['id'] . '_' . $key . '_' . $option['name'] );
				$option_name  = staggs_sanitize_title( $sanitized_step['title'] );
				$preview_urls = get_option_preview_urls( $option, $sanitized_step['preview_index'] );

				if ( isset( $option['manage_stock'] ) && 'yes' === $option['manage_stock'] && 0 >= $option['stock_qty'] ) {
					echo '<option disabled>' . esc_attr( $option['name'] ) . ' (' . esc_attr( $option['stock_text'] ) . ')</option>';
				} else {
					$option_args  = staggs_get_option_group_input_args( $sanitized_step, $option, $key );
					$option_name  = $option['name'];
					$price        = $option['price'];
					$sale         = $option['sale_price'];
					$option_price = '';
					$price_html   = '';

					if ( 'no' === $option['base_price'] ) {
						$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
						
						$option_args['data-alt-price'] = $option['price'];
					}

					if ( 'yes' === $option['enable_preview'] ) {
						if ( count( $preview_urls ) > 0 ) {
							$option_args['data-preview-urls'] = implode( ',', $preview_urls );
						}
					}

					if ( 'hide' === $sanitized_step['show_summary'] ) {
						if ( isset( $sanitized_step['show_option_price'] ) && 'hide' !== $sanitized_step['show_option_price'] ) {
							$price_html = strip_tags( get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) );

							$option_name .= ' ' . $price_html;
						}
					}

					if ( isset( $option['note'] ) && '' !== $option['note'] ) {
						$option_args['data-note'] = $option['note'];
					}

					if ( in_array( staggs_sanitize_title( $option['name'] ), $default_values ) ) {
						$option_args['selected'] = 'selected';
						$option_args['data-default'] = '1';
					}

					echo '<option name="' . esc_attr( $option_name ) . '" data-price="' . esc_attr( $option_price ) . '"';
					foreach ( $option_args as $prop => $val ) {
						echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
					}

					if ( isset( $option['font_family'] ) ) {
						echo ' style="font-family:' . esc_attr( $option['font_family'] ) . ';font-weight:' . esc_attr( $option['font_weight'] ) . '"';
					}
					
					if ( is_array( $option['conditional_rules'] ) && count( $option['conditional_rules'] ) > 0 ) {
						echo ' data-option-rules="' . urldecode( str_replace( '"', "'", json_encode( $option['conditional_rules'] ) ) ) . '"';
					}
					echo '>';
					echo esc_attr( $option_name );
					echo '</option>';
				}
			}
			?>
		</select>
	</div>
</div>
<?php
if ( 'below' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	if ( ( 'formula' === $price_type || 'matrix' === $price_type || 'formula-matrix' === $price_type ) && 'hide' !== $price_display ) {
		staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
	}
}