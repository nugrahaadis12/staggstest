<h3 class="wildnest-post-name post-name">
    <a href="<?php echo esc_url(get_the_permalink()); ?>">
        <?php if (is_sticky()) { ?>
            <i class="fas fa-bolt" aria-hidden="true"></i>
        <?php } ?>
        <?php the_title(); ?>
    </a>
</h3>
