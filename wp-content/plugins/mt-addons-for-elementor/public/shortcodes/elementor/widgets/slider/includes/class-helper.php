<?php
/**
 *
 * @package MT_Addons_Slider
 */
namespace MT_Addons\includes;

defined( 'ABSPATH' ) || die();

class MT_Addons_Slider_Helper {
    
    /**
     * Get Allowed HTML
     *
     * @return void
     */
    static function allowed_html() {
        $kses_defaults = wp_kses_allowed_html( 'post' );

        $svg_args = array(
            'svg'   => array(
                'class'           => true,
                'aria-hidden'     => true,
                'aria-labelledby' => true,
                'role'            => true,
                'xmlns'           => true,
                'width'           => true,
                'height'          => true,
                'viewbox'         => true, // <= Must be lower case!
            ),
            'g'     => array( 'fill' => true ),
            'title' => array( 'title' => true ),
            'path'  => array(
                'd'    => true,
                'fill' => true,
            ),
        );
        return array_merge( $kses_defaults, $svg_args );
    }

    /**
     * Get image alt text by attachement ID
     *
     * @param [type] $image_id
     * @return void
     */
    static function get_image_alt_text( $image_id ) {
        $img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        if( ! empty( get_the_title( $img_alt ) ) ) {
            return get_the_title($img_alt);
        }else{
            return 'Image';
        }
    }

    /**
     * Slider Animation
     *
     * @return void
     */
    static function get_svg_icons() {
        $icons = [
            "arrow-left"        => "<svg width='16' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/></svg>",
            "arrow-left-long"   => "<svg width='16' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z'/></svg>",
            "arrow-right"       => "<svg width='16' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/></svg>",
            "arrow-right-long"  => "<svg width='16' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z'/></svg>",
        ];

        return $icons;
    }

    /**
     * Slider Animation
     *
     * @return void
     */
    static function get_animation_effects( $exclude = [] ) {
        $effects = [
            'none'                  => esc_html__('None','mt-addons'),
            'dl-fadeIn'             => esc_html__('Fade In','mt-addons'),
            'dl-fadeInLeft'         => esc_html__('Fade In Left','mt-addons'),
            'dl-fadeInRight'        => esc_html__('Fade In Right','mt-addons'),
            'dl-fadeInDown'         => esc_html__('Fade In Down','mt-addons'),
            'dl-fadeInUp'           => esc_html__('Fade In Up','mt-addons'),
            'clip-text'             => esc_html__('Clip Text','mt-addons'),
            'reveal-text'           => esc_html__('Reveal Text','mt-addons'),
            'char-top'              => esc_html__('Splitting Text Top','mt-addons'),
            'char-right'            => esc_html__('Splitting Text Right','mt-addons'),
            'char-bottom'           => esc_html__('Splitting Text Bottom','mt-addons'),
            'char-expand'           => esc_html__('Splitting Text Expand','mt-addons'),
            'dl-moveFromLeft'       => esc_html__('Move From Left','mt-addons'),
            'dl-moveFromRight'      => esc_html__('Move From Right','mt-addons'),
            'dl-moveFromTop'        => esc_html__('Move From Top','mt-addons'),
            'dl-moveFromBottom'     => esc_html__('Move From Bottom','mt-addons'),
            'dl-blurIn'             => esc_html__('Blur In','mt-addons'),
            'dl-blurInLeft'         => esc_html__('Blur In Left','mt-addons'),
            'dl-blurInRight'        => esc_html__('Blur In Right','mt-addons'),
            'dl-blurInTop'          => esc_html__('Blur In Top','mt-addons'),
            'dl-blurInBottom'       => esc_html__('Blur In Bottom','mt-addons'),
            'dl-zoomIn'             => esc_html__('Zoom In','mt-addons'),
            'dl-zoomInLeft'         => esc_html__('Zoom In Left','mt-addons'),
            'dl-zoomInRight'        => esc_html__('Zoom In Right','mt-addons'),
            'dl-zoomInTop'          => esc_html__('Zoom In Top','mt-addons'),
            'dl-zoomInBottom'       => esc_html__('Zoom In Bottom','mt-addons'),
            'dl-flipInTop'          => esc_html__('Flip In Top','mt-addons'),
            'dl-flipInBottom'       => esc_html__('Flip In Bottom','mt-addons'),
            'dl-rollFromLeft'       => esc_html__('Roll From Left','mt-addons'),
            'dl-rollFromRight'      => esc_html__('Roll From Right','mt-addons'),
            'dl-rollFromTop'        => esc_html__('Roll From Top','mt-addons'),
            'dl-rollFromBottom'     => esc_html__('Roll From Bottom','mt-addons'),
            'dl-rotateSkateInRight' => esc_html__('Rotate Skate In Right','mt-addons'),
            'dl-rotateSkateInLeft'  => esc_html__('Rotate Skate In Left','mt-addons'),
            'dl-rotateSkateInTop'   => esc_html__('Rotate Skate In Top','mt-addons'),
            'dl-rotateSkateInBottom'=> esc_html__('Rotate Skate In Bottom','mt-addons'),
            'dl-popUp'              => esc_html__('PopUp','mt-addons'),
            'dl-popUpRight'         => esc_html__('PopUp Right','mt-addons'),
            'dl-popUpLeft'          => esc_html__('PopUp Left','mt-addons'),
        ];
        if( ! empty( $exclude ) ) {
            foreach( $exclude as $key ) {
                unset( $effects[$key] );
            }
            return $effects;
        }else{
            return $effects;
        }
    }

