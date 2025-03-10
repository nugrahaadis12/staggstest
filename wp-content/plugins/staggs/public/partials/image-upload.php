<?php

/**
 * Provide a public-facing view for the Image Upload step type.
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

$class = ' image-input-field';
$is_custom_upload = staggs_get_theme_option( 'sgg_product_disable_system_file_upload' );
if ( $is_custom_upload ) {
	$class .= ' image-input-field-custom';
}

$classes = '';
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}
?>
<div class="option-group-options image-input<?php echo esc_attr( $classes ); ?>">
	<?php
	foreach ( $sanitized_step['options'] as $key => $option ) {
		$option_name = staggs_sanitize_title( $option['name'] );

		$supported_attributes = array(
			'allowed_file_types' => 'accept',
			'sku'          => 'data-sku',
			'max_file_size' => 'data-size',
		);

		$required_visual_keys = array('preview_width', 'preview_height');
		$filled_visual_keys = array();

		if ( 'yes' === $option['enable_preview'] ) {
			$supported_attributes = array(
				'allowed_file_types' => 'accept',
				'sku'           => 'data-sku',
				'max_file_size'  => 'data-size',
				'field_key'      => 'data-field-key',
				'material_key'   => 'data-material-key',
				'preview_top'    => 'data-preview-top',
				'preview_left'   => 'data-preview-left',
				'preview_width'  => 'data-preview-width',
				'preview_height' => 'data-preview-height',
				'preview_top_mobile' => 'data-preview-top-xs',
				'preview_left_mobile' => 'data-preview-left-xs',
				'preview_image_fill' => 'data-preview-fill',
			);
		}

		foreach ( $supported_attributes as $field_key => $data_attribute ) {
			if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] && in_array( $field_key, $required_visual_keys) ) {
				$filled_visual_keys[] = $field_key;
			}
		}

		$price_html   = '';
		$option_price = '';
		$price        = $option['price'];
		$sale         = $option['sale_price'];
		if ( 'no' === $option['base_price'] ) {
			$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
		}

		if ( $required_visual_keys === $filled_visual_keys && ( isset( $option['material_key'] ) || isset( $sanitized_step['model_group'] ) ) ) {
			$material_key = isset( $option['material_key'] ) ? $option['material_key'] : $sanitized_step['model_group'];
			if ( $material_key ) {
				echo '<canvas id="' . esc_attr( $option['id'] ) . '_canvas" class="option-group-canvas" width="' . esc_attr( $option['preview_width'] )
					. '" height="' . esc_attr( $option['preview_height'] ) . '" data-key="' . esc_attr( $material_key ) . '"></canvas>';
			}
		}
		?>
		<div class="input-field-wrapper<?php echo esc_attr( $class ); ?>">
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
				echo '<p class="option-note">' . wp_kses_post( $option['note'] ) . '</p>';
			}
			?>
			<div class="show-if-input-value hidden"></div>
			<div class="hide-if-input-value">
				<label for="<?php echo esc_attr( $option_name ); ?>-input">
					<input type="file"
						name="<?php echo esc_attr( $option_name ); ?>-input"
						value=""
						id="<?php echo esc_attr( $option_name ); ?>-input"
						data-step-id="<?php echo esc_attr( $option['id'] ); ?>"
						data-option-id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
						<?php
						foreach ( $supported_attributes as $field_key => $data_attribute ) {
							if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] ) {
								echo ' ' . esc_attr( $data_attribute ) . '="' . esc_attr( $option[ $field_key ] ) . '"';
							}
						}

						if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
							echo ' required="required"';
						}
						
						if ( $sanitized_step['preview_index'] && 'yes' === $option['enable_preview'] ) {
							echo ' data-preview-index="' . esc_attr( $sanitized_step['preview_index'] ) . '"';
						}

						if ( 'no' === $option['base_price'] ) {
							echo ' data-price="' . esc_attr( $option_price ) . '"';
							echo ' data-alt-price="' . esc_attr( $option_price ) . '"';
						}
						?>>
					<input type="hidden" name="<?php echo esc_attr( $option_name ); ?>" value="">
					<?php
					if ( $is_custom_upload ) {
						$field_label = staggs_get_theme_option( 'sgg_product_file_upload_label' ) ?: __( 'No file selected', 'staggs' );
						$field_button = staggs_get_theme_option( 'sgg_product_file_upload_button_label' ) ?: __( 'Browse', 'staggs' );

						echo '<p class="image-input-field-label"><span class="input-field-button">' . esc_attr( $field_button ) . '</span>';
						echo esc_attr( $field_label ) . '</p>';
					}
					?>
				</label>
			</div>
		</div>
		<?php
	}
	?>
</div>