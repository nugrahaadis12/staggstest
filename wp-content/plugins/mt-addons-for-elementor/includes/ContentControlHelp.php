<?php

namespace MT_Addons\includes;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

trait ContentControlHelp {
    /**
     * Slider Settings
     *
     * @return void
     */
    private function section_help_settings() {

        $this->start_controls_section(
          'section_help_hero_settings',
          [
              'label'       => esc_html__( 'Help', 'mt-addons' ),
          ]
        );

        if(!empty($this->get_name())) {
          $get_name = str_replace('mtfe-', '', $this->get_name());
          $this->add_control(
            'widget_showcase',
            [
              'type'          => \Elementor\Controls_Manager::RAW_HTML,
              'raw'           => '<a target="_blank" href="'.esc_url('https://mt-addons.modeltheme.com/'.esc_html($get_name).'/').'"><i class="eicon-favorite" aria-hidden="true"></i> '.esc_html__('Widget Presentation','mt-addons').'</a>',
            ]
          );
        }
        $this->add_control(
          'more_widgets',
          [
            'type'          => \Elementor\Controls_Manager::RAW_HTML,
            'raw'           => '<a target="_blank" href="'.esc_url('https://mt-addons.modeltheme.com/elementor-widgets/').'"><i class="eicon-check-circle" aria-hidden="true"></i> '.esc_html__('More Free Widgets','mt-addons').'</a>',
          ]
        );
        $this->add_control(
          'get_support',
          [
            'type'          => \Elementor\Controls_Manager::RAW_HTML,
            'raw'           => '<a target="_blank" href="'.esc_url('https://modeltheme.ticksy.com/submit/#100022324/').'"><i class="eicon-mail" aria-hidden="true"></i> '.esc_html__('Get Support','mt-addons').'</a>',
          ]
        );
        $this->add_control(
          'leave_review',
          [
            'type'          => \Elementor\Controls_Manager::RAW_HTML,
            'raw'           => '<a target="_blank" href="'.esc_url('https://wordpress.org/plugins/mt-addons-for-elementor/#reviews/').'"><i class="eicon-star" aria-hidden="true"></i> '.esc_html__('Leave us a review!','mt-addons').'</a>',
          ]
        );
        $this->end_controls_section();
    }

}
