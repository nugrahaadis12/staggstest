<?php

/**
 * Provide a public-facing view for the Options step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.7
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

if ( isset( $sanitized_step['shared_group'] ) && '' !== $sanitized_step['shared_group'] ) {
	$option_name = staggs_sanitize_title( $sanitized_step['shared_group'] );
}
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
<div class="option-group-options options buttongroup<?php echo esc_attr( $classes ); ?>"
	<?php
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
				<span class="button disabled out-of-stock">
					<span class="button-name"><?php echo esc_attr( $option['name'] ); ?></span>
					<span class="button-price"><?php echo esc_attr( $option['stock_text'] ); ?></span>
				</span>
				<?php
			} else {
				$option_args = staggs_get_option_group_input_args( $sanitized_step, $option, $key );
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

				echo '<input id="' , esc_attr( $option_id ) . '" type="' . esc_attr( $input_type ) . '" name="' . esc_attr( $option_name ) . '" 
					data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '"';

				foreach ( $option_args as $prop => $val ) {
					echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
				}

				echo '>';
				?>
				<span class="button"<?php 
					if ( isset( $option['font_family'] ) && '' !== $option['font_family'] ) {
						echo ' style="font-family:' . esc_attr( $option['font_family'] ) . ';font-weight:' . esc_attr( $option['font_weight'] ) . '";';
					}
					?>>
					<span class="button-name"><?php echo esc_attr( $option['name'] ); ?></span>
					<span class="button-price">
						<?php
						if ( ! isset( $sanitized_step['show_option_price'] ) || 'hide' !== $sanitized_step['show_option_price'] ) {
							echo get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] );
						}
						?>
					</span>
				</span>
				<?php
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
