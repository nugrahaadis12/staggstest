<?php

/**
 * Provide a public-facing view for the True/False step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.1.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/partials
 */

global $sanitized_step, $density, $text_align;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$option_name    = staggs_sanitize_title( $sanitized_step['title'] );
$single_html    = '';
$option_price   = 0;
$price_type     = isset( $sanitized_step['calc_price_type'] ) ? $sanitized_step['calc_price_type'] : '';
$formula        = isset( $sanitized_step['price_formula'] ) ? $sanitized_step['price_formula'] : '';
$matrix_table   = isset( $sanitized_step['price_table'] ) ? $sanitized_step['price_table'] : '';
$price_label_position = isset( $sanitized_step['calc_price_label_pos'] ) ? $sanitized_step['calc_price_label_pos'] : '';

$default_values = array();
if ( isset( $sanitized_step['default_values'] ) ) {
	$default_values = $sanitized_step['default_values'];
}

$classes = '';
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

if ( is_array( $sanitized_step['options'] ) && count( $sanitized_step['options'] ) > 0 ) {
	if ( 'above' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
		if ( $formula != '' || $matrix_table != '' ) {
			staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
		}
	}

	foreach ( $sanitized_step['options'] as $key => $option ) {
		// Out of stock and hidden.
		if ( $option['hide_option'] && '' !== $option['stock_qty'] && 0 >= $option['stock_qty'] ) {
			continue;
		}

		$is_disabled  = ( isset( $option['manage_stock'] ) && 'yes' === $option['manage_stock'] && 0 >= $option['stock_qty'] );
		$preview_urls = get_option_preview_urls( $option, $sanitized_step['preview_index'] );
		$option_id    = staggs_sanitize_title( $sanitized_step['id'] . '_' . $key . '_' . $option['name'] );
		$option_args  = staggs_get_option_group_input_args( $sanitized_step, $option, $key );
		$option_price = '';
		$price        = $option['price'];
		$sale         = $option['sale_price'];

		if ( 'no' === $option['base_price'] ) {
			$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
			$option_args['data-alt-price'] = $option['price'];
		}

		if ( 'yes' === $option['enable_preview'] ) {
			if ( count( $preview_urls ) > 0 ) {
				$option_args['data-preview-urls'] = implode( ',', $preview_urls );
			}
		}

		if ( in_array( staggs_sanitize_title( $option['name'] ), $default_values ) ) {
			$option_args['checked'] = 'checked';
			$option_args['data-default'] = '1';
		}

		$price_html = '';
		if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
			$price_html = get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] );
		}

		if ( 'toggle' === $sanitized_step['button_view'] ) {

			if ( 'left' === $text_align ) {
				echo '<div class="option-group-header">';
			} else if ( '' !== $price_html ) {
				?>
				<p class="option-group-price"><?php echo wp_kses_post( $price_html ); ?></p>
				<?php
			}
			?>
			<div class="option-group-options single single-toggle<?php echo $is_disabled ? ' disabled out-of-stock' : ''; ?><?php echo esc_attr( $classes ); ?>"
				<?php
				if ( function_exists( 'staggs_output_attribute_pricing_details' ) ) {
					staggs_output_attribute_pricing_details( $sanitized_step, $price_type );
				}
				?>>
				<label for="<?php echo esc_attr( $option_id ); ?>">
					<div class="toggle">
						<?php
						echo '<input id="' , esc_attr( $option_id ) . '" type="checkbox" class="checkbox" name="' . esc_attr( $option_name ) . '" 
							data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '"';
						foreach ( $option_args as $prop => $val ) {
							echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
						}
						echo '>';
						?>
						<div class="knobs<?php echo $is_disabled ? ' disabled' : ''; ?>">
							<span class="before"><?php echo esc_attr( $sanitized_step['button_add'] ); ?></span>
							<span class="switch"></span>
							<span class="after"><?php echo esc_attr( $sanitized_step['button_del'] ); ?></span>
						</div>
						<div class="layer"></div>
						<span class="toggle-label">
							<span class="before"><?php echo esc_attr( $sanitized_step['button_add'] ); ?></span>
							<span class="after"><?php echo esc_attr( $sanitized_step['button_del'] ); ?></span>
						</span>
					</div>
				</label>
			</div>
			<?php
			if ( 'left' === $text_align ) {
				?>
				<div class="option-group-title">
					<strong class="title"><?php echo esc_attr( $sanitized_step['title'] ); ?></strong>
					<?php if ( $sanitized_step['description'] ) : ?>
						<a href="#0" class="show-panel" aria-label="<?php esc_attr_e( 'Show description', 'staggs' ); ?>">
							<?php
							echo wp_kses( staggs_get_icon( 'sgg_group_info_icon', 'panel-info' ), staggs_get_icon_kses_args() );
							?>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $price_html ) : ?>
						<p class="option-group-price"><?php echo wp_kses_post( $price_html ); ?></p>
					<?php endif; ?>
				</div>
				<?php
				echo '</div>';
			}
		} else {
			?>
			<p class="option-group-price"><?php echo wp_kses_post( $price_html ); ?></p>
			<div class="option-group-options single<?php echo $is_disabled ? ' disabled out-of-stock' : ''; ?><?php echo esc_attr( $classes ); ?>"
				<?php
				if ( function_exists( 'staggs_output_attribute_pricing_details' ) ) {
					staggs_output_attribute_pricing_details( $sanitized_step, $price_type );
				}
				?>>
				<label for="<?php echo esc_attr( $option_id ); ?>">
					<?php
					echo '<input id="' , esc_attr( $option_id ) . '" type="checkbox" class="checkbox" name="' . esc_attr( $option_name ) . '" 
						data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '"';
					foreach ( $option_args as $prop => $val ) {
						echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
					}
					echo '>';
					?>
					<span class="button<?php echo $is_disabled ? ' disabled' : ''; ?>">
						<span class="add"><?php echo esc_attr( $sanitized_step['button_add'] ); ?></span>
						<span class="del"><?php echo esc_attr( $sanitized_step['button_del'] ); ?></span>
					</span>
				</label>
			</div>
			<?php
		}
		break; // Only show first and single option.
	}

	if ( 'below' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
		if ( $formula != '' || $matrix_table != '' ) {
			staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
		}
	}
}
