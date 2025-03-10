<?php

namespace MT_Addons\includes;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

trait ContentControlElementorIcons {
    /**
     * Icon Settings
     *
     * @return void
     */
    private function section_icons_settings() {

        $this->start_controls_section(
          'section_icons_settings',
          [
              'label'     => esc_html__( 'Icons Settings', 'mt-addons' ),
          ]
        );
        $this->add_control(
          'icon_type',
          [
            'label'       => esc_html__( 'Type', 'mt-addons' ),
            'label_block' => true,
            'type'        => Controls_Manager::SELECT,
            'default'     => '',
            'options'     => [
              ''            => esc_html__( 'Select Option', 'mt-addons' ),
              'font_icon'   => esc_html__( 'Font Icon', 'mt-addons' ),
              'image'       => esc_html__( 'Image', 'mt-addons' ),
            ],
          ]
        );
        $this->add_control( 
          'icon_fontawesome',
          [
            'label'       => esc_html__( 'Icon', 'mt-addons' ),
            'type'        => \Elementor\Controls_Manager::ICONS,
            'default'     => [
              'value'       => 'fas fa-star',
              'library'     => 'solid',
            ],
            'condition'   => [
              'icon_type'   => 'font_icon',
            ],
          ]
        );
        $this->add_control(
          'image',
          [
            'label'       => esc_html__( 'Image', 'mt-addons' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'default'     => [
              'url'         => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition'   => [
              'icon_type'   => 'image',
            ],
          ]
        );
        $this->add_control(
            'image_max_width',
            [
              'label'     => esc_html__( 'Image Max Width', 'mt-addons' ),
              'type'      => \Elementor\Controls_Manager::NUMBER,
              'default'   => 50,
              'condition' => [
                'icon_type' => 'image',
              ],
            ]
        );
        $this->add_control(
            'image_margin',
            [
              'label'     => esc_html__( 'Image Margin right', 'mt-addons' ),
              'type'      => \Elementor\Controls_Manager::NUMBER,
              'condition' => [
              'icon_type' => 'image',
          ],
            ]
        );
        $this->add_control(
            'icon_size',
            [
              'label'     => esc_html__( 'Icon Size', 'mt-addons' ),
              'type'      => \Elementor\Controls_Manager::NUMBER,
              'condition' => [
              'icon_type' => 'font_icon',
          ],
            ]
          );
          $this->add_control(
            'icon_color',
            [
              'type'        => \Elementor\Controls_Manager::COLOR,
              'label'       => esc_html__( 'Icon Color', 'mt-addons' ),
              'label_block' => true,
              'condition'   => [
                'icon_type'   => 'font_icon',
              ],
            ]
          );
          $this->add_control(
          'use_svg',
          [
            'label'         => esc_html__( 'SVG Code', 'mt-addons' ),
            'type'          => \Elementor\Controls_Manager::TEXTAREA,
            'rows'          => 10,
            'condition'     => [
              'icon_type'     => 'svg',
            ],
          ]
        );
          $this->add_control(
          'icon_url',
          [
            'label'       => esc_html__( 'Link', 'mt-addons' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'mt-addons' ),
            'default'     => [
              'url'         => '',
              'is_external' => true,
              'nofollow'    => true,
              'custom_attributes' => '',
            ],
            'label_block' => true,
          ]
        );

        $this->end_controls_section();
    }

}