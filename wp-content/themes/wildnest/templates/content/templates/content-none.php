<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 *
 * @package wildnest
 */
?>

<section class="no-results not-found">
	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<h2 class="page-title">
				<?php echo esc_html__( 'Ready to publish your first post?', 'wildnest' ); ?>
				<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php echo esc_html__( 'Get started here', 'wildnest' ); ?></a>.
			</h2>

		<?php elseif ( is_search() ) : ?>

			<h2 class="page-title"><?php echo esc_html__( 'Nothing Found', 'wildnest' ); ?></h2>
			<?php get_search_form(); ?>
			<p class="page-title"><?php echo esc_html__( 'Try to search using another term via the form above', 'wildnest' ); ?></p>

		<?php elseif ( is_author() ) : ?>

			<h2 class="page-title"><?php echo esc_html__( 'Nothing Found', 'wildnest' ); ?></h2>
			<p class="page-title"><?php echo esc_html__( 'Try to search for posts via the form above', 'wildnest' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<h2 class="page-title"><?php echo esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wildnest' ); ?></h2>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>