    /**
     * Kenburns Effects
     *
     * @return void
     */
    static function get_kenburns_effects() {
        return [
            'kenburns-top'          => esc_html__('Kenburns Top','mt-addons'),
            'kenburns-top-right'    => esc_html__('Kenburns Top Right','mt-addons'),
            'kenburns-right'        => esc_html__('Kenburns Right','mt-addons'),
            'kenburns-bottom-right' => esc_html__('Kenburns Bottom Right','mt-addons'),
            'kenburns-bottom'       => esc_html__('Kenburns Bottom','mt-addons'),
            'kenburns-bottom-left'  => esc_html__('Kenburns Bottom Left','mt-addons'),
            'kenburns-left'         => esc_html__('Kenburns Left','mt-addons'),
            'kenburns-top-left'     => esc_html__('Kenburns Top Left','mt-addons'),
            'none'                  => esc_html__('None','mt-addons'),

        ];
    }

    /**
     * Get Slider Image
     *
     * @param string $img_url
     * @param string $kenburns_effecct
     * @param boolean $echo
     * @return void
     */
    static function get_slider_image( $settings, $data = [], $echo = true ) {
        if( 'image' === $data['bg_type'] ) {
            $kenburns_duration = 'none' != $data['kenburns_effect'] ? 'animation-duration: ' . $data['kenburns_duration'] . 'ms;': '';
            $kenburns_cls = 'none' != $data['kenburns_effect'] ? 'kenburns ' . $data['kenburns_effect'] : '';
            $image_url = ! empty( $data['slide_image']['id'] ) ? self::get_slide_image_url( $data['slide_image']['id'], 'imagesize', $settings ) : self::get_el_placeholder_img();
            $image_alt = ! empty( $data['slide_image']['id'] ) ? self::get_image_alt_text( $data['slide_image']['id'] ) : esc_html__( 'Placeholder', 'enova-toolkit' );
            $output = '<div class="slide-img-wrap"><img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $image_alt ) .'" class="slide-img '. esc_attr( $kenburns_cls ) .'" style="'. esc_attr( $kenburns_duration ) .'"/></div>';
        }else{
            $output = '<div class="slide-img-wrap"></div>';
        }
        if( $echo === true ){
            echo $output;
        }else{
            return $output;
        }
    }

