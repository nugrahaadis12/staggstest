<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_hero_slider extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-hero-slider', MT_ADDONS_PUBLIC_ASSETS.'css/hero-slider.css');
      	wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');

        return [
            'mt-addons-hero-slider',
            'swiper-bundle',
        ];
    }
	use ContentControlSlider;
	use ContentControlHelp;
	public function get_name() { 
		return 'mtfe-hero-slider';
	}
	
	public function get_title() {
        return esc_html__( 'MT - Hero Slider', 'mt-addons' );
	}
	
	public function get_icon() {
		return 'eicon-slider-full-screen';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
    public function get_script_depends() {
        
        wp_register_script( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/swiperjs/swiper-bundle.min.js');
        wp_register_script( 'mt-addons-swiper', MT_ADDONS_PUBLIC_ASSETS.'js/swiper.js');
        
        return [ 'jquery', 'elementor-frontend', 'swiper-bundle', 'mt-addons-swiper' ];
    }

	protected function register_controls() {
        $this->section_slider();
        $this->section_help_settings();
    }

    private function section_slider() {

        $this->start_controls_section(
            'section_slider',
            [
                'label' 			=> esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'slider_container_radius',
	            [
	                'label' 		=> esc_html__( 'Image Border Radius', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} img.mt-addons-hero-slider-background-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'title_typography',
				'label' 			=> esc_html__( 'Title Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-hero-slider-title',
                'fields_options' 	=> [
                    'typography'    	=> ['default' => 'yes'],
                    'font_size'     	=> ['default' => ['size' => 16]],
                    'font_weight'   	=> ['default' => 400],
                ],
            ]
        );
		$this->add_control(
			'slider_title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 		=> true,
				 'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-title' => 'color: {{VALUE}}',
                ]
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'subtitle_typography',
				'label' 			=> esc_html__( 'SubTitle Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-hero-slider-subtitle',
                'fields_options' 	=> [
                    'typography'    	=> ['default' => 'yes'],
                    'font_size'     	=> ['default' => ['size' => 30]],
                    'font_weight'   	=> ['default' => 500],
                ],
            ]
        );
		$this->add_control(
			'slider_subtitle_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Subtitle Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-subtitle' => 'color: {{VALUE}}',
                ]
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'beftitle_typography',
				'label' 			=> esc_html__( 'BeforeTitle Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-hero-slider-beftitle',
                'fields_options' 	=> [
                    'typography'    	=> ['default' => 'yes'],
                    'font_size'     	=> ['default' => ['size' => 55]],
                    'font_weight'   	=> ['default' => 600],
                ],
            ]
        ); 
		$this->add_control(
			'slider_beftitle_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Before Title Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-beftitle' => 'color: {{VALUE}}',
                ]
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'aftersubtitle_typography',
				'label' 			=> esc_html__( 'AfterSubtitle Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-hero-slider-aftersubtitle',
                'fields_options' 	=> [
                    'typography'    	=> ['default' => 'yes'],
                    'font_size'     	=> ['default' => ['size' => 40]],
                    'font_weight'   	=> ['default' => 500],
                ],
            ]
        );
		$this->add_control(
			'slider_aftersubtitle_color', 
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'After Subtitle Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-aftersubtitle' => 'color: {{VALUE}}',
                ]
			]
		); 
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'button_typography',
				'label' 			=> esc_html__( 'Button Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-hero-slider-button',
            ]
        );
    	$repeater = new Repeater();
		$repeater->add_control(
			'background_image',
			[
				'label' 			=> esc_html__( 'Background', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 			=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 				=> 'image_gradient',
				'label' 			=> esc_html__( 'Slider Background Gradient', 'mt-addons' ),
				'types' 			=> ['gradient'],
				'selector' 			=> '{{WRAPPER}} .mt-addons-hero-slider-bg',
			]
		);
		$repeater->add_control(
			'section_align',
			[
				'type' 				=> \Elementor\Controls_Manager::CHOOSE,
				'label' 			=> esc_html__( 'Alignment', 'mt-addons' ),
				'options' 			=> [
					'left' 			=> [
						'title' 		=> esc_html__( 'Left', 'mt-addons' ),
						'icon' 			=> 'eicon-text-align-left',
					],
					'center' 		=> [
						'title' 		=> esc_html__( 'Center', 'mt-addons' ),
						'icon' 			=> 'eicon-text-align-center',
					],
					'right' 		=> [
						'title' 		=> esc_html__( 'Right', 'mt-addons' ),
						'icon' 			=> 'eicon-text-align-right',
					],
				],
				'default' 			=> 'left',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-hero-slider-bg' => 'text-align: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'title', 
			[
				'label'       		=> esc_html__( 'Title', 'mt-addons' ),
				'label_block' 		=> true,
				'type'        		=> Controls_Manager::TEXT,
				'default'     		=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		$repeater->add_control(
			'title_tag',
			[ 
				'label' 			=> esc_html__( 'Element Title Tag', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'h1' 				=> esc_html__( 'h1', 'mt-addons' ),
					'h2'				=> esc_html__( 'h2', 'mt-addons' ),
					'h3' 				=> esc_html__( 'h3', 'mt-addons' ),
					'h4' 				=> esc_html__( 'h4', 'mt-addons' ),
					'h5' 				=> esc_html__( 'h5', 'mt-addons' ),
					'h6' 				=> esc_html__( 'h6', 'mt-addons' ),
					'p' 				=> esc_html__( 'p', 'mt-addons' ),
					'div' 				=> esc_html__( 'div', 'mt-addons' ),

				],
				'default' 			=> 'h1',
			]
		); 
		$repeater->add_control(
			'subtitle',
			[
				'label' 			=> esc_html__( 'Subtitle', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default'     		=> esc_html__( 'Subtitle Text', 'mt-addons' ),
			]
		); 
		$repeater->add_control(
			'subtitle_tag',
			[
				'label' 			=> esc_html__( 'Element Subtitle Tag', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'h1' 				=> esc_html__( 'h1', 'mt-addons' ),
					'h2'				=> esc_html__( 'h2', 'mt-addons' ),
					'h3' 				=> esc_html__( 'h3', 'mt-addons' ),
					'h4' 				=> esc_html__( 'h4', 'mt-addons' ),
					'h5' 				=> esc_html__( 'h5', 'mt-addons' ),
					'h6' 				=> esc_html__( 'h6', 'mt-addons' ),
					'p' 				=> esc_html__( 'p', 'mt-addons' ),
					'div' 				=> esc_html__( 'div', 'mt-addons' ),
				],
				'default' 			=> 'h2',
			]
		);
		$repeater->add_control(
			'before_title',
			[
				'label' 	  		=> esc_html__( 'Before Title Text', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 		  		=> Controls_Manager::TEXT,
				'default'     		=> esc_html__( 'Before Title Text', 'mt-addons' ),
			]
		); 
		$repeater->add_control(
			'before_tag',
			[
				'label' 			=> esc_html__( 'Element Before Tag', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'h1' 				=> esc_html__( 'h1', 'mt-addons' ),
					'h2'				=> esc_html__( 'h2', 'mt-addons' ),
					'h3' 				=> esc_html__( 'h3', 'mt-addons' ),
					'h4' 				=> esc_html__( 'h4', 'mt-addons' ),
					'h5' 				=> esc_html__( 'h5', 'mt-addons' ),
					'h6' 				=> esc_html__( 'h6', 'mt-addons' ),
					'p' 				=> esc_html__( 'p', 'mt-addons' ),
					'div' 				=> esc_html__( 'div', 'mt-addons' ),
				],
				'default' 			=> 'p',
			]
		);
		$repeater->add_control(
			'after_subtitle',
			[
				'label' 	  		=> esc_html__( 'After Subtitle Text', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 		  		=> Controls_Manager::TEXT,
				'default'     		=> esc_html__( 'After SubTitle Text', 'mt-addons' ),
			]
		); 
		$repeater->add_control(
			'after_tag',
			[
				'label' 			=> esc_html__( 'Element After Tag', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'h1' 				=> esc_html__( 'h1', 'mt-addons' ),
					'h2'				=> esc_html__( 'h2', 'mt-addons' ),
					'h3' 				=> esc_html__( 'h3', 'mt-addons' ),
					'h4' 				=> esc_html__( 'h4', 'mt-addons' ),
					'h5' 				=> esc_html__( 'h5', 'mt-addons' ),
					'h6' 				=> esc_html__( 'h6', 'mt-addons' ),
					'p' 				=> esc_html__( 'p', 'mt-addons' ),
					'div' 				=> esc_html__( 'div', 'mt-addons' ),
				],
				'default' 			=> 'h1',
			]
		);
		$repeater->add_control(
			'button_status',
			[
				'label' 			=> esc_html__( 'Button', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		); 
		$repeater->add_control(
			'slider_button_text',
			[
				'label' 			=> esc_html__( 'Text', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default'     		=> esc_html__( 'Shop Now', 'mt-addons' ),
				'condition' 		=> [
					'button_status' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'button_style',
			[
				'label' 			=> esc_html__( 'Style', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'round' 			=> esc_html__( 'Round (30px Radius)', 'mt-addons' ),
					'rounded'			=> esc_html__( 'Rounded (5px Radius)', 'mt-addons' ),
					'square'			=> esc_html__( 'Square', 'mt-addons' ),
				],
				'default' 			=> 'rounded',
				'condition' 		=> [
					'button_status' 	=> 'yes',
				],
			]
		);
		$repeater->add_control(
            'button_padding',
            [
                'label'      		=> esc_html__( 'Padding', 'mt-addons' ),
                'type'       		=> Controls_Manager::DIMENSIONS,
                'condition' 		=> [
					'button_status' 	=> 'yes',
				],
                'size_units' 		=> ['px', '%', 'em'],
				'default' 			=> [
					'top' 				=> 15,
					'right' 			=> 30,
					'bottom' 			=> 15,
					'left' 				=> 30,
					'unit' 				=> 'px',
					'isLinked' 		=> false,
				],
                'selectors'  => [
                    '{{WRAPPER}} .mt-addons-hero-slider-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
		$repeater->add_control(
	    	'slider_button_url',
	        [
	            'label' 			=> esc_html__('Link', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT,
	            'condition' 		=> [
					'button_status' 	=> 'yes',
				],
	        ]
	    );
		$repeater->add_control(
			'slider_button_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-button' => 'color: {{VALUE}}',
                ],
				'condition' 		=> [
					'button_status' 	=> 'yes',
				],
			]
		);
		$repeater->add_control(
			'slider_button_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Hover Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-button:hover' => 'color: {{VALUE}}',
                ],
				'condition' 		=> [
					'button_status' 	=> 'yes',
				],
			]
		);
		$repeater->add_control(
			'slider_button_background',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-hero-slider-button' => 'background: {{VALUE}}',
                ],
				'condition' 		=> [
					'button_status' 	=> 'yes',
				],
			]
		);
		$repeater->add_control( 
			'slider_button_hover_bg',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background Hover', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mt-addons-hero-slider-button:hover' => 'background: {{VALUE}}',
                ],
				'condition' 		=> [
					'button_status' 	=> 'yes',
				],
			]
		);
	    $this->add_control(
	        'sliders_groups',
	        [    
	            'label' 			=> esc_html__('Sliders Items', 'mt-addons'),
	            'type' 				=> Controls_Manager::REPEATER,
	            'fields' 			=> $repeater->get_controls(),
	            'default' 			=> [ 
	            	[                      
                        'section_align' 			  => esc_html__( 'left', 'mt-addons' ),
                        'title' 					  => esc_html__( ' Quality Audio ', 'mt-addons' ),
                        'title_tag' 				  => esc_html__( 'h2', 'mt-addons' ),
                        'subtitle' 					  => esc_html__( ' ── ', 'mt-addons' ),
                        'subtitle_tag' 				  => esc_html__( 'h2', 'mt-addons' ),
                        'before_title' 				  => esc_html__( ' Phone Earbuds ', 'mt-addons' ),
                        'before_tag' 				  => esc_html__( 'h3', 'mt-addons' ),
                        'after_subtitle' 			  => esc_html__( ' $199 OFF ', 'mt-addons' ),
                        'after_tag' 				  => esc_html__( 'h3', 'mt-addons' ),
                        'button_status' 			  => esc_html__( 'no', 'mt-addons' ),
                        'slider_button_text' 		  => esc_html__( 'Shop Now', 'mt-addons' ),
                        'button_style' 				  => esc_html__( 'rounded', 'mt-addons' ),
                        'slider_button_url' 		  => esc_url( '#', 'mt-addons' ),
                        'slider_button_color' 		  => esc_attr( '#ffffff', 'mt-addons' ),
                        'slider_button_color_hover'   => esc_attr( '#111111', 'mt-addons' ),
                        'slider_button_background' 	  => esc_attr(  '#111111', 'mt-addons' ),
                        'slider_button_hover_bg'      => esc_attr( '#ffffff', 'mt-addons' ),
                    ],
	            ],
	        ]
	    );
		$this->end_controls_section();
		$this->start_controls_section(
            'section_responsive',
            [
                'label' 			=> esc_html__( 'Responsive', 'mt-addons' ),
            ]
        );
        $this->add_responsive_control(
			'title_status',
			[
				'label' 			=> esc_html__( 'Show/Hide title text', 'mt-addons' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'On', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Off', 'mt-addons' ),
				'return_value'		=> 'none',
				'default'			=> 'block',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-hero-slider-title' => 'display: {{label_on}}',
				],
			]
		);
        $this->add_responsive_control(
			'subtitle_status',
			[
				'label' 			=> esc_html__( 'Show/Hide subtitle text', 'mt-addons' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'On', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Off', 'mt-addons' ),
				'return_value'		=> 'none',
				'default'			=> 'block',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-hero-slider-subtitle' => 'display: {{label_on}}',
				],
			]
		);
		$this->add_responsive_control(
			'before_status',
			[
				'label' 			=> esc_html__( 'Show/Hide before text', 'mt-addons' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'On', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Off', 'mt-addons' ),
				'return_value'		=> 'none',
				'default'			=> 'block',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-hero-slider-beftitle' => 'display: {{label_on}}',
				],
			]
		);
		$this->add_responsive_control(
			'after_status',
			[
				'label' 			=> esc_html__( 'Show/Hide aftersubtitle text', 'mt-addons' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'On', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Off', 'mt-addons' ),
				'return_value'		=> 'none',
				'default'			=> 'block',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-hero-slider-aftersubtitle' => 'display: {{label_on}}',
				],
			]
		);
		$this->add_responsive_control(
			'button_status',
			[
				'label' 			=> esc_html__( 'Show/Hide button', 'mt-addons' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'On', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Off', 'mt-addons' ),
				'return_value'		=> 'none',
				'default'			=> 'block',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-hero-slider-button' => 'display: {{label_on}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
          'section_slider_hero_settings',
          [
              'label' 				=> esc_html__( 'Carousel', 'mt-addons' ),
          ]
        );

        $this->add_control(
          'items_desktop',
          [
            'label' 				=> esc_html__( 'Visible Items (Desktop)', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::NUMBER,
            'default' 				=> 1,
          ]
        );
        $this->add_control(
          'items_mobile',
          [
            'label' 				=> esc_html__( 'Visible Items (Mobiles)', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::NUMBER,
            'default' 				=> 1,
          ]
        );
        $this->add_control(
          'items_tablet',
          [
            'label' 				=> esc_html__( 'Visible Items (Tablets)', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::NUMBER,
            'default' 				=> 1,
          ]
        );
        $this->add_control(
          'autoplay',
          [
            'label' 				=> esc_html__( 'AutoPlay', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default' 				=> 'no',
          ]
        );
        $this->add_control(
          'delay',
          [
            'label' 				=> esc_html__( 'Slide Speed (in ms)', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::NUMBER,
            'min' 					=> 500,
            'max' 					=> 10000,
            'step' 					=> 100,
            'default' 				=> 600,
          ]
        );
        $this->add_control(
          'navigation',
          [
            'label' 				=> esc_html__( 'Navigation', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default' 				=> 'no',
          ]
        );
        $this->add_control(
          'navigation_position',
          [
            'label' 				=> esc_html__( 'Navigation Position', 'mt-addons' ),
            'label_block' 			=> true,
            'type' 					=> Controls_Manager::SELECT,
            'default' 				=> '',
            'options' 				=> [
              ''           				=> esc_html__( 'Select Option', 'mt-addons' ),
              'nav_above_left'       	=> esc_html__( 'Above Slider Left', 'mt-addons' ),
              'nav_above_center'     	=> esc_html__( 'Above Slider Center', 'mt-addons' ),
              'nav_above_right'      	=> esc_html__( 'Above Slider Right', 'mt-addons' ),
              'nav_top_left'         	=> esc_html__( 'Top Left (In Slider)', 'mt-addons' ),
              'nav_top_center'     		=> esc_html__( 'Top Center (In Slider)', 'mt-addons' ),
              'nav_top_right'      		=> esc_html__( 'Top Right (In Slider)', 'mt-addons' ),
              'nav_middle'         		=> esc_html__( 'Middle Left/Right ( In Slider)', 'mt-addons' ),
              'nav_middle_slider'  		=> esc_html__( 'Middle (Left/Right)', 'mt-addons' ),
              'nav_bottom_left'      	=> esc_html__( 'Bottom Left (In Slider)', 'mt-addons' ),
              'nav_bottom_center'    	=> esc_html__( 'Bottom Center (In Slider)', 'mt-addons' ),
              'nav_bottom_right'     	=> esc_html__( 'Bottom Right (In Slider)', 'mt-addons' ),
              'nav_below_left'     		=> esc_html__( 'Below Slider Left', 'mt-addons' ),
              'nav_below_center'     	=> esc_html__( 'Below Slider Center', 'mt-addons' ),
              'nav_below_right'      	=> esc_html__( 'Below Slider Right', 'mt-addons' ),
            ],
            'condition' 			=> [
              'navigation' 				=> 'yes',
            ],
          ]
        );
        $this->add_control(
          'nav_style',
          [
            'label' 				=> esc_html__( 'Navigation Shape', 'mt-addons' ),
            'label_block' 			=> true,
            'type'		 			=> Controls_Manager::SELECT,
            'default' 				=> '',
            'options' 				=> [
              ''           				=> esc_html__( 'Select Option', 'mt-addons' ),
              'nav-square'       		=> esc_html__( 'Square', 'mt-addons' ),
              'nav-rounde'     			=> esc_html__( 'Rounded (5px Radius)', 'mt-addons' ),
              'nav-round'      			=> esc_html__( 'Round (50px Radius)', 'mt-addons' ),
            ],
            'condition' 			=> [
              'navigation' 				=> 'yes',
            ],
          ]
        );
        $this->add_control(
          'navigation_color',
          [
            'type' 					=> \Elementor\Controls_Manager::COLOR,
            'label' 				=> esc_html__( 'Navigation color', 'mt-addons' ),
            'label_block' 			=> true,
            'condition' 			=> [
              'navigation' 			=> 'yes',
            ],
            'selectors' 			=> [
                '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'color: {{VALUE}};',
            ],
          ]
        );
        $this->add_control(
          	'navigation_bg_color',
          	[
            	'type' 				=> \Elementor\Controls_Manager::COLOR,
            	'label' 			=> esc_html__( 'Navigation Background color', 'mt-addons' ),
            	'label_block' 		=> true,
            	'selectors' 		=> [
                	'{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'background-color: {{VALUE}};',
            	],
            	'condition' 		=> [
              		'navigation' 		=> 'yes',
            	],
          	]
        );
        $this->add_control(
          'navigation_color_hover',
          [
            'type' 					=> \Elementor\Controls_Manager::COLOR,
            'label' 				=> esc_html__( 'Navigation Color Hover', 'mt-addons' ),
            'label_block' 			=> true,
            'selectors' 			=> [
                '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'color: {{VALUE}};',
            ],
            'condition' 			=> [
              'navigation' 				=> 'yes',
            ],
          ]
        );
        $this->add_control(
          'navigation_bg_color_hover',
          [
            'type' 					=> \Elementor\Controls_Manager::COLOR,
            'label' 				=> esc_html__( 'Navigation Background color - Hover', 'mt-addons' ),
            'label_block' 			=> true,
            'selectors' 			=> [
                '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'background: {{VALUE}}',
            ],
            'condition' 			=> [
              'navigation' 				=> 'yes',
            ],
          ]
        );
        $this->add_control(
          'pagination',
          [
            'label' 				=> esc_html__( 'Pagination (dots)', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default' 				=> 'no',
          ]
        );
        $this->add_control(
          'pagination_color',
          [
            'type' 					=> \Elementor\Controls_Manager::COLOR,
            'label' 				=> esc_html__( 'Pagination color', 'mt-addons' ),
            'label_block' 			=> true,
            'selectors' 			=> [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}',
            ],
            'condition' 			=> [
              'pagination' 				=> 'yes',
            ],
          ]
        );
        $this->add_control(
          'space_items',
          [
            'label' 				=> esc_html__( 'Space Between Items', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::NUMBER,
            'default' 				=> 30,
          ]
        );
        $this->add_control(
          'touch_move',
          [
            'label' 				=> esc_html__( 'Allow Touch Move', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default' 				=> 'no',
          ]
        );
        $this->add_control(
          'grab_cursor',
          [
            'label' 				=> esc_html__( 'Grab Cursor', 'mt-addons' ),
            'placeholder' 			=> esc_html__( 'If checked, will show the mouse pointer over the carousel', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default'      			=> 'no',
          ]
        );
        $this->add_control(
          'effect',
          [
            'label' 				=> esc_html__( 'Carousel Effect', 'mt-addons' ),
            'placeholder' 			=> esc_html__( "See all availavble effects on <a target='_blank' href='https://swiperjs.com/demos#effect-fade'>swiperjs.com</a>", 'mt-addons' ),
            'label_block' 			=> true,
            'type' 					=> Controls_Manager::SELECT,
            'default' 				=> '',
            'options' 				=> [
              ''               			=> esc_html__( 'Select Option', 'mt-addons' ),
              'creative'       			=> esc_html__( 'Creative', 'mt-addons' ),
              'cards'          			=> esc_html__( 'Cards', 'mt-addons' ),
              'coverflow'      			=> esc_html__( 'Coverflow', 'mt-addons' ),
              'cube'           			=> esc_html__( 'Cube', 'mt-addons' ),
              'fade'           			=> esc_html__( 'Fade', 'mt-addons' ),
              'flip'           			=> esc_html__( 'Flip', 'mt-addons' ),
            ],
          ]
        );
        $this->add_control(
          'infinite_loop',
          [
            'label' 				=> esc_html__( 'Infinite Loop', 'mt-addons' ),
            'placeholder' 			=> esc_html__( 'If checked, will show the numerical value of infinite loop', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default' 				=> 'no',
          ]
        );
        $this->add_control(
          'centered_slides',
          [
            'label' 				=> esc_html__( 'Centered Slides', 'mt-addons' ),
            'placeholder' 			=> esc_html__( 'If checked, the left side and the right side will have a partial slide visible.', 'mt-addons' ),
            'type' 					=> \Elementor\Controls_Manager::SWITCHER,
            'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
            'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
            'return_value' 			=> 'yes',
            'default' 				=> 'no',
          ]
        );
        $this->end_controls_section();
	}
	
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $sliders_groups 			= $settings['sliders_groups'];
        $autoplay 					= $settings['autoplay'];
        $delay 					    = $settings['delay'];
        $items_desktop 				= $settings['items_desktop'];
        $items_mobile 				= $settings['items_mobile'];
        $items_tablet 				= $settings['items_tablet'];
        $space_items 				= $settings['space_items'];
        $touch_move 				= $settings['touch_move'];
        $effect 					= $settings['effect'];
        $grab_cursor 				= $settings['grab_cursor'];
        $infinite_loop 				= $settings['infinite_loop'];
        $centered_slides 			= $settings['centered_slides'];
        $navigation_position 		= $settings['navigation_position'];
        $nav_style 					= $settings['nav_style'];
        $navigation 				= $settings['navigation'];
        $pagination 				= $settings['pagination'];

	    $id = 'mt-addons-swipper-'.uniqid();

	    $carousel_item_class = '';
	    $carousel_holder_class = '';
	    $swiper_wrapped_start = '';
	    $swiper_wrapped_end = '';
	    $swiper_container_start = '';
	    $swiper_container_end = '';
	    $html_post_swiper_wrapper = '';

	    $carousel_holder_class = 'mt-addons-swipper swiper'; 
	    $carousel_item_class = 'swiper-slide elementor-repeater-item-';

	    $swiper_wrapped_start = '<div class="swiper-wrapper">';
	    $swiper_wrapped_end = '</div>';
	    
	    $swiper_container_start = '<div class="mt-addons-swiper-container">';
	    $swiper_container_end = '</div>';
	    
	    if($navigation == "yes") { 
	        // next/prev
	        $html_post_swiper_wrapper .= '
	        <div class="dashicons dashicons-arrow-left-alt swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></div>
	        <div class="dashicons dashicons-arrow-right-alt swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></div>';
	    }
	   	if($pagination == "yes") { 
	        //pagination
	        $html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
	    }
 	?>
    <?php //swiper container start ?>
    <?php echo wp_kses_post($swiper_container_start); ?>
    <div class="mt-swipper-carusel-position" style="position:relative;">
        <div id="<?php echo esc_attr($id); ?>" 
          	<?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides, $navigation, $pagination); ?> class="mt-addons-hero-slider <?php echo esc_attr($carousel_holder_class); ?>">

            	<?php //swiper wrapped start ?>
            	<?php echo wp_kses_post($swiper_wrapped_start); ?>
            	<?php //items ?>
            	<?php if ($sliders_groups) { ?>
                	<?php foreach ($sliders_groups as $slider) {
                    	$slider_button_background   = $slider['slider_button_background'];
                    	$slider_button_color_hover  = $slider['slider_button_color_hover'];
                    	$slider_button_url 			= $slider['slider_button_url'];
                    	$background_image 			= $slider['background_image']['url'];
                    	$title_tag 					= $slider['title_tag'];
                    	$subtitle_tag 				= $slider['subtitle_tag'];
                    	$after_tag 					= $slider['after_tag'];
                    	$button_status 				= $slider['button_status'];
                    	$before_tag 				= $slider['before_tag'];
                    	$button_style 				= $slider['button_style'];
                    	$slider_button_text 		= $slider['slider_button_text']; ?>
                 
                    	<div class="<?php echo esc_attr($carousel_item_class)?> elementor-repeater-item-<?php echo esc_attr($slider['_id'])?>">
	                    	<div class="mt-addons-hero-slider-background">
	                    		<img class="mt-addons-hero-slider-background-image" src="<?php echo esc_url($background_image); ?>" alt="mt-addons-image">
	                    		<div class="mt-addons-hero-slider-bg">
		                        	<div class="mtfe-container">
		                          		<div class="mt-addons-hero-slider-holder elementor-repeater-items-<?php echo esc_attr( $slider['_id'] ); ?>">
				                            <?php if(!empty($slider['before_title'])){ ?> 
				                            	<<?php echo Utils::validate_html_tag( $before_tag ); ?> class="mt-addons-hero-slider-beftitle">
				                              		<?php echo esc_html($slider['before_title']);?> 
				                            	</<?php echo Utils::validate_html_tag( $before_tag ); ?>>
				                            <?php } ?>
				                            <?php if(!empty($slider['title'])){ ?>
				                            	<<?php echo Utils::validate_html_tag( $title_tag ); ?> class="mt-addons-hero-slider-title"> 
				                            		<?php echo esc_html($slider['title']);?> 
				                            	</<?php echo Utils::validate_html_tag( $title_tag ); ?>>
				                            <?php } ?>
				                            <?php if(!empty($slider['subtitle'])){ ?>
				                            	<<?php echo Utils::validate_html_tag( $subtitle_tag ); ?> 
				                            	class="mt-addons-hero-slider-subtitle"> 
				                            		<?php echo esc_html($slider['subtitle']);?> 
				                            	</<?php echo Utils::validate_html_tag( $subtitle_tag ); ?>>
				                            <?php } ?>
				                            <?php if(!empty($slider['after_subtitle'])){ ?>
				                            	<<?php echo Utils::validate_html_tag( $after_tag ); ?>
				                            	class="mt-addons-hero-slider-aftersubtitle"> 
				                              		<?php echo esc_html($slider['after_subtitle']);?> 
				                            	</<?php echo Utils::validate_html_tag( $after_tag ); ?>>
				                            <?php } ?>
				                            <?php if( $button_status == "yes") { ?>
				                                <a href="<?php echo esc_url($slider_button_url);?>" class="relative ">
				                                  	<span class="mt-addons-hero-slider-button <?php echo esc_attr($button_style);?>">
				                                  		<?php echo esc_html($slider_button_text);?>
				                                  	</span>
				                                </a>
				                            <?php } ?>
		                          		</div>
		                        	</div>
	                      		</div>
	                    	</div>
                		</div>
                	<?php } ?>
              	<?php } ?>
	            <?php //swiper wrapped end ?>
	            <?php echo wp_kses_post($swiper_wrapped_end); ?>
	            <?php //pagination/navigation ?>
	            <?php echo wp_kses_post($html_post_swiper_wrapper); ?>
        	</div>
      	</div>
    <?php //swiper container end ?>
    <?php echo wp_kses_post($swiper_container_end); ?>
    <?php
	}
	
	protected function content_template() {

    }
}