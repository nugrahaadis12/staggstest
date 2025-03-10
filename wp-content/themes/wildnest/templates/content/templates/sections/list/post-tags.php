<div class="article-footer">
    <?php if (get_the_tags()) { ?>
        <div class="single-post-tags">
            <span><?php echo esc_html__('Tags:', 'wildnest') ?></span> <?php echo get_the_term_list( get_the_ID(), 'post_tag', '', ' ' ); ?>
        </div>
    <?php } ?>
</div>