    /**
     * Splitting Text Effect
     *
     * @param array $data
     * @param string $text
     * @param string $effect
     * @param boolean $echo
     * @return void
     */
    static function get_splitting_text_effect( $data = [], $text = '', $effect = 'char-top', $echo = true ) {
        $output = '';
        if( ! empty( $text ) ) {
            $output .= 'yes' === $data['text_masking'] ? '<div class="inner-layer">' : '';
            $output .= '<div class="mt-cap '. $effect .'" data-splitting>'. $text .'</div>';
            $output .= 'yes' === $data['text_masking'] ? '</div>' : '';
        }
        if ( $echo === true ) {
            echo wp_kses( $output, self::allowed_html() );
        } else {
            return $output;
        }
    }

    /**
     * Get Slider Text
     *
     * @param string $text
     * @param string $effect
     * @param string $delay
     * @param string $duration
     * @param string $mask
     * @param boolean $echo
     * @return void
     */
    static function get_slider_text( $data = [], $text = '', $effect = 'fadeIn', $delay = '1000', $duration = '800', $echo = true ) {
        $output = '';
        $reveal_text = 'reveal-text' === $effect ? '<span style="animation-delay: '. $delay .'ms; animation-duration: '. $duration .'ms;"></span>' : '';
        if( ! empty( $text ) ) {
            $output .= 'yes' === $data['text_masking'] ? '<div class="inner-layer">' : '';
            $output .= '<div class="mt-cap" '. self::render_animation( $effect, $delay, $duration ) .'>'. $reveal_text . $text .'</div>';
            $output .= 'yes' === $data['text_masking'] ? '</div>' : '';
        }
        if( $echo === true ){
            echo $output;
        }else{
            return $output;
        }
    }

    /**
     * Get Sub Heading
     *
     * @param array $data
     * @return void
     */
    static function get_sub_heading( $data = [] ) {
        $splitting_text = self::is_splitting_effect( $data['sh_animation'] );
        if( ! empty( $data['sub_heading'] ) ) : ?>
            <div class="mt-caption sub-heading">
            <?php
            if( $splitting_text === true ) {
                self::get_splitting_text_effect( $data, $data['sub_heading'], $data['sh_animation'] );
            }else{
                self::get_slider_text( $data, $data['sub_heading'], $data['sh_animation'], $data['sh_anim_delay']['size'], $data['sh_anim_duration']['size'] );
            } ?>
            </div>
        <?php endif;
    }

    /**
     * Get Heading
     *
     * @param array $data
     * @return void
     */
    static function get_heading( $data = [] ) {
        $splitting_text = self::is_splitting_effect( $data['h_animation'] );
        if( ! empty( $data['heading'] ) ) :
            $heading_arr = preg_split ("/\,/", $data['heading'] );
        if( is_array($heading_arr) ) :
        foreach ( $heading_arr as $index => $val  ) :
        ?>
        <div class="mt-caption heading">
        <?php
            if( $splitting_text === true ) {
                self::get_splitting_text_effect( $data, $val, $data['h_animation'] );
            }else{
                self::get_slider_text( $data, $val, $data['h_animation'], ($data['h_anim_delay']['size'] + ( $index * 400 ) ), $data['h_anim_duration']['size'] );
            }
        ?>
        </div>
        <?php 
        endforeach;
        else: ?>
        <div class="mt-caption heading">
        <?php
            if( $splitting_text === true ) {
                self::get_splitting_text_effect( $data, $data['heading'], $data['h_animation'] );
            }else{
                self::get_slider_text( $data, $data['heading'], $data['h_animation'], $data['h_anim_delay']['size'], $data['h_anim_duration']['size'] );
            }
        ?>
        </div>
        <?php 
        endif;
        endif;
    }

    /**
     * Get Description
     *
     * @param array $data
     * @return void
     */
    static function get_description( $data = [] ) {
        $splitting_text = self::is_splitting_effect( $data['d_animation'] );
        if( ! empty( $data['desc'] ) ) : ?>
        <div class="mt-caption desc">
        <?php
            if( $splitting_text === true ) {
                self::get_splitting_text_effect( $data, $data['desc'], $data['d_animation'] );
            }else{
                self::get_slider_text( $data, $data['desc'], $data['d_animation'], $data['d_anim_delay']['size'], $data['d_anim_duration']['size'] );
            }
        ?>
        </div>
        <?php endif;
    }

