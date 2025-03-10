<?php if ( have_posts() ) : ?>
    <div class="row">
        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

            <?php
            get_template_part('templates/content/templates/sections/list/post-wrapper' );
            ?>

        <?php endwhile; ?>

        <div class="wildnest-pagination pagination col-md-12">             
            <?php wildnest_pagination(); ?>
        </div>
    </div>

<?php else : ?>
    <?php get_template_part( 'templates/content/templates/content-none' ); ?>
<?php endif;