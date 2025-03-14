<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.0.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $sgg_fs, $post, $product, $sanitized_steps;

if ( 'sgg_product' === get_post_type() ) {
	$product = get_post( get_the_ID() );
} else {
	$product = wc_get_product( get_the_ID() );
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="staggs-configurator staggs-configurator-full staggs-configurator-steps">

	<?php
		/**
		 * Hook: staggs_before_single_product.
		 *
		 * @hooked -
		 */
		do_action( 'staggs_before_single_product' );
	?>

	<?php
		/**
		* Hook: woocommerce_before_single_product.
		*
		* @hooked woocommerce_output_all_notices - 10
		*/
		do_action( 'woocommerce_before_single_product' );
	?>

	<div id="product-<?php the_ID(); ?>" <?php staggs_product_class( '', $product ); ?>>

		<?php
			/**
			 * Hook: staggs_before_single_product_content.
			 *
			 * @hooked staggs_output_content_wrapper - 20
			 */
			do_action( 'staggs_before_single_product_content' );
		?>

		<?php
			/**
			 * Hook: staggs_before_single_product_content.
			 *
			 * @hooked staggs_single_product_topbar - 20
			 */
			do_action( 'staggs_single_product_topbar' );
		?>

		<?php
			/**
			 * Shared template: gallery
			 *
			 */
			require STAGGS_BASE . 'public/templates/shared/gallery.php';
		?>

		<?php
			/**
			 * Hook: staggs_before_single_product_options.
			 *
			 * @hooked staggs_output_options_wrapper - 10
			 */
			do_action( 'staggs_before_single_product_options' );
		?>

		<div class="option-group intro">
			<div class="option-group-content">

				<?php
					/**
					 * Hook: staggs_single_product_summary.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 20
					 * @hooked woocommerce_template_single_excerpt - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'staggs_single_product_summary' );
				?>

			</div>
		</div>

		<?php
			/**
			 * Hook: staggs_single_product_options
			 *
			 * @hooked -
			 */
			do_action( 'staggs_single_product_options' );
		?>

		<?php
			/**
			 * Hook: staggs_after_single_product_options.
			 *
			 * @hooked staggs_output_options_wrapper_close - 20
			 */
			do_action( 'staggs_after_single_product_options' );
		?>

		<?php
			/**
			 * Hook: staggs_before_single_product_content.
			 *
			 * @hooked staggs_single_product_bottom_bar - 20
			 */
			do_action( 'staggs_single_product_bottom_bar' );
		?>

	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<?php
		/**
		 * Hook: staggs_after_single_product_content.
		 *
		 * @hooked staggs_output_content_wrapper_close - 10
		 */
		do_action( 'staggs_after_single_product_content' );
	?>

	<?php
		/**
		 * Hook: woocommerce_after_single_product.
		 *
		 * @hooked -
		 */
		do_action( 'woocommerce_after_single_product' );
	?>

	<?php
		/**
		 * Hook: staggs_after_single_product.
		 *
		 * @hooked -
		 */
		do_action( 'staggs_after_single_product' );
	?>

</div>

<?php wp_footer(); ?>
</body>
</html>

<?php

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
