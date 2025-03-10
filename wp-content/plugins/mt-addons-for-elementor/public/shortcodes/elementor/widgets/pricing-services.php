<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_pricing_services extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-pricing-services', MT_ADDONS_PUBLIC_ASSETS.'css/pricing-services.css');
        return [
            'mt-addons-pricing-services',
        ];
    }

    public function get_name()
    {
        return 'mtfe-pricing-services';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Pricing Services', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'prcing', 'services', 'highlight', 'custom' ];
    }

    protected function register_controls() {
        $this->section_pricing_services();
        $this->section_help_settings();
    }

    private function section_pricing_services() {
        $this->start_controls_section(
            'container_section',
            [
                'label'         => esc_html__( 'Container', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title',
            [
                'label'         => esc_html__( 'Title', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'Biochemistry Investigations', 'mt-addons' ),
            ]
        );
        $this->add_control (
            'title_tag',
            [
                'label'         => esc_html__('Tag', 'mt-addons'),
                'label_block'   => true,
                'type'          => \Elementor\Controls_Manager::SELECT,
                'options'       => [
                    ''              => esc_html__('Select', 'mt-addons'),
                    'h1'            => esc_html__('h1', 'mt-addons'),
                    'h2'            => esc_html__('h2', 'mt-addons'),
                    'h3'            => esc_html__('h3', 'mt-addons'),
                    'h4'            => esc_html__('h4', 'mt-addons'),
                    'h5'            => esc_html__('h5', 'mt-addons'),
                    'h6'            => esc_html__('h6', 'mt-addons'),
                    'p'             => esc_html__('p', 'mt-addons'),
                ],
                'default'       => 'h2',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'         => esc_html__( 'Typography', 'mt-addons' ),
                'name'          => 'content_typography',
                'selector'      => '{{WRAPPER}} .mt-price-title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'         => esc_html__( 'Color', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-price-title' => 'color: {{VALUE}}',
                ],
                'default'       => '#ffffff',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'          => 'background',
                'types'         => [ 'classic', 'gradient', 'video' ],
                'selector'      => '{{WRAPPER}} .mt-addons-title-pricing',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label'         => esc_html__( 'Button', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_button',
            [
                'label'         => esc_html__( 'Show Button', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mt-addons' ),
                'label_off'     => esc_html__( 'Hide', 'mt-addons' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );
        $this->add_control(
            'button_title',
            [
                'label'         => esc_html__( 'Button Title', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'Shop Now', 'mt-addons' ),
                'condition'     => [
                    'show_button' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__( 'Link', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'options'       => [ 'url', 'is_external', 'nofollow' ],
                'condition'     => [
                    'show_button' => 'yes',
                ],
                'default'       => [
                    'url'           => '',
                    'is_external'   => true,
                    'nofollow'      => true,
                ],
                'label_block'   => true,
            ]
        );
        $this->add_control(
            'button_align',
            [
                'label'         => esc_html__( 'Alignment', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'    => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'flex-end'      => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                 'selectors'        => [
                    '{{WRAPPER}} .mt-addons-btn-zone' => 'justify-content: {{VALUE}}',
                ],
                'default'       => 'center',
                'toggle'        => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'button_typography',
                'selector'      => '{{WRAPPER}} .mt-addons-pricing-btn',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'          => 'button_border',
                'label'         => esc_html__( 'Border Button', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-pricing-btn',
            ]
        );
        $this->add_control(
            'button_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-pricing-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 30,
                    'right'         => 30,
                    'bottom'        => 30,
                    'left'          => 30,
                ],
            ]
        );
        $this->add_control(
            'button_padding',
            [
                'label'         => esc_html__( 'Padding', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-pricing-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 12,
                    'right'         => 25,
                    'bottom'        => 12,
                    'left'          => 25,
                ],
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-pricing-btn' => 'color: {{VALUE}}',
                ],
                'default'       => '#ffffff',
            ]
        );
        $this->add_control(
            'button_text_color_hover',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Color Hover', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-pricing-btn:hover' => 'color: {{VALUE}}',
                ],
                'default'       => '#ffffff',
            ]
        );
        $this->add_control(
            'button_background_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Background', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-pricing-btn' => 'background-color: {{VALUE}}',
                ],
                'default'       => '#AC2AD0',
            ]
        );
        $this->add_control(
            'button_background_color_hover',
            [
                'label'         => esc_html__( 'Background Hover', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-pricing-btn:hover' => 'background-color: {{VALUE}}',
                ],
                'default'       => '#000000',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'repeater_section',
            [
                'label'         => esc_html__( 'List Items', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'service_name', [
                'label'         => esc_html__( 'Service Name', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'Service Name' , 'mt-addons' ),
                'label_block'   => true,
            ]
        );
        $repeater->add_control(
            'service_price', [
                'label'         => esc_html__( 'Service Price', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( '$69' , 'mt-addons' ),
                'label_block'   => true,
            ]
        );
        $this->add_control(
            'list',
            [
                'label'         => esc_html__( 'List Items', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'default'       => [
                    [
                        'service_name'  => esc_html__( 'Microalbuminuria', 'mt-addons' ),
                        'service_price' => esc_html__( '10$', 'mt-addons' ),
                    ],
                    [
                        'service_name'  => esc_html__( 'Direct Bilirubin', 'mt-addons' ),
                        'service_price' => esc_html__( '20$', 'mt-addons' ),
                    ],
                    [
                        'service_name'  => esc_html__( 'Indirect Bilirubin', 'mt-addons' ),
                        'service_price' => esc_html__( '30$', 'mt-addons' ),
                    ],
                    [
                        'service_name'  => esc_html__( 'Total Bilirubin', 'mt-addons' ),
                        'service_price' => esc_html__( '25$', 'mt-addons' ),
                    ],
                    [
                        'service_name'  => esc_html__( 'Clearance Creatinine', 'mt-addons' ),
                        'service_price' => esc_html__( '25$', 'mt-addons' ),
                    ],
                    [
                        'service_name'  => esc_html__( 'Microalbuminuria', 'mt-addons' ),
                        'service_price' => esc_html__( '15$', 'mt-addons' ),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'list_style',
            [
                'label'         => esc_html__( 'List Style', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'list_color',
            [
                'label'         => esc_html__( 'List Background', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .price-list-container' => 'background-color: {{VALUE}}',
                ],
                'default'       => '#ffffff',
            ]
        );
        $this->add_control(
            'service_color',
            [
                'label'         => esc_html__( 'Service Color', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-service' => 'color: {{VALUE}}',
                ],
                'default'       => '#000000',
            ]
        );
        $this->add_control(
            'price_color',
            [
                'label'         => esc_html__( 'Price Color', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-service-price' => 'color: {{VALUE}}',
                ],
                'default'       => '#000000',
            ]
        );
        $this->end_controls_section();

    }
    protected function render() {
        $settings       = $this->get_settings_for_display();
        $title          = $settings['title'];
        $title_tag      = $settings['title_tag'];
        $list           = $settings['list'];
        $button_title   = $settings['button_title'];
        
        if ( ! empty( $settings['button_link']['url'] ) ) {
            $button_link = $settings['button_link']['url'];
            $this->add_link_attributes( 'button_link', $settings['button_link'] );
        }
        ?>
        <div class="mt-addons-services-container">
            <div class="mt-addons-price-container">
                <div class="mt-addons-title-pricing">
                    <<?php echo Utils::validate_html_tag( $title_tag ); ?> class="mt-addons-price-title"><?php echo esc_html($title); ?></<?php echo Utils::validate_html_tag( $title_tag ); ?>>
                </div>
                <div class="mt-addons-price-list-container">
                    <ul class="mt-addons-price-list">
                        <?php foreach (  $list as $item ) {
                            $service_name   = $item['service_name'];
                            $service_price  = $item['service_price']; ?>

                            <li class="mt-addons-price-list-item">
                                <span class="mt-addons-service-name"><?php echo esc_html($service_name); ?></span>
                                <strong class="mt-addons-service-price"><?php echo  esc_html($service_price); ?></strong>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="mt-addons-btn-zone">
                        <?php
                        if ( 'yes' === $settings['show_button'] ) { ?>
                          <a class="mt-addons-pricing-btn" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_title); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}