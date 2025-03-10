<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_accordion extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-accordion', MT_ADDONS_PUBLIC_ASSETS.'css/accordion.css' );
        return [
            'mt-addons-accordion',
        ];
    }

    use ContentControlHelp;

	public function get_name() {
		return 'mtfe-accordion';
	}
	
	public function get_title() {
		return esc_html__('MT - Accordion','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-toggle';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_accordion_container();
        $this->section_help_settings();
    }

    private function section_accordion_container() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 	=> esc_html__( 'Container', 'mt-addons' ),
			]
		);
	    $repeater = new Repeater();
		$repeater->add_control(
	    	'title',
	        [
	            'label' 	=> esc_html__('Title', 'mt-addons'),
	            'type' 		=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'description',
	        [
	            'label' 	=> esc_html__('Description', 'mt-addons'),
	            'type' 		=> Controls_Manager::TEXTAREA
	        ]
	    );

	    $this->add_control(
	        'accordion_groups',
	        [
	            'label' 	=> esc_html__('Items', 'mt-addons'),
	            'type' 		=> Controls_Manager::REPEATER,
	            'fields' 	=> $repeater->get_controls(),
	            'default' 	=> [
					[
						'title' 		=> esc_html__( 'Can I work for the Agency Group? ', 'mt-addons' ),
						'description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea . Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore .', 'mt-addons' )
					],
					[
						'title' 		=> esc_html__( 'How do I choose the best Agency Group?', 'mt-addons' ),
						'description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea . Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore .', 'mt-addons' )
					],
					[
						'title' 		=> esc_html__( 'What is a Content Management System?', 'mt-addons' ),
						'description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea . Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore .', 'mt-addons' )
					],
					[
						'title' 		=> esc_html__( 'Do I have to register a Domain Name?', 'mt-addons' ),
						'description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea . Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore .', 'mt-addons' )
					],
				],
	        ]
	    );

		$this->end_controls_section();
		$this->start_controls_section(
            'style_container',
            [
                'label' 		=> esc_html__( 'Container', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'title_underline_active',
			[
				'label' 		=> esc_html__( 'Title Underline', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> esc_html__( 'Yes', 'mt-addons' ),
				'label_off' 	=> esc_html__( 'No', 'mt-addons' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 			=> 'container_background',
				'types' 		=> [ 'classic', 'gradient' ],
				'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-holder',
			]
		);
		$this->add_control(
            'container_padding',
	            [
	                'label' 	=> esc_html__( 'Padding', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-accordion-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'container_margin',
	            [
	                'label' 	=> esc_html__( 'Margin', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-accordion-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'container_radius',
	            [
	                'label' 	=> esc_html__( 'Border Radius', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-accordion-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     		=> 'container_border',
                'label'    		=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-holder',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     		=> 'container_box_shadow',
                'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-holder',
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
            'style_items',
            [
                'label' 		=> esc_html__( 'Menu Items', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 			=> 'menu_items_background',
				'types' 		=> [ 'classic', 'gradient' ],
				'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-content',
			]
		);
		$this->add_control(
            'menu_items_padding',
	            [
	                'label' 	=> esc_html__( 'Padding', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'menu_items_margin',
	            [
	                'label' 	=> esc_html__( 'Margin', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-accordion-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'menu_items_radius',
	            [
	                'label' 	=> esc_html__( 'Border Radius', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     		=> 'menu_item_border',
                'label'    		=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-content',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     		=> 'menu_item_box_shadow',
                'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-content',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'style_accordion',
            [
                'label' 		=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     		=> 'title_item_typography',
                'label'    		=> esc_html__( 'Title Typography', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-holder .mt-addons-accordion-header',
            ]
        );                
		$this->add_control(
			'title_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
	        		'{{WRAPPER}} .mt-addons-accordion-header' => 'color: {{VALUE}};',
	    		],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     		=> 'desc_item_typography',
                'label'    		=> esc_html__( 'Description Typography', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-accordion-item p',
            ]
        ); 
		$this->add_control(
			'description_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Description Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
	        		'{{WRAPPER}} .mt-addons-accordion-item p' => 'color: {{VALUE}};',
	    		],
			]
		);
		$this->end_controls_section();
	}
	    
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $title_underline_active = $settings['title_underline_active'];
        $accordion_groups 		= $settings['accordion_groups'];
        $underline_active       = '';

        if($title_underline_active == 'yes') {
        	$underline_active = 'underline_active';
        }
        ?>

        <div class="mt-addons-accordion relative">
        	<?php if ($accordion_groups) { ?>
          		<?php foreach ($accordion_groups as $accordion) {
            		if (!array_key_exists('title', $accordion)) {
              			$title = '';
            		}else{
              			$title = $accordion['title'];
            		} ?>
          
		            <div class="mt-addons-accordion-holder">
		              	<div class="mt-addons-accordion-header <?php echo esc_attr($underline_active); ?>">
		                	<?php echo esc_html($title); ?>
		                	<div class="mt-addons-accordion-arrow">
		                  		<i class="fa fa-angle-down"></i>
		                	</div>
		              	</div>
		              	<div class="mt-addons-accordion-content">
		                	<div class="mt-addons-accordion-item">
		                  		<p><?php echo esc_html($accordion['description']); ?></p>
		                	</div>
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