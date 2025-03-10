<?php

/**
 * Provide a public-facing view for the Options step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.1.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $sanitized_step;

$show_image = $sanitized_step['show_image'] === 'show';

$has_descriptions     = false;
$option_name          = staggs_sanitize_title( $sanitized_step['title'] );
$price_display        = isset( $sanitized_step['show_option_price'] ) ? $sanitized_step['show_option_price'] : 'hide';
$price_type           = isset( $sanitized_step['calc_price_type'] ) ? $sanitized_step['calc_price_type'] : '';
$price_label_position = isset( $sanitized_step['calc_price_label_pos'] ) ? $sanitized_step['calc_price_label_pos'] : '';
$default_values       = array();

$classes = '';
if ( $show_image ) {
	$classes .=  ' list--preview';
}
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

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
<div class="option-group-options options list<?php echo esc_attr( $classes ); ?>"<?php 
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
				?>
				<input id="<?php echo esc_attr( $option_id ); ?>" type="<?php echo esc_attr( $input_type ); ?>" disabled>
				<span class="option out-of-stock">
					<?php
					if ( $option['image'] && $show_image ) {
						echo '<span class="option-image">';
						echo wp_kses_post( $option['image'] );
						if ( isset( $option['image_url'] ) && '' !== $option['image_url'] && $sanitized_step['show_zoom'] ) {
							$zoom_icon = staggs_get_icon( 'sgg_zoom_icon', 'zoom' );
							echo '<a href="' . esc_url( $option['image_url'] ) . '" data-staggs-lightbox="gallery" class="icon-zoom">' .  wp_kses( $zoom_icon, staggs_get_icon_kses_args() ) . '</a>';
						}
						echo '</span>';
					}
					?>
					<span class="option-name">
						<?php
						echo '<span class="option-label">' . esc_attr( $option['name'] ) . '</span>';
						if ( isset( $option['note'] ) && $option['note'] ) {
							echo '<small class="option-note">' . wp_kses_post( $option['note'] ) . '</small>';
						}
						?>
					</span>
					<span class="option-price"><?php echo esc_attr( $option['stock_text'] ); ?></span>
				</span>
				<?php
			} else {
				$option_args  = staggs_get_option_group_input_args( $sanitized_step, $option, $key );
				$option_price = '';
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
				<span class="option"<?php 
					if ( isset( $option['font_family'] ) && '' !== $option['font_family'] ) {
						echo ' style="font-family:' . esc_attr( $option['font_family'] ) . ';font-weight:' . esc_attr( $option['font_weight'] ) . '";';
					}
					?>>
					<?php
					if ( $option['image'] && $show_image ) {
						echo '<span class="option-image">';
						echo wp_kses_post( $option['image'] );
						if ( isset( $option['image_url'] ) && '' !== $option['image_url'] && $sanitized_step['show_zoom'] ) {
							$zoom_icon = staggs_get_icon( 'sgg_zoom_icon', 'zoom' );
							echo '<a href="' . esc_url( $option['image_url'] ) . '" data-staggs-lightbox="gallery" class="icon-zoom">' .  wp_kses( $zoom_icon, staggs_get_icon_kses_args() ) . '</a>';
						}
						echo '</span>';
					}
					?>
					<span class="option-name">
						<?php
						echo '<span class="option-label">' . esc_attr( $option['name'] ) . '</span>';
						if ( isset( $option['note'] ) && $option['note'] ) {
							echo '<small class="option-note">' . wp_kses_post( $option['note'] ) . '</small>';
						}
						?>
					</span>
					<span class="option-price">
						<?php
						if ( ! isset( $sanitized_step['show_option_price'] ) || 'hide' !== $sanitized_step['show_option_price'] ) {
							echo get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] );
						}

						if ( isset( $option['description'] ) && $option['description'] ) {
							echo '<a href="#0" class="show-panel show-panel-option" aria-label="' . esc_attr__( 'Show description', 'staggs' ) . '">';
							echo wp_kses( staggs_get_icon( 'sgg_group_info_icon', 'panel-info' ), staggs_get_icon_kses_args() );
							echo '</a>';

							$has_descriptions = true;
						}
						?>
					</span>
				</span>
				<?php
				if ( isset( $option['description'] ) ) {
					echo '<div class="option-description hidden">' . wp_kses_post( $option['description'] ) . '</div>';
				}
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

if ( $has_descriptions ) {
	?>
	<div id="option-panel-<?php echo esc_attr( $sanitized_step['id'] ); ?>" class="option-group-panel">
		<div class="option-group-panel-header">
			<p><strong class="option-group-panel-label"></strong></p>
			<a href="#0" class="close-panel" aria-label="<?php esc_attr_e( 'Hide description', 'staggs' ); ?>">
				<?php
				echo wp_kses( staggs_get_icon( 'sgg_group_close_icon', 'panel-close' ), staggs_get_icon_kses_args() );
				?>
			</a>
		</div>
		<div class="option-group-panel-content">
		</div>
	</div>
	<?php
}
