<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
$class = "col-md-12";
$side = "";

if ( Wildnest()->get_setting('wildnest_shop_layout') == 'no-sidebar' ) {
	$class = "col-md-12";
}elseif ( Wildnest()->get_setting('wildnest_shop_layout') == 'right-sidebar' or Wildnest()->get_setting('wildnest_shop_layout') == 'left-sidebar') {
	$class = "col-md-9 wildnest-shop-has-sidebar";

	if ( Wildnest()->get_setting('wildnest_shop_layout') == 'right-sidebar' ) {
		$side = "right";
	}else{
		$side = "left";
	}
}
?>

<!-- HEADER TITLE BREADCRUBS SECTION -->
<?php echo wildnest_header_title_breadcrumbs(); ?>

	<!-- Page content -->
	<div class="high-padding">
	    <!-- Blog content -->
	    <div class="container blog-posts">
	    	<div class="row">
	    	
		        <?php if (is_active_sidebar('woocommerce')) { ?>
			        <?php if ( $side == 'left' ) { ?>
				        <div class="col-md-3 sidebar-content wildnest-shop-sidebar">
				        	<div class="wildnest-shop-sidebar-content-inner">
				        		<div class="wildnest-shop-sidebar-close-btn hide-on-desktops"><i class="fas fa-arrow-left"></i></div>
					            <?php
									/**
									 * woocommerce_sidebar hook
									 *
									 * @hooked woocommerce_get_sidebar - 10
									 */
									do_action( 'woocommerce_sidebar' );
								?>
					        </div>
				        </div>
			        <?php } ?>
		        <?php }else{ ?>
		            <?php $class = 'col-md-12'; ?>
		        <?php } ?>



            <div class="<?php echo esc_attr($class); ?> main-content">

				<?php do_action( 'woocommerce_archive_description' ); ?>

				<?php if ( have_posts() ) : ?>
					
					<div class="wildnest-shop-sort-group">
						<?php
							/**
							 * woocommerce_before_shop_loop hook
							 *
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );
						?>
						<div class="clearfix"></div>
					</div>

					<div class="clearfix"></div>

					<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

						<?php $i = 1; ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

								<?php
									global $woocommerce_loop;
									// Store column count for displaying the grid
									if ( empty( $woocommerce_loop['columns'] ) ){
										$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
									}
								?>

								<?php

								if ( $woocommerce_loop['columns'] == 2 ) {
									if ($i % 2 == 0){
										echo '<li class="clearfix hide-on-mobile"></li>';
									}
								}elseif ( $woocommerce_loop['columns'] == 3 ) {
									if ($i % 3 == 0){
										echo '<li class="clearfix hide-on-mobile"></li>';
									}
								}elseif ( $woocommerce_loop['columns'] == 4 ) {
									if ($i % 4 == 0){
										echo '<li class="clearfix hide-on-mobile"></li>';
									}
								} ?>

								<?php $i++; ?>

							<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
						/**
						 * woocommerce_after_shop_loop hook
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php wc_get_template( 'loop/no-products-found.php' ); ?>

				<?php endif; ?>

			</div>

	        <?php if ( $side == 'right' ) { ?>
	        <div class="col-md-3 sidebar-content wildnest-shop-sidebar right">
	        	<div class="wildnest-shop-sidebar-content-inner">
	        		<div class="wildnest-shop-sidebar-close-btn hide-on-desktops"><i class="icon-close icons"></i></div>
		            <?php
						/**
						 * woocommerce_sidebar hook
						 wildnest-shop-sidebar-close-btn hide-on-desktops						 * @hooked woocommerce_get_sidebar - 10
						 */
						do_action( 'woocommerce_sidebar' );
					?>
		        </div>
	        </div>
	        <?php } ?>

	    	</div>
	    </div>
	</div>

	<?php get_footer( 'shop' ); ?>
	
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		       