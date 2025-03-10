<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Utils;
use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_members extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-members', MT_ADDONS_PUBLIC_ASSETS.'css/members.css');
        wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');

        return [
            'mt-addons-members',
            'swiper-bundle',
        ];
    }
	use ContentControlSlider;
	use ContentControlHelp;
	public function get_name() {
		return 'mtfe-members';
	} 
	
	public function get_title() {
		return esc_html__('MT - Members','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-person';
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
        $this->section_team();
        $this->section_slider_hero_settings();
        $this->section_help_settings();
    }
	protected function section_title() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'General Settings', 'mt-addons' ),
			]
		);
		$this->add_control(
            'container_padding',
	        [
	            'label' 			=> esc_html__( 'Card Box Padding', 'mt-addons' ),
	            'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
	            'size_units' 		=> [ 'px', '%', 'em' ],
	            'selectors' 		=> [
	                '{{WRAPPER}} .mt-addons-member-columns-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        	],
	       	 	'default' 			=> [
	            	'unit' 				=> 'px',
	            	'size' 				=> 15,
	        	],
	        ]
	    );
	    $this->add_control(
            'container_margin',
	            [
	                'label' 		=> esc_html__( 'Card Box Margin', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons-member-columns' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     			=> 'container_border',
                'label'    			=> esc_html__( 'Card Box Border', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-member-columns-wrapper',
            ]
        );
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
            	'label' 			=> esc_html__( 'Card Box Shadow', 'mt-addons' ),
                'name'     			=> 'container_box_shadow',
                'selector' 			=> '{{WRAPPER}} .mt-addons-member-columns-wrapper',
            ]
        );
		$this->add_control(
            'image_shape',
	            [
	                'label' 		=> esc_html__( 'Image Shape', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons-member-image img, {{WRAPPER}} .mt-addons-member-image-flex-zone ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
		$this->add_control(
			'custom_dimension',
			[
				'label' 			=> esc_html__( 'Image width', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::NUMBER,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-member-image' => 'width: {{VALUE}}px',
                ],
			] 
		);
		$this->add_control(
			'disable_hover',
			[
				'label' 			=> esc_html__( 'Show social icons on hover?', 'mt-addons' ),
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'yes',
				'options' 			=> [
					'yes' 				=> esc_html__( 'Yes', 'mt-addons' ),
					'no' 				=> esc_html__( 'No', 'mt-addons' ),
				],
			]
		);
		$this->add_control(
			'overlay_bg',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Image Hover Background', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-member-image-flex-zone' => 'background: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'links_target',
			[
				'label' 			=> esc_html__( 'Open Link In New Tab', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
		$this->end_controls_section();
	}

	protected function section_team() {

		$this->start_controls_section(
			'section_team',
			[
				'label' 			=> esc_html__( 'Team Members', 'mt-addons' ),
			]
		);
	    $repeater = new Repeater();
		$repeater->add_control(
			'list_image',
			[
				'label' 			=> esc_html__( 'Image', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default'           => [
                    'url'           	=> Utils::get_placeholder_image_src(),
                ],
			]
		);
		$repeater->add_control(
	    	'member_name',
	        [
	            'label' 			=> esc_html__('Name', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
		$repeater->add_control(
	    	'member_position',
	        [
	            'label' 			=> esc_html__('Position', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
		$repeater->add_control(
	    	'member_description',
	        [
	            'label' 			=> esc_html__('Short description', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
		$repeater->add_control(
	    	'member_url',
	        [
	            'label' 			=> esc_html__('Website', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'email',
	        [
	            'label' 			=> esc_html__('Email', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'facebook',
	        [
	            'label' 			=> esc_html__('Facebook URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'twitter',
	        [
	            'label' 			=> esc_html__('Twitter URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'pinterest',
	        [
	            'label' 			=> esc_html__('Pinterest URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'instagram',
	        [
	            'label' 			=> esc_html__('Instagram URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'youtube',
	        [
	            'label' 			=> esc_html__('YouTube URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'linkedin',
	        [
	            'label' 			=> esc_html__('LinkedIn URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'dribbble',
	        [
	            'label' 			=> esc_html__('Dribbble URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'deviantart',
	        [
	            'label' 			=> esc_html__('Deviantart URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'digg',
	        [
	            'label' 			=> esc_html__('Digg URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'flickr',
	        [
	            'label'		 		=> esc_html__('Flickr URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'tumblr',
	        [
	            'label' 			=> esc_html__('Tumblr URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'stumbleupon',
	        [
	            'label' 			=> esc_html__('Stumbleupon URL', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $this->add_control(
	        'member_groups',
	        [
	            'label' 			=> esc_html__('Members Items', 'mt-addons'),
	            'type' 				=> Controls_Manager::REPEATER,
	            'fields' 			=> $repeater->get_controls(),
	            'default' 			=> [
					[
						'member_name' 		=> esc_html__( 'Melinda Steel', 'mt-addons' ),
						'member_position' 	=> esc_html__( 'Graphic & Motion Designer', 'mt-addons' ),
						'facebook'			=> '#',
						'twitter'			=> '#',
						'instagram'			=> '#',
					],
					[
						'member_name' 		=> esc_html__( 'Alex Dewes', 'mt-addons' ),
						'member_position' 	=> esc_html__( 'Frontend Web Developer', 'mt-addons' ),
						'facebook'			=> '#',
						'twitter'			=> '#',
						'instagram'			=> '#',
					],
					[
						'member_name' 		=> esc_html__( 'Joanne Lewis', 'mt-addons' ),
						'member_position' 	=> esc_html__( 'Customers Support', 'mt-addons' ),
						'facebook'			=> '#',
						'twitter'			=> '#',
						'instagram'			=> '#',
					],
				],
	        ]
	    );
	    $this->add_control(
			'aligment',
			[
				'label' 			=> esc_html__( 'Aligment', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'left' 				=> esc_html__( 'Left', 'mt-addons' ),
					'center'			=> esc_html__( 'Center', 'mt-addons' ),
					'right' 			=> esc_html__( 'Right', 'mt-addons' ),
				],
				'selectors' => [
        			'{{WRAPPER}} .mt-addons-member-section' => 'text-align: {{VALUE}};',
    			],
    			'default' 			=> 'left',
			]
		);
		$this->add_control(
            'info_padding',
	            [
	                'label' 		=> esc_html__( 'Info Padding', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons-member-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'info_radius',
	            [
	                'label' 		=> esc_html__( 'Info Border Radius', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons-member-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     			=> 'info_border',
                'label'    			=> esc_html__( 'Info Box Border', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-member-section',
            ]
        );
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
            	'label' 			=> esc_html__( 'Info Box Shadow', 'mt-addons' ),
                'name'     			=> 'info_box_shadow',
                'selector' 			=> '{{WRAPPER}} .mt-addons-member-section',
            ]
        );
        $this->add_control(
			'box_bg',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Box Background', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-member-section' => 'background: {{VALUE}};',
    			],
			]
		);
	    $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Name Typography', 'mt-addons' ),
				'name' 				=> 'name_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-member-name',
			]
		);
		$this->add_control(
			'name_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Name Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-member-url' => 'color: {{VALUE}};',
    			],
    			'default' 			=> '#000',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Position Typography', 'mt-addons' ),
				'name' 				=> 'position_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-member-position',
			]
		);
		$this->add_control(
			'position_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Position Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-member-position' => 'color: {{VALUE}};',
    			],
    			'default' 			=> '#888',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Description Typography', 'mt-addons' ),
				'name' 				=> 'description_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-member-description',
			]
		);
		$this->add_control(
			'description_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Description Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-member-description' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'icons_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Social Icons Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-member-image-flex-zone-inside.member_social a' => 'color: {{VALUE}};',
        			'{{WRAPPER}} .mt-addons-member-image-flex-zone-inside.member_social a svg' => 'fill: {{VALUE}};',
    			],
			]
		);
		$this->end_controls_section();
	}
	    
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $links_target 				= $settings['links_target'] ?? '';
	    $member_groups 				= $settings['member_groups'] ?? '';
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
	    $navigation_color 			= $settings['navigation_color'] ?? '';
	    $navigation_bg_color 		= $settings['navigation_bg_color'] ?? '';
	    $navigation_bg_color_hover 	= $settings['navigation_bg_color_hover'] ?? '';
	    $navigation_color_hover 	= $settings['navigation_color_hover'] ?? '';
	    $pagination_color 			= $settings['pagination_color'] ?? '';
	    $navigation 				= $settings['navigation'] ?? '';
	    $pagination 				= $settings['pagination'] ?? '';
	    $disable_hover 				= $settings['disable_hover'] ?? '';

    	$links_target_attr = '';
    	if ($links_target) {
      		$links_target_attr = 'target="'.$links_target.'"';
    	}
 
    	$id = 'mt-addons-carousel-'.uniqid();
    	$carousel_item_class = $columns;
    	$carousel_holder_class = '';
    	$swiper_wrapped_start = '';
    	$swiper_wrapped_end = '';
    	$html_post_swiper_wrapper = '';

    	if ($layout == "carousel") {
      		$carousel_holder_class = 'mt-addons-swipper swiper';
      		$carousel_item_class = 'swiper-slide';

      		$swiper_wrapped_start = '<div class="swiper-wrapper">';
      		$swiper_wrapped_end = '</div>';

      		if($navigation == "yes") { 
        		// next/prev
        		$html_post_swiper_wrapper .= '
        		<i class="fas fa-arrow-left swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'" style="color:'.esc_attr($navigation_color).'; background:'.esc_attr($navigation_bg_color).';"></i>
        		<i class="fas fa-arrow-right swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'" style="color:'.esc_attr($navigation_color).'; background:'.esc_attr($navigation_bg_color).';"></i>';
      		}
      		// next/prev
      		if($pagination == "yes") { 
        		$html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
      		}
    	} ?>

    	<div class="mt-swipper-carusel-position">
       		<?php if ($layout == "carousel") { ?>
        		<div id="<?php echo esc_attr($id); ?>" 
            		<?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?> class="mt-addons-members <?php echo esc_attr($carousel_holder_class); ?>">
       		<?php } else {  ?>
          		<div id="<?php echo esc_attr($id); ?>" 
            		<?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?> class="mt-addons-members mtfe-row <?php echo esc_attr($carousel_holder_class); ?>">
       		<?php } ?>

          	<?php //swiper wrapped start ?>
          	<?php echo wp_kses_post($swiper_wrapped_start); ?>

            <?php //items ?>
            <?php if ($member_groups) { ?>
              	<?php foreach ($member_groups as $param) {
                  	$image_url = '';
                  	$image_id = '';
                  	$member_link = '';
   
                    if ($param['list_image']['id']) {
                      	$image_id = $param['list_image']['id'];
                    	}else{
                      		$image_url = $param['list_image']['url'];
                    	}

                    	$member_link = $param['member_url'];
                    	$link = array(
                      		'target' => '_blank',
                      		'rel' => 'nofollow',
                    	);
                  
                  		if ($image_id) {
                    		$img_url = wp_get_attachment_image_src($image_id, 'full' )[0];
                  		}else{
                    		$img_url = $image_url;
                  		} ?>
                
                		<div class="mt-addons-member-columns <?php echo esc_attr($carousel_item_class); ?>">
                  			<div class="mt-addons-member-columns-wrapper">
                 				<?php if ($img_url) { ?>
                    				<div class="mt-addons-member-image">
                    					<?php if($member_link != ''){ ?>
                            				<a class="mt-addons-member-link" href="<?php echo esc_url($member_link); ?>" alt="<?php echo esc_attr($param['member_name']); ?>" target="<?php echo esc_attr($link['target']); ?>" rel="<?php echo esc_attr($link['rel']); ?>">
                        				<?php } ?>
                        				<img src="<?php echo esc_url($img_url); ?>" alt="<?php esc_attr_e('Member', 'mt-addons'); ?>" />
                      					<div class="mt-addons-member-image-flex-zone <?php echo esc_attr($disable_hover); ?>">
                        					<div class="mt-addons-member-image-flex-zone-inside member_social social-icons">
				                          		<?php if (isset($param['facebook']) && !empty($param['facebook'])) { ?>
				                            		<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['facebook']); ?>"><i class="fab fa-facebook-f"></i></a>
				                          		<?php } ?>
                          						<?php if (isset($param['twitter']) && !empty($param['twitter'])) { ?>
                            						<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['twitter']); ?>"><svg aria-hidden="true" class="e-font-icon-svg e-fab-x-twitter" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg></a>
                          						<?php } ?>
                          						<?php if (isset($param['pinterest']) && !empty($param['pinterest'])) { ?>
                            						<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['pinterest']); ?>"><i class="fab fa-pinterest"></i></a>
                          						<?php } ?>
                          						<?php if (isset($param['instagram']) && !empty($param['instagram'])) { ?>
                            						<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['instagram']); ?>"><i class="fab fa-instagram"></i></a>
                          						<?php } ?>
                          						<?php if (isset($param['youtube']) && !empty($param['youtube'])) { ?>
                            						<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['youtube']); ?>"><i class="fab fa-youtube"></i></a>
                          						<?php } ?>
					                          	<?php if (isset($param['dribbble']) && !empty($param['dribbble'])) { ?>
					                            	<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['dribbble']); ?>"><i class="fab fa-dribbble"></i></a>
					                          	<?php } ?>
                          						<?php if (isset($param['linkedin']) && !empty($param['linkedin'])) { ?>
					                            	<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['linkedin']); ?>"><i class="fab fa-linkedin"></i></a>
					                          	<?php } ?>
                          						<?php if (isset($param['deviantart']) && !empty($param['deviantart'])) { ?>
                            						<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['deviantart']); ?>"><i class="fab fa-deviantart"></i></a>
                          						<?php } ?>
                          						<?php if (isset($param['digg']) && !empty($param['digg'])) { ?>
                            						<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['digg']); ?>"><i class="fab fa-digg"></i></a>
                          						<?php } ?>
					                          	<?php if (isset($param['flickr']) && !empty($param['flickr'])) { ?>
					                            	<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['flickr']); ?>"><i class="fab fa-flickr"></i></a>
					                          	<?php } ?>
					                          	<?php if (isset($param['tumblr']) && !empty($param['tumblr'])) { ?>
					                            	<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['tumblr']); ?>"><i class="fab fa-tumblr"></i></a>
					                          	<?php } ?>
					                          	<?php if (isset($param['stumbleupon']) && !empty($param['stumbleupon'])) { ?>
					                            	<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['stumbleupon']); ?>"><i class="fab fa-stumbleupon"></i></a>
					                          	<?php } ?>
					                          	<?php if (isset($param['email']) && !empty($param['email'])) { ?>
					                            	<a <?php echo wp_kses($links_target_attr, 'link'); ?> href="<?php echo esc_url($param['email']); ?>"><i class="fab fa-envelope"></i></a>
					                          	<?php } ?>
                        					</div>
                      					</div>
                    				</div>
                  				<?php } ?>
                  				<div class="mt-addons-member-section"> 
                    				<?php if(!empty($param['member_name'])){ ?>
                      					<h3 class="mt-addons-member-name">
                        					<a href="<?php echo esc_url($param['member_url']); ?>" class="mt-addons-member-url"><?php echo esc_html($param['member_name']); ?>
                        					</a>
                      					</h3>
                    				<?php } ?>
                     
                    				<?php if(!empty($param['member_position'])){ ?>
                      					<div class="mt-addons-member-position"><?php echo esc_html($param['member_position']);?></div>
                    				<?php } ?>

                    				<?php if(!empty($param['member_description'])){ ?>
                      					<div class="mt-addons-member-description"><?php echo esc_html($param['member_description']);?></div>
                    				<?php } ?>
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
    
    <?php
	}
	protected function content_template() {

    }
}