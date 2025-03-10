<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_tabs_style_v2 extends Widget_Base {
    
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-tabs-style-v2', MT_ADDONS_PUBLIC_ASSETS.'css/tabs-style-v2.css');
        return [
            'mt-addons-tabs-style-v2',
        ];
    }
    public function get_name() {
        return 'mtfe-tabs-style-v2';
    }
    use ContentControlHelp;

    public function get_title() {
        return esc_html__('MT - Tabs Style v2','mt-addons');
    }
    public function get_icon() {
        return 'eicon-tabs';
    }
    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    } 
    protected function register_controls() {
        $this->section_tabs_v2();
        $this->section_help_settings();
    }

    private function section_tabs_v2() {
        $this->start_controls_section(
            'section_title',
            [
                'label'         => esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'underline_nav',
            [
                'label'         => esc_html__( 'Underline Navigation', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'     => esc_html__( 'No', 'mt-addons' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );
       $this->add_control(
            'content_position', 
            [
                'label'                => esc_html__( 'Tab Image Position', 'mt-addons' ),
                'type'                 => \Elementor\Controls_Manager::CHOOSE, 
                'options'              => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'              => 'right',
                'selectors_dictionary' => [
                    'left'  => 'flex-flow: inherit',
                    'right' => 'flex-direction:row-reverse',
                ],
                'toggle'               => false, 
                'selectors'            => [
                    '{{WRAPPER}} .mt-addons-tab-content-v2 .mtfe-row ' => '{{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'top_title',
            [
                'label'         => esc_html__( 'Title', 'mt-addons' ),
                'label_block'   => true,
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Plan And Room Dimensions','mt-addons'),
            ]
        );
        // start repeater
        $repeater = new Repeater();
        $repeater->add_control(
            'title',
            [
                'label'         => esc_html__( 'Tab Title', 'mt-addons' ),
                'label_block'   => true,
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
            ]
        );
        $repeater->add_control(
            'desc_image', 
            [
                'label'         => esc_html__( 'Description Image', 'plugin-name' ),
                'type'          => \Elementor\Controls_Manager::MEDIA,
                'default'       => [
                    'url'       => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        ); 
        $repeater->add_control(
            'desc_title',
            [
                'label'         => esc_html__( 'Description Title', 'mt-addons' ),
                'label_block'   => true,
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
            ]
        );
        $repeater->add_control(
            'desc_content',
            [
                'label'         => esc_html__( 'Description Content', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::WYSIWYG,
                'default'       => esc_html__( 'Default description', 'mt-addons' ),
                'placeholder'   => esc_html__( 'Type your description here', 'mt-addons' ),
            ]
        );
        $repeater->add_control(
            'button_text',
            [
                'label'         => esc_html__( 'Button text', 'mt-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
            ]
        );
        $repeater->add_control(
            'button_url',
            [
                'label'         => esc_html__( 'Button URL', 'mt-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
            ]
        ); 
        $tabs_items = [
            [
                'title'         => esc_html__('Exterior Details','mt-addons'),
                'desc_image'    => [
                    'url'       => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'desc_title'    => esc_html__('Exterior Details','mt-addons'),
                'desc_content'  => esc_html__('Sed maximus consequat ante a congue. In eu finibus turpis. Integer ut nisl lacinia, elementum ex in, fermentum sapien. Aenean commodo urna lacus, nec dignissim lorem facilisis vel. In a lobortis erat.','mt-addons'),
                'button_text'   => esc_html__('Read More','mt-addons'),
                'button_url'    => '#',
            ],
            [
                'title'         => esc_html__('Interior Details','mt-addons'),
                'desc_image'    => [
                    'url'       => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'desc_title'    => esc_html__('Interior Details','mt-addons'),
                'desc_content'  => esc_html__('Sed maximus consequat ante a congue. In eu finibus turpis. Integer ut nisl lacinia, elementum ex in, fermentum sapien. Aenean commodo urna lacus, nec dignissim lorem facilisis vel. In a lobortis erat.','mt-addons'),
                'button_text'   => esc_html__('Read More','mt-addons'),
                'button_url'    => '#',
            ],
            [
                'title'         => esc_html__('Room Dimensions','mt-addons'),
                'desc_image'    => [
                    'url'       => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'desc_title'    => esc_html__('Room Dimensions','mt-addons'),
                'desc_content'  => esc_html__('Sed maximus consequat ante a congue. In eu finibus turpis. Integer ut nisl lacinia, elementum ex in, fermentum sapien. Aenean commodo urna lacus, nec dignissim lorem facilisis vel. In a lobortis erat.','mt-addons'),
                'button_text'   => esc_html__('Read More','mt-addons'),
                'button_url'    => '#',
            ],
        ];
        $this->add_control(
            'category_tabs',
            [
                'label'         => esc_html__('Tabs Items', 'mt-addons'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'default'       => $tabs_items,
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_btn', 
            [
                'label'         => esc_html__( 'Tab', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'background_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Tab Background Active', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-v2 nav ul li.tab-active' => 'background-color: {{VALUE}};',
                ],
                'default'       => 'transparent',
            ]
        ); 
        $this->add_control(
            'divider_1',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'tab_text',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Tab Text Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-nav-title' => 'color: {{VALUE}};',
                ],
                'default'       => '#cdcdcd',
            ]
        );
        $this->add_control(
            'tab_text_hover',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Tab Text Color Active', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-v2 nav ul li.tab-active .mt-addons-tabs-nav-title' => 'color: {{VALUE}};',
                ],
                'default'       => '#000000',
            ]
        );
        $this->add_control(
            'divider_2',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_responsive_control(
            'list_border_color',
            [
                'label'         => esc_html__( 'Border Color', 'mt-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-v2 ul li ' => 'border-color: {{VALUE}};',
                ],
                'default'       => '#0A0A0A',
                'condition'     => [
                    'underline_nav' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'divider_3',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_responsive_control(
            'padding_tab',
            [
                'label'         => esc_html__( 'Padding', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-v2 nav ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_border_color_active',
            [
                'label'         => esc_html__( 'Border Color Active', 'mt-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-v2 ul li.tab-active' => 'border-color: {{VALUE}};',
                ],
                'default'       => '#0A0A0A'
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_btns', 
            [
                'label'         => esc_html__( 'Button', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'button_content_border',
            [
                'label'         => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_content_padding',
            [
                'label'         => esc_html__( 'Padding', 'mt-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'button_typography',
                'label'         => esc_html__( 'Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-tab-content-button',
            ]
        );
        $this->add_control(
            'button_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'color: {{VALUE}};',
                ],
                'default'       => '#ffffff',
            ]
        ); 
        $this->add_control(
            'button_color_hover',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Color Hover', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tab-content-button:hover' => 'color: {{VALUE}};',
                ],
                'default'       => '#ffffff',
            ]
        ); 
        $this->add_control(
            'button_bg_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Background Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'background-color: {{VALUE}};',
                ],
                'default'       => '#000000',
            ]
        );
        $this->add_control(
            'button_bg_color_hover',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Background Color Hover', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tab-content-button:hover' => 'background-color: {{VALUE}};',
                ],
                'default'       => '#000000',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style', 
            [
                'label'         => esc_html__( 'Title', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Typography', 'mt-addons' ),
                'name'              => 'title_typography',
                'selector'          => '{{WRAPPER}} .mt-addons-tabs-nav-title-top',
            ]
        );
        $this->add_control(
            'top_title_width',
            [
                'label'         => esc_html__( 'Title Width', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::NUMBER,
                'min'           => 0,
                'max'           => 100,
                'step'          => 1,
                'default'       => 41,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-nav-title-top' => 'width: {{VALUE}}%',
                ],
            ]
        );
        $this->add_control(
            'top_title_color',
            [
                'label'         => esc_html__( 'Title Color', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-nav-title-top' => 'color: {{VALUE}}',
                ],
            ]
        );
        // $this->add_group_control(
        //     \Elementor\Group_Control_Typography::get_type(),
        //     [
        //         'name'          => 'title_typography',
        //         'label'         => esc_html__( 'Title Typography', 'mt-addons' ),
        //         'selector'      => '{{WRAPPER}} .mt-addons-tabs-nav-title-top',
        //     ]
        // );
        $this->add_control(
            'description_spacing',
            [
                'label'         => esc_html__( 'Description Spacing', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::SLIDER,
                'size_units'    => [ 'px'],
                'range'         => [
                    'px'        => [
                        'min'   => -990,
                        'max'   => 1000,
                        'step'  => 1,
                    ],
                ],
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-tab-desc-content' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'desc_typography',
                'label'         => esc_html__( 'Description Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-tab-desc-content',
            ]
        );
        $this->add_responsive_control(
            'padding_title',
            [
                'label'         => esc_html__( 'Padding', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-tabs-nav-title-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_description', 
            [
                'label'         => esc_html__( 'Description', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Typography', 'mt-addons' ),
                'name'              => 'description_typography',
                'selector'          => '{{WRAPPER}} .mt-addons-tab-content-title',
            ]
        );
        $this->end_controls_section();
        }   
        protected function render() {
        $settings               = $this->get_settings_for_display();
        $category_tabs          = $settings['category_tabs'];
        $top_title              = $settings['top_title'];
        $underline_nav          = $settings['underline_nav'];
        // $content_position       = isset($settings['content_position']) ? $settings['content_position'] : '';
        $content_position = isset($settings['content_position']) ? 'left' : 'right';
        if($underline_nav == 'yes') {
            $nav_style = '';
        } else {
            $nav_style = 'no_underline';
        }
     
        if (isset($settings['content_position'])) {
            $content_position = 'left';
        } else {
            $content_position = 'right';
        }
        ?>
        <div class="mt-addons-tabs-v2 <?php echo esc_attr($nav_style); ?>">
            <nav>
                <div class="mt-addons-header-tabs col-md-12 <?php echo esc_attr($content_position);?>">
                    <h5 class="mt-addons-tabs-nav-title-header-top col-md-6"></h5>
                    <h5 class="mt-addons-tabs-nav-title-top col-md-6"><?php echo esc_html($top_title);?></h5>
                </div>
                <ul class="mt-addons-tabs-nav-v2 col-md-6 "> 
                    <?php $tab_id = 1; ?>
                    <?php if ($category_tabs) { ?>
                        <?php foreach ($category_tabs as $tab) { 
                            $title = $tab['title'];
                            ?>  
                            <li><a href="#section-iconbox-<?php echo esc_attr($tab_id); ?>"> 
                                <h5 class="mt-addons-tabs-nav-title"><?php echo esc_html($title);?></h5>
                            </a></li> 
                            <?php $tab_id++; ?>
                        <?php } ?>
                    <?php }?>
                </ul>
            </nav>
            <div class="mt-addons-tab-content-v2">
                <?php $content_id = 1; ?>
                    <?php if ($category_tabs) { ?>
                        <?php foreach ($category_tabs as $tab) { 
                            $desc_image         = $tab['desc_image']['url'];
                            $desc_title         = $tab['desc_title'];
                            $desc_content       = $tab['desc_content'];
                            $button_text        = $tab['button_text'];
                            $button_url         = $tab['button_url'];

                        ?>
                        <section id="section-iconbox-<?php echo esc_attr($content_id);?>">
                            <div class="mtfe-row <?php echo esc_attr($content_position);?>">
                                <div class="col-md-6 text-left"> 
                                    <div class="zoom-img--main"> 
                                        <img class="mt-addons-tab-content-image" src="<?php echo esc_url($desc_image); ?>" alt="tabs-image">
                                    </div>
                                </div>
                                <div class="mt-addons-tab-v2-description col-md-6 text-left">
                                    <p class="mt-addons-tab-content-title"><?php echo esc_html($desc_title); ?></p>
                                    <div class="mt-addons-tab-desc-content">
                                        <?php echo wp_kses_post($tab['desc_content']); ?>
                                    </div>
                                    <?php  if($button_url != ''){ ?>
                                        <a class="mt-addons-tab-content-button" href="<?php echo esc_url($button_url); ?>" > <?php echo esc_html($tab['button_text']); ?></a>
                                    <?php  } ?>
                                </div>
                            </div>                     
                        </section>
                        <?php $content_id++; ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php }
    protected function content_template() {}
}