    /**
     * Get Button
     *
     * @param array $data
     * @return void
     */
    static function get_btn( $data = [] ) {
        if( ! empty( $data['btn_label'] && $data['btn_url']['url'] ) ) {
            $target = $data['btn_url']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $data['btn_url']['nofollow'] ? ' rel="nofollow"' : '';
            $splitting_text = self::is_splitting_effect( $data['btn_animation'] );
            $icon = ! empty( $data['btn_icon']['value'] ) ? ' <i class="'. $data['btn_icon']['value'] .'"></i>' : '';
            if( $splitting_text == true ) {
                $output = '<a href="'. esc_url( $data['btn_url']['url'] ) .'" '. $target . $nofollow .' class="slider-btn" '. self::render_animation( $data['btn_animation'], 0, 0 ) .' data-splitting>'. $data['btn_label'] . $icon . '</a>';
            }else{
                $output = '<a href="'. esc_url( $data['btn_url']['url'] ) .'" '. $target . $nofollow .' class="slider-btn" '. self::render_animation( $data['btn_animation'], $data['btn_anim_delay']['size'], $data['btn_anim_duration']['size'] ) .'>'. $data['btn_label'] . $icon .'</a>';
            }
            echo wp_kses( $output, self::allowed_html() );
        }
    }

    /**
     * Get Secondary Button
     *
     * @param array $data
     * @return void
     */
    static function get_secondary_btn( $data = [] ) {
        if( ! empty( $data['secondary_btn_label'] && $data['secondary_btn_url']['url'] ) ) {
            $target = $data['secondary_btn_url']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $data['secondary_btn_url']['nofollow'] ? ' rel="nofollow"' : '';
            $splitting_text = self::is_splitting_effect( $data['secondary_btn_animation'] );
            $icon = ! empty( $data['secondary_btn_icon']['value'] ) ? ' <i class="'. $data['secondary_btn_icon']['value'] .'"></i>' : '';
            if( $splitting_text == true ) {
                $output = '<a href="'. esc_url( $data['secondary_btn_url']['url'] ) .'" '. $target . $nofollow .' class="slider-secondary-btn" '. self::render_animation( $data['secondary_btn_animation'], 0, 0 ) .' data-splitting>'. $data['secondary_btn_label'] . $icon . '</a>';
            }else{
                $output = '<a href="'. esc_url( $data['secondary_btn_url']['url'] ) .'" '. $target . $nofollow .' class="slider-secondary-btn" '. self::render_animation( $data['secondary_btn_animation'], $data['secondary_btn_anim_delay']['size'], $data['secondary_btn_anim_duration']['size'] ) .'>'. $data['secondary_btn_label'] . $icon .'</a>';
            }
            echo wp_kses( $output, self::allowed_html() );
        }
    }

    /**
     * Get Play Button
     *
     * @param array $data
     * @return void
     */
    static function get_play_btn( $data = [] ) {
        if( ! empty( $data['play_btn_url']['url'] ) ) {
            $target = $data['play_btn_url']['is_external'] ? ' target="_blank"' : '';
		    $nofollow = $data['play_btn_url']['nofollow'] ? ' rel="nofollow"' : '';
            $btn_text = ! empty( $data['play_btn_label'] ) ? '<small>'. $data['play_btn_label'] .'</small>' : '';
            $output = '<a class="dl-play-btn" '. $target . $nofollow .' data-animation="'. $data['play_btn_animation'] .'" data-delay="'. $data['play_btn_anim_delay']['size'] .'ms" data-duration="'. $data['play_btn_anim_delay']['size'] .'ms" href="'. esc_url( $data['play_btn_url']['url'] ) .'"><span class="play-icon"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" width="13" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg></span>'. $btn_text .'</a>';
            echo wp_kses( $output, self::allowed_html() );
        }
    }

