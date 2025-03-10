<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_timeline extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-timeline', MT_ADDONS_PUBLIC_ASSETS.'css/timeline.css');
        return [
            'mt-addons-timeline',
        ];
    }

	public function get_name() {
		return 'mtfe-timeline';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Timeline','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-time-line';
	} 

	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_timeline();
        $this->section_help_settings();
    }

    private function section_timeline() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 					=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$this->add_control(
			'line_status',
			[
				'label' 					=> esc_html__( 'Disable Vertical Line', 'mt-addons' ),
				'type' 						=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 					=> esc_html__( 'Hide', 'mt-addons' ),
				'label_off' 				=> esc_html__( 'Show', 'mt-addons' ),
				'return_value' 				=> 'yes',
				'default' 					=> 'no',
			]
		);
		$this->add_control(
			'line_bg_color',
			[
				'type' 						=> \Elementor\Controls_Manager::COLOR,
				'label' 					=> esc_html__( 'Line Background', 'mt-addons' ),
				'label_block' 				=> true,
				'selectors' 				=> [
					'{{WRAPPER}} .mt-addons-timeline::before' => 'background: {{VALUE}};',
				],
				'condition' 				=> [
					'line_status' 			=> '',
	            ],
				'default' 					=> '#eee',
			]
		);
		$this->add_control(
			'image_status',
			[
				'label' 					=> esc_html__( 'Disable Image', 'mt-addons' ),
				'type' 						=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 					=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 				=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 				=> 'yes',
				'default' 					=> 'no',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 					=> esc_html__( 'Title Typography', 'mt-addons' ),
				'name' 						=> 'content_typography',
				'selector' 					=> '{{WRAPPER}} .mt-addons-timeline-title',
			]
		);
		$this->add_control(
			'title_color',
			[
				'type' 						=> \Elementor\Controls_Manager::COLOR,
				'label' 					=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 				=> true,
				'selectors' 				=> [
					'{{WRAPPER}} .mt-addons-timeline-title' => 'color: {{VALUE}};',
				],
				'default' 					=> '#000000',
			]
		);
		$this->add_control(
	      	'block_separator',
	      	[
	        	'type' 						=> \Elementor\Controls_Manager::DIVIDER,
	      	]
	    ); 
		$this->add_control(
			'block_bg',
			[
				'type' 						=> \Elementor\Controls_Manager::COLOR,
				'label' 					=> esc_html__( 'Block Background', 'mt-addons' ),
				'label_block' 				=> true,
				'selectors' 				=> [
					'{{WRAPPER}} .mt-addons-timeline-content' => 'background: {{VALUE}};',
				],
				'default' 					=> '#EEEFF2',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     					=> 'block_border',
                'label'    					=> esc_html__( 'Block Border', 'mt-addons' ),
                'selector' 					=> '{{WRAPPER}} .mt-addons-timeline-item',
            ]
        );
        $this->add_control(
            'block_margin',
	            [
	                'label' 				=> esc_html__( 'Block Margin', 'mt-addons' ),
	                'type' 					=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 			=> [ 'px', '%', 'em' ],
	                'selectors' 			=> [
	                    '{{WRAPPER}} .mt-addons-timeline-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 					=> [
	                'unit' 					=> 'px',
	                'size' 					=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
	      	'description_separator',
	      	[
	        	'type' 						=> \Elementor\Controls_Manager::DIVIDER,
	      	]
	    );
		$this->add_control(
			'desc_color',
			[
				'type' 						=> \Elementor\Controls_Manager::COLOR,
				'label' 					=> esc_html__( 'Description Color', 'mt-addons' ),
				'label_block' 				=> true,
				'selectors' 				=> [
					'{{WRAPPER}} .mt-addons-timeline-desc' => 'color: {{VALUE}};',
				],
				'default' 					=> '#000000',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 					=> esc_html__( 'Date Typography', 'mt-addons' ),
				'name' 						=> 'date_typography',
				'selector' 					=> '{{WRAPPER}} .mt-addons-timeline-date',
			]
		);
		$this->add_control(
			'date_color',
			[
				'type' 						=> \Elementor\Controls_Manager::COLOR,
				'label' 					=> esc_html__( 'Date Color', 'mt-addons' ),
				'selectors' 				=> [
					'{{WRAPPER}} .mt-addons-timeline-date' => 'color: {{VALUE}} !important;',
				],
				'default' 					=> '#000000',
			]
		);
		$this->add_control(
            'content_position',
            [
                'label'                		=> esc_html__( 'Text Position', 'mt-addons' ),
				'type' 				   		=> \Elementor\Controls_Manager::CHOOSE,
                'options'              		=> [
                    'left'  				=> [
                        'title' 			=> esc_html__( 'Left', 'mt-addons' ),
                        'icon'  			=> 'eicon-h-align-left',
                    ],
                    'justify' 				=> [
                        'title' 			=> esc_html__( 'Justify', 'mt-addons' ),
                        'icon'  			=> 'eicon-h-align-center',
                    ],
                    'right' 				=> [
                        'title' 			=> esc_html__( 'Right', 'mt-addons' ),
                        'icon'  			=> 'eicon-h-align-right',
                    ],
                ],
                'default'              		=> 'right',
                'toggle'               		=> false,
                'selectors'            		=> [
                    '{{WRAPPER}} .mt-addons-timeline-content' => '{{VALUE}}',
                ],
            ]
        );
		$repeater = new Repeater();
		$repeater->add_control(
			'item_date_image',
			[
				'label' 					=> esc_html__( 'Image', 'mt-addons' ),
                'description' 				=> esc_attr__('Choose image for timeline pin.', 'mt-addons'),
				'type' 						=> \Elementor\Controls_Manager::MEDIA,
				'default' 					=> [
					'url' 					=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'title',
			[
				'label' 					=> esc_html__( 'Title', 'mt-addons' ),
				'type' 						=> \Elementor\Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'description',
			[
				'label' 					=> esc_html__( 'Description', 'mt-addons' ),
				'type' 						=> \Elementor\Controls_Manager::TEXTAREA,
			]
		);
		$repeater->add_control(
			'item_date',
			[
				'label' 					=> esc_html__( 'Item Date', 'mt-addons' ),
				'type' 						=> \Elementor\Controls_Manager::TEXT,
          		'description'  				=> esc_attr__('Enter the date for current timeline item. Format example: 2017 November 15th', 'mt-addons'),
			]
		);  
		$this->add_control( 
	        'accordion_groups',
	        [
	            'label' 					=> esc_html__(' ', 'mt-addons'),
	            'type' 						=> Controls_Manager::REPEATER,
	            'fields' 					=> $repeater->get_controls(),
	            'default' 					=> [ 
	            	[
                        'title' 			=> esc_html__( 'Junior Developer', 'mt-addons' ),
                        'description'	 	=> esc_html__( ' Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 'mt-addons' ),
                        'item_date' 		=> esc_html__( 'September 2017 - June 2018', 'mt-addons' ),
                    ],
                    [
                        'title' 			=> esc_html__( 'Senior Developer', 'mt-addons' ),
                        'description' 		=> esc_html__( ' Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 'mt-addons' ),
                        'item_date' 		=> esc_html__( 'June 2018 - May 2020', 'mt-addons' ),
                    ],
                    [
                        'title' 			=> esc_html__( 'CEO', 'mt-addons' ),
                        'description' 		=> esc_html__( ' Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 'mt-addons' ),
                        'item_date' 		=> esc_html__( 'May 2020 - Current', 'mt-addons' ),
                    ],
	            ],
	        ]
	    );
		$this->end_controls_section();
	}
	           
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $line_status 				= $settings['line_status'];
        $accordion_groups 			= $settings['accordion_groups'];
        $block_bg 		    		= $settings['block_bg'];
        $image_status 				= $settings['image_status'];
        $content_position 			= $settings['content_position'];

	    $line = '';
	    if ($line_status == 'yes') {
	      $line = 'mt-addons-no-line';
	    } else if ($line_status == 'false') {
	      $line = '';
	    }
		?>
		<div class="mt-addons-timeline relative <?php echo esc_attr($line); ?> <?php echo esc_attr($content_position); ?>">
        <?php if ($accordion_groups) { ?>
          	<?php foreach ($accordion_groups as $accordion) {
            	if (!array_key_exists('title', $accordion)) {
              		$title = '';
            	}else{
              		$title = $accordion['title'];
            	}
            	if (!array_key_exists('item_date', $accordion)) {
              		$item_date = '';
            	}else{
              		$item_date = $accordion['item_date'];
            	}
            
            	$item_date_image = $accordion['item_date_image']['url'];
            	?>
          
            	<div class="mt-addons-timeline-item <?php echo esc_attr($content_position); ?>">
              		<?php if ($image_status == "yes")  { ?>
		                <div class="mt-addons-timeline-img">
		                	<img src="<?php echo esc_url($item_date_image); ?>" data-src="<?php echo esc_url($item_date_image); ?>" alt="<?php echo esc_attr($title); ?>">
		                </div>
	              	<?php } ?>
              		<div class="mt-addons-timeline-content">
                		<h3 class="mt-addons-timeline-title" ><?php echo esc_html($title); ?></h3>
                		<p class="mt-addons-timeline-desc"><?php echo esc_html($accordion['description']); ?></p>
                		<p class="mt-addons-timeline-date"><?php echo esc_html($item_date); ?></p>
              		</div>         
            	</div>
          	<?php } ?>
        <?php } ?>
    </div> 
    <?php
	}
	protected function content_template() {

    }
}