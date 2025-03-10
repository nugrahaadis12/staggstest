<?php
namespace Elementor; 

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_row_overlay extends Widget_Base {
	
	public function get_style_depends() {
   	 	wp_enqueue_style( 'mt-addons-row-overlay', MT_ADDONS_PUBLIC_ASSETS.'css/row-overlay.css');
        return [
            'mt-addons-row-overlay',
        ];
    }
	public function get_name() {
		return 'mtfe-row-overlay';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Row Overlay','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-image-rollover';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_row_overlay();
        $this->section_help_settings();
    }

    private function section_row_overlay() {
		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$this->add_control(
			'background',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '.mt_addons--row-overlay-inner' => 'background: {{VALUE}}',
                ],
                'default' 			=> '#00000066',
			]
		);
		$this->add_control(
			'inner_column',
			[
				'label' 			=> esc_html__( 'Keep in Column?', 'mt-addons' ),
                'description' 		=> esc_html__( 'If checked, the overlay will be only applied in a column. By default, it will be applied on row.', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'yes',
			]
		);
		$this->add_control(
			'moving_images_grid',
			[
				'label' 			=> esc_html__( 'Moving Images Grid?', 'mt-addons' ),
                'description' 		=> esc_html__( 'If checked, an infinite moving images grid will appear below the overlay.', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'yes',
			]
		);
		$this->add_control(  
			'images_gap',
			[
				'label' 			=> esc_html__( 'Images Gap', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'min' 				=> 0,
				'max' 				=> 9999,
				'step' 				=> 1,
				'default' 			=> 0,
				'selectors' 		=> [
                    '.mt_addons--row-overlay .mafw-row-overlay-moving-gallery-item' => 'margin: {{VALUE}}px',
                ],
				'condition' 		=> [
					'moving_images_grid' => 'yes',
				],
			]
		);
    	$repeater = new Repeater();
		$repeater->add_control(
	   		'images',
	    	[
	        	'label' 			=> esc_html__( 'Upload Images for the current column', 'mt-addons' ),
	        	'description' 		=> esc_html__( 'Each group will consist of a vertical images row', 'mt-addons' ),
	        	'type' 				=> \Elementor\Controls_Manager::GALLERY,
	        	'default' 			=> [
	            	[
	                	'id' 		=> 0,
	                	'url' 		=> \Elementor\Utils::get_placeholder_image_src(),
	            	],
	        	],
	    	]
		);
		$repeater->add_control(
	    	'animation_type',
	    	[
	        	'label' 			=> esc_html__( 'Animation type', 'mt-addons' ),
	        	'label_block' 		=> true,
	        	'type' 				=> Controls_Manager::SELECT,
	        	'default' 			=> '',
	        	'options' 			=> [
	            		''              => esc_html__( 'Select Option', 'mt-addons' ),
	            		'mt_slide_up'   => esc_html__( 'Sliding Up', 'mt-addons' ),
	            		'mt_slide_down' => esc_html__( 'Sliding Down', 'mt-addons' ),
	        	]
	    	]
		);
		$image_groups_default = [
		    [
		        'images' => [
		            [
		                'id' => 0,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		            [
		                'id' => 0,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		            [
		                'id' => 0,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		        ],
		        'animation_type' => 'mt_slide_up',
		    ],
		    [
		        'images' => [
		            [
		                'id' => 1,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		            [
		                'id' => 1,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		            [
		                'id' => 1,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		        ],
		        'animation_type' => 'mt_slide_up',
		    ],
		    [
		        'images' => [
		            [
		                'id' => 2,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		            [
		                'id' => 2,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		            [
		                'id' => 2,
		                'url' => MT_ADDONS_ASSETS.'/placeholder.png',
		            ],
		        ],
		        'animation_type' => 'mt_slide_up',
		    ],
		];
		$this->add_control(
		    'image_groups',
		    [
		        'label' 		=> esc_html__('Items', 'mt-addons'),
		        'type' 			=> Controls_Manager::REPEATER,
		        'condition' 	=> [
		            'moving_images_grid' => 'yes',
		        ],
		        'default' 		=> $image_groups_default,
		        'fields' 		=> $repeater->get_controls()
		    ]
		);
		$this->end_controls_section();
	}

	protected function render() {
    $settings 	  = $this->get_settings_for_display();
    $inner_column = $settings['inner_column'];
    $image_groups = $settings['image_groups'];

    ?>
    <div class="mt_addons--row-overlay" data-inner-column="<?php echo esc_attr($inner_column); ?>">
        <?php if ($image_groups) { ?>
            <div class="mafw-row-overlay-moving-gallery">
                <?php foreach ($image_groups as $gallery) { ?>
                    <div class="mafw-row-overlay-moving-gallery-group">
                        <?php if (isset($gallery['images']) && !empty($gallery['images'])) { ?>
                            <div class="mafw-row-overlay-moving-gallery-inner-holder">
                                <div class="mafw-row-overlay-moving-gallery-inner mafw-<?php echo esc_attr($gallery['animation_type']); ?>">
                                    <?php foreach ($gallery['images'] as $image) {
                                        $image_url = $image['url'];
                                        ?>
                                        <img class="mafw-row-overlay-moving-gallery-item" src="<?php echo esc_url($image_url); ?>"/>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="mt_addons--row-overlay-inner"></div>
    </div>
    <?php
}

protected function content_template() {}
}