<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_map_pins extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-map-pins', MT_ADDONS_PUBLIC_ASSETS.'css/map-pins.css');
        return [
            'mt-addons-map-pins',
        ];
    }
	public function get_name() {
		return 'mtfe-map-pins';
	} 
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Map Pins','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-map-pin';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_map_pins();
        $this->section_help_settings();
    }

    private function section_map_pins() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 				=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$this->add_control(
			'item_image_map',
			[
				'label' 				=> esc_html__( 'Background', 'mt-addons' ),
				'type' 					=> \Elementor\Controls_Manager::MEDIA,
				'default' 				=> [
					'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		); 
		$this->add_control(
			'effect_status',
			[
				'label' 				=> esc_html__( 'Show Grow Effect ', 'mt-addons' ),
				'type' 					=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 			=> 'yes',
				'default' 				=> 'no',
			]
		);
		$this->add_control(
			'pin_color',
			[
				'type' 					=> \Elementor\Controls_Manager::COLOR,
				'label' 				=> esc_html__( 'Pin Color', 'mt-addons' ),
				'label_block' 			=> true,
				'selectors' 			=> [ 
                    '{{WRAPPER}} .mt-addons-map-single-point a::after'  => 'background: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-map-single-point a::before' =>  'background-color: {{VALUE}}',
                ],
				'default' 				=> '#000000',
			]
		);
		$this->add_control(
			'pin_bg_color',
			[
				'type' 					=> \Elementor\Controls_Manager::COLOR,
				'label' 				=> esc_html__( 'Pin Bg Color', 'mt-addons' ),
				'label_block' 			=> true,
				'selectors' 			=> [
                    '{{WRAPPER}} .mt-addons-replace' => 'background: {{VALUE}}',
                ],
				'default' 				=> '#FFFFFF',
			]
		); 
		$repeater = new \Elementor\Repeater(); 
		$repeater->add_control(
			'title',
			[
				'label' 				=> esc_html__( 'Pin Title', 'mt-addons' ),
				'label_block' 			=> true,
				'type' 					=> Controls_Manager::TEXT,
				'default' 				=> esc_html__('URBAN PATCHED BLACK','mt-addons'),
			]
		);
		$repeater->add_control(
			'subtitle',
			[
				'label' 				=> esc_html__( 'Content', 'mt-addons' ),
				'label_block' 			=> true,
				'rows' 					=> 5,
				'type' 					=> Controls_Manager::TEXTAREA,
				'placeholder' 			=> esc_html__( 'Type your description here', 'mt-addons' ),
				'default' 				=> '',
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' 				=> esc_html__( 'Thumbnail', 'mt-addons' ),
				'type' 					=> Controls_Manager::MEDIA,
				'default' 				=> [
					'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
				]
			]
		);
		$repeater->add_control(
		    'coordinates_x',
		    [
		        'label' 				=> esc_html__( 'Coordinates on x axis', 'mt-addons' ),
		        'label_block' 			=> true,
		        'type' 					=> Controls_Manager::NUMBER,
		        'placeholder' 			=> esc_html__( 'Enter coordinates on x axis in percentage', 'mt-addons' ),
		       'selectors' 				=> [
				    '{{WRAPPER}} {{CURRENT_ITEM}}'  => 'top: {{VALUE}}%',
				],

		    ]
		);
		$repeater->add_control(
			'coordinates_y',
			[
				'label' 				=> esc_html__( 'Coordinates on y axis', 'mt-addons' ),
				'label_block' 			=> true,
				'type' 					=> Controls_Manager::NUMBER,
				'placeholder' 			=> esc_html__( 'Enter coordinates on y axis in percentange', 'mt-addons' ),
				'selectors' 			=> [
                    '{{WRAPPER}}  {{CURRENT_ITEM}}' => 'right: {{VALUE}}%',
                ],
			] 
		);
		$repeater->add_control(
			'el_class',
			[
				'label' 				=> esc_html__( 'Extra class name', 'mt-addons' ),
				'label_block' 			=> true,
				'type' 					=> Controls_Manager::TEXT,
				'placeholder' 			=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mt-addons' ),
			]
		);
 		$this->add_control(
			'map_pins',
			[
				'label' 				=> esc_html__( 'Map Pins', 'mt-addons' ),
				'type' 					=> \Elementor\Controls_Manager::REPEATER,
				'fields' 				=> $repeater->get_controls(),
				'default' 				=> [ 
					[ 
						'title' 		=> esc_html__( 'URBAN PATCHED BLACK', 'mt-addons' ),
		                'subtitle' 		=> esc_html__( 'Duis porttitor, turpis sollicitudin maximus bibendum, eros sapien feugiat magna, id interdum ex justo ut dolor. Nulla facilisis urna sed ipsum euismod porta.', 'mt-addons' ),
		                'coordinates_x' => esc_attr( '70', 'mt-addons' ),
		                'coordinates_y' => esc_attr( '70', 'mt-addons' ),
		            ],
		            [ 
						'title' 		=> esc_html__( 'URBAN PATCHED BLACK', 'mt-addons' ),
		                'subtitle' 		=> esc_html__( 'Duis porttitor, turpis sollicitudin maximus bibendum, eros sapien feugiat magna, id interdum ex justo ut dolor. Nulla facilisis urna sed ipsum euismod porta.', 'mt-addons' ),
		                'coordinates_x' => esc_attr( '50', 'mt-addons' ),
		                'coordinates_y' => esc_attr( '65', 'mt-addons' ),
		            ],
		            [ 
						'title' 		=> esc_html__( 'URBAN PATCHED BLACK', 'mt-addons' ),
		                'subtitle' 		=> esc_html__( 'Duis porttitor, turpis sollicitudin maximus bibendum, eros sapien feugiat magna, id interdum ex justo ut dolor. Nulla facilisis urna sed ipsum euismod porta.', 'mt-addons' ),
		                'coordinates_x' => esc_attr( '40', 'mt-addons' ),
		                'coordinates_y' => esc_attr( '40', 'mt-addons' ),
		            ],
		            
	            ],
				'title_field' 			=> '',
			]
		);
		$this->end_controls_section();
	}
	                    
	protected function render() {
        $settings 						= $this->get_settings_for_display();
        $item_image_map 				= $settings['item_image_map']['url'];
        $map_pins 						= $settings['map_pins'];
        $effect_status 					= $settings['effect_status'];
		$no_img                         = '';

		if(empty($item_image_map)) {
			$no_img = 'mt-addons-no-img';
		}
        ?>
        
        <div class="mt-addons-map-pins">
	        <div class="mt-addons-map-pins-container">
	            <div class="mt-addons-map-pins-wrapper <?php echo esc_attr($no_img); ?>">
	               	<?php if (isset($item_image_map) &&  !empty($item_image_map)) { ?>
					    <img class="mt-addons-map-pins-image" src="<?php echo esc_url($item_image_map); ?>" alt="<?php esc_attr_e('Map Pin', 'mt-addons'); ?>" />
					<?php } ?>
	                <ul>
	                	<?php if ($map_pins) {
	    					foreach ($map_pins as $pins ) {
					    		$title 							= $pins['title'];
						        $subtitle 						= $pins['subtitle'];
						        $image 							= $pins['image']['url'];
						        $coordinates_x 					= $pins['coordinates_x'];
						        $coordinates_y 					= $pins['coordinates_y'];
						        $el_class 						= $pins['el_class'];

		                	?>   
		                	<li class="mt-addons-map-single-point elementor-repeater-item-<?php echo esc_attr( $pins['_id'] ); ?>">
						    	<a  class="mt-addons-replace <?php echo esc_attr($effect_status); ?>"></a>
							    <?php if($el_class) {
							        $class_pin = $el_class;
							    } else {
							        $class_pin = 'bottom';
							    } 
							  	?>
						    	<div class="mt-addons-map-info pin-<?php echo esc_attr($class_pin); ?>">
							        <?php if (isset($image)) { ?>
							          <img class="mt-addons-image" src="<?php echo esc_url($image);?>" alt="<?php esc_html_e('Pin', 'mt-addons'); ?>" />
							        <?php } ?>
							        <h3 class="mt-addons-pin-title"><?php echo esc_html($title); ?></h3>
							        <p class="mt-addons-pin-content"><?php echo esc_html($subtitle); ?></p>
							        <a href="#0" class="mt-addons-pin-close"><?php esc_html_e('X','mt-addons'); ?></a>
						      	</div> 
						    </li>
							<?php } ?>
						<?php } ?>
	                </ul>
	            </div>
	        </div>
	    </div>
		<?php
	}
	protected function content_template() {

    }
}