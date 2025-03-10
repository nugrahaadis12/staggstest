<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' ); ?>

<!-- Breadcrumbs -->
<div class="wildnest-single-product">
    <?php
        /**
        * woocommerce_before_main_content hook
        *
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
        * @hooked woocommerce_breadcrumb - 20
        */
        do_action( 'woocommerce_before_main_content' );
    ?>

    <!-- Page content -->
    <div class="high-padding">
        <!-- Blog content -->
        <div class="container blog-posts">
            <div class="row">
                <div class="col-md-12 main-content">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php wc_get_template_part( 'content', 'single-product' ); ?>
                    <?php endwhile; // end of the loop. ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    /**
    * woocommerce_after_main_content hook
    *
    * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    */
    do_action( 'woocommerce_after_main_content' );
    ?>
<?php get_footer( 'shop' ); ?>

</div>