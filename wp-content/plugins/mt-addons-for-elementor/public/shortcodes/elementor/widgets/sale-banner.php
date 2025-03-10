<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_sale_banner extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-sale-banner', MT_ADDONS_PUBLIC_ASSETS.'css/sale-banner.css');
        return [
            'mt-addons-sale-banner',
        ];
    }

    public function get_name()
    {
        return 'mtfe-sale-banner';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Sale Banner', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-price-list';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'discount', 'sale', 'banner', 'highlight', 'custom' ];
    }

    protected function register_controls() {
        $this->section_sale_banner();
        $this->section_help_settings();
    }

    private function section_sale_banner() {
        $this->start_controls_section(
            'section_bg',
            [
                'label'         => esc_html__('Container', 'mt-addons'),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'          => 'container_background',
                'label'         => esc_html__( 'Container Background', 'mt-addons' ),
                'types'         => [ 'classic', 'gradient', 'video' ],
                'selector'      => '{{WRAPPER}} .mt-discount-container, {{WRAPPER}} .mt-discount-container.mt-discount-container-hover::before',
            ]
        );
        $this->add_control(
            'container_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .mt-discount-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 0,
                    'bottom'        => 0,
                    'left'          => 0,
                ],
            ]
        );
        $this->add_responsive_control(
            'container_padding',
            [
                'label'         => esc_html__( 'Container Padding', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .mt-discount-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 50,
                    'right'         => 30,
                    'bottom'        => 50,
                    'left'          => 30,
                ],
            ]
        );
        $this->add_control(
            'hover_effect',
            [
                'label'         => esc_html__( 'Hover Effect?', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'     => esc_html__( 'No', 'mt-addons' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_title',
            [
                'label'         => esc_html__('Title Section', 'mt-addons'),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label'         => esc_html__( 'Show Title', 'plugin-name' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'your-plugin' ),
                'label_off'     => esc_html__( 'Hide', 'your-plugin' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        $this->add_control(
            'title',
            [
                'label'         => esc_html__( 'Title', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'Free Shipping', 'mt-addons' ),
                'placeholder'   => esc_html__( 'Type your title here', 'mt-addons' ),
                'condition'     => [
                    'show_title'    => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'margin_title',
            [
                'label'         => esc_html__( 'Title Spacing', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .first-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'show_title'    => 'yes',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 0,
                    'bottom'        => 0,
                    'left'          => 0,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_subtitle',
            [
                'label'         => esc_html__('Subtitle Section', 'mt-addons'),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_subtitle',
            [
                'label'         => esc_html__( 'Show Subtitle', 'plugin-name' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'your-plugin' ),
                'label_off'     => esc_html__( 'Hide', 'your-plugin' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        $this->add_control(
            'subtitle',
            [
                'label'         => esc_html__( 'Subtitle', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'Health Boost Sale: Unbeatable Deals on Medical Essentials!', 'mt-addons' ),
                'placeholder'   => esc_html__( 'Type your title here', 'mt-addons' ),
                'condition'     => [
                    'show_subtitle' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'margin_subtitle',
            [
                'label'         => esc_html__( 'Subtitle Spacing', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .second-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'show_subtitle' => 'yes',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 0,
                    'bottom'        => 20,
                    'left'          => 0,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_paragraph',
            [
                'label'         => esc_html__('Paragraph Section', 'mt-addons'),
                'tab'           => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_paragraph',
            [
                'label'         => esc_html__( 'Show Paragraph', 'plugin-name' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'your-plugin' ),
                'label_off'     => esc_html__( 'Hide', 'your-plugin' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        $this->add_control(
            'paragraph',
            [
                'label'         => esc_html__( 'Paragraph', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'Get healthy savings on essential medical supplies! Our sale features a wide range of top-quality products to support your wellness needs.', 'mt-addons' ),
                'placeholder'   => esc_html__( 'Type your title here', 'mt-addons' ),
                'condition'     => [
                    'show_paragraph' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'margin_paragraph',
            [
                'label'         => esc_html__( 'Paragraph Spacing', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .third-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'show_paragraph' => 'yes',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 0,
                    'bottom'        => 30,
                    'left'          => 0,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_btn',
            [
                'label'         => esc_html__('Button Section', 'mt-addons'),
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
                'default'       => 'yes',
            ]
        );
        $this->add_control (
            'btn_title', [
                'label'         => esc_html__( 'Button Title', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'default'       => esc_html__( 'SHOP NOW' , 'mt-addons' ),
                'label_block'   => true,
                'condition'     => [
                    'show_button'   => 'yes',
                ],
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__( 'Button Link', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'options'       => [ 'url', 'is_external', 'nofollow' ],
                'default'       => [
                    'url'           => '',
                    'is_external'   => true,
                    'nofollow'      => true,
                ],
                'label_block'   => true,
                'condition'     => [
                    'show_button'   => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'title_style',
            [
                'label'         => esc_html__('Title Style', 'mt-addons'),
                'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'show_title'    => 'yes',
                ],
            ]
        );
        $this->add_control(
            'title_align',
            [
                'label'         => esc_html__( 'Alignment', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::CHOOSE,
                'options'       => [
                    'left'          => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'         => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .first-text' => 'text-align: {{VALUE}};',
                ],
                'default'           => 'left',
                'toggle'            => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'title_typography',
                'selector'          => '{{WRAPPER}} .first-text',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Title Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .first-text' => 'color: {{VALUE}}',
                ],
                'default'           => 'rgb(0, 0, 0)',
            ]
        );
        $this->add_responsive_control(
            'title_width',
            [
                'label'             => esc_html__( 'Title Width', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 1,
                'max'               => 100,
                'step'              => 1,
                'default'           => 100,
                'selectors'         => [
                    '{{WRAPPER}} .first-text' => 'width: {{VALUE}}%',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'subtitle_style',
            [
                'label'             => esc_html__('Subtitle Style', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'show_subtitle'     => 'yes',
                ],
            ]
        );
        $this->add_control(
            'subtitle_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'             => esc_html__( 'Left', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'             => esc_html__( 'Center', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'             => esc_html__( 'Right', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .second-text' => 'text-align: {{VALUE}};',
                ],
                'default'           => 'left',
                'toggle'            => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'subtitle_typography',
                'selector'          => '{{WRAPPER}} .second-text',
            ]
        );
        $this->add_control(
            'text_color_2',
            [
                'label'             => esc_html__( 'Subtitle Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .second-text' => 'color: {{VALUE}}',
                ],
                'default'           => 'rgb(0, 0, 0)',
            ]
        );
        $this->add_responsive_control(
            'subtitle_width',
            [
                'label'             => esc_html__( 'Subtitle Width', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 1,
                'max'               => 100,
                'step'              => 1,
                'default'           => 100,
                'selectors'         => [
                    '{{WRAPPER}} .second-text' => 'width: {{VALUE}}%',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'paragraph_style',
            [
                'label'             => esc_html__('Paragraph Section', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'show_paragraph'    => 'yes',
                ],
            ]
        );
        $this->add_control(
            'paragraph_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'             => esc_html__( 'Left', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'             => esc_html__( 'Center', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'             => esc_html__( 'Right', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .third-text' => 'text-align: {{VALUE}};',
                ],
                'default'           => 'left',
                'toggle'            => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'paragraph_typography',
                'selector'          => '{{WRAPPER}} .third-text',
            ]
        );
        $this->add_control(
            'paragraph_color',
            [
                'label'             => esc_html__( 'Paragraph Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .third-text' => 'color: {{VALUE}}',
                ],
                'default'           => 'rgb(0, 0, 0)',
            ]
        );
        $this->add_responsive_control(
            'paragraph_width',
            [
                'label'             => esc_html__( 'Paragraph Width', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 1,
                'max'               => 100,
                'step'              => 1,
                'default'           => 100,
                'selectors'         => [
                    '{{WRAPPER}} .third-text' => 'width: {{VALUE}}%',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'button_style_section',
            [
                'label'             => esc_html__( 'Button Style', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'show_button'       => 'yes',
                ],
            ]
        );
        $this->add_control(
            'button_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'flex-start'        => [
                        'title'             => esc_html__( 'Left', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'             => esc_html__( 'Center', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-center',
                    ],
                    'flex-end'          => [
                        'title'             => esc_html__( 'Right', 'mt-addons' ),
                        'icon'              => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .discount-btn-zone' => 'justify-content: {{VALUE}};',
                ],
                'default'           => 'flex-start',
                'toggle'            => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'button_typography',
                'selector'          => '{{WRAPPER}} .discount-btn',
                'field_options'     => [
                    'font_size'         => [
                        'default'           => [
                            'size'          => '16',
                            'unit'          => 'px',
                        ],
                    ],
                    'font_weight'       => [
                        'default'           => '600',
                    ],
                ],
            ]
        );
        $this->add_control(
            'button-border-radius',
            [
                'label'             => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .discount-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 30,
                    'right'             => 30,
                    'bottom'            => 30,
                    'left'              => 30,
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'              => 'border',
                'label'             => esc_html__( 'Border Button', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .discount-btn',
            ]
        );
        $this->add_responsive_control(
            'padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .discount-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 10,
                    'right'             => 25,
                    'bottom'            => 10,
                    'left'              => 25,
                ],
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'selectors'         => [
                    '{{WRAPPER}} .discount-btn' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_control(
            'button_text_color_hover',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Color Hover', 'mt-addons' ),
                'selectors'         => [
                    '{{WRAPPER}} .discount-btn:hover' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_control(
            'button_background_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Background', 'mt-addons' ),
                'selectors'         => [
                    '{{WRAPPER}} .discount-btn' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#8F80AF',
            ]
        );
        $this->add_control(
            'button_background_color_hover',
            [
                'label'             => esc_html__( 'Background Hover', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .discount-btn:hover' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->end_controls_section();
    }
    protected function render() {
        $settings       = $this->get_settings_for_display();
        $hover_effect   = $settings['hover_effect'];
        $title          = $settings['title'];
        $subtitle       = $settings['subtitle'];
        $paragraph      = $settings['paragraph'];
        $button_title   = $settings['btn_title'];

        $hover_class = '';
        if($hover_effect == 'yes') {
            $hover_class = 'mt-discount-container-hover';
        } else {
            $hover_class = '';
        }

        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_link_attributes( 'button_link', $settings['button_link'] );
            $button_link = $settings['button_link']['url'];
        } else {
            $button_link = '#';
        }
        ?>
        <div class="mt-discount-container <?php echo esc_attr($hover_class); ?>">
            <div class="mt-discount-content">
                <?php if ( 'yes' === $settings['show_title'] ) { ?>
                    <div class="first-text"><?php echo esc_html($title); ?></div>
                <?php } ?>
                <?php if ( 'yes' === $settings['show_subtitle'] ) { ?>
                    <div class="second-text"><?php echo esc_html($subtitle); ?></div>
                <?php } ?>
                <?php if ( 'yes' === $settings['show_paragraph'] ) { ?>
                    <div class="third-text"><?php echo esc_html($paragraph); ?></div>
                <?php } ?>
                <div class="discount-btn-zone">
                    <?php
                    if ( 'yes' === $settings['show_button'] ) { ?>
                        <a class="discount-btn" href="<?php echo esc_url($button_link);?>" ><?php echo esc_html($button_title);?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}

