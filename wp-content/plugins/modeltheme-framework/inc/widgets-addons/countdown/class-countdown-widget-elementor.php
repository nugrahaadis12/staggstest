<?php
class Modeltheme_Countdown extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-countdown', plugin_dir_url( __FILE__ ).'css/countdown.css');
        return [
            'modeltheme-countdown',
        ];
    }
    public function get_script_depends() {
      wp_enqueue_script( 'modeltheme-countdown', plugin_dir_url( __FILE__ ).'js/jquery.countdown.js' );   
      return [ 'jquery', 'elementor-frontend', 'countdown', 'modeltheme-countdown' ];
    }
    public function get_name()
    {
        return 'mtfe-countdown';
    }

    public function get_title()
    {
        return esc_html__('MT - Countdown', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'countdown', 'modeltheme-countdown' ];
    }

    protected function register_controls() {
        $this->all_controls();
    }

    private function all_controls() {
        $this->start_controls_section(
            'category_info',
            [
                'label'             => esc_html__('Content', 'modeltheme'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'insert_date', 
            [
                'label'             => esc_html__( 'Date', 'modeltheme' ),
                'label_block'       => true,
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( '2024-07-20', 'modeltheme' ),
            ]
        );
        $this->add_responsive_control(
            'dots',
            [
                'label'             => esc_html__( 'Dots', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::SWITCHER,
                'label_on'          => esc_html__( 'On', 'modeltheme' ),
                'label_off'         => esc_html__( 'Off', 'modeltheme' ),
                'return_value'      => 'none',
                'default'           => 'label_off',
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-countdown > span' => 'display: {{label_on}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'digit_typography',
                'label'             => esc_html__( 'Digit Typography', 'modeltheme' ),
                'selector'          => '{{WRAPPER}} .modeltheme-countdown div div:first-child',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'text_typography',
                'label'             => esc_html__( 'Text Typography', 'modeltheme' ),
                'selector'          => '{{WRAPPER}} .modeltheme-countdown div div:last-child',
            ]
        );
        $this->add_control(
            'digit_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Color of the digits', 'modeltheme' ),
                'label_block'       => true,
                'default'           => '#495153',
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-countdown div div:first-child' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .modeltheme-countdown span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Color of the text', 'modeltheme' ),
                'label_block'       => true,
                'default'           => '#848685',
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-countdown div div:last-child' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'background_digits',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Background Digits', 'modeltheme' ),
                'label_block'       => true,
                'default'           => '#ffffff',
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-countdown > div' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .modeltheme-countdown > div',
            ]
        );
        $this->add_control(
            'digits_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius Digits', 'modeltheme' ),
                    'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}} .modeltheme-countdown > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'size'              => 5,
                ],
            ]
        );
        $this->add_control(
            'digits_padding',
            [
                'label'             => esc_html__( 'Padding Digits', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', '%', 'em'],
                'default'           => [
                    'top'               => 12,
                    'right'             => 23,
                    'bottom'            => 12,
                    'left'              => 23,
                    'unit'              => 'px',
                    'isLinked'          => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .modeltheme-countdown > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'margin',
            [
                'label' => esc_html__( 'Margin', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 12,
                    'right' => 23,
                    'bottom' => 12,
                    'left' => 23,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .your-class' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'box_shadow',
                'label'             => esc_html__( 'Box Shadow', 'modeltheme' ),
                'selector'          => '{{WRAPPER}} .modeltheme-countdown > div',
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
                            'color' => 'rgba(0,0,0,0.1)'
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $insert_date        = $settings['insert_date'];
        
        $uniqueID = 'countdown_'.uniqid();

        ?>

        <div class="modeltheme-countdown" id="<?php echo esc_attr($uniqueID); ?>">
        <script type="text/javascript">
          jQuery( document ).ready(function() {
            jQuery("#<?php echo esc_attr($uniqueID); ?>").countdown("<?php echo esc_attr($insert_date); ?>", function(event) {
              jQuery(this).html(
                event.strftime("<div class=\'days\'><div class=\'days-digit\'>%D</div><div class=\'clearfix\'></div><div class=\'days-name\'>days</div></div><span>&middot;</span><div class=\'hours\'><div class=\'hours-digit\'>%H</div><div class=\'clearfix\'></div><div class=\'hours-name\'>hours</div></div><span>&middot;</span><div class=\'minutes\'><div class=\'minutes-digit\'>%M</div><div class=\'clearfix\'></div><div class=\'minutes-name\'>minutes</div></div><span>&middot;</span><div class=\'seconds\'><div class=\'seconds-digit\' >%S</div><div class=\'clearfix\'></div><div class=\'seconds-name\' >seconds</div></div>")
              ); 
            });
          });
        </script>
       
        <?php
    }

    protected function content_template() {}
}


