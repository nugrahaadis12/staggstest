<?php
$page_spacing = get_post_meta( get_the_ID(), 'mt_page_spacing', true );
?>
<div id="primary" class="<?php echo esc_attr($page_spacing); ?> content-area no-sidebar">
    <div class="container">
        <main class="col-md_12 site-main main-content">
        	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        		<?php while ( have_posts() ) : the_post(); ?>
	        		<div class="entry-content">
						<?php the_content();
						// Include Post Page links
	        			get_template_part('templates/content/templates/sections/list/post-link-pages' );
	        			// Include Post Page links
	        			get_template_part('templates/content/templates/sections/list/post-comment-form' );
	        			?>
					</div>
				<?php endwhile; // end of the loop. ?>
        	</article>
		</main>
	</div>
</div>