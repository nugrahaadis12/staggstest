<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_clients extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-clients-carousel', MT_ADDONS_PUBLIC_ASSETS.'css/clients-carousel.css');
      	wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');
        return [
            'mt-addons-clients-carousel',
            'swiper-bundle',
        ];
    }
    public function get_script_depends() {
        
        wp_register_script( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/swiperjs/swiper-bundle.min.js');
        wp_register_script( 'mt-addons-swiper', MT_ADDONS_PUBLIC_ASSETS.'js/swiper.js');
        
        return [ 'jquery', 'elementor-frontend', 'swiper-bundle', 'mt-addons-swiper' ];
    }
	use ContentControlSlider;

	public function get_name() {
		return 'mtfe-clients';
	}
	
	use ContentControlHelp;
	
	public function get_title() {
		return esc_html__('MT - Clients','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-gallery-grid';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
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
		'client_name_status',
		[
			'label' 			=> esc_html__( 'Client Names', 'mt-addons' ),
			'type' 				=> \Elementor\Controls_Manager::SWITCHER,
			'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
			'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
			'return_value' 		=> 'yes',
			'default' 			=> 'off',
		]
	);
	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'label' 			=> esc_html__( 'Names Typography', 'mt-addons' ),
			'name' 				=> 'names_typography',
			'selector' 			=> '{{WRAPPER}} .mt-addons-heading a',
			'condition' 		=> [
				'client_name_status' => 'yes',
			],
		]
	);
	$this->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'     			=> 'client_border',
            'label'    			=> esc_html__( 'Border', 'mt-addons' ),
            'selector' 			=> '{{WRAPPER}} .mt-addons-client-image-holder',
        ]
    );
   	$this->add_control(
		'padding_clients',
		[
			'label' 			=> esc_html__( 'Spacing Clients', 'mt-addons' ),
			'type' 				=> \Elementor\Controls_Manager::NUMBER,
			'min' 				=> 0,
			'max' 				=> 999,
			'step' 				=> 5,
			'default' 			=> 15,
			'selectors' 		=> [
	           '{{WRAPPER}} .mt-addons-client-image-item' => 'padding: {{VALUE}}px !important;',
	        ],
		]
	);
    $this->add_control(
        'client_radius',
	    [
	        'label' 			=> esc_html__( 'Border Radius', 'mt-addons' ),
	        'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
	        'size_units' 		=> [ 'px', '%', 'em' ],
	        'selectors' 		=> [
	            '{{WRAPPER}} .mt-addons-client-image-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        ],
	        'default' 			=> [
	            'unit'			=> 'px',
	            'size' 			=> 0,
	        ],
	    ]
	);
	$this->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        [
            'name'     			=> 'client_box_shadow',
            'selector' 			=> '{{WRAPPER}} .mt-addons-client-image-holder',
        ]
    );
    $this->add_control(
        'client_padding',
	    [
	        'label' 			=> esc_html__( 'Padding', 'mt-addons' ),
	        'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
	        'size_units' 		=> [ 'px', '%', 'em' ],
	        'selectors' 		=> [
	            '{{WRAPPER}} .mt-addons-client-image-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        ],
	        'default' 			=> [
	            'unit' 			=> 'px',
	            'size' 			=> 0,
	        ],
	    ]
	);
	$this->add_control(
		'client_photo_height',
		[
			'label' 			=> esc_html__( 'Photo Height', 'mt-addons' ),
			'type' 				=> \Elementor\Controls_Manager::NUMBER,
			'selectors' 		=> [
        		'{{WRAPPER}} .mt-addons-client-image img' => 'height: {{VALUE}}px;',
    		],
			'default' 			=> '60',
		]
	);
	$this->add_control(
        'client_image_radius',
	     [
	        'label' 			=> esc_html__( 'Image Border Radius', 'mt-addons' ),
	        'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
	        'size_units' 		=> [ 'px', '%', 'em' ],
	        'selectors' 		=> [
	            '{{WRAPPER}} .mt-addons-client-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        ],
	        'default' 			=> [
	            'unit' 			=> 'px',
	            'size' 			=> 0,
	        ],
	    ]
	);
	$repeater = new Repeater();
	$repeater->add_control(
		'clients_image',
		[
			'label' 			=> esc_html__( 'Image', 'mt-addons' ),
			'type' 				=> \Elementor\Controls_Manager::MEDIA,
			'default' 			=> [
				'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
			],
		]
	);
	$repeater->add_control(
    	'clients_name',
        [
            'label' 			=> esc_html__('Client Name', 'mt-addons'),
            'type' 				=> Controls_Manager::TEXT
        ]
    );
	$repeater->add_control(
		'client_url',
		[
			'label' 			=> esc_html__( 'Client Link', 'mt-addons' ),
			'type' 				=> Controls_Manager::TEXT,
			'default' 			=> '#',
		]
	);
    $this->add_control(
        'clients_groups',
        [
            'label'			 	=> esc_html__('Items', 'mt-addons'),
            'type' 				=> Controls_Manager::REPEATER,
            'fields' 			=> $repeater->get_controls(),
            'default' 			=> [
				[
					'clients_image' => [
						'url' => MT_ADDONS_ASSETS.'logo.png',
					],
					'clients_name' 	=> esc_html__( 'Client', 'mt-addons' ),
					'client_url' 	=> esc_html__( 'https://modeltheme.com', 'mt-addons' ),
				],
				[
					'clients_image' => [
						'url' 		=> MT_ADDONS_ASSETS.'logo.png',
					],
					'clients_name' 	=> esc_html__( 'Client', 'mt-addons' ),
					'client_url' 	=> esc_html__( 'https://modeltheme.com', 'mt-addons' ),
				],
				[
					'clients_image' => [
						'url' 		=> MT_ADDONS_ASSETS.'logo.png',
					],
					'clients_name' 	=> esc_html__( 'Client', 'mt-addons' ),
					'client_url' 	=> esc_html__( 'https://modeltheme.com', 'mt-addons' ),
				],
			],

        ]
    );
    $this->add_control( 
		'grid_rows',
		[
			'label' 			=> esc_html__( 'Show Grid', 'mt-addons' ),
			'type' 				=> \Elementor\Controls_Manager::SWITCHER,
			'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
			'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
			'return_value' 		=> 'yes',
			'default' 			=> 'no',
			'condition' 		=> [
				'layout' 			=> 'carousel',
			],
		]
	);
	$this->end_controls_section();
	}
	    
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $client_name_status 		     = $settings['client_name_status'];
        $clients_groups 			       = $settings['clients_groups'];
        $autoplay 					         = $settings['autoplay'];
        $delay 					             = $settings['delay'];
        $items_desktop 				       = $settings['items_desktop'];
        $items_mobile 				       = $settings['items_mobile'];
        $items_tablet 				       = $settings['items_tablet'];
        $space_items 				         = $settings['space_items'];
        $touch_move 				         = $settings['touch_move'];
        $effect 					           = $settings['effect'];
        $grab_cursor 				         = $settings['grab_cursor'];
        $infinite_loop 				       = $settings['infinite_loop'];
        $columns 					           = $settings['columns'];
        $layout 					           = $settings['layout'];
        $centered_slides 			       = $settings['centered_slides'];
        $navigation_position 		     = $settings['navigation_position'];
        $nav_style 					         = $settings['nav_style'];
        $navigation_color 			     = $settings['navigation_color'] ?? '';
        $navigation_bg_color 		     = $settings['navigation_bg_color'] ?? '';
        $navigation_bg_color_hover 	 = $settings['navigation_bg_color_hover'] ?? '';
        $navigation_color_hover 	   = $settings['navigation_color_hover'] ?? '';
        $pagination_color 			     = $settings['pagination_color'] ?? '';
        $navigation 				         = $settings['navigation'];
        $pagination 				         = $settings['pagination'];
        $grid_rows 				           = $settings['grid_rows'];

    	$id = 'mt-addons-carousel-'.uniqid();
    	$carousel_item_class 	= $columns;
    	$carousel_holder_class 	= '';
    	$swiper_wrapped_start 	= '';
    	$swiper_wrapped_end 	= '';
    	$swiper_container_start = '';
    	$swiper_container_end 	= '';
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
        		<i class="fas fa-arrow-left swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'" style="color:'.esc_attr($navigation_color).'; background:'.esc_attr($navigation_bg_color).';"></i>
        		<i class="fas fa-arrow-right swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'" style="color:'.esc_attr($navigation_color).'; background:'.esc_attr($navigation_bg_color).';"></i>';
      		}
      		if($pagination == "yes") { 
          		// next/prev
        		$html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
      		}	
    	} ?>

    	<?php //swiper container start ?>
    	<?php echo wp_kses_post($swiper_container_start); ?>
      	<div class="mt-swipper-carusel-position">
        	<div id="<?php echo esc_attr($id); ?>" 
          		<?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?> class="mt-addons-clients-carusel mtfe-row <?php echo esc_attr($carousel_holder_class); ?>">

            	<?php //swiper wrapped start ?>
            	<?php echo wp_kses_post($swiper_wrapped_start); ?>

              	<?php //items ?>
              	<?php if ($clients_groups) { ?>
            		<?php $count = 1; ?>
                	<?php foreach ($clients_groups as $client) {

                  		$image_url = '';
                  		$image_id = '';
                  		$client_link = '';

                    	if ($client['clients_image']['id']) {
                      		$image_id = $client['clients_image']['id'];
                    	}else{
                      		$image_url = $client['clients_image']['url'];
                    	}

                    	$client_link = $client['client_url'];
                    	$link = array(
                      		'target' => '_blank',
                      		'rel' => 'nofollow',
                    	);
                  
                  		if ($image_id) {
                    		$img_url = wp_get_attachment_image_src($image_id, 'full' )[0];
                  		}else{
                    		$img_url = $image_url;
                  		} ?>
                  
                  		<div class="mt-addons-client-image-item relative <?php echo esc_attr($carousel_item_class); ?>">
                    		<?php if($grid_rows == "yes") { ?>
                      			<?php if( $count % 2 == 1 ) {  ?>
                        			<div class="mt-addons-client-grid-rows">
                      			<?php } ?>
                    		<?php } ?>

                    		<?php if ($img_url) { ?>
                      			<div class="mt-addons-client-image-holder">
                        			<div class="mt-addons-client-image">
                          				<?php if($client_link != ''){ ?>
                            				<a href="<?php echo esc_url($client_link); ?>" target="<?php echo esc_attr($link['target']); ?>" rel="<?php echo esc_attr($link['rel']); ?>">
                          				<?php } ?>

                          				<img src="<?php echo esc_url($img_url); ?>" alt="<?php esc_attr_e('Client', 'mt-addons'); ?>" />
                          
                          				<?php if($client_link != ''){ ?>
                            				</a>
                          				<?php } ?>

                          				<?php if ($client_name_status == 'yes') { ?>
                            				<h6 class="mt-addons-heading">
                              				<?php if($client_link != ''){ ?>
                                				<a href="<?php echo esc_url($client_link); ?>" target="<?php echo esc_attr($link['target']); ?>" rel="<?php echo esc_attr($link['rel']); ?>"><?php echo esc_html($client['clients_name']); ?>
                                				</a>
                              				<?php } else { ?>
                                  				<?php echo esc_html($client['clients_name']); ?>
                              				<?php } ?>
                            				</h6>
                          				<?php } ?>
                        			</div>
                      			</div>
                    		<?php } ?>

                    		<?php  if($grid_rows == "yes") { ?>
                      			<?php if($count % 2 == 0) { ?>
                        			</div>
                      			<?php } ?>
                      		<?php $count++; ?>
                    	<?php } ?>
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