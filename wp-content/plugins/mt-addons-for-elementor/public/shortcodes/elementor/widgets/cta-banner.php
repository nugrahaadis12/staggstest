<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_cta_banner extends Widget_Base {

    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-cta-banner', MT_ADDONS_PUBLIC_ASSETS.'css/cta-banner.css');
        
        return [
            'mt-addons-cta-banner',
        ];
    }

    public function get_name()
    {
        return 'mtfe-cta-banner';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - CTA Banner', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'cta', 'banner', 'call'];
    }

    protected function register_controls() {
        $this->section_cta_banner();
        $this->section_help_settings();
    }

    private function section_cta_banner() {
        $this->start_controls_section(
            'content',
            [
                'label'             => esc_html__( 'Content', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title',
            [
                'label'             => esc_html__('Main Title', 'mt-addons'),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__('Bring it all togheter', 'mt-addons'),
            ]
        );
        $this->add_control(
            'subtitle',
            [
                'label'             => esc_html__('Main Subtitle', 'mt-addons'),
                'type'              => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'paragraph',
            [
                'label'             => esc_html__('Main Paragraph', 'mt-addons'),
                'type'              => Controls_Manager::TEXTAREA,
                'default'           => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus nisl vitae magna pulvinar laoreet. Nullam erat ipsum, mattis nec mollis ac, accumsan a enim. Nunc at euismod arcu. Aliquam ullamcorper eros justo, vel mollis neque facilisis vel.','mt-addons'),
            ]
        );
        $this->add_control(
            'show_link',
            [
                'label'             => esc_html__( 'Enable Link on Banner', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SWITCHER,
                'label_on'          => esc_html__( 'Show', 'mt-addons' ),
                'label_off'         => esc_html__( 'Hide', 'mt-addons' ),
                'return_value'      => 'yes',
                'default'           => 'no',
            ]
        );
        $this->add_control(
            'content_link',
            [
                'label'             => esc_html__( 'Content Link', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::URL,
                'placeholder'       => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'options'           => [ 'url', 'is_external', 'nofollow' ],
                'default'           => [
                    'url'               => '',
                    'is_external'       => true,
                    'nofollow'          => true,
                ],
                'label_block'       => true,
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'button',
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
            'button_text',
            [
                'label'             => esc_html__('Button Text', 'mt-addons'),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__('Read More','mt-addons'),
            ]
        );
        $this->add_control(
            'button_align',
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
                    '{{WRAPPER}} .mt-addons-cta-banner-button' => 'text-align: {{VALUE}};',
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
                'default'           => [
                    'url'               => '',
                    'is_external'       => true,
                    'nofollow'          => true,
                ],
                'label_block'       => true,
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label'             => esc_html__( 'Text Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-html--link' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Text Typography', 'mt-addons' ),
                'name'              => 'button_typography',
                'selector'          => '{{WRAPPER}} .mt-addons-cta-banner-html--link',
            ]
        );
        $this->add_control(
            'button_background',
            [
                'label'             => esc_html__( 'Background', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-html--link' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#0960F0',
            ]
        );
        $this->add_control(
            'button_background_hover',
            [
                'label'             => esc_html__( 'Background Color (Hover)', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-html--link:hover' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#292929'
            ]
        );
        $this->add_control(
            'padding_button',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 10,
                    'right'             => 30,
                    'bottom'            => 10,
                    'left'              => 30,
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .mt-addons-cta-banner-html--link',
            ]
        );
        $this->add_control(
            'button_border_color_cta',
            [
                'label'             => esc_html__( 'Border Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-html--link' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_border_color_hover',
            [
                'label'             => esc_html__( 'Border Color Hover', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-html--link:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_radius',
            [
                'label'             => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-html--link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 5,
                    'right'             => 5,
                    'bottom'            => 5,
                    'left'              => 5,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'title_style',
            [
                'label'             => esc_html__('Title Style', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'text_align',
            [
                'label'             => esc_html__( 'Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
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
                'default'           => 'left',
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-subtitle' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .mt-addons-cta-banner-title' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .mt-addons-cta-banner-text' => 'text-align: {{VALUE}};',
                ],
                'toggle'            => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Title Typography', 'mt-addons' ),
                'name'              => 'title_typography',
                'selector'          => '{{WRAPPER}} .mt-addons-cta-banner-title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-title' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 0,
                    'right'             => 0,
                    'bottom'            => 10,
                    'left'              => 0,
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'subtitle_style',
            [
                'label'             => esc_html__('Subtitle Style', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Subtitle Typography', 'mt-addons' ),
                'name'              => 'subtitle_typography',
                'selector'          => '{{WRAPPER}} .mt-addons-cta-banner-subtitle',
            ]
        );
        $this->add_control(
            'subtitle_color',
            [
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-subtitle' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                 'default'          => [
                    'unit'              => 'px',
                    'top'               => 0,
                    'right'             => 0,
                    'bottom'            => 25,
                    'left'              => 0,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'paragraph_style',
            [
                'label'             => esc_html__('Paragraph Style', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Paragraph Typography', 'mt-addons' ),
                'name'              => 'paragraph_typography',
                'selector'          => '{{WRAPPER}} .mt-addons-cta-banner-text',
            ]
        );
        $this->add_control(
            'paragraph_color',
            [
                'label'             => esc_html__( 'Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-text' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_responsive_control(
            'paragraph_width',
            [
                'label'             => esc_html__( 'Width', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 1,
                'max'               => 100,
                'step'              => 1,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-text' => 'width: {{VALUE}}%',
                ],
                'default'           => 100,
            ]
        );
        $this->add_responsive_control(
            'paragraph_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                 'default'          => [
                    'unit'              => 'px',
                    'top'               => 0,
                    'right'             => 0,
                    'bottom'            => 25,
                    'left'              => 0,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style',
            [
                'label'             => esc_html__('Banner Style', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'              => 'container_background',
                'types'             => [ 'classic', 'gradient', 'video' ],
                'selector'          => '{{WRAPPER}} .mt-addons-cta-banner-shortcode',
                'fields_options'    => [
                     'background'       => [
                        'default'       => 'classic',
                     ],
                     'color'            => [
                        'default'       => '#000000',
                    ],
               ]
            ]
        );
        $this->add_responsive_control(
            'container_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-shortcode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 60,
                    'right'             => 30,
                    'bottom'            => 70,
                    'left'              => 45,
                ]
            ]
        );
        $this->add_control(
            'container_border_radius',
            [
                'label'             => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-cta-banner-shortcode' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'container_box_shadow',
                'label'             => esc_html__( 'Box Shadow', 'textdomain' ),
                'selector'          => '{{WRAPPER}} .mt-addons-cta-banner-shortcoder',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $content_link   = $settings['content_link']['url'];
        $title          = $settings['title'];
        $subtitle       = $settings['subtitle'];
        $paragraph      = $settings['paragraph'];
        $button_text    = $settings['button_text'];
        $button_link    = $settings['button_link']['url'];
        ?>

        <div class="mt-addons-cta-banner-shortcode mt-addons-cta-banner  mt-addons-cta-banner-inner mt-addons-cta-banner-layout--standard mt-addons-cta-banner-vertical--bottom mt-addons-cta-banner-horizontal--left mt-addons-cta-banner-image--hover-zoom ">
            <div class="mt-addons-cta-banner-content">
                <div class="mt-addons-cta-banner-content-inner">
                    <?php if(!empty($subtitle)){?>
                        <h5 class="mt-addons-cta-banner-subtitle"><?php echo esc_html__($subtitle); ?> </h5>
                    <?php }?>
                    <?php if(!empty($title)){?>
                        <h3 class="mt-addons-cta-banner-title"><?php echo esc_html__($title); ?> </h3>
                    <?php }?>
                    <?php if(!empty($paragraph)){?>
                        <p class="mt-addons-cta-banner-text"><?php echo esc_html__($paragraph); ?></p>
                    <?php }?>
                    <?php if ( 'yes' === $settings['show_button'] ) { ?>
                        <div class="mt-addons-cta-banner-button">
                            <a href="<?php echo esc_url($button_link); ?>" class="mt-addons-cta-banner  mt-addons-cta-banner-button mt-addons-cta-banner-html--link mt-addons-cta-banner-layout--textual mt-addons-cta-banner-type--standard   mt-addons-cta-banner-icon--right mt-addons-cta-banner-hover--iconove-horizontal-short   mt-addons-cta-banner-text-underline mt-addons-cta-banner-underline--left">
                                <span><?php echo esc_html__($button_text); ?></span> 
                            </a> 
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php if ( 'yes' === $settings['show_link'] ) { ?>
                <a href="<?php echo esc_url($content_link); ?>" itemprop="url" class="mt-addons-cta-banner-inner-link" target="_self"></a>
            <?php }?>
        </div>
        <?php
    }
    protected function content_template() {}
}

