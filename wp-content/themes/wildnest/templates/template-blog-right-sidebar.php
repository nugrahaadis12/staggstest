<?php
/**
 *
 * Template Name: Blog (Right Sidebar)
 *
 * @package Wildnest
 */

get_header();

$class                  = "col-md-8";
$page_sidebar           = 'sidebar-1';

do_action( 'wildnest_before_main_content' );
?>

<div class="high-padding">
    <div class="container blog-posts">
        <div class="row">
            <div class="<?php echo esc_attr($class); ?> main-content">
                <?php
                // Include blog loop
                echo get_template_part('templates/content/templates/sections/blog-loop'); ?>
            </div>

            <?php if ( is_active_sidebar( $page_sidebar ) ) { ?>
                <div class="col-md-3 sidebar-content">
                    <?php  dynamic_sidebar( $page_sidebar ); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php 
do_action( 'wildnest_after_main_content' );

get_footer();