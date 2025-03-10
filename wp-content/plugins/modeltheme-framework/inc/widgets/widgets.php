<?php 

/* ========= social_icons ===================================== */
class mt_address_social_icons extends WP_Widget {

    function __construct() {
        parent::__construct('mt_address_social_icons', esc_attr__('MT - Contact + Social Media','modeltheme'),array( 'description' => esc_attr__( 'MT - Contact + Social Media','modeltheme' ), ) );
    }

    public function widget( $args, $instance ) {
        $widget_title = $instance[ 'widget_title' ];

        echo  $args['before_widget']; ?>

        <div class="sidebar-social-networks address-social-links">
            <?php if($widget_title) { ?>
               <h3 class="widget-title"><?php echo esc_attr($widget_title); ?></h3>
            <?php } ?>

            <?php if(wildnest()->get_setting('wildnest_contact_address') || wildnest()->get_setting('wildnest_contact_email') || wildnest()->get_setting('wildnest_contact_phone')) { ?>
            <div class="contact-details">
                <?php if(wildnest()->get_setting('wildnest_contact_address')) { ?><span><i class="fas fa-map-marker-alt"></i><?php echo esc_attr(wildnest()->get_setting('wildnest_contact_address')); ?></span> <?php } ?>
                <?php if(wildnest()->get_setting('wildnest_contact_email')) { ?><span><i class="far fa-envelope"></i><?php echo esc_attr(wildnest()->get_setting('wildnest_contact_email')); ?></span> <?php } ?>
                <?php if(wildnest()->get_setting('wildnest_contact_phone')) { ?><span><i class="fas fa-phone"></i><?php echo esc_attr(wildnest()->get_setting('wildnest_contact_phone')); ?></span> <?php } ?>
            </div>
            <?php } ?>

            <ul class="social-links">
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_facebook') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_facebook')) ?>"><i class="fab fa-facebook"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_twitter') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_twitter') ) ?>"><i class="fab fa-twitter"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_youtube') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_youtube') ) ?>"><i class="fab fa-youtube"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_pinterest') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_pinterest') ) ?>"><i class="fab fa-pinterest"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_linkedin') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_linkedin') ) ?>"><i class="fab fa-linkedin"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_skype') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_skype')) ?>"><i class="fab fa-skype"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_instagram') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_instagram') ) ?>"><i class="fab fa-instagram"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_dribble') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_dribble') ) ?>"><i class="fab fa-dribbble"></i></a></li>
            <?php } ?>
            <?php if ( wildnest()->get_setting('wildnest_social_media_links_vimeo') != '' ) { ?>
                <li><a target="_blank" href="<?php echo esc_attr( wildnest()->get_setting('wildnest_social_media_links_vimeo') ) ?>"><i class="fab fa-vimeo-square"></i></a></li>
            <?php } ?>
            </ul>
        </div>
        <?php echo  $args['after_widget'];
    }

    public function form( $instance ) {

        # Widget Title
        if ( isset( $instance[ 'widget_title' ] ) ) {
            $widget_title = $instance[ 'widget_title' ];
        } else {
            $widget_title = esc_attr__( 'Social icons','modeltheme' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'widget_title' )); ?>"><?php esc_attr_e( 'Widget Title:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'widget_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'widget_title' )); ?>" type="text" value="<?php echo esc_attr( $widget_title ); ?>">
        </p>
        <p><?php esc_attr_e( '* Social Network account must be set from Customizer - Social Media.','modeltheme' ); ?></p>
        <?php 
    }




    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ?  $new_instance['widget_title']  : '';

        return $instance;
    }
}


/* ========= MT_Recent_Posts_Widget ===================================== */
class mt_recent_entries_with_thumbnail extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('mt_recent_entries_with_thumbnail', esc_attr__('MT - Recent Posts with thumbnails','modeltheme'),array( 'description' => esc_attr__( 'MT - Recent Posts with thumbnails','modeltheme' ), ) );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $recent_posts_title = $instance[ 'recent_posts_title' ];
        $recent_posts_number = $instance[ 'recent_posts_number' ];

        echo  $args['before_widget'];

        $args_recenposts = array(
                'posts_per_page'   => $recent_posts_number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish' 
                );

        $recentposts = get_posts($args_recenposts);
        $myContent  = "";
        $myContent .= '<h3 class="widget-title">'.$recent_posts_title.'</h3>';
        $myContent .= '<ul class="widget_recent_entries_with_thumbnail_ul">';

        foreach ($recentposts as $post) {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'thumbnail' );

            $myContent .= '<li class="row">';
            if($thumbnail_src) {
                $myContent .= '<div class="col-md-4 post-thumbnail relative">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">';
                         $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                    $myContent .= '</a>';
                $myContent .= '</div>';
            }
                $myContent .= '<div class="col-md-8 post-details">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">'. $post->post_title.'</a>';
                    $myContent .= '<span class="post-date">'.get_the_date( "F j, Y" ).'</span>';
                $myContent .= '</div>';
            $myContent .= '</li>';
        }
        $myContent .= '</ul>';

        echo  $myContent;
        echo  $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'recent_posts_title' ] ) ) {
            $recent_posts_title = $instance[ 'recent_posts_title' ];
        } else {
            $recent_posts_title = esc_attr__( 'Recent posts','modeltheme' );;
        }

        # Number of posts
        if ( isset( $instance[ 'recent_posts_number' ] ) ) {
            $recent_posts_number = $instance[ 'recent_posts_number' ];
        } else {
            $recent_posts_number = esc_attr__( '5','modeltheme' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>"><?php esc_attr_e( 'Widget Title:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_title' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>"><?php esc_attr_e( 'Number of posts:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_number' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_number ); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['recent_posts_title'] = ( ! empty( $new_instance['recent_posts_title'] ) ) ?  $new_instance['recent_posts_title']  : '';
        $instance['recent_posts_number'] = ( ! empty( $new_instance['recent_posts_number'] ) ) ? strip_tags( $new_instance['recent_posts_number'] ) : '';
        return $instance;
    }

} 


// Register Widgets
function mt_register_widgets() {
    register_widget( 'mt_address_social_icons' );
    register_widget( 'mt_recent_entries_with_thumbnail' );
}
add_action( 'widgets_init', 'mt_register_widgets' );
?>