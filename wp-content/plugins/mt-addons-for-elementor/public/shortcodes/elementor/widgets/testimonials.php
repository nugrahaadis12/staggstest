<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_testimonials extends Widget_Base {
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-testimonials', MT_ADDONS_PUBLIC_ASSETS.'css/testimonials.css');
      	wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');
        return [
            'mt-addons-testimonials',
            'swiper-bundle',
        ];
    }
	use ContentControlSlider;
	use ContentControlHelp;

	public function get_name() {
		return 'mtfe-testimonials';
	}
	
	public function get_title() {
		return esc_html__( 'MT - Testimonials', 'mt-addons' );
	}
	
	public function get_icon() {
		return 'eicon-testimonial';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
    public function get_script_depends() {
        
        wp_register_script( 'swiper', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/swiperjs/swiper-bundle.min.js');
        wp_register_script( 'mt-addons-swiper', MT_ADDONS_PUBLIC_ASSETS.'js/swiper.js');
        
        return [ 'jquery', 'elementor-frontend', 'swiper', 'mt-addons-swiper' ];
    }
	protected function register_controls() {

        $this->section_title();
        $this->section_slider_hero_settings();
        $this->section_help_settings();
    }
    private function section_title() {

        $this->start_controls_section(
            'section_title',
            [
                'label' 			=> esc_html__( 'Content', 'mt-addons' ),
            ]
        );
		$this->add_control(
			'section_align',
			[
				'label' 			=> esc_html__( 'Text Description Aligment', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'text-left' 		=> esc_html__( 'Left', 'mt-addons' ),
					'text-center'		=> esc_html__( 'Center', 'mt-addons' ),
					'text-right' 		=> esc_html__( 'Right', 'mt-addons' ),
				],
                'default' 			=> 'text-center',
			]
		);
		$this->add_control(
			'section_align_image',
			[
				'label' 			=> esc_html__( 'Image/Position Aligment', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 							=> __( 'Select', 'mt-addons' ),
					'text-and-img-left' 		=> esc_html__( 'Left', 'mt-addons' ),
					'text-and-img-center'		=> esc_html__( 'Center', 'mt-addons' ),
					'text-and-img-right' 		=> esc_html__( 'Right', 'mt-addons' ),
				],
                'default' => 'text-and-img-center',
			]
		);
		$this->add_control(
			'holder_image_position',
			[
				'label' 			=> esc_html__( 'Holder image Position', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 							=> esc_html__( 'Select', 'mt-addons' ),
					'mt-addons-holder_down' 	=> esc_html__( 'Down', 'mt-addons' ),
					'mt-addons-holder_top'		=> esc_html__( 'Top', 'mt-addons' ),
				],
                'default' => 'mt-addons-holder_down',
			]
		);
		$this->add_control(
			'image_shape',
			[
				'label' 			=> esc_html__( 'Image Shape', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'img-rounded' 		=> esc_html__( 'Rounded', 'mt-addons' ),
					'img-circle'		=> esc_html__( 'Circle', 'mt-addons' ),
					'img-square' 		=> esc_html__( 'Square', 'mt-addons' ),
				],
				'default' 			=> 'img-rounded',
			]
		);
		$this->add_control(
			'testimonial_bg_item', 
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background Item', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-item' => 'background-color: {{VALUE}}',
                ],
			]
		);
		$this->add_control(
		    'testimonial_bg_height',
		    [
		        'label' 			=> esc_html__( 'Item Height', 'mt-addons' ),
		        'label_block' 		=> true,
		        'type' 				=> Controls_Manager::NUMBER,
		       'selectors' 			=> [
				    '{{WRAPPER}} .mt-addons-testimonial-item'  => 'height: {{VALUE}}px!important',
				],
		    ]
		);
    	$repeater = new Repeater();
		$repeater->add_control(
		'list_image',
			[
				'label' 			=> esc_html__( 'Image', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
	    'testimonial_description',
	        [
	            'label' 			=> esc_html__('Description', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXTAREA
	        ]
	    );
	    $repeater->add_control(
	    	'testimonial_short_description',
	        [
	            'label' 			=> esc_html__('Short Description', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'testimonial_name',
	        [
	            'label' 			=> esc_html__('Name', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'testimonial_date',
	        [
	            'label' 			=> esc_html__('Date', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
		$repeater->add_control(
	    	'testimonial_position',
	        [
	            'label' 			=> esc_html__('Position', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $this->add_control(
	        'testimonials_groups',
	        [
	            'label' 			=> esc_html__('Items', 'mt-addons'),
	            'type' 				=> Controls_Manager::REPEATER,
	            'fields' 			=> $repeater->get_controls(),
	            'default' 			=> [
                    [
                        'testimonial_description' 		=> esc_html__( '"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam mod tempora incidunt!"', 'mt-addons' ),
                        'testimonial_short_description' => esc_html__( '', 'mt-addons' ),
                        'testimonial_name' 				=> esc_html__( 'Elena Jackson', 'mt-addons' ),
                        'testimonial_date' 				=> esc_html__( '', 'mt-addons' ),
                        'testimonial_position' 			=> esc_html__( 'Bank Director', 'mt-addons' ),

                    ],
                    [
                        'testimonial_description' 		=> esc_html__( '"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam mod tempora incidunt!"', 'mt-addons' ),
                        'testimonial_short_description' => esc_html__( '', 'mt-addons' ),
                        'testimonial_name' 				=> esc_html__( 'Elena Jackson', 'mt-addons' ),
                        'testimonial_date' 				=> esc_html__( '', 'mt-addons' ),
                        'testimonial_position' 			=> esc_html__( 'Bank Director', 'mt-addons' ),

                    ],
                    [
                        'testimonial_description' 		=> esc_html__( '"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam mod tempora incidunt!"', 'mt-addons' ),
                        'testimonial_short_description' => esc_html__( '', 'mt-addons' ),
                        'testimonial_name' 				=> esc_html__( 'Elena Jackson', 'mt-addons' ),
                        'testimonial_date' 				=> esc_html__( '', 'mt-addons' ),
                        'testimonial_position' 			=> esc_html__( 'Bank Director', 'mt-addons' ),

                    ],
                ],
	        ]
	    );
		$this->end_controls_section();
		$this->start_controls_section(
			'title_tab',
			[
				'label' 			=> esc_html__( 'Quote', 'mt-addons' ),
			]
		);
		$this->add_control(  
			'quote_testimonial',
			[
				'label' 			=> esc_html__( 'Status', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
		$this->add_control(
			'aligment',
			[
				'label' 			=> esc_html__( 'Quote Aligment', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'text-left' 		=> esc_html__( 'Left', 'mt-addons' ),
					'text-center'		=> esc_html__( 'Center', 'mt-addons' ),
					'text-right' 		=> esc_html__( 'Right', 'mt-addons' ),
				],
				'default' 			=> 'no',
				'condition' 		=> [
					'quote_testimonial' => 'text-left',
				],
			]
		);
		$this->add_control(
			'quote_position',
			[
				'label' 			=> esc_html__( 'Quotes Position', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 						=> esc_html__( 'Select', 'mt-addons' ),
					'top-content' 			=> esc_html__( 'Top Content', 'mt-addons' ),
					'background-content'	=> esc_html__( 'Background Content', 'mt-addons' ),
				],
				'default' 			=> 'background-content',
				'condition' 		=> [
					'quote_testimonial' 	=> 'yes',
				],
			]
		); 
		$this->add_control(
			'quote_size',
			[
				'label' 			=> esc_html__( 'Quote Font size', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 100,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-quote-image' => 'font-size: {{VALUE}}px;',
                ],
				'condition' 		=> [
					'layout' 			=> 'grid',
				],
				'condition'	 		=> [
					'quote_testimonial' => 'yes',
				],
			]
		);
		$this->add_control(
			'quote_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Quote Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#DD3333',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-quote-image' => 'color: {{VALUE}};',
                ],
				'condition' 		=> [
					'quote_testimonial' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'title_tab_styling',
			[
				'label' 			=> esc_html__( 'Title', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'title_fileds_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-testimonial-name',
                'fields_options' 	=> [
                    'typography'    	=> ['default' => 'yes'],
                    'font_size'     	=> ['default' => ['size' => 17]],
                    'font_weight'   	=> ['default' => 500],
                ],
            ]
        );
		$this->add_control(
			'title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'default' 			=> '#000000',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-name' => 'color: {{VALUE}};',
                ],
				'label_block' 		=> true,
			]
		); 
		$this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_date',
            [
                'label' 			=> esc_html__( 'Date', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'date_fileds_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} p.mt-addons-testimonial-date',
            ]
        );
		$this->add_control(
			'testimonial_date_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#000000',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-date' => 'color: {{VALUE}};',
                ],
			]
		); 
		$this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_position',
            [
                'label' 			=> esc_html__( 'Position', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'position_fileds_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-testimonial-position',
            ]
        );
        $this->add_control(
			'section_align_position',
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
				'default' 			=> 'center',
				'selectors' 		=> [ 
					'{{WRAPPER}} .mt-addons-testimonial-position' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'position_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#000000',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-position' => 'color: {{VALUE}};',
                ],
			]
		);
		$this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_description',
            [
                'label' 			=> esc_html__( 'Description', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'description_fileds_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-testimonial-description',
                'fields_options' 	=> [
                    'typography'   		=> ['default' => 'yes'],
                    'font_size'     	=> ['default' => ['size' => 25]],
                    'font_weight'   	=> ['default' => 500],
                ],
            ]
        );
		$this->add_control(
			'description_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#000000',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-description' => 'color: {{VALUE}};',
                ],
			]
		);
		$this->add_control(
            'description_padding',
            [
                'label' 			=> esc_html__( 'Padding', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em' ],
                'default' 			=> [
                    'top' 				=> 30,
                    'right' 			=> 30,
                    'bottom' 			=> 30,
                    'left' 				=> 30,
                    'unit' 				=> 'px',
                    'isLinked' 			=> false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-testimonial-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_short_description',
            [
                'label' 			=> esc_html__( 'Short Description', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'fileds_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} p.mt-addons-testimonial-short-description',
            ]
        ); 
		$this->add_control(
			'short_description_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#000000',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-short-description' => 'color: {{VALUE}};',
                ],
			]
		);

        $this->end_controls_tab();
		$this->end_controls_section();

		$this->start_controls_section(
            'style_block',
            [
                'label' 			=> esc_html__( 'Block', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'testimonial_block_bg',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '',
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-item' => 'background: {{VALUE}};',
                ],
			]
		);
		$this->add_control(
            'block_padding',
            [
                'label' 			=> esc_html__( 'Padding', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em' ],
                'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'block_border_radius',
            [
                'label' 			=> esc_html__( 'Border Radius', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em' ],
                'default' 			=> [
                    'top' 				=> 50,
                    'right' 			=> 50,
                    'bottom' 			=> 50,
                    'left' 				=> 50,
                    'unit' 				=> 'px',
                    'isLinked' 			=> false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-testimonial-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' 				=> 'border',
                'label' 			=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-testimonial-item',
            ]
        ); 
		$this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_image',
            [
                'label' 			=> esc_html__( 'Image', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'image_padding',
            [
                'label' 			=> esc_html__( 'Padding', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em' ],
                'selectors'		 	=> [
                    '{{WRAPPER}} .mt-addons-testimonial-image-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border-radius',
            [
                'label' 			=> esc_html__( 'Border Radius', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em' ],
                'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-testimonial-image-holder img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_tab();
        $this->end_controls_section();
	}
	protected function render() {
   		$settings 					= $this->get_settings_for_display();
		$section_align 				= $settings['section_align'] ?? '';
		$testimonials_groups 		= $settings['testimonials_groups'] ?? '';
		$quote_testimonial 			= $settings['quote_testimonial'] ?? '';
		$quote_position 			= $settings['quote_position'] ?? '';
		$quote_size 				= $settings['quote_size'] ?? '';
		$quote_color 				= $settings['quote_color'] ?? '';
		$title_color 				= $settings['title_color'] ?? '';
		$position_color 			= $settings['position_color'] ?? '';
		$description_color 			= $settings['description_color'] ?? '';
		$aligment 					= $settings['aligment'] ?? '';
		$section_align_image 		= $settings['section_align_image'] ?? '';
		$testimonial_date_color 	= $settings['testimonial_date_color'] ?? '';
		$autoplay 					= $settings['autoplay'] ?? '';
		$delay 						= $settings['delay'] ?? '';
		$items_desktop 				= $settings['items_desktop'] ?? '';
		$items_mobile 				= $settings['items_mobile'] ?? '';
		$items_tablet 				= $settings['items_tablet'] ?? '';
		$space_items 				= $settings['space_items'] ?? '';
		$touch_move 				= $settings['touch_move'] ?? '';
		$effect 					= $settings['effect'] ?? '';
		$grab_cursor 				= $settings['grab_cursor'] ?? '';
		$infinite_loop 				= $settings['infinite_loop'] ?? '';
		$columns 					= $settings['columns'] ?? '';
		$layout 					= $settings['layout'] ?? '';
		$centered_slides 			= $settings['centered_slides'] ?? '';
		$navigation_position 		= $settings['navigation_position'] ?? '';
		$nav_style 					= $settings['nav_style'] ?? '';
		$navigation 				= $settings['navigation'] ?? '';
		$pagination 				= $settings['pagination'] ?? '';
		$holder_image_position 		= $settings['holder_image_position'] ?? '';
		$image_shape 				= $settings['image_shape'] ?? '';

	    $quote_position_style = 'before_content';
	    if($quote_position == "before_content") {
	      $quote_position_style = 'before_content';
	    } elseif ($quote_position == "background_content") {
	      $quote_position_style = 'background_content';
	    }

    	$id = 'mt-addons-carousel-'.uniqid();
	    $carousel_item_class = $columns;
	    $carousel_holder_class = '';
	    $swiper_wrapped_start = '';
	    $swiper_wrapped_end = '';
	    $swiper_container_start = '';
	    $swiper_container_end = '';
	    $html_post_swiper_wrapper = '';

	    if ($layout == "carousel") {
	      	$carousel_holder_class = 'mt-addons-swipper swiper';
	      	$carousel_item_class = 'swiper-slide';

	      	$swiper_wrapped_start = '<div class="swiper-wrapper">';
	      	$swiper_wrapped_end = '</div>';

	      	$swiper_container_start = '<div class="mt-addons-swiper-container">';
	      	$swiper_container_end = '</div>';

	      	if($navigation == "yes") { 
	        	// next/prev
	        	$html_post_swiper_wrapper .= '
	        	<i class="fas fa-arrow-left swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></i>
	        	<i class="fas fa-arrow-right swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></i>';
	      	}
	      	if($pagination == "yes") { 
	        	// pagination
	        	$html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
	      	}
	    }
		?>
    	<?php //swiper container start ?>
    	<?php echo wp_kses_post($swiper_container_start); ?>
      		<div class="mt-swipper-carusel-position relative">
        		<div id="<?php echo esc_attr($id); ?>" <?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?> class="mt-addons-testimonials-carusel mtfe-row <?php echo esc_attr($carousel_holder_class); ?>">
            		<?php //swiper wrapped start ?>
            		<?php echo wp_kses_post($swiper_wrapped_start); ?>
              			<?php //items ?>
              			<?php if ($testimonials_groups) { ?>
                			<?php foreach ($testimonials_groups as $testimonial) {
                    			$testimonial_name = $testimonial['testimonial_name'];
                    			$image_id = isset($testimonial['list_image']['url']) ? $testimonial['list_image']['url'] : null;
                  				?>
			                    <div class="mt-addons-testimonial-item relative <?php echo esc_attr($carousel_item_class.' '.$holder_image_position); ?> elementor-repeater-item-<?php echo esc_attr($testimonial['_id'])?>">
			                      	<?php if ($quote_testimonial == "yes") { ?>
			                        	<div class="mt-addons-quote-image <?php echo esc_attr($aligment.' '.$quote_position);?>">
			                          		<i class="fas fa-quote-right"></i>
			                       		</div>
			                      	<?php } ?>
			                      	<div class="mt-addons-testimonial-holder <?php echo esc_attr($section_align);?>">
			                      		<?php if(!empty($testimonial['testimonial_description'])){ ?>
				                        	<div class="mt-addons-testimonial-description">
				                        		<?php echo esc_html($testimonial['testimonial_description']);?>
				                        		<?php if(!empty($testimonial['testimonial_date'])){ ?>
				                         			<p class="mt-addons-testimonial-date">
				                            			<?php echo esc_html($testimonial['testimonial_date']); ?>
				                          			</p>
				                        		<?php } ?>
				                        	</div>
					                        <?php if(!empty($testimonial['testimonial_short_description'])){ ?>
						                        <p class="mt-addons-testimonial-short-description">
						                        	<?php echo esc_html($testimonial['testimonial_short_description']);?>
						                        </p>
					                      	<?php } ?>
			                      		<?php } ?>
			                    	</div>
			                    	<div class="mt-addons-testimonial-image-holder <?php echo esc_attr($section_align_image);?>">
			                        	<?php if ($image_id) { ?>
				                        	<div class="mt-addons-testimonial-image <?php echo esc_attr($section_align_image);?>">
				                            	<img src="<?php echo esc_url($image_id); ?>" alt="<?php echo esc_attr($testimonial_name); ?>" class="<?php echo esc_attr($image_shape); ?>" />
				                          	</div>
				                        <?php } ?>
				                        <div class="mt-addons-testimonial-title-position "> 
				                        	<?php if(!empty($testimonial['testimonial_name'])){ ?>
					                            <h4 class="mt-addons-testimonial-name">
					                            	<?php echo esc_html($testimonial['testimonial_name']); ?>
					                            </h4>
				                          		<?php if(!empty($testimonial['testimonial_position'])){ ?>
				                            		<div class="mt-addons-testimonial-position"><?php echo esc_html($testimonial['testimonial_position']);?>
				                            		</div>
				                          		<?php } ?>
				                        	<?php } ?>
				                      	</div>
			                    	</div>
			                    </div>
                			<?php } ?>
              			<?php } ?>
            		<?php //swiper wrapped end ?>
            		<?php echo wp_kses_post($swiper_wrapped_end); ?>
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