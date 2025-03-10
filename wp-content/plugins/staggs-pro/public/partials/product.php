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

global $sanitized_step, $sgg_minus_button, $sgg_plus_button;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$add_label = __( 'Add', 'staggs' );
if (staggs_get_theme_option('sgg_product_add_label')) {
	$add_label = __( staggs_get_theme_option('sgg_product_add_label'), 'staggs' );
}
$remove_label = __( 'Remove', 'staggs' );
if (staggs_get_theme_option('sgg_product_remove_label')) {
	$remove_label = __( staggs_get_theme_option('sgg_product_remove_label'), 'staggs' );
}

$classes = '';
if ( isset( $sanitized_step['product_template'] ) ) {
	$classes .= ' products--' . $sanitized_step['product_template'];
}
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

$has_descriptions = false;
?>
<div class="option-group-options products<?php echo esc_attr( $classes ); ?>">
	<?php
	foreach ( $sanitized_step['options'] as $key => $option ) {
		// Out of stock and hidden.
		if ( $option['hide_option'] && '' !== $option['stock_qty'] && 0 >= $option['stock_qty'] ) {
			continue;
		}

		$option_id    = staggs_sanitize_title( $sanitized_step['id'] . '_' . $key . '_' . $option['name'] );
		$option_name  = staggs_sanitize_title( $option['name'] );
		$preview_urls = get_option_preview_urls( $option, $sanitized_step['preview_index'] );
		$option_title = $option['name'];
		$price        = $option['price'];
		$sale         = $option['sale_price'];
		$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
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
				<input 
					id="<?php echo esc_attr( $option_id ); ?>" 
					type="radio"
					disabled>
				<span class="sgg-product out-of-stock">
					<span class="sgg-product-image">
						<?php
						if ( $option['image'] ) {
							echo wp_kses_post( $option['image'] );
						}
						?>
					</span>
					<span class="sgg-product-info">
						<span class="sgg-product-title">
							<span class="sgg-product-name"><?php echo esc_attr( $option_title ); ?></span>
							<?php if ( isset( $option['note'] ) && '' !== $option['note'] ) : ?>
								<small class="sgg-product-note"><?php echo wp_kses_post( $option['note'] ); ?></small>
							<?php endif; ?>
							<span class="sgg-product-price"><?php echo esc_attr( $option['stock_text'] ); ?></span>
						</span>
					</span>
				</span>
				<?php
			} else {
				$option_args  = staggs_get_option_group_input_args( $sanitized_step, $option, $key );
				$option_price = '';
				$price        = $option['price'];
				$sale         = $option['sale_price'];

				if ( 'no' === $option['base_price'] ) {
					$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
					
					$option_args['data-alt-price'] = $option['price'];
				}

				if ( isset( $option['stock_qty'] ) && '' !== $option['stock_qty'] ) {
					$option_args['max'] = $option['stock_qty'];
				}

				if ( 'yes' === $option['enable_preview'] ) {
					if ( count( $preview_urls ) > 0 ) {
						$option_args['data-preview-urls'] = implode( ',', $preview_urls );
					}
				}

				if ( 'multiple' === $option['product_quantity'] ) {
					?>
					<span class="sgg-product">
						<span class="sgg-product-image">
							<?php
							if ( $option['image'] ) {
								echo wp_kses_post( $option['image'] );

								if ( isset( $option['image_url'] ) && '' !== $option['image_url'] && $sanitized_step['show_zoom'] ) {
									$zoom_icon = staggs_get_icon( 'sgg_zoom_icon', 'zoom' );
									echo '<a href="' . esc_url( $option['image_url'] ) . '" data-staggs-lightbox="gallery" class="icon-zoom">' . wp_kses( $zoom_icon, staggs_get_icon_kses_args() ) . '</a>';
								}
							}
							?>
						</span>
						<span class="sgg-product-info">
							<span class="sgg-product-title">
								<span class="sgg-product-name">
									<?php 
									echo esc_attr( $option_title ); 
									
									if ( isset( $option['description'] ) && $option['description'] ) {
										echo '<a href="#0" class="show-panel show-panel-option" aria-label="' . esc_attr__( 'Show description', 'staggs' ) . '">';
										echo wp_kses( staggs_get_icon( 'sgg_group_info_icon', 'panel-info' ), staggs_get_icon_kses_args() );
										echo '</a>';

										$has_descriptions = true;
									}
									?>
								</span>
								<?php if ( isset( $option['note'] ) && '' !== $option['note'] ) : ?>
									<small class="sgg-product-note"><?php echo wp_kses_post( $option['note'] ); ?></small>
								<?php endif; ?>
								<span class="sgg-product-price">
									<?php
									if ( ! isset( $sanitized_step['show_option_price'] ) || 'hide' !== $sanitized_step['show_option_price'] ) {
										echo get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] );
									}
									?>
								</span>
							</span>
							<span class="sgg-product-action">
								<?php
								if ( $sgg_minus_button && '' !== $sgg_minus_button ) {
									echo '<a href="#0" class="button-minus">' . wp_kses( $sgg_minus_button, staggs_get_icon_kses_args() ) . '</a>';
								} 
								
								echo '<input id="' , esc_attr( $option_id ) . '" type="number" name="' . esc_attr( $option_name ) . '" 
									data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '" value="0"';

								foreach ( $option_args as $prop => $val ) {
									echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
								}

								echo '>';

								if ( $sgg_plus_button && '' !== $sgg_plus_button ) {
									echo '<a href="#0" class="button-plus">' . wp_kses( $sgg_plus_button, staggs_get_icon_kses_args() ) . '</a>';
								}
								?>
							</span>
						</span>
					</span>
					<?php
					if ( isset( $option['description'] ) ) {
						echo '<div class="option-description hidden">' . wp_kses_post( $option['description'] ) . '</div>';
					}
				} else {
					?>
					<span class="sgg-product">
						<span class="sgg-product-image">
							<?php
							if ( $option['image'] ) {
								echo wp_kses_post( $option['image'] );

								if ( isset( $option['image_url'] ) && '' !== $option['image_url'] && $sanitized_step['show_zoom'] ) {
									$zoom_icon = staggs_get_icon( 'sgg_zoom_icon', 'zoom' );
									echo '<a href="' . esc_url( $option['image_url'] ) . '" data-staggs-lightbox="gallery" class="icon-zoom">' . wp_kses( $zoom_icon, staggs_get_icon_kses_args() ) . '</a>';
								}
							}
							?>
						</span>
						<span class="sgg-product-info">
							<span class="sgg-product-title">
								<span class="sgg-product-name">
									<?php 
									echo esc_attr( $option_title ); 
									
									if ( isset( $option['description'] ) && $option['description'] ) {
										echo '<a href="#0" class="show-panel show-panel-option" aria-label="' . esc_attr__( 'Show description', 'staggs' ) . '">';
										echo wp_kses( staggs_get_icon( 'sgg_group_info_icon', 'panel-info' ), staggs_get_icon_kses_args() );
										echo '</a>';

										$has_descriptions = true;
									}
									?>
								</span>
								<span class="sgg-product-price">
									<?php
									if ( ! isset( $sanitized_step['show_option_price'] ) || 'hide' !== $sanitized_step['show_option_price'] ) {
										echo get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] );
									}
									?>
								</span>
							</span>
							<span class="sgg-product-action">
								<?php
								echo '<input id="' , esc_attr( $option_id ) . '" type="checkbox" name="' . esc_attr( $option_name ) . '" 
									data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '" value="1"';

								foreach ( $option_args as $prop => $val ) {
									echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
								}

								echo '>';
								?>
								<span class="button">
									<span class="add"><?php echo esc_attr( $add_label ); ?></span>
									<span class="del"><?php echo esc_attr( $remove_label ); ?></span>
								</span>
							</span>
						</span>
					</span>
					<?php
					if ( isset( $option['description'] ) ) {
						echo '<div class="option-description hidden">' . wp_kses_post( $option['description'] ) . '</div>';
					}
				}
			}
			?>
		</label>
		<?php
	}
	?>
</div>
<?php
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
