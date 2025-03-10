<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_contact_form extends Widget_Base {
    
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-contact-form', MT_ADDONS_PUBLIC_ASSETS.'css/contact-form.css');
        return [
            'mt-addons-contact-form',
        ];
    }

    public function get_name() {
        return 'mtfe-contact-form';
    }
    
    use ContentControlHelp;

    public function get_title() {
        return esc_html__('MT - Contact Form','mt-addons');
    }
    
    public function get_icon() {
        return 'eicon-form-horizontal';
    }
    
    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    protected function register_controls() {
        $this->section_contact_form();
        $this->section_help_settings();
    }

    private function section_contact_form() {

        $this->start_controls_section(
            'section_title',
            [
                'label'         => esc_html__( 'Contact', 'mt-addons' ),
            ]
        );

        $cf7            = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
        $contact_forms  = array();
        if ( $cf7 ) {
            foreach ( $cf7 as $cform ) {
                $contact_forms[ $cform->ID ] = $cform->post_title;
            }
        } else {
            $contact_forms[ esc_html__( 'No contact forms found', 'mt-addons' ) ] = 0;
        }

        $this->add_control(
            'contact_forms',
            [
                'label'         => esc_html__( 'Select Contact Form', 'mt-addons' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => $contact_forms,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_sub_heading',
            [
                'label'         => esc_html__( 'Fields', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'field_width',
            [
                'label'         => esc_html__('Field Width', 'mt-addons'),
                'placeholder'   => esc_html__( 'Type your width here', 'mt-addons' ),
                'type'          => Controls_Manager::NUMBER,
                'selectors'     => [
                    ' {{WRAPPER}} .mt-addons-contact-form .wpcf7-form textarea, {{WRAPPER}} .wpcf7-form-control:not(input[type="submit"])' => 'width: {{VALUE}}%',
                    ' {{WRAPPER}} .mt-addons-contact-form .wpcf7-form label' => 'width: {{VALUE}}%',
                ],
                    'default'   => 100,
            ]
        );
        $this->add_control(
            'field_padding',
            [
                'label'         => esc_html__('Field Padding', 'mt-addons'),
                'type'          => Controls_Manager::DIMENSIONS,
                'selectors'     => [
                    '{{WRAPPER}} 
                        .mt-addons-contact-form .wpcf7-form input[type=date], 
                        .mt-addons-contact-form .wpcf7-form input[type=email], 
                        .mt-addons-contact-form .wpcf7-form input[type=number], 
                        .mt-addons-contact-form .wpcf7-form input[type=password], 
                        .mt-addons-contact-form .wpcf7-form input[type=search], 
                        .mt-addons-contact-form .wpcf7-form input[type=tel], 
                        .mt-addons-contact-form .wpcf7-form input[type=text], 
                        .mt-addons-contact-form .wpcf7-form input[type=url], 
                        .mt-addons-contact-form .wpcf7-form select, 
                        .mt-addons-contact-form .wpcf7-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]    
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'fields_typography', 
                'label'         => esc_html__( 'Field Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} body .mt-addons-contact-form .wpcf7-form input[type="text"], body .mt-addons-contact-form .wpcf7-form input, .mt-addons-contact-form .wpcf7-form textarea',
            ]
        );
        $this->add_control(
            'field_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Active Field Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} body .mt-addons-contact-form .wpcf7-form input[type="text"], body .mt-addons-contact-form .wpcf7-form input, .mt-addons-contact-form .wpcf7-form textarea' => 'color: {{VALUE}};'
                ],
                'default'       => '#000000',
            ]
        );
        $this->add_control(
            'contact_divider_1',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'label_spacing',
            [
                'label'             => esc_html__( 'Label Spacing', 'mt-addons' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} body .mt-addons-contact-form .wpcf7-form input[type="text"], body .mt-addons-contact-form .wpcf7-form input, .mt-addons-contact-form .wpcf7-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'label_typography', 
                'label'         => esc_html__( 'Label Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form label',
            ]
        );
        $this->add_control(
            'label_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Label Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form label' => 'color: {{VALUE}}',
                ],
                'default'       => '#000000',
            ]
        );
        $this->add_control(
            'contact_divider_2',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'placeholder_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Placeholder Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form ::placeholder' => 'color: {{VALUE}} !important',
                ],
                'default'       => '#3B3F59',
            ]
        );
        $this->add_control(
            'contact_divider_3',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'background_label',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Background', 'mt-addons' ),
                'selectors'     => [
                    ' {{WRAPPER}} .mt-addons-contact-form .wpcf7-form input[type=date], 
                        .mt-addons-contact-form .wpcf7-form input[type=email], 
                        .mt-addons-contact-form .wpcf7-form input[type=number], 
                        .mt-addons-contact-form .wpcf7-form input[type=password], 
                        .mt-addons-contact-form .wpcf7-form input[type=search], 
                        .mt-addons-contact-form .wpcf7-form input[type=tel], 
                        .mt-addons-contact-form .wpcf7-form input[type=text], 
                        .mt-addons-contact-form .wpcf7-form input[type=url], 
                        .mt-addons-contact-form .wpcf7-form select, 
                        .mt-addons-contact-form .wpcf7-form textarea' => 'background-color: {{VALUE}}',
                ],
                'default'       => 'transparent',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'field_padding_box_shadow',
                'selector'      => '{{WRAPPER}} .wpcf7-form input, .wpcf7-form textarea',
            ]
        );
        $this->add_control(
            'contact_divider_4',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'field_border',
                'label'         => esc_html__( 'Border', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form input[type=date], .mt-addons-contact-form .wpcf7-form input[type=email], .mt-addons-contact-form .wpcf7-form input[type=number], .mt-addons-contact-form .wpcf7-form input[type=password], .mt-addons-contact-form .wpcf7-form input[type=search], input[type=tel], .mt-addons-contact-form .wpcf7-form input[type=text], .mt-addons-contact-form .wpcf7-form input[type=url], .mt-addons-contact-form .wpcf7-form select, .mt-addons-contact-form .wpcf7-form textarea',
            ]
        );
        $this->add_responsive_control(
            'field_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [ 
                    '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'focus_fields',
            [
                'label'         => esc_html__( 'Focus Fields', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'focus_border',
                'label'         => esc_html__( 'Border', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form input[type=date]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=email]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=number]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=password]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=search]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=tel]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=text]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=url]:focus, 
                        .mt-addons-contact-form .wpcf7-form select:focus, 
                        .mt-addons-contact-form .wpcf7-form textarea:focus',
            ]
        );
        $this->add_control(
            'field_padding_focus',
            [
                'label'         => esc_html__('Focus Field Padding', 'mt-addons'),
                'type'          => Controls_Manager::DIMENSIONS,
                'selectors'     => [
                    '{{WRAPPER}} 
                        .mt-addons-contact-form .wpcf7-form input[type=date]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=email]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=number]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=password]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=search]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=tel]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=text]:focus, 
                        .mt-addons-contact-form .wpcf7-form input[type=url]:focus, 
                        .mt-addons-contact-form .wpcf7-form select:focus, 
                        .mt-addons-contact-form .wpcf7-form textarea:focus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]    
        );
        $this->end_controls_tab();
        $this->end_controls_section();
        $this->start_controls_section(
            'style_button',
            [
                'label'         => esc_html__( 'Button', 'mt-addons' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'button_width',
            [
                'label'         => esc_html__( 'Width', 'mt-addons' ),
                'type'          => \Elementor\Controls_Manager::NUMBER,
                'min'           => 1,
                'max'           => 100,
                'step'          => 5,
                'default'       => 100,
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form  .wpcf7-form [type=submit]' => 'width: {{VALUE}}%',
                ],
            ]
        );
        $this->add_control(
            'button_submit_padding',
            [
                'label'         => esc_html__( 'Padding', 'mt-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form  .wpcf7-form [type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 10,
                    'right'         => 30,
                    'bottom'        => 10,
                    'left'          => 30,
                ]
            ]
        );
        $this->add_control(
            'contact_divider_5',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'button_background_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Background', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form [type=submit]' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_background_hover_color',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Hover Background', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form  .wpcf7-form [type=submit]:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_text_align',
            [
                'label' => esc_html__( 'Alignment', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'mt-addons' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-button' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'button_submit_box_shadow',
                'selector'      => '{{WRAPPER}} .wpcf7-form [type=submit]',
            ]
        );
        $this->add_control(
            'contact_divider_6',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'button_typography',
                'label'         => esc_html__( 'Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .wpcf7-form [type=submit]',
            ]
        );
        $this->add_control(
            'btn_margin',
            [
                'label'             => esc_html__( 'Margin', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default'           => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 0,
                    'bottom'        => 10,
                    'left'          => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form [type=submit]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_background_text',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Text Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form [type=submit]' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_background_text_hover',
            [
                'type'          => \Elementor\Controls_Manager::COLOR,
                'label'         => esc_html__( 'Hover Text Color', 'mt-addons' ),
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-contact-form  .wpcf7-form [type=submit]:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'contact_divider_7',
            [
                'type'          => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'button_submit_border',
                'label'         => esc_html__( 'Border', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-contact-form .wpcf7-form [type=submit]',
            ]
        );
        $this->add_responsive_control(
            'button_submit_border',
            [
                'label'         => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .wpcf7-form [type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'unit'          => 'px',
                    'top'           => 30,
                    'right'         => 30,
                    'bottom'        => 30,
                    'left'          => 30,
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();
    }
        
    protected function render() {
        $settings                 = $this->get_settings_for_display();
        $contact_forms            = $settings['contact_forms'];
        
        $id = 'mt-addons-contact-form-'.uniqid();
        ?>
        <div class="mt-addons-contact-form" id="<?php echo esc_attr($id); ?>">
            <?php if (!empty($contact_forms)) {
                echo do_shortcode( '[contact-form-7 id="' . esc_attr($contact_forms) . '" title="'.esc_html__('Contact Form','mt-addons').'"]' );
            } ?>
        </div>

    <?php
    }
    protected function content_template() {
    }
}