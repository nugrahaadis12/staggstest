<?php 
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
    'post_type'        => 'post',
    'post_status'      => 'publish',
    'paged'            => $paged,
);
$posts = new WP_Query( $args );

if ( $posts->have_posts() ) : ?>
    <?php /* Start the Loop */ ?>
    <?php
    while ( $posts->have_posts() ) : $posts->the_post(); ?>
        <?php
            get_template_part('templates/content/templates/sections/list/post-wrapper' );
        ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php echo '<div class="clearfix"></div>'; ?>
<?php else : ?>
    <?php get_template_part( 'templates/content/templates/content-none' ); ?>
<?php endif; ?>

<div class="clearfix"></div>
<?php 
$wp_query = new WP_Query($args);
global  $wp_query;
if ($wp_query->max_num_pages != 1) { ?>                
    <div class="modeltheme-pagination-holder col-md-12">           
        <div class="modeltheme-pagination pagination">           
            <?php the_posts_pagination(); ?>
        </div>
    </div>
<?php }
wp_reset_postdata();
