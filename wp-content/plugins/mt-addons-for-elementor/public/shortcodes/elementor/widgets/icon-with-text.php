<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlElementorIcons;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_icon_with_text extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-icon-list-group-item', MT_ADDONS_PUBLIC_ASSETS.'css/icon-list-group-item.css');

	        return [
	            'mt-addons-icon-list-group-item',
	        ];
    }
	use ContentControlElementorIcons;
	use ContentControlHelp;
	public function get_name() { 
		return 'mtfe-icon-with-text';
	}
	
	public function get_title() {
		return esc_html__('MT - Icon With Text','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-nerd';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_title();
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
            'section_aligment',
            [
                'label'   			=> esc_html__( 'Alignment', 'mt-addons' ),
                'type'    			=> Controls_Manager::CHOOSE,
                'options' 			=> [
                    'left'   			=> [
                        'title' 			=> esc_html__( 'Left', 'mt-addons' ),
                        'icon'  			=> 'eicon-text-align-left',
                    ],
                    'center' 			=> [
                        'title' 			=> esc_html__( 'Center', 'mt-addons' ),
                        'icon'  			=> 'eicon-text-align-center',
                    ],
                    'right'  			=> [
                        'title' 			=> esc_html__( 'Right', 'mt-addons' ),
                        'icon'  			=> 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
        			'{{WRAPPER}} .mt-icon-listgroup-item' => 'text-align: {{VALUE}};',
    			],
                'default' 			=> 'left',
                'toggle'  			=> false,
            ]
        );
		$this->add_control(
			'icon_position',
			[
				'label' 			=> esc_html__( 'Icon Position', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'layout_before' 	=> esc_html__( 'Before Content', 'mt-addons' ),
					'layout_top'		=> esc_html__( 'Top', 'mt-addons' ),
				]
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'title_tab',
			[
				'label' 			=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label' 			=> esc_html__( 'Title Label', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default' 			=> esc_html__('Wellness Companion', 'mt-addons'),
			]
		);
        $this->add_control(
			'title_tag',
			[
				'label' 			=> esc_html__( 'Element tag', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'h1' 				=> 'h1',
					'h2'				=> 'h2',
					'h3' 				=> 'h3',
					'h4' 				=> 'h4',
					'h5' 				=> 'h5',
					'h6' 				=> 'h6',
					'p' 				=> 'p',
				],
				'default' 			=> 'h3',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'subtitle_tab',
			[
				'label' 			=> esc_html__( 'Subtitle', 'mt-addons' ),
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label' 			=> esc_html__( 'Label/SubTitle', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default' 			=> esc_html__('Customizable marketplace on your own domain.', 'mt-addons'),
			]
		);
		$this->add_control(
			'subtitle_tag',
			[
				'label' 			=> esc_html__( 'Element tag', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'h1' 				=> 'h1',
					'h2'				=> 'h2',
					'h3' 				=> 'h3',
					'h4' 				=> 'h4',
					'h5' 				=> 'h5',
					'h6' 				=> 'h6',
					'p' 				=> 'p',
				],
				'default' 			=> 'p',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
          	'section_icons_settings',
          	[
              'label' 				=> esc_html__( 'Icon', 'mt-addons' ),
          	]
        );
        $this->add_control(
          	'icon_type',
          	[
            	'label' 			=> esc_html__( 'Type', 'mt-addons' ),
            	'label_block' 		=> true,
            	'type' 				=> Controls_Manager::SELECT,
            	'options' 			=> [
              		''            		=> esc_html__( 'Select Option', 'mt-addons' ),
              		'font_icon'   		=> esc_html__( 'Font Icon', 'mt-addons' ),
              		'image'       		=> esc_html__( 'Image', 'mt-addons' ),
            	],
            	'default' 			=> 'font_icon',
          	]
        );
        $this->add_control( 
          	'icon_fontawesome',
          	[
            	'label' 			=> esc_html__( 'Icon', 'mt-addons' ),
            	'type'  			=> \Elementor\Controls_Manager::ICONS,
            	'default' 			=> [
              		'value' 			=> 'fas fa-star',
              		'library' 			=> 'solid',
            	],
            	'condition' 		=> [
              		'icon_type' 		=> 'font_icon',
            	],
          	]
        );
        $this->add_control(
          	'image',
          	[
            	'label' 			=> esc_html__( 'Image', 'mt-addons' ),
            	'type' 				=> \Elementor\Controls_Manager::MEDIA,
            	'default' 			=> [
              		'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
            	],
            	'condition' 		=> [
              		'icon_type' 		=> 'image',
            	],
          	]
        );
        $this->add_control(
            'image_max_width',
            [
              	'label' 			=> esc_html__( 'Image Max Width', 'mt-addons' ),
              	'type' 				=> \Elementor\Controls_Manager::NUMBER,
              	'default' 			=> 50,
              	'condition' 		=> [
	              'icon_type' 			=> 'image',
	          	],
	          	'selectors' 		=> [
        			'{{WRAPPER}} .mt-image-list' => 'max-width: {{VALUE}}px;',
    			],
            ]
        );
        $this->add_control(
            'icon_size',
            [
              	'label' 			=> esc_html__( 'Icon Size', 'mt-addons' ),
              	'type' 				=> \Elementor\Controls_Manager::NUMBER,
              	'condition' 		=> [
              		'icon_type' 		=> 'font_icon',
          		],
          		'selectors'		 	=> [
        			'{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span' => 'font-size: {{VALUE}}px;',
        			'{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner svg' => 'width: {{VALUE}}%;',
    			],
    			'default' 			=> '44',
            ]
        );
        $this->add_control(
            'icon_color',
            [
              	'type' 				=> \Elementor\Controls_Manager::COLOR,
              	'label' 			=> esc_html__( 'Icon Color', 'mt-addons' ),
              	'label_block' 		=> true,
              	'condition' 		=> [
            		'icon_type' 		=> 'font_icon',
          		],
          		'selectors' 		=> [
        			'{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span' => 'color: {{VALUE}};',
        			'{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner svg' => 'fill: {{VALUE}};',
    			],
            ]
        );
        $this->add_control(
          	'use_svg',
          	[
            	'label' 			=> esc_html__( 'SVG Code', 'mt-addons' ),
            	'type' 				=> \Elementor\Controls_Manager::TEXTAREA,
            	'rows' 				=> 10,
             	'condition' 		=> [
            		'icon_type' 		=> 'svg',
          		],
          	]
        );
        $this->add_control(
          	'icon_url',
          	[
            	'label' 			=> esc_html__( 'Link', 'mt-addons' ),
            	'type' 				=> \Elementor\Controls_Manager::URL,
            	'placeholder' 		=> esc_html__( 'https://your-link.com', 'mt-addons' ),
            	'default' 			=> [
	              	'url' 				=> '',
	              	'is_external' 		=> true,
	              	'nofollow' 			=> true,
	              	'custom_attributes' => '',
            	],
            	'label_block' 		=> true,
          	]
        );
        $this->end_controls_section();

		$this->start_controls_section(
            'style_container',
            [
                'label' 			=> esc_html__( 'Container', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 				=> 'container_background',
				'types' 			=> [ 'classic', 'gradient' ],
				'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-item',
			]
		);
		$this->add_control(
            'container_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'container_margin',
	            [
	                'label'			=> esc_html__( 'Margin', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
        $this->add_control(
            'container_border_radius',
	            [
	                'label' 		=> esc_html__( 'Box Border Radius', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name'     			=> 'container_border',
                'label'    			=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-item',
            ]
        );
	    $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     			=> 'container_box_shadow',
                'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-item',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_title',
            [
                'label' 			=> esc_html__( 'Title', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-content-holder-inner .mt-icon-listgroup-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'fileds_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-content-holder-inner .mt-icon-listgroup-title',
            ]
        ); 
		$this->add_control(
			'title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-icon-listgroup-content-holder-inner a' => 'color: {{VALUE}};',
	    		],
				'default' 			=> '#F0099D',
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text Color Hover', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-icon-listgroup-item:hover .mt-icon-listgroup-content-holder-inner .mt-icon-listgroup-title a' => 'color: {{VALUE}};',
	    		],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_section();
        $this->start_controls_section(
            'style_subtitle',
            [
                'label' 			=> esc_html__( 'Subtitle ', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'subtitle_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'mt-addons'),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors'  	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'fileds_typography_subtitle',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-text',
            ]
        ); 
		$this->add_control(
			'subtitle_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-icon-listgroup-text' => 'color: {{VALUE}};',
	    		],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_container',
            [
                'label' 			=> esc_html__( 'Icon', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 				=> 'icon_background',
				'types' 			=> [ 'classic', 'gradient' ],
				'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span',
				'default' 			=> [
		            'background' 		=> '#E4E2E2',
		        ],
			]
		);
		$this->add_control(
            'icon_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'icon_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span, {{WRAPPER}} .mt-icon-listgroup-icon-holder-inner .mt-image-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
        $this->add_control(
            'icon_border_radius',
	            [
	                'label' 		=> esc_html__( 'Box Border Radius', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name'     			=> 'icon_border',
                'label'    			=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span',
            ]
        );
	    $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     			=> 'icon_box_shadow',
                'selector' 			=> '{{WRAPPER}} .mt-icon-listgroup-icon-holder-inner span',
            ]
        );
        $this->end_controls_section();

	}
	
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $icon_position 			= $settings['icon_position'];
        $title 			        = $settings['title'];
        $subtitle 				= $settings['subtitle'];
        $icon_url 				= $settings['icon_url'] ?? '';
        $icon_url 				= $settings['icon_url'];
        $icon_fontawesome 		= $settings['icon_fontawesome'];
        $icon_type 				= $settings['icon_type'];
        $subtitle_tag 			= $settings['subtitle_tag'];
        $title_tag 				= $settings['title_tag'];
        $use_svg 				= $settings['use_svg'];

        if(!empty($settings['image'])) {
        	$image 				= $settings['image']['url'];
        }
        $btn_atts = '';
		$btn_atts .= $icon_url['url'].',';
		$btn_atts .= $icon_url['is_external'].',';
		$btn_atts .= $icon_url['nofollow'].',';
		$btn_atts .= $title.',';
    	$icon_url = esc_url($btn_atts);

    	$url_link = mt_addons_build_box_icon_link($icon_url);

	  	$icon_position_style = 'layout_before';
	  	if($icon_position == "layout_before") {
	    	$icon_position_style = 'mt-addons-before_content';
	  	} else if ($icon_position == "layout_top") {
	    	$icon_position_style = 'mt-addons-top_content';
	  	}

	  	?>
	  	<div class="mt-icon-listgroup-item wow">
	      <div class="mt-icon-listgroup-holder <?php echo esc_attr($icon_position_style); ?>">
		        <div class="mt-icon-listgroup-icon-holder-inner">
		          	<?php if(empty($image)) { ?>
		            	<a href="<?php echo esc_url($url_link['url']); ?>" target="<?php echo esc_attr($url_link['target']); ?>" rel="<?php echo esc_attr($url_link['rel']); ?>">
		              		<span><?php \Elementor\Icons_Manager::render_icon( $settings['icon_fontawesome'], [ 'aria-hidden' => 'true', 'class' => 'mt-icon-listgroup-icon-holder-inner' ] ); ?></span>
		            	</a>
		          	<?php } else { ?>
		          		<?php if (!empty($url_link['url']) && $url_link['url'] !== 'http://') { ?>
			                <a href="<?php echo esc_url($url_link['url']); ?>" 
			                   target="<?php echo isset($url_link['target']) ? esc_attr($url_link['target']) : '_self'; ?>" 
			                   rel="<?php echo isset($url_link['rel']) ? esc_attr($url_link['rel']) : 'noopener'; ?>">
			                    <img alt="list-image" class="mt-image-list" src="<?php echo esc_url($image); ?>">
			                </a>
			            <?php } else { ?>
			                <img alt="list-image" class="mt-image-list" src="<?php echo esc_url($image); ?>">
			            <?php } ?>
		          	<?php }?>
		        </div>
		        <div class="mt-icon-listgroup-content-holder-inner" >
		          	<<?php echo Utils::validate_html_tag( $title_tag ); ?> class="mt-icon-listgroup-title">
					<?php if (!empty($url_link['url']) && $url_link['url'] !== 'http://') { ?>
					    <a href="<?php echo esc_url($url_link['url']); ?>" target="<?php echo esc_attr($url_link['target']); ?>" rel="<?php echo esc_attr($url_link['rel']); ?>"><?php echo esc_html($title); ?></a>
					<?php } else { ?>
					    <?php echo esc_html($title); ?>
					<?php } ?>
		          	</<?php echo Utils::validate_html_tag( $title_tag ); ?>>
		          	<?php if(!empty($subtitle)){ ?>
		            	<<?php echo Utils::validate_html_tag( $subtitle_tag ); ?> class="mt-icon-listgroup-text"> <?php echo esc_attr($subtitle);?> </<?php echo Utils::validate_html_tag( $subtitle_tag ); ?>>     
		           	<?php } ?>
		        </div>
	      	</div>
	   	</div>
	<?php }
	protected function content_template() {

    }
}