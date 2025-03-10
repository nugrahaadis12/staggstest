<?php
$image_size = 'wildnest_blog_single';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );
$thumbnail_class = 'wildnest-article-image-inner';

if($thumbnail_src) { ?>
    <div class="<?php echo esc_attr($thumbnail_class); ?> post-thumbnail">
        <a href="<?php echo esc_url(get_the_permalink()); ?>" class="relative">
            <?php if($thumbnail_src) { 
                echo '<img src="'. esc_url($thumbnail_src[0]) . '" alt="'.esc_attr(the_title_attribute('echo=0')).'" />';
            } ?>
        </a>
    </div>
<?php }