<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_absolute_element extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-absolute-element', MT_ADDONS_PUBLIC_ASSETS.'css/absolute-element.css');
        return [
            'mt-addons-absolute-element',
        ];
    }  
    use ContentControlHelp;
    public function get_name() {
        return 'mtfe-absolute-element'; 
    }
    public function get_title() {
        return esc_html__('MT - Absolute Element','mt-addons');
    }
    public function get_icon() {
        return 'eicon-elementor-circle';
    }
    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }
    protected function register_controls() {
        $this->section_absolute_element();
        $this->section_help_settings();
    }
    private function section_absolute_element() {
        $this->start_controls_section(
            'section_title',
            [
                'label'             => esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'image_border_radius',
            [
                'label'             => esc_html__( 'Image Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-absolute-element-absolute' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 0,
                    'right'             => 0,
                    'bottom'            => 0,
                    'left'              => 0,
                ],
            ]
        );
        $this->add_control(
            'image', 
            [
                'label'             => esc_html__( 'Element Image', 'plugin-name' ),
                'type'              => \Elementor\Controls_Manager::MEDIA,
                'default'           => [
                    'url'               => MT_ADDONS_ASSETS.'/placeholder.png',
                ],
            ]
        );
        $this->add_control(
            'height_value',
            [
                'label'             => esc_html__( 'Element Height', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-absolute-element-absolute' => 'height: {{VALUE}}px;',
                ],
                'default'           => 300,
            ]
        );
        $this->add_control( 
            'left_percent',
            [
                'label'             => esc_html__( "Left (%) - Do not write the '%'", 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-absolute-element-absolute' => 'left: {{VALUE}}%;',
                ],
                'default'           => 0,
            ]
        );
        $this->add_control(
            'top_percent',
            [
                'label'             => esc_html__("Top (%) - Do not write the '%'", 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                   'selectors'      => [
                    '{{WRAPPER}} .mt-addons-absolute-element-absolute' => 'top: {{VALUE}}px;',
                ],
                'default'           => 0,
            ]
        );
        $this->add_control(
            'enable_animation',
            [
                'label'             => esc_html__( 'Image Animation', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SWITCHER,
                'label_on'          => esc_html__( 'Show', 'mt-addons' ),
                'label_off'         => esc_html__( 'Hide', 'mt-addons' ),
                'return_value'      => 'yes',
                'default'           => 'yes',
            ]
        );
        $this->add_control(
            'animation_type',
            [
                'label'             => esc_html__( 'Animation Type', 'mt-addons' ),
                'label_block'       => true,
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    ''                  => esc_html__( 'Select', 'mt-addons' ),
                    'rotate'            => esc_html__( 'Rotate', 'mt-addons' ),
                    'float'             => esc_html__( 'Float', 'mt-addons' ),
                ],
                'default'           => 'float',
                'condition'         => [
                    'enable_animation'  => 'yes',
                ],
            ]
        );
        $this->end_controls_section();

    
    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $image_url      = $settings['image']['url'];
        $animation_type = $settings['animation_type'];
        ?>

        <img class="mt-addons-absolute-element-absolute <?php echo esc_attr($animation_type); ?>" src="<?php echo esc_url($image_url); ?>" alt="mt-addons-absolute-image"/>
        
    <?php
    }

    protected function content_template() {
    }
}