<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.7
 *
 * @package    Staggs
 * @subpackage Staggs/public/templates/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$theme_id = staggs_get_theme_id();
$class = ' staggs-product-view-' . staggs_get_post_meta( get_the_ID(), 'sgg_configurator_type' );
if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
	$class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
}
if ( 'inline' === staggs_get_post_meta( $theme_id, 'sgg_mobile_gallery_display' ) ) {
	$class .= ' mobile-inline';
}
if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_scale_mobile_display' ) ) {
	$class .= ' fix-mobile-view';
}
$view_layout = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_view' ) );
if ( 'classic' === $view_layout && staggs_get_post_meta( $theme_id, 'sgg_configurator_gallery_sticky' ) ) {
	$class .= ' staggs-product-view-sticky';
}
$data_attr = '';
$capture_all = staggs_get_post_meta( $theme_id, 'sgg_configurator_generate_pdf_images' );
if ( $capture_all ) {
	$data_attr .= ' data-capture-full="1"';
}

global $inline_style;
?>

<section class="staggs-product-view<?php echo esc_attr( $class ); ?>"<?php echo $data_attr; ?>>

	<?php
		/**
		 * Hook: staggs_before_single_product_gallery.
		 *
		 * @hooked staggs_output_company_logo - 10
		 */
		do_action( 'staggs_before_single_product_gallery' );
	?>

	<div class="product-view-inner"<?php echo ( $inline_style ) ? ' style="' . esc_attr( $inline_style ) . '"' : ''; ?>>

		<?php
			/**
			 * Hook: staggs_single_product_gallery.
			 *
			 * @hooked staggs_output_preview_gallery_wrapper - 10
			 * @hooked staggs_output_preview_gallery - 20
			 * @hooked staggs_output_preview_gallery_nav - 30
			 * @hooked staggs_output_preview_gallery_wrapper_close - 40
			 */
			do_action( 'staggs_single_product_gallery' );
		?>

	</div>

	<?php
		/**
		 * Hook: staggs_after_single_product_gallery.
		 *
		 * @hooked staggs_output_preview_gallery_nav - 10
		 */
		do_action( 'staggs_after_single_product_gallery' );
	?>

</section>
