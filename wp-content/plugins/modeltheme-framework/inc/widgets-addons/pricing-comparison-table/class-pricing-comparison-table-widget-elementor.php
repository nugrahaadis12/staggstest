<?php
class Modeltheme_Pricing_Comparison_Table extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-pricing-comparison-table', plugin_dir_url( __FILE__ ).'css/pricing-comparison-table.css');
        return [
            'modeltheme-pricing-comparison-table',
        ];
    } 
    public function get_name()
    {
        return 'mtap-pricing-comparison-table';
    }

    public function get_title()
    {
        return esc_html__('Pricing Comparison Table', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'pricing', 'table', 'custom' ];
    }

    protected function register_controls() {
        $this->section_pricing_tables();
    }

    protected function section_pricing_tables() {

        $this->start_controls_section(
            'section_1',
            [
                'label' => esc_html__( 'GENERAL OPTIONS', 'mt-addons' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => esc_html__( 'Column Width', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 250,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-premium-main' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'general_color',
            [
                'label'             => esc_html__( 'General Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-premium-price-table-popular' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-premium-price-table-icon.mt-addons-premium-price-featured-item' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-premium-price-table-icon.mt-addons-premium-price-featured-item' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-premium-price-table-button' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} svg.mt-addons-premium-price-table-help-check' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-premium-price-table .mt-addons-premium-price-table-icon' => 'color: {{VALUE}}',
                ],
                'default'           => '#5336ca',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .mt-addons-premium-price-table-popular',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_2',
            [
                'label' => esc_html__( 'HEADER', 'mt-addons' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_featured',
            [
                'label' => esc_html__( 'Show as Featured Item', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'mt-addons' ),
                'label_off' => esc_html__( 'Hide', 'mt-addons' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'featured_text',
            [
                'label' => esc_html__( 'Show Featured Text', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'MOST POPULAR',
                'placeholder' => esc_html__( 'Type your featured text here', 'mt-addons' ),
                'condition' => [
                    'show_featured' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'featured_color',
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .mt-addons-premium-price-featured-item',
                'default' => [
                    'classic' => '#F9F9FB',
                ],
                'condition' => [
                    'show_featured' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'header_color',
            [
                'label'             => esc_html__( 'Header Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-premium-price-table-head.mt-addons-premium-price-featured-item' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#5336ca',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title Text', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'FREE',
                'placeholder' => esc_html__( 'Type your title here', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__( 'Subtitle Text', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'STARTER PLAN',
                'placeholder' => esc_html__( 'Type your title here', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'separator' => 'before',
                'default' => [
                    'value' => 'fas fa-rocket',
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->add_control(
            'icon_width',
            [
                'label' => esc_html__( 'Icon Width', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-premium-price-table-icon.mt-addons-premium-price-featured-item svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-addons-premium-price-table-icon.mt-addons-premium-price-featured-item svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'item_height',
            [
                'label' => esc_html__( 'Item Height', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 220,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-premium-price-table .mt-addons-premium-price-table-icon' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'price',
            [
                'label' => esc_html__( 'Price', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type your price here', 'mt-addons' ),
                'default' => '€9/mo',
            ],
        );  

        $this->add_control(
            'button_title',
            [
                'label' => esc_html__( 'Button Title', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type your button title here', 'mt-addons' ),
                'default' => 'GET STARTED',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_3',
            [
                'label' => esc_html__( 'FEATURES', 'mt-addons' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title_alignment',
            [
                'label'             => esc_html__( 'Title Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SELECT,
                'default'           => 'center',
                'options'           => [
                    'left'          => esc_html__( 'Left', 'mt-addons' ),
                    'center'        => esc_html__( 'Center', 'mt-addons' ),
                    'right'         => esc_html__( 'Right', 'mt-addons' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-premium-price-table-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'             => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} svg.mt-addons-premium-price-table-help-uncheck' => 'fill: {{VALUE}}',
                ],
                'default'           => '#D8D6E3',
            ]
        );
        $this->add_control(
            'tooltip_bg_color',
            [
                'label'             => esc_html__( 'Tooltip Backgorund Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-premium-price-tooltiptext' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#5336ca',
            ]
        );
        $this->add_control(
            'tooltip_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Tooltip Color', 'mt-addons' ),
                'default'           => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-premium-price-tooltiptext' => 'background: {{VALUE}};',
                ],
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_title',
            [
                'label' => esc_html__( 'Feature Title', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type your title here', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'select_icon',
            [
                'label' => esc_html__( 'Icon', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'mt-addons' ),
                'label_off' => esc_html__( 'Hide', 'mt-addons' ),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'select_true',
            [
                'label' => esc_html__( 'Choose', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Check', 'mt-addons' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'Unchecked', 'mt-addons' ),
                        'icon' => 'eicon-close',
                    ],
                ],
                'default' => 'no',
                'toggle' => true,
                'condition' => [
                    'select_icon' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_icon',
            [
                'label' => esc_html__( 'Custom Icon', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'mt-addons' ),
                'label_off' => esc_html__( 'Hide', 'mt-addons' ),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'icon_data',
            [
                'label' => esc_html__( 'Choose Icon', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'default' => [
                    'value' => 'fas fa-question-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'tooltip_title',
            [
                'label' => esc_html__( 'Tooltip Title', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type your tooltip title here', 'mt-addons' ),
                'condition' => [
                    'show_icon' => 'yes',
                ],
                'default' => 'Learn More',
            ]
        );

        $this->add_control( 
            'list',
            [
                'label' => esc_html__('Table Elements', 'mt-addons'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'feature_title' => esc_html__( 'Sites', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Data Retention', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Chart Annotations', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Uptime Monitoring', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Weekly Reports', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Security Audit', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'On-Demand Audit', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Priority Support', 'mt-addons' ),
                    ],
                    [
                        'feature_title' => esc_html__( ' Easy Billing + No Contracts', 'mt-addons' ),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_4',
            [
                'label' => esc_html__( 'FOOTER', 'mt-addons' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'footer_button',
            [
                'label' => esc_html__( 'Show Footer Button', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'mt-addons' ),
                'label_off' => esc_html__( 'Hide', 'mt-addons' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'condition'         => [
                    'button_status'     => 'yes',
                ],
                'size_units'        => ['px', '%', 'em'],
                'default'           => [
                    'top'               => 12,
                    'right'             => 32,
                    'bottom'            => 12,
                    'left'              => 32,
                    'unit'              => 'px',
                    'isLinked'      => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-addons-premium-price-footer a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->end_controls_section();

    }
    protected function render() {
        $settings                   = $this->get_settings_for_display();
        $show_featured              = $settings['show_featured'];
        $footer_button              = $settings['footer_button'];
        $featured_text              = $settings['featured_text'];
        $title                      = $settings['title'];
        $subtitle                   = $settings['subtitle'];
        $price                      = $settings['price'];
        $button_title               = $settings['button_title'];
        $button_link                = $settings['button_link']['url'];
        $icon                       = $settings['icon'];
        $list                       = $settings['list'];

        ?>
        <div class="mt-addons-premium-main">
            <div class="price-table-wrapper">   
                <div class="mt-addons-premium-price-table">      
                    <div class="mt-addons-premium-price-featured mt-addons-premium-price-featured-item">
                        <?php if($show_featured === "yes"){ ?>
                            <div class="mt-addons-premium-price-table-popular">                 
                                <?php echo esc_html($featured_text);  ?>                    
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mt-addons-premium-price-table-head mt-addons-premium-price-featured-item">
                        <?php if(!empty($title)){?>
                            <div class="mt-addons-premium-price-table-large"><?php echo esc_html($title);  ?></div>
                        <?php } ?>
                        <?php if(!empty($subtitle)){?>
                            <div class="mt-addons-premium-price-table-small"><?php echo esc_html($subtitle);  ?></div>
                        <?php } ?>
                    </div>
                    <div class="mt-addons-premium-price-table-icon mt-addons-premium-price-featured-item">                                  
                        <?php if(!empty($icon)){?>
                            <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php } ?>
                        <?php if(!empty($price)){?>
                            <br><?php echo esc_html($price);  ?>
                        <?php } ?>
                        <br>
                        <?php if(!empty($button_title)){?>
                            <a class="mt-addons-premium-price-table-button" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_title);  ?></a>
                        <?php } ?>
                    </div>
                    <?php foreach ( $list as $item ) {
                        $select_icon    = $item['select_icon'];
                        $select_true    = $item['select_true'];
                        $feature_title  = $item['feature_title'];
                        $icon_data      = $item['icon_data'];
                        $show_icon      = $item['show_icon'];
                        $tooltip_title  = $item['tooltip_title'];

                    ?> 
                        <div class="mt-addons-premium-items-list mt-addons-premium-list">
                            <div class="mt-addons-premium-price-table-content mt-addons-premium-price-featured-item">
                                <a class="mt-addons-premium-price-table-help">
                                    <?php if($select_icon === "yes"){ ?>
                                        <?php if($select_true === "yes"){ ?>
                                            <svg class="mt-addons-premium-price-table-help-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                        <?php } else {?>
                                            <svg class="mt-addons-premium-price-table-help-uncheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                        <?php } ?>
                                    <?php } else{ ?>  
                                    <?php if($show_icon === "yes"){ ?>
                                        <?php if(!empty($icon_data)){?>
                                            <?php \Elementor\Icons_Manager::render_icon( $item['icon_data'], [ 'aria-hidden' => 'true' ] ); ?>
                                            <span class="mt-addons-premium-price-tooltiptext"><?php echo esc_html($tooltip_title);  ?></span>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </a> 
                                <?php if(!empty($feature_title)){?>
                                    <?php echo esc_html($feature_title);  ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="mt-addons-premium-price-footer mt-addons-premium-price-featured-item">
                        <?php if($footer_button === "yes"){ ?>
                            <?php if(!empty($footer_button)){?>
                                <a class="mt-addons-premium-price-table-button" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_title);  ?></a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}