    /**
     * Get Slider Shape
     *
     * @param array $data
     * @return void
     */
    static function get_slider_shapes( $data = [] ) {
        $output = '';
        if( 'yes' === $data['slider_shape'] ) {
            
            if( 'angle_shape' === $data['shape_style'] ) {
                $output .= '<div '. self::render_animation( $data['shape_animation'], $data['shape_anim_delay']['size'], $data['shape_anim_duration']['size'] ) .' class="slider-layer '. esc_attr( $data['content_align'] ) .'"></div>';
            }else{
                $output .= '<div class="border-layers"><span></span><span></span><span></span><span></span></div>';
            }
        }
        echo wp_kses( $output, self::allowed_html() );
    }

    /**
     * Gel Slider Image URL
     *
     * @param string $atts_id
     * @param string $size
     * @param [type] $settings
     * @return void
     */
    static function get_slide_image_url( $atts_id = '', $size = 'imagesize', $settings = [] ) {
        if( ! empty( $atts_id ) ) {
            return \Elementor\Group_Control_Image_Size::get_attachment_image_src( $atts_id, $size, $settings );
        }else{
            return '';
        }
    }

    /**
     * Get Elementor Placeholder Image
     *
     * @return void
     */
    static function get_el_placeholder_img(){
        return \Elementor\Utils::get_placeholder_image_src();
    }

    /**
     * Return true if is splitting effect
     *
     * @param string $val
     * @return boolean
     */
    static function is_splitting_effect( $val = '' ) {
        $effects = ['char-top', 'char-right', 'char-bottom', 'char-expand' ];
        if(in_array( $val, $effects, true ) ) {
            return true;
        }
    }

    /**
     * Render Animation
     *
     * @param string $effect
     * @param integer $delay
     * @param integer $duration
     * @return void
     */
    static function render_animation( $effect = 'fadeIn', $delay = 1000, $duration = 1000 ) {
        if( 'none' != $effect && '' != $effect ) {
            $delay_val = ! empty( $delay ) ? $delay.'ms' : '0ms';
            $duration_val = ! empty( $duration ) ? $duration.'ms' : '0ms';
            return 'data-animation="'. $effect .'" data-delay="'. $delay_val .'" data-duration="'. $duration_val .'"';
        }else{
            return '';
        }
    }

    /**
     * Slider Controls
     *
     * @param string $navigation
     * @param string $pagination
     * @param integer $style
     * @return void
     */
    static function get_slider_controls( $navigation = 'yes', $pagination = 'yes', $style = '1', $nav_long_arrow = 'yes', $pagiStyle = '1', $autoplay = 'no' ) {
        if( 'yes' === $navigation || 'yes' === $pagination ) :
            $nav_icon = $nav_long_arrow === 'yes' ? '-long' : '';
            $autoplay_status = 'yes' === $autoplay ? ' autoplay-active' : '';
        ?>
        <div class="mt-slider-controls style-<?php echo esc_attr( $style ) . esc_attr( $autoplay_status ); ?>">
        <?php
            if( 'yes' === $navigation && '1' === $style ) {
                echo '<div class="mt-slider-button-prev">' . wp_kses( self::get_svg_icons()["arrow-left{$nav_icon}"], self::allowed_html() ) . '</div>';
            }
            if( 'yes' === $pagination ) {
                echo '<div class="dl-swiper-pagination pagi-style-'. esc_attr( $pagiStyle ) .'"></div>';
            }
            if( 'yes' === $navigation && '1' === $style ) {
                echo '<div class="mt-slider-button-next">' . wp_kses( self::get_svg_icons()["arrow-right{$nav_icon}"], self::allowed_html() ) . '</div>';
            }
        ?>
        </div>
        <?php
        if( 'yes' === $navigation && '2' === $style ) {
            echo '<div class="mt-slider-button-prev nav-2">' . wp_kses( self::get_svg_icons()["arrow-left{$nav_icon}"], self::allowed_html() ) . '</div>';
        }
        if( 'yes' === $navigation && '2' === $style ) {
            echo '<div class="mt-slider-button-next nav-2">' . wp_kses( self::get_svg_icons()["arrow-right{$nav_icon}"], self::allowed_html() ) . '</div>';
        }
        endif;
    }

}