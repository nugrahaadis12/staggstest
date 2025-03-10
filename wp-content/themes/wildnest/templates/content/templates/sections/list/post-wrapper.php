<?php
/**
 * @package wildnest
 */

$featured_image = wildnest()->get_setting( 'wildnest_blog_featured_image_status' );
$title_status = wildnest()->get_setting( 'wildnest_blog_post_title_status' );
$metas_status = wildnest()->get_setting( 'wildnest_blog_metas_status' );
$description_status = wildnest()->get_setting( 'wildnest_blog_description_status' );
$btn_status = wildnest()->get_setting( 'wildnest_blog_readmore_btn_status' );

$class = '';
if ($featured_image == 0) {
    $class = 'wildnest-image-disabled';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wildnest-article-wrapper single-post grid-view col-md-12 list-view '.esc_attr($class)); ?>>
     <div class="wildnest-article-content">
        <?php 
        // Include Post Image    
        if ($featured_image == 1) {
            get_template_part('templates/content/templates/sections/list/post-image' );
        }
        ?>
        <div class="wildnest-article-inner post-details">
            <?php 

            // Include Post Informations
            if ($metas_status == 1) {
                get_template_part('templates/content/templates/sections/list/post-info' );
            }
            
            // Include Post Title
            if ($title_status == 1) {
                get_template_part('templates/content/templates/sections/list/post-title' );
            }
            
            
            // Include Post Excerpt
            if ($description_status == 1) {
                get_template_part('templates/content/templates/sections/list/post-excerpt' );
            }

            // Include Post button
            if ($btn_status == 1) {
                get_template_part('templates/content/templates/sections/list/post-button' );
            }
            // Include Post Page links
            get_template_part('templates/content/templates/sections/list/post-link-pages' ); 
            ?>
        </div>
    </div>
</article>