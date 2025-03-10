<?php if (get_the_category()) { ?>
    <div class="article-detail-meta post-categories post-author">
        <?php echo get_the_term_list( get_the_ID(), 'category', '<i class="fas fa-tag"></i>', ', ' ); ?>
    </div>
<?php }