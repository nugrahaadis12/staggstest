<?php

namespace MT_Addons\includes;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

trait ContentControlSlider {
    /**
     * Slider Settings
     *
     * @return void
     */
    private function section_slider_hero_settings() {

        $this->start_controls_section(
          'section_slider_hero_settings',
          [
              'label'       => esc_html__( 'Carousel/Grid', 'mt-addons' ),
          ]
        );
        $this->add_control(
          'layout',
          [
            'label'         => esc_html__( 'Layout', 'mt-addons' ),
            'label_block'   => true,
            'type'          => Controls_Manager::SELECT,
            'default'       => 'grid',
            'options'       => [
              ''              => esc_html__( 'Select Option', 'mt-addons' ),
              'carousel'      => esc_html__( 'Carousel', 'mt-addons' ),
              'grid'          => esc_html__( 'Grid', 'mt-addons' ),
            ],
          ]
        );
        $this->add_control(
          'items_desktop',
          [
            'label'         => esc_html__( 'Visible Items (Desktop)', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::NUMBER,
            'default'       => 4,
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'items_mobile',
          [
            'label'         => esc_html__( 'Visible Items (Mobiles)', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::NUMBER,
            'default'       => 1,
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'items_tablet',
          [
            'label'         => esc_html__( 'Visible Items (Tablets)', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::NUMBER,
            'default'       => 4,
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'autoplay',
          [
            'label'         => esc_html__( 'AutoPlay', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'delay',
          [
            'label'         => esc_html__( 'Slide Speed (in ms)', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::NUMBER,
            'min'           => 500,
            'max'           => 10000,
            'step'          => 100,
            'default'       => 600,
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'navigation',
          [
            'label'         => esc_html__( 'Navigation', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'navigation_position',
          [
            'label'         => esc_html__( 'Navigation Position', 'mt-addons' ),
            'label_block'   => true,
            'type'          => Controls_Manager::SELECT,
            'default'       => '',
            'options'       => [
              ''                  => esc_html__( 'Select Option', 'mt-addons' ),
              'nav_above_left'    => esc_html__( 'Above Slider Left', 'mt-addons' ),
              'nav_above_center'  => esc_html__( 'Above Slider Center', 'mt-addons' ),
              'nav_above_right'   => esc_html__( 'Above Slider Right', 'mt-addons' ),
              'nav_top_left'      => esc_html__( 'Top Left (In Slider)', 'mt-addons' ),
              'nav_top_center'    => esc_html__( 'Top Center (In Slider)', 'mt-addons' ),
              'nav_top_right'     => esc_html__( 'Top Right (In Slider)', 'mt-addons' ),
              'nav_middle'        => esc_html__( 'Middle Left/Right ( In Slider)', 'mt-addons' ),
              'nav_middle_slider' => esc_html__( 'Middle (Left/Right)', 'mt-addons' ),
              'nav_bottom_left'   => esc_html__( 'Bottom Left (In Slider)', 'mt-addons' ),
              'nav_bottom_center' => esc_html__( 'Bottom Center (In Slider)', 'mt-addons' ),
              'nav_bottom_right'  => esc_html__( 'Bottom Right (In Slider)', 'mt-addons' ),
              'nav_below_left'    => esc_html__( 'Below Slider Left', 'mt-addons' ),
              'nav_below_center'  => esc_html__( 'Below Slider Center', 'mt-addons' ),
              'nav_below_right'   => esc_html__( 'Below Slider Right', 'mt-addons' ),
            ],
            'condition'     => [
              'navigation'    => 'yes',
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'nav_style',
          [
            'label'         => esc_html__( 'Navigation Shape', 'mt-addons' ),
            'label_block'   => true,
            'type'          => Controls_Manager::SELECT,
            'default'       => '',
            'options'       => [
              ''              => esc_html__( 'Select Option', 'mt-addons' ),
              'nav-square'    => esc_html__( 'Square', 'mt-addons' ),
              'nav-rounde'    => esc_html__( 'Rounded (5px Radius)', 'mt-addons' ),
              'nav-round'     => esc_html__( 'Round (50px Radius)', 'mt-addons' ),
            ],
            'condition'     => [
              'navigation'    => 'yes',
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'navigation_color',
          [
            'type'          => \Elementor\Controls_Manager::COLOR,
            'label'         => esc_html__( 'Navigation color', 'mt-addons' ),
            'label_block'   => true,
            'condition'     => [
              'navigation'  => 'yes',
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'navigation_bg_color',
          [
            'type'          => \Elementor\Controls_Manager::COLOR,
            'label'         => esc_html__( 'Navigation Background color', 'mt-addons' ),
            'label_block'   => true,
            'condition'     => [
              'navigation'    => 'yes',
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'navigation_color_hover',
          [
            'type'          => \Elementor\Controls_Manager::COLOR,
            'label'         => esc_html__( 'Navigation Color Hover', 'mt-addons' ),
            'label_block'   => true,
            'selectors'     => [
                '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'color: {{VALUE}};',
            ],
            'condition'     => [
              'navigation'    => 'yes',
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'navigation_bg_color_hover',
          [
            'type'          => \Elementor\Controls_Manager::COLOR,
            'label'         => esc_html__( 'Navigation Background color - Hover', 'mt-addons' ),
            'label_block'   => true,
            'selectors'     => [
                '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'background: {{VALUE}}',
            ],
            'condition'     => [
              'navigation'    => 'yes',
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'pagination',
          [
            'label'         => esc_html__( 'Pagination (dots)', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'         => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'pagination_color',
          [
            'type'          => \Elementor\Controls_Manager::COLOR,
            'label'         => esc_html__( 'Pagination color', 'mt-addons' ),
            'label_block'   => true,
            'selectors'     => [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}',
            ],
            'condition'     => [
              'pagination'    => 'yes',
            ],
          ]
        );
        $this->add_control(
          'space_items',
          [
            'label'         => esc_html__( 'Space Between Items', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::NUMBER,
            'default'       => 30,
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'touch_move',
          [
            'label'         => esc_html__( 'Allow Touch Move', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'grab_cursor',
          [
            'label'         => esc_html__( 'Grab Cursor', 'mt-addons' ),
            'placeholder'   => esc_html__( 'If checked, will show the mouse pointer over the carousel', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'effect',
          [
            'label'         => esc_html__( 'Carousel Effect', 'mt-addons' ),
            'placeholder'   => esc_html__( "See all availavble effects on <a target='_blank' href='https://swiperjs.com/demos#effect-fade'>swiperjs.com</a>", 'mt-addons' ),
            'label_block'   => true,
            'type'          => Controls_Manager::SELECT,
            'default'       => '',
            'options'       => [
              ''               => esc_html__( 'Select Option', 'mt-addons' ),
              'creative'       => esc_html__( 'Creative', 'mt-addons' ),
              'cards'          => esc_html__( 'Cards', 'mt-addons' ),
              'coverflow'      => esc_html__( 'Coverflow', 'mt-addons' ),
              'cube'           => esc_html__( 'Cube', 'mt-addons' ),
              'fade'           => esc_html__( 'Fade', 'mt-addons' ),
              'flip'           => esc_html__( 'Flip', 'mt-addons' ),
            ],
            'condition'     => [
              'layout'         => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'infinite_loop',
          [
            'label'         => esc_html__( 'Infinite Loop', 'mt-addons' ),
            'placeholder'   => esc_html__( 'If checked, will show the numerical value of infinite loop', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'centered_slides',
          [
            'label'         => esc_html__( 'Centered Slides', 'mt-addons' ),
            'placeholder'   => esc_html__( 'If checked, the left side and the right side will have a partial slide visible.', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::SWITCHER,
            'label_on'      => esc_html__( 'Show', 'mt-addons' ),
            'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
            'return_value'  => 'yes',
            'default'       => 'no',
            'condition'     => [
              'layout'        => 'carousel',
            ],
          ]
        );
        $this->add_control(
          'columns',
          [
            'label'         => esc_html__( 'Columns', 'mt-addons' ),
            'label_block'   => true,
            'type'          => Controls_Manager::SELECT,
            'default'       => 'col-md-4',
            'options'       => [
              ''                => esc_html__( 'Select Option', 'mt-addons' ),
              'col-md-12'       => esc_html__( '1 Column', 'mt-addons' ),
              'col-md-6'        => esc_html__( '2 Columns', 'mt-addons' ),
              'col-md-4'        => esc_html__( '3 Columns', 'mt-addons' ),
              'col-md-3'        => esc_html__( '4 Columns', 'mt-addons' ),
              'col-md-2'        => esc_html__( '6 Columns', 'mt-addons' ),
            ],
            'condition'     => [
              'layout'        => 'grid',
            ],
          ]
        );
        $this->end_controls_section();
    }

}
