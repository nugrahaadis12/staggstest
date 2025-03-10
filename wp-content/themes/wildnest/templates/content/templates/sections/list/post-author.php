<div class="article-detail-meta post-author">
    <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>">
    <i class="fas fa-user-circle"></i>
        <?php echo esc_html(get_the_author()); ?>
    </a>
</div>