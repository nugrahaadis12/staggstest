<?php 
$class = "col-md-8";
$sidebar = "sidebar-1";
if (!is_active_sidebar( $sidebar )) {
    $class = "col-md-12";
}

?>
<div class="high-padding">
    <!-- Blog content -->
    <div class="container blog-posts">
        <div class="row">
			<?php do_action('wildnest_before_blog_content'); ?>
			<div class="<?php echo esc_attr($class); ?> main-content">
				<?php
				// Include blog template
				echo get_template_part('templates/content/templates/sections/loop'); ?>
			</div>
			<?php #sidebar ?>
			<?php do_action('wildnest_after_blog_pagination'); ?>
		</div>
	</div>
</div>