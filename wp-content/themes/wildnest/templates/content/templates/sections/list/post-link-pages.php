<div class="clearfix"></div>
<?php
    wp_link_pages( array(
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wildnest' ),
        'after'  => '</div>',
    ) );