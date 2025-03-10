<?php
$class = "col-md-8";
$sidebar = "sidebar-1";
if (!is_active_sidebar( $sidebar )) {
    $class = "col-md-12";
}

?>

<div id="primary" class="content-area">
	<div class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding '. get_post_field( 'post_name', get_post() )); ?>>
			    <div class="container">
			       <div class="row">
			            <?php 
			            // Left Sidebar
			            do_action('wildnest_before_single_post_content'); ?>
			            <div class="<?php echo esc_attr($class); ?> main-content">
			                <div class="article-header">
			                    <?php 
			                    // Include Post Image    
			                    get_template_part('templates/content/templates/sections/list/post-image' );?>
			                    <div class="clearfix"></div>
			                    <div class="wildnest-post-metas">
			                        <div class="wildnest-article-details">
			                            <?php 
			                            //Hook: Before post metas
			                            do_action('wildnest_before_single_post_metas');
			                            
			                            // Include Post Author
			                            get_template_part('templates/content/templates/sections/list/post-author' );
			                            // Include Post Category
			                            get_template_part('templates/content/templates/sections/list/post-category' );
			                            // Include Post Date
			                            get_template_part('templates/content/templates/sections/list/post-date' );

			                            //Hook: After post metas
			                            do_action('wildnest_after_single_post_metas');?>
			                            <div class="clearfix"></div>
			                            <h1><?php echo get_the_title(); ?></h1>
			                        </div>
			                    </div>
			                </div>

			                <div class="article-content">
			                    <?php the_content(); ?>
			                    <div class="clearfix"></div>
			                    <?php 
			                    // Include Post Links Pages
			                    get_template_part('templates/content/templates/sections/list/post-link-pages' ); ?>
			                </div>

			                <?php 
			                // Include Post Tags
			                get_template_part('templates/content/templates/sections/list/post-tags' ); ?>

			                <div class="clearfix"></div>
			                <?php 
			                // Include Post Comment Form
			                get_template_part('templates/content/templates/sections/list/post-comment-form' ); ?>
			             </div>
			            
			            <?php 
			            // Right Sidebar
			            do_action('wildnest_after_post_content'); ?>
			        </div>
			    </div>
			</article>
		<?php endwhile; ?>
	</div>
</div>