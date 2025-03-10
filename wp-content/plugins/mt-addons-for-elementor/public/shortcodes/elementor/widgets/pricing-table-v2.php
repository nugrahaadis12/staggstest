<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_pricing_table_v2 extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-pricing-table-v2', MT_ADDONS_PUBLIC_ASSETS.'css/pricing-table-v2.css');
        return [
            'mt-addons-pricing-table-v2',
        ];
    }

    public function get_name()
    {
        return 'mtfe-pricing-table-v2';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Pricing Table', 'mt-addons');
    } 

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'pricing', 'table', 'highlight', 'custom' ];
    }

    protected function register_controls() {
        $this->section_pricing_table();
        $this->section_help_settings();
    }

    private function section_pricing_table() {
        $this->start_controls_section(
            'section_title',
            [
                'label'             => esc_html__('Title', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title',
            [
                'label'             => esc_html__('Title', 'mt-addons'),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__('Premium', 'mt-addons'),
            ]
        );
        $this->add_control(
            'tag_select',
            [
                'label'             => esc_html__('Tag Select', 'mt-addons'),
                'label_block'       => true,
                'type'              => \Elementor\Controls_Manager::SELECT,
                'options'           => [
                    ''                  => esc_html__( 'Default', 'mt-addons' ),
                    'h1'                => esc_html__( 'H1', 'mt-addons' ),
                    'h2'                => esc_html__( 'H2', 'mt-addons' ),
                    'h3'                => esc_html__( 'H3', 'mt-addons' ),
                    'h4'                => esc_html__( 'H4', 'mt-addons' ),
                    'h5'                => esc_html__( 'H5', 'mt-addons' ),
                    'h6'                => esc_html__( 'H6', 'mt-addons' ),
                    'p'                 => esc_html__( 'p', 'mt-addons' ),
                ],
                'default'               => 'h1',
            ]
        );
        $this->add_control(
            'title_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'default'           => 'left',
                'toggle'            => true,
                 'selectors'        => [
                    '{{WRAPPER}} .mt-package-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'content_typography',
                'selector'          => '{{WRAPPER}} .price-title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .price-title' => 'color: {{VALUE}}',
                ],
                'default'           => '#0A102F',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_price',
            [
                'label'             => esc_html__('Price', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'currency',
            [
                'label'             => esc_html__('Currency', 'mt-addons'),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__('$', 'mt-addons'),
            ]
        );
        $this->add_control(
            'price',
            [
                'label'             => esc_html__('Price', 'mt-addons'),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'default'           => 200,
            ]
        );
        $this->add_control(
            'period',
            [
                'label'             => esc_html__('Period', 'mt-addons'),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__('mo', 'mt-addons'),
            ]
        );
        $this->add_control(
            'price_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'default'           => 'left',
                'toggle'            => true,
                'selectors'         => [
                    '{{WRAPPER}} .mt-package-price' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'price_typography',
                'selector'          => '{{WRAPPER}} .cd-value-year',
                'fields_options'    => [
                    'typography'        => ['default' => 'yes'],
                    'font_size'         => ['default' => ['size' => 32]],
                    'font_weight'       => ['default' => 700],
                ],
            ]
        );
        $this->add_control(
            'price_color',
            [
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .cd-value-year' => 'color: {{VALUE}}',
                ],
                'default'           => '#027BFF',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'period_typography',
                'selector'          => '{{WRAPPER}} .cd-duration',
            ]
        );
        $this->add_control(
            'separator_color',
            [
                'label'             => esc_html__( 'Separator Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-package-price' => 'border-color: {{VALUE}}',
                ],
                'default'           => '#ececec',
            ]
        );
        $this->add_control(
            'price_separator_color',
            [
                'label'             => esc_html__( 'Price Separator Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .line' => 'color: {{VALUE}} !important',
                ],
                'default'           => '#ececec',
            ]
        );
        $this->add_control(
            'period_color',
            [
                'label'             => esc_html__( 'Period Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .cd-duration' => 'color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label'             => esc_html__( 'Button', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_button',
            [
                'label'             => esc_html__( 'Show Button', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SWITCHER,
                'label_on'          => esc_html__( 'Show', 'mt-addons' ),
                'label_off'         => esc_html__( 'Hide', 'mt-addons' ),
                'return_value'      => 'yes',
                'default'           => 'yes',
            ]
        );
        $this->add_control(
            'button_inside',
            [
                'label'             => esc_html__( 'Button Inside Container', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SWITCHER,
                'label_on'          => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'         => esc_html__( 'No', 'mt-addons' ),
                'return_value'      => 'yes',
                'default'           => 'yes',
                'condition'         => [
                    'show_button'       => 'yes',
                ],
            ]
        );
        $this->add_control(
            'button_title',
            [
                'label'             => esc_html__( 'Button Title', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( 'Get Started', 'mt-addons' ),
                'condition'         => [
                    'show_button'       => 'yes',
                ],
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label'             => esc_html__( 'Link', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::URL,
                'placeholder'       => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'options'           => [ 'url', 'is_external', 'nofollow' ],
                'condition'         => [
                    'show_button'       => 'yes',
                ],
                'default'           => [
                    'url'               => '',
                    'is_external'       => true,
                    'nofollow'          => true,
                ],
                'label_block'       => true,
            ]
        );
        $this->add_control(
            'text_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'flex-start'        => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'flex-end'          => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'default'           => 'flex-start',
                'toggle'            => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'button_content_typography',
                'selector'          => '{{WRAPPER}} .mt-btn',
            ]
        );
        $this->add_group_control(
            'box-shadow',
            [
                'name'              => 'button_content_box_shadow',
                'selector'          => '{{WRAPPER}} .mt-btn',
            ]
        );
        $this->add_control(
            'border-radius',
            [
                'label'             => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'default'           => [
                    'top'               => 30,
                    'right'             => 30,
                    'bottom'            => 30,
                    'left'              => 30,
                    'unit'              => 'px',
                    'isLinked'          => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'              => 'border',
                'label'             => esc_html__( 'Border Button', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mt-btn',
            ]
        );
        $this->add_control(
            'button_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'default'           => [
                    'top'               => 12,
                    'right'             => 30,
                    'bottom'            => 12,
                    'left'              => 30,
                    'unit'              => 'px',
                    'isLinked'          => false,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'selectors'         => [
                    '{{WRAPPER}} .mt-btn' => 'color: {{VALUE}}',
                ],
                'default'           => '#FFFFFF',
            ]
        );
        $this->add_control(
            'button_text_color_hover',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Color Hover', 'mt-addons' ),
                'selectors'         => [
                    '{{WRAPPER}} .mt-btn:hover' => 'color: {{VALUE}}',
                ],
                'default'           => '#FFFFFF',
            ]
        );
        $this->add_control(
            'button_background_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Background', 'mt-addons' ),
                'selectors'         => [
                    '{{WRAPPER}} .mt-btn' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#027BFF',
            ]
        );
        $this->add_control(
            'button_background_color_hover',
            [
                'label'             => esc_html__( 'Background Hover', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-btn:hover' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_card_style',
            [
                'label'             => esc_html__('Card Style', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'card_color',
            [
                'label'             => esc_html__( 'Background', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .price-table-container' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'              => 'border_container',
                'selector'          => '{{WRAPPER}} .price-table-container',
            ]
        );
        $this->add_control(
            'card_border',
            [
                'label'             => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default'           => [
                    'top'               => 30,
                    'right'             => 30, 
                    'bottom'            => 30,
                    'left'              => 30,
                    'unit'              => 'px',
                ],
                'selectors'         => [
                    '{{WRAPPER}} .price-table-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'card_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default'           => [
                    'top'               => 30,
                    'right'             => 30, 
                    'bottom'            => 70,
                    'left'              => 30,
                    'unit'              => 'px',
                ],
                'selectors'         => [
                    '{{WRAPPER}} .price-table-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'card_box_shadow',
                'label'             => esc_html__( 'Box Shadow', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .price-table-container',
                'fields_options'    =>
                    [
                        'box_shadow_type' =>
                        [ 
                            'default' =>'yes' 
                        ],
                        'box_shadow' => [
                            'default' =>
                                [
                                    'horizontal' => 0,
                                    'vertical' => 0,
                                    'blur' => 25,
                                    'spread' => 0,
                                    'color' => 'rgba(0,0,0,0.15)'
                                ]
                        ]
                    ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'card_box_shadow_hover',
                'label'             => esc_html__( 'Box Shadow Hover', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .price-table-container:hover',
                'fields_options'    =>
                    [
                        'box_shadow_type' =>
                        [ 
                            'default' =>'yes' 
                        ],
                        'box_shadow' => [
                            'default' =>
                                [
                                    'horizontal' => 0,
                                    'vertical' => 0,
                                    'blur' => 25,
                                    'spread' => 0,
                                    'color' => 'rgba(0,0,0,0.3)'
                                ]
                        ]
                    ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'repeater_section',
            [
                'label'             => esc_html__( 'List', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'             => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .package-list-icon' => 'color: {{VALUE}}',
                ],
                'default'           => '#7cafff',
            ]
        );
        $this->add_control(
            'package_color',
            [
                'label'             => esc_html__( 'Text Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .package-list-text' => 'color: {{VALUE}}',
                ],
                'default'           => '#111111',
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'icon',
            [
                'label'             => esc_html__( 'Icon', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::ICONS,
                'default'           => [
                    'value'             => 'fas fa-star',
                    'library'           => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'package_text',
            [
                'label'             => esc_html__('Package Text', 'mt-addons'),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__('Package Text', 'mt-addons'),
            ]
        );
        $this->add_control(
            'list',
            [
                'label'             => esc_html__( 'List Items', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::REPEATER,
                'fields'            => $repeater->get_controls(),
                'default'           => [
                    [
                        'icon'          => esc_html__( 'fas fa-star', 'mt-addons' ),
                        'package_text'  => esc_html__( '1 Job', 'mt-addons' ),
                    ],
                    [
                        'icon'          => esc_html__( 'fas fa-star', 'mt-addons' ),
                        'package_text'  => esc_html__( '3 Brand Deals', 'mt-addons' ),
                    ],
                    [
                        'icon'          => esc_html__( 'fas fa-star', 'mt-addons' ),
                        'package_text'  => esc_html__( '1 Campaign Runs', 'mt-addons' ),
                    ],
                ],
                'title_field'       => '',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings                   = $this->get_settings_for_display();
        $title                      = isset($settings['title'])?$settings['title']:"";
        $tag_select                 = isset($settings['tag_select'])?$settings['tag_select']:"";
        $currency                   = isset($settings['currency'])?$settings['currency']:"";
        $period                     = isset($settings['period'])?$settings['period']:"";
        $price                      = isset($settings['price'])?$settings['price']:"";
        $title_align                = isset($settings['title_align'])?$settings['title_align']:"";
        $price_align                = isset($settings['price_align'])?$settings['price_align']:"";
        $list                       = isset($settings['list'])?$settings['list']:"";
        $button_title               = isset($settings['button_title'])?$settings['button_title']:"";
        $button_align               = isset($settings['text_align'])?$settings['text_align']:"";
        $button_link                = isset($settings['button_link']['url'])?$settings['button_link']['url']:"";
        $card_border                = isset($settings['card_border'])?$settings['card_border']:"";
        $card_padding               = isset($settings['card_padding'])?$settings['card_padding']:"";
        $button_inside              = isset($settings['button_inside'])?$settings['button_inside']:"";
        $button_absolute_class      = '';

        if($button_inside != 'yes') {
            $button_absolute_class = 'mt-addons-absolute-class';
        }


        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_link_attributes( 'button_link', $settings['button_link'] );
        }

        ?>
        
        <div class="price-table-container elementor-repeater-item  <?php echo esc_attr( $button_absolute_class); ?>">
            <div class="mt-package-title">
                <<?php echo esc_attr($tag_select); ?> class="price-title">
                    <?php echo esc_html($title); ?>
                </<?php echo Utils::validate_html_tag( $tag_select ); ?>>
            </div>
            <div class="mt-package-price">
                <span class="cd-value-year">
                    <sup><?php echo esc_html($currency); ?></sup>
                    <?php echo esc_html($price); ?>
                    <span class="line">/</span>
                </span>
                <span class="cd-duration"><?php echo esc_html($period); ?></span>
            </div>
            <div class="mt-package-list">
                <ul>
                    <?php
                    if ($list) {
                        foreach ( $list as $feature ) {
                            $icon = $feature['icon']['value'];
                            $package_text = $feature['package_text'];
                            ?>
                            <li class="package-list-item elementor-repeater-item">
                                <i class="package-list-icon <?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                                <span class="package-list-text"><?php echo esc_html($package_text); ?></span>
                            </li><?php 
                        }
                    } ?>
                </ul>
            </div>
            <div class="mt-btn-zone">
                <?php if ( 'yes' === $settings['show_button'] ) { ?>
                    <a class="mt-btn" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_title); ?></a>
                <?php } ?>
            </div>
        </div>
        
    <?php
    }
    protected function content_template() {}
}

