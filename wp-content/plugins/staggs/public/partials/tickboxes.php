<?php

/**
 * Provide a public-facing view for the Tickboxes step type.
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

$has_descriptions = false;

$default_values = array();
if ( isset( $sanitized_step['default_values'] ) ) {
	$default_values = $sanitized_step['default_values'];
}

$classes = '';
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}
?>
<div class="option-group-options tickboxes<?php echo esc_attr( $classes ); ?>">
	<?php
	if ( isset( $sanitized_step['show_tick_all'] ) && $sanitized_step['show_tick_all'] && isset( $sanitized_step['tick_all_label'] ) ) {
		?>
		<label for="<?php echo esc_attr( $sanitized_step['id'] . '_all' ); ?>">
			<input id="<?php echo esc_attr( $sanitized_step['id'] . '_all' ); ?>" type="checkbox" class="tickboxes-all-option">
			<span class="box">
				<span class="box-name"><?php echo esc_attr( $sanitized_step['tick_all_label'] ); ?></span>
			</span>
		</label>
		<?php
	}

	foreach ( $sanitized_step['options'] as $key => $option ) {
		// Out of stock and hidden.
		if ( $option['hide_option'] && '' !== $option['stock_qty'] && 0 >= $option['stock_qty'] ) {
			continue;
		}

		$option_id    = staggs_sanitize_title( $sanitized_step['id'] . '_' . $key . '_' . $option['name'] );
		$option_name  = staggs_sanitize_title( $sanitized_step['title'] );
		$preview_urls = get_option_preview_urls( $option, $sanitized_step['preview_index'] );	

		$option_rules = '';
		if ( is_array( $option['conditional_rules'] ) && count( $option['conditional_rules'] ) > 0 ) {
			$option_rules = ' data-option-rules="' . urldecode( str_replace( '"', "'", json_encode( $option['conditional_rules'] ) ) ) . '"';
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
				<input id="<?php echo esc_attr( $option_id ); ?>" type="checkbox" disabled>
				<span class="box disabled out-of-stock">
					<span class="box-name">
						<?php
						echo esc_attr( $option['name'] );

						if ( isset( $option['note'] ) && $option['note'] ) {
							echo '<small class="box-note">' . wp_kses_post( $option['note'] ) . '</small>';
						}
						?>
					</span>
					<span class="box-price"><?php echo esc_attr( $option['stock_text'] ); ?></span>
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

				if ( 'yes' === $option['enable_preview'] ) {
					if ( count( $preview_urls ) > 0 ) {
						$option_args['data-preview-urls'] = implode( ',', $preview_urls );
					}
				}

				if ( in_array( staggs_sanitize_title( $option['name'] ), $default_values ) ) {
					$option_args['checked'] = 'checked';
					$option_args['data-default'] = '1';
				}

				echo '<input id="' , esc_attr( $option_id ) . '" type="checkbox" name="' . esc_attr( $option_name ) . '" 
					data-index="' . esc_attr( $step_key ) . '" data-price="' . esc_attr( $option_price ) . '"';
				foreach ( $option_args as $prop => $val ) {
					echo ' ' . esc_attr( $prop ) . '="' . esc_attr( $val ) . '"';
				}
				echo '>';
				?>
				<span class="box">
					<span class="box-name">
						<?php 
						echo esc_attr( $option['name'] );

						if ( isset( $option['note'] ) && $option['note'] ) {
							echo '<small class="box-note">' . wp_kses_post( $option['note'] ) . '</small>';
						}
						?>
					</span>
					<span class="box-price">
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
					<?php echo isset( $option['description'] ) ? '<div class="option-description hidden">' . wp_kses_post( $option['description'] ) . '</div>' : ''; ?>
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
