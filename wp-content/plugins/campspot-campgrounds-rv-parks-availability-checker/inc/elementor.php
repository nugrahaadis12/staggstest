<?php
namespace Elementor;

class APAC_Widget extends Widget_Base {
	
	public function get_name() {
		return 'ccrpac-forms';
	}
	
	public function get_title() {
		return esc_html__('Campspot Campgrounds, RV parks Availability Checker', 'ccrpac');
	}
	
	public function get_icon() {
		return 'eicon-form-horizontal';
	}
	
	public function get_categories() {
		return [ 'modeltheme-affiliate-widgets' ];
	}

   protected function register_controls() {

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'General Options', 'ccrpac' ),
            ]
        );
        $this->add_control(
            'version',
            [
                'label' => esc_html__( 'Version', 'ccrpac' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'v1'    => esc_html__( 'V1', 'ccrpac' ),
                    'v2'    => esc_html__( 'V2', 'ccrpac' ),
                ]
            ]
        );
        $this->add_control(
            'detailed_finder',
            [
                'label' => esc_html__( 'Detailed Finder', 'ccrpac' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'ccrpac' ),
                'label_off' => esc_html__( 'No', 'ccrpac' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            'url_bnb',
            [
                'label' => esc_html__( 'Campspot Link', 'ccrpac' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'placeholder' => esc_html__( 'Example: www.campspot.com/new-frontier-campground-rv-park/', 'ccrpac' ),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'property_id',
            [
                'label' => esc_html__( 'Property ID Code', 'ccrpac' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Example: 901405', 'ccrpac' ),
            ]
        );
        $this->add_control(
            'max_guests',
            [
                'label' => esc_html__( 'Max Guests', 'ccrpac' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 1,
            ]
        );
        $this->add_control(
            'submit_button_label',
            [
                'label' => esc_html__('Submit Button Label', 'ccrpac'),
                'type' => Controls_Manager::TEXT,
                'description ' => esc_html__('ex: Submit', 'ccrpac'),
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style Options', 'ccrpac' ),
            ]
        );
        $this->add_control(
            'color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__( 'Button Text Color', 'ccrpac' ),
                'selectors' => [
                    '{{WRAPPER}} .ccrpac-submit' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'color_hover',
            [
                'label' => esc_html__( 'Button Text Color Hover', 'ccrpac' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ccrpac-submit:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'bg_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__( 'Button Background Color', 'ccrpac' ),
                 'selectors' => [
                    '{{WRAPPER}} .ccrpac-submit' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'bg_color_hover',
            [
                'label' => esc_html__( 'Button Background Color Hover', 'ccrpac' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ccrpac-submit:hover' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'bg_form',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__( 'Form Background', 'ccrpac' ),
                 'selectors' => [
                    '{{WRAPPER}} .mt-campspot-campgrounds-rv-parks-availability-checker' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'color_label',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__( 'Label Text Color', 'ccrpac' ),
                 'selectors' => [
                    '{{WRAPPER}} .ccrpac_row.v2 .ccrpac_input_wrapper label, {{WRAPPER}} .ccrpac-date-wrapper label ' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->end_controls_section();

    }
	
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $version                    = $settings['version'];
        $detailed_finder            = $settings['detailed_finder'];
        $property_id                = $settings['property_id'];
        $max_guests                 = $settings['max_guests'];
        $submit_button_label        = $settings['submit_button_label'];
        $color                      = $settings['color'];
        $color_hover                = $settings['color_hover'];
        $bg_color                   = $settings['bg_color'];
        $bg_color_hover             = $settings['bg_color_hover'];
        $bg_form                    = $settings['bg_form'];
        $color_label                = $settings['color_label'];
        $url_bnb                    = $settings['url_bnb']['url'];

        $shortcode_content = '';
        $shortcode_content .= do_shortcode('[ccrpac-builder-shortcode 
            property_id="'.esc_attr($property_id).'"  
            url_bnb="'.esc_attr($url_bnb).'"  
            version="'.esc_attr($version).'" 
            detailed_finder="'.esc_attr($detailed_finder).'"  
            max_guests="'.esc_attr($max_guests).'" 
            color="'.esc_attr($color).'" 
            color_hover="'.esc_attr($color_hover).'" 
            bg_color="'.esc_attr($bg_color).'" 
            bg_color_hover="'.esc_attr($bg_color_hover).'" 
            bg_form="'.esc_attr($bg_form).'" 
            color_label="'.esc_attr($color_label).'" 
            submit_button_label="'.esc_html__($submit_button_label).'"]');

        echo  do_shortcode($shortcode_content);
	}
	
	protected function content_template() {

    }
}
