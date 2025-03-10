<?php

/**
 * Provide a public-facing view for the Icons step type.
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

$columns = $sanitized_step['layout'];

$classes = '';
if ( isset( $sanitized_step['swatch_size'] ) ) {
	$classes .= ' size-' . $sanitized_step['swatch_size'];
}
if ( isset( $sanitized_step['swatch_style'] ) ) {
	$classes .= ' style-' . $sanitized_step['swatch_style'];
}
if ( isset( $sanitized_step['show_swatch_label'] ) ) {
	$classes .= ' ' . $sanitized_step['show_swatch_label'] . '-label';
}
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

$option_name          = staggs_sanitize_title( $sanitized_step['title'] );
$price_display        = isset( $sanitized_step['show_option_price'] ) ? $sanitized_step['show_option_price'] : 'hide';
$price_type           = isset( $sanitized_step['calc_price_type'] ) ? $sanitized_step['calc_price_type'] : '';
$price_label_position = isset( $sanitized_step['calc_price_label_pos'] ) ? $sanitized_step['calc_price_label_pos'] : '';
$default_values       = array();

if ( isset( $sanitized_step['shared_group'] ) && '' !== $sanitized_step['shared_group'] ) {
	$option_name = staggs_sanitize_title( $sanitized_step['shared_group'] );
}

if ( isset( $sanitized_step['default_values'] ) ) {
	$default_values = $sanitized_step['default_values'];
}

if ( 'above' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	if ( ( 'formula' === $price_type || 'matrix' === $price_type || 'formula-matrix' === $price_type ) && 'hide' !== $price_display ) {
		staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
	}
}
?>
<div class="option-group-options icons<?php echo esc_attr( $classes ); ?>"<?php
	if ( isset( $sanitized_step['shared_group'] ) && '' !== $sanitized_step['shared_group'] ) {
		echo ' data-group="' . esc_attr( $option_name ) . '"';
	}

	if ( '' !== $price_label_position ) {
		echo ' data-price-label-pos="' . esc_attr( $price_label_position ) . '"';
	}

	if ( function_exists( 'staggs_output_attribute_pricing_details' ) ) {
		staggs_output_attribute_pricing_details( $sanitized_step, $price_type );
	}
	?>>
	<?php
	foreach ( $sanitized_step['options'] as $key => $option ) {
		// Out of stock and hidden.
		if ( $option['hide_option'] && '' !== $option['stock_qty'] && 0 >= $option['stock_qty'] ) {
			continue;
		}

		$option_id    = staggs_sanitize_title( $sanitized_step['id'] . '_' . $key . '_' . $option['name'] );
		$preview_urls = get_option_preview_urls( $option, $sanitized_step['preview_index'] );
		$option_note  = isset( $option['note'] ) ? $option['note'] : '';
		$inline_label = '';

		$input_type = 'radio';
		if ( isset( $sanitized_step['allowed_options'] ) && 'multiple' == $sanitized_step['allowed_options'] ) {
			$input_type = 'checkbox';
		}
		?>
		<label 
			for="<?php echo esc_attr( $option_id ); ?>"
			<?php 
			if ( is_array( $option['conditional_rules'] ) && count( $option['conditional_rules'] ) > 0 ) {
				echo ' data-option-rules="' . urldecode( str_replace( '"', "'", json_encode( $option['conditional_rules'] ) ) ) . '"';
			}
			?>>
			<?php
			if ( isset( $option['manage_stock'] ) && 'yes' === $option['manage_stock'] && 0 >= $option['stock_qty'] ) {
				if ( isset( $sanitized_step['show_swatch_label'] ) ) {
					if ( 'show' === $sanitized_step['show_swatch_label'] ) {
						$inline_label .= '<div class="label"><span class="name">' . $option['name'] . '</span></div>';
					} elseif ( 'show_note' === $sanitized_step['show_swatch_label'] && '' !== $option_note ) {
						$inline_label .= '<div class="label"><span class="name">' . $option_note . '</span></div>';
					}
				}
				?>
				<input id="<?php echo esc_attr( $option_id ); ?>" type="<?php echo esc_attr( $input_type ); ?>" disabled>
				<span class="icon out-of-stock">
					<?php echo wp_kses_post( $option['image'] ); ?>
				</span>
				<?php
				echo wp_kses_post( $inline_label );
			} else {
				$option_args  = staggs_get_option_group_input_args( $sanitized_step, $option, $key );
				$option_price = '';
				$label_price  = '';
				$price_html   = '';
				$tooltip      = '';
				$price        = $option['price'];
				$sale         = $option['sale_price'];

				if ( 'yes' === $option['enable_preview'] ) {
					if ( count( $preview_urls ) > 0 ) {
						$option_args['data-preview-urls'] = implode( ',', $preview_urls );
					}
				}
				
				if ( 'no' === $option['base_price'] ) {
					$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );

					$option_args['data-alt-price'] = $option['price'];
				}

				if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
					$label_price  = '<span class="tooltip-price">' . get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) . '</span>';

					if ( $sale !== -1 && $price !== -1 ) {
						$price_html = $price . '|' . $sale;
					} elseif ( $sale !== -1 || $price !== -1 ) {
						$price_html = $sale !== -1 ? $sale : $price;
					}
				}

				if ( isset( $sanitized_step['show_swatch_label'] ) ) {
					if ( 'show' === $sanitized_step['show_swatch_label'] ) {
						$inline_label .= '<div class="label"><span class="name">' . $option['name'] . '</span><br>' . $label_price . '</div>';
					} elseif ( 'show_note' === $sanitized_step['show_swatch_label'] && '' !== $option_note ) {
						$inline_label .= '<div class="label"><span class="name">' . $option_note . '</span></div>';
					}
				}
				
				if ( $price_html ) {
					$option_args['data-label-value'] = $price_html;
				} else {
					$option_args['data-label-value'] = '';
				}
				
				if ( isset( $option['note'] ) && '' !== $option['note'] ) {
					$option_args['data-note'] = $option['note'];
				}

				if ( isset( $option['name'] ) && '' !== $option['name'] ) {
					$option_args['data-label'] = $option['name'];
				}

				$option_image = '';
				if ( isset( $option['image'] ) && '' !== $option['image'] ) {
					$option_image = $option['image'];
				}

				if ( 'show' === $sanitized_step['show_tooltip'] ) {
					if ( isset( $sanitized_step['tooltip_template'] ) ) {
						if ( 'extended' === $sanitized_step['tooltip_template'] ) {
							$tooltip .= '<div class="tooltip tooltip-large"><div class="tooltip-content">' . $option_image . '<span class="name">' . $option['name'] . '</span>' . $label_price . '</div></div>';
						} elseif ( 'full' === $sanitized_step['tooltip_template'] ) {
							$tooltip .= '<div class="tooltip tooltip-large"><div class="tooltip-content">' . $option_image . '<span class="name">' . $option['name'] . '</span><span class="note">' . $option_note . '</span>' . $label_price . '</div></div>';
						} elseif ( 'text' === $sanitized_step['tooltip_template'] ) {
							$tooltip .= '<div class="tooltip tooltip-large"><div class="tooltip-content"><span class="name">' . $option['name'] . '</span><span class="note">' . $option_note . '</span>' . $label_price . '</div></div>';
						} else {
							$tooltip .= '<div class="tooltip"><span class="name">' . $option['name'] . '</span>' . $label_price . '</div>';
						}
					} else {
						$tooltip .= '<div class="tooltip"><span class="name">' . $option['name'] . '</span>' . $label_price . '</div>';
					}
				}

				if ( in_array( staggs_sanitize_title( $option['name'] ), $default_values ) ) {
					$option_args['checked'] = 'checked';
					$option_args['data-default'] = '1';
				}

				echo '<input id="' , esc_attr( $option_id ) . '" type="' . esc_attr( $input_type ) . '" name="' . esc_attr( $option_name ) . '" 
					data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '"';
				foreach ( $option_args as $prop => $val ) {
					echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
				}
				echo '>';
				?>
				<span class="icon">
					<?php 
					echo wp_kses_post( $option_image );

					if ( isset( $option['image_url'] ) && '' !== $option['image_url'] && $sanitized_step['show_zoom'] ) {
						$zoom_icon = staggs_get_icon( 'sgg_zoom_icon', 'zoom' );
						echo '<a href="' . esc_url( $option['image_url'] ) . '" data-staggs-lightbox="gallery" class="icon-zoom">' . wp_kses( $zoom_icon, staggs_get_icon_kses_args() ) . '</a>';
					}
					?>
				</span>
				<?php
				echo wp_kses_post( $tooltip );
				echo wp_kses_post( $inline_label );
			}
			?>
		</label>
		<?php
	}
	?>
</div>
<?php
if ( 'below' === $price_label_position && function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	if ( ( 'formula' === $price_type || 'matrix' === $price_type || 'formula-matrix' === $price_type ) && 'hide' !== $price_display ) {
		staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position );
	}
}
