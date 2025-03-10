<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_skill_counter extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-skill-counter', MT_ADDONS_PUBLIC_ASSETS.'css/skill-counter.css');
        return [
            'mt-addons-skill-counter',
        ];
    }

	public function get_name() {
		return 'mtfe-skill-counter';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__( 'MT - Skill Counter', 'mt-addons' );
	}
	
	public function get_icon() {
		return 'eicon-nerd';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
    public function get_script_depends() {
        wp_register_script( 'jquery-appear', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/jquery-appear/jquery.appear.js');
        return [ 'jquery', 'elementor-frontend', 'jquery-appear'];
    }

	protected function register_controls() {
        $this->section_skill_counter();
        $this->section_help_settings();
    }

    private function section_skill_counter() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Content', 'mt-addons' ),
			]
		);

		$this->add_control(
			'columns',
			[
				'label' 			=> esc_html__( 'Columns', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 						=> esc_html__( 'Select', 'mt-addons' ),
					'col-md-12 col-xs-6' 	=> esc_html__( '1 Column', 'mt-addons' ),
					'col-md-6 col-xs-6'		=> esc_html__( '2 Columns', 'mt-addons' ),
					'col-md-4 col-xs-6' 	=> esc_html__( '3 Columns', 'mt-addons' ),
					'col-md-3 col-xs-6' 	=> esc_html__( '4 Columns', 'mt-addons' ),
					'col-md-2 col-xs-6' 	=> esc_html__( '6 Columns', 'mt-addons' ),

				],
				'default' 					=> 'col-md-3 col-xs-6',
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
        			'{{WRAPPER}} .mt-addons-skill-counter-stats-content.percentage, {{WRAPPER}} .mt-addons-skill-counter-choose-icon, {{WRAPPER}} .mt-addons-skill-counter-title' => 'text-align: {{VALUE}};',
    			],
    			'default' 			=> 'left',
			]
		);
		$this->add_control(
			'extra_class',
			[
				'label' 			=> esc_html__( 'Extra Class', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
			]
		);

        $this->add_control(
            'title_mb',
            [
                'label' => esc_html__( 'Title Margin Bottom', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-skill-counter-stats-content.percentage' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_pb',
            [
                'label' => esc_html__( 'Title Padding Bottom', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-skill-counter-stats-content.percentage' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'label' 			=> esc_html__( 'Number Stroke', 'mt-addons' ),
				'name' 				=> 'text_stroke',
				'selector' 			=> '{{WRAPPER}} .mt-addons-skill-counter-stats-content.percentage',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 				=> 'product_border',
				'selector' 			=> '{{WRAPPER}} .mt-addons-skill-counter-stats-content.percentage',
			]
		);
    	$repeater = new Repeater();
		$repeater->add_control(
			'tabs_item_service_icon_dropdown',
			[
				'label' 			=> esc_html__( 'Type', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 						=> esc_html__( 'Select', 'mt-addons' ),
					'choosed_fontawesome' 	=> esc_html__( 'Font Icon', 'mt-addons' ),
					'choosed_img' 			=> esc_html__( 'Image', 'mt-addons' ),
				]
			]
		);
		$repeater->add_control(
			'tabs_item_service_icon_fa',
			[
				'label' 			=> esc_html__( 'Icon', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::ICONS,
				'default' 			=> [
					'value' 			=> 'fas fa-star',
					'library' 			=> 'solid',
				],
				'condition' 		=> [
					'tabs_item_service_icon_dropdown' => 'choosed_fontawesome',
				],
			]
		);
		$repeater->add_control(
			'use_img',
			[
				'label' 			=> esc_html__( 'Image', 'plugin-name' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' 		=> [
					'tabs_item_service_icon_dropdown' => 'choosed_img',
				],
			]
		);
		$repeater->add_control(
	      'list_icon_size',
	      [
	        'label' 				=> esc_html__( 'Icon Size', 'mt-addons' ),
	        'type' 					=> \Elementor\Controls_Manager::NUMBER,
	        'selectors' 			=> [
        		'{{WRAPPER}} .mt-addons-skill-counter-choose-icon i' => 'font-size: {{VALUE}}px;',
    		],
    		'condition' 			=> [
				'tabs_item_service_icon_dropdown' => 'choosed_fontawesome',
			],
	      ]
	    );
	    $repeater->add_control(
	      'list_icon_color',
	      [
	        'label' 				=> esc_html__( 'Icon Color', 'mt-addons' ),
	        'type' 					=> \Elementor\Controls_Manager::COLOR,
	        'selectors' 			=> [
        		'{{WRAPPER}} .mt-addons-skill-counter-choose-icon i' => 'color: {{VALUE}};',
    		],
    		'condition' 			=> [
				'tabs_item_service_icon_dropdown' => 'choosed_fontawesome',
			],
	      ]
	    );
	    $repeater->add_control(
	      'title_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
		$repeater->add_control(
			'title',
			[
				'label' 			=> esc_html__( 'Title', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Title Typography', 'mt-addons' ),
				'name' 				=> 'title_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-skill-counter-title',
			]
		);
		$repeater->add_control(
	      'title_color',
	      [
	        'type' 					=> \Elementor\Controls_Manager::COLOR,
	        'label' 				=> esc_html__( 'Title Color', 'mt-addons' ),
	        'label_block' 			=> true,
	        'selectors' 			=> [
        		'{{WRAPPER}} .mt-addons-skill-counter-title' => 'color: {{VALUE}};',
    		],
	      ]
	    );
	    $repeater->add_control(
	      'skill_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
	    $repeater->add_control(
	      'skill_value',
	      [
	        'label' 				=> esc_html__( 'Skill value', 'mt-addons' ),
	        'type' 					=> \Elementor\Controls_Manager::NUMBER,
	      ]
	    );
	    $repeater->add_control(
	      'skill_color',
	      [
	        'type' 					=> \Elementor\Controls_Manager::COLOR,
	        'label' 				=> esc_html__( 'Skill Color', 'mt-addons' ),
	        'label_block' 			=> true,
	        'selectors' 			=> [
        		'{{WRAPPER}} .mt-addons-skill-counter-stats-content.percentage' 	=> 'color: {{VALUE}};',
        		'{{WRAPPER}} .mt-addons-skill-counter-suffix' 						=> 'color: {{VALUE}};',
    		],
	      ]
	    );
	    $repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Skill Typography', 'mt-addons' ),
				'name' 				=> 'skill_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-skill-counter-stats-content',
			]
		);
		$repeater->add_control(
	      'suffix_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
	    $repeater->add_control(
			'suffix',
			[
				'label' 			=> esc_html__( 'Suffix', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Suffix Typography', 'mt-addons' ),
				'name' 				=> 'suffix_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-skill-counter-suffix',
			]
		);
		$repeater->add_control(
	      'description_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
	    $repeater->add_control(
			'description',
			[
				'label' 			=> esc_html__( 'Description', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Description Typography', 'mt-addons' ),
				'name' 				=> 'description_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-skill-counter-description',
			]
		);
		$repeater->add_control(
			'suffix_position',
			[
				'label' 			=> esc_html__( 'Suffix Left position', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::NUMBER,
				'selectors' 		=> [
                    '{{WRAPPER}}  {{CURRENT_ITEM}}' => 'left: {{VALUE}}px',
                ],
			] 
		);
	    $this->add_control(
	        'skillcounter_groups',
	        [
	            'label' 			=> esc_html__('Items', 'mt-addons'),
	            'type' 				=> Controls_Manager::REPEATER,
	            'fields' 			=> $repeater->get_controls(),
	            'default' 			=> [
					[
						'title' 		=> esc_html__( 'Team Size', 'mt-addons' ),
						'skill_value' 	=> esc_html__( '55', 'mt-addons' )
					],
					[
						'title' 		=> esc_html__( 'Client Base', 'mt-addons' ),
						'skill_value' 	=> esc_html__( '130', 'mt-addons' )
					],
					[
						'title' 		=> esc_html__( 'Upcoming Events', 'mt-addons' ),
						'skill_value' 	=> esc_html__( '20', 'mt-addons' )
					],
				],
	        ]
	    );
		$this->end_controls_section();

		$this->start_controls_section(
			'container_tab',
			[
				'label' 		=> esc_html__( 'Container', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 			=> 'container_background',
				'types' 		=> [ 'classic', 'gradient' ],
				'selector' 		=> '{{WRAPPER}} .mt-addons-skill-counter-stats-block',
			]
		);
		$this->add_control(
            'container_padding',
	            [
	                'label' 	=> esc_html__( 'Padding', 'mt-addons' ),
	                'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-skill-counter-stats-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	                'size_units' => [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .mt-addons-skill-counter-stats-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' 		=> '{{WRAPPER}} .mt-addons-skill-counter-stats-block',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     		=> 'container_box_shadow',
                'selector' 		=> '{{WRAPPER}} .mt-addons-skill-counter-stats-block',
            ]
        );
        $this->end_controls_section();
	}

	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $columns 				= $settings['columns'];
        $aligment 				= $settings['aligment'];
        $extra_class 			= $settings['extra_class'];
        $skillcounter_groups 	= $settings['skillcounter_groups']; ?>

    	<div class="mt-addons-skill-counter mtfe-row">
        	<?php if ($skillcounter_groups) { ?>
          		<?php foreach ($skillcounter_groups as $param) {

              		if(!empty($param['use_img'])){ 
                		$use_img = $param['use_img']['id'];
              		}else{
                		$use_img = $param['use_img'];
              		}
            	
            		if (!array_key_exists('tabs_item_service_icon_fa', $param)) {
              			$tabs_item_service_icon_fa = '';
            		}else{
              			$tabs_item_service_icon_fa = $param['tabs_item_service_icon_fa'];
            		}

              		if(!empty($tabs_item_service_icon_fa)){ 
                		$icon = $tabs_item_service_icon_fa['value'];
              		}
            	
                	$image_skillcounter = wp_get_attachment_image_src( $use_img, 'medium' );

                	$classes = get_body_class(); 
                	?>
          			<div class="mt-addons-skill-counter-stats-block statistics <?php echo esc_attr($columns.' '.$extra_class.' '); ?>">
            			<div class="mt-addons-skill-counter-stats-heading-img">
              				<div class="mt-addons-skill-counter-choose-icon">
                			<?php if($param['tabs_item_service_icon_dropdown'] == 'choosed_img'){ ?>
                  				<img src="<?php echo esc_url($image_skillcounter[0]); ?>" alt="<?php echo esc_attr($param['title']); ?>"  />
                			<?php } elseif($param['tabs_item_service_icon_dropdown'] == 'linecons'){
                    			wp_enqueue_style( 'vc_linecons' );?>
                  				<i class="<?php echo esc_attr($param['tabs_item_service_icon__lineicons']); ?>"></i>
                			<?php } elseif($param['tabs_item_service_icon_dropdown'] == 'choosed_fontawesome'){
                        		wp_enqueue_style( 'vc_font_awesome_5' );?>
                    			<i class="<?php echo esc_attr($icon); ?>"></i>
                			<?php } ?>
              				</div>
            			</div>
            			<div class="mt-addons-skill-counter-stats-content percentage mt-addons-skill-counter-suffix" data-perc="<?php echo esc_html($param['skill_value']); ?>"><?php if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) { echo esc_html($param['skill_value']); } ?></div>
 
              			<?php if(!empty($param['suffix'])){ ?>
              				<span class="mt-addons-skill-counter-suffix elementor-repeater-item-<?php echo esc_attr( $param['_id'] ); ?>"><?php echo esc_attr($param['suffix']); ?></span>
              			<?php } ?>
              			<?php if(!empty($param['title'])){ ?>
                			<p class="mt-addons-skill-counter-title"><?php echo esc_html($param['title']); ?></p>
              			<?php } ?>
          			</div>
        		<?php  } ?>
        	<?php } ?>
      	</div>
	<?php
	}
	protected function content_template() {

    }
}