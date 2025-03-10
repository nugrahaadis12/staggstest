<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_mt_social_icon_box extends Widget_Base {
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-social-icon-box', MT_ADDONS_PUBLIC_ASSETS.'css/social-icon-box.css');
        return [
            'mt-addons-social-icon-box',
        ];
    }
	public function get_name() {
		return 'mtfe-social-icons-box';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Social Icon Box','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-icon-box';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_social_icon_box();
        $this->section_help_settings();
    }

    private function section_social_icon_box() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Container', 'mt-addons' ),
			]
		);	
		$this->add_control(
			'icon_url',
			[
				'label' 		=> esc_html__( 'Link', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::URL,
				'placeholder' 	=> esc_html__( 'https://your-link.com', 'mt-addons' ),
				'default' 		=> [
					'url' 			=> '',
					'is_external' 	=> true,
					'nofollow' 		=> true,
					'custom_attributes' => '',
				],
				'label_block' 	=> true,
			]
		);
		$this->add_control(
			'button_text',
			[
				'label' 		=> esc_html__( 'Button Text', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> esc_html__( 'Go to', 'mt-addons' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 		=> esc_html__( 'Button Typography', 'mt-addons' ),
				'name' 			=> 'button_typography',
				'selector' 		=> '{{WRAPPER}} .mt-addons-social-icon-box-button',
				'default' 		=> [
		            'font_size' 	=> [
		                'size' 			=> 16,
		                'unit' 			=> 'px',
		            ],
		        ],
			]
		);
		$this->add_control( 
			'button_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Button Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [ 
        			'{{WRAPPER}} .mt-addons-social-icon-box-button' 	=> 'color: {{VALUE}};',
        			'{{WRAPPER}} span.mt-addons-social-icon-box-button' => 'color: {{VALUE}};',
        			'{{WRAPPER}} .mt-addons-social-icon-box-button' 	=> 'border: 1px solid {{VALUE}};',
    			],
				'default' => '#c36',
			]
		);
		$this->add_control(
			'aligment',
			[
				'label' 		=> esc_html__( 'Aligment', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'left' 				=> esc_html__( 'Left', 'mt-addons' ),
					'center'			=> esc_html__( 'Center', 'mt-addons' ),
					'right' 			=> esc_html__( 'Right', 'mt-addons' ),
				],
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'text-align: {{VALUE}};',
    			],
    			'default' 		=> 'center',
			]
		);
		$this->add_control( 
			'container_background',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Background', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'background-color: {{VALUE}};',
    			],
				'default' 		=> '#BBE2FF',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_tab',
			[
				'label' 		=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		$this->add_control(
	    	'title_text',
	        [
	            'label' 		=> esc_html__('Social/Title', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	            'default' 		=> esc_html__('My website','mt-addons'),
	        ]
	    );	
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 		=> esc_html__( 'Typography', 'mt-addons' ),
				'name' 			=> 'title_typography',
				'selector' 		=> '{{WRAPPER}} .mt-addons-social-icon-box-title-text',
			]
		);
		$this->add_control(
			'title_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Text Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors'	 	=> [
	        		'{{WRAPPER}} .mt-addons-social-icon-box-title-text' => 'color: {{VALUE}};',
	    		],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' 		=> esc_html__( 'Icon', 'mt-addons' ),
			]
		);
		$this->add_control( 
			'icon_fontawesome',
			[
				'label' 		=> esc_html__( 'Icon', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::ICONS,
				'default' 		=> [
					'value'	 		=> 'fas fa-star',
					'library' 		=> 'solid',
				],
			]
		);

		$this->add_control(
	      	'icon_color',
	      	[
	        	'type' 			=> \Elementor\Controls_Manager::COLOR,
	        	'label' 		=> esc_html__( 'Color', 'mt-addons' ),
	        	'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'color: {{VALUE}};',
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'fill: {{VALUE}};',
    			],
	      	]
	    );
		$this->add_control(
	      	'icon_size',
	      	[
	        	'label' 		=> esc_html__( 'Icon Width', 'mt-addons' ),
	        	'type' 			=> \Elementor\Controls_Manager::NUMBER,
	        	'default' 		=> 50,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder .mt-addons-social-icon-box-img' => 'width: {{VALUE}}px;',
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder .mt-addons-social-icon-box-img' => 'height: {{VALUE}}px;',
    			],
	      	]
	    );
	    $this->add_responsive_control(
			'position',
			[
				'label' 		=> esc_html__( 'Position', 'mt-addons' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'default' 		=> 'top',
				'mobile_default' => 'top',
				'options' 		=> [
					'left' 			=> [
						'title' 		=> esc_html__( 'Left', 'mt-addons' ),
						'icon' 			=> 'eicon-h-align-left',
					],
					'top' 			=> [
						'title' 		=> esc_html__( 'Top', 'mt-addons' ),
						'icon' 			=> 'eicon-v-align-top',
					],
				],
			]
		);
		$this->add_control(
			'justify_content',
			[
				'type' 			=> \Elementor\Controls_Manager::CHOOSE,
				'label' 		=> esc_html__( 'Justify Content', 'mt-addons' ),
				'options' 		=> [
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
				'condition' 		=> [
					'position' 			=> 'left',
				],
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'justify-content: {{VALUE}};',
    			],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'container_tab',
			[
				'label' 			=> esc_html__( 'Container', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
            'container_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            	],
	            	'default' 		=> [
			            'top' 			=> '40',
			            'right' 		=> '20',
			            'bottom' 		=> '40',
			            'left' 			=> '20',
			            'unit' 			=> 'px',
			        ],
	        	]
	    );
		$this->add_control(
            'container_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons-social-icon-box-holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 				=> 'px',
	                'size' 				=> 0,
	            ],
	        ]
	    );
		$this->end_controls_section();
	}
	
	protected function render() {
        $settings 			= $this->get_settings_for_display();
        $title_text 		= $settings['title_text'];
        $icon_fontawesome 	= $settings['icon_fontawesome'];
        $icon_url 			= $settings['icon_url'];
        $button_text 		= $settings['button_text'];
        $position 			= $settings['position'];

        $btn_atts = '';
		$btn_atts .= $icon_url['url'].',';
		$btn_atts .= $icon_url['is_external'].',';
		$btn_atts .= $icon_url['nofollow'].',';
		$btn_atts .= $button_text.',';
		$icon_url = esc_url($btn_atts);

	    if(!empty($icon_url)){
        	$url_link = mt_addons_build_link($icon_url);
        } ?>

	    <div class="mt-addons-social-icon-box">
	      	<div class="mt-addons-social-icon-box-holder <?php echo esc_attr($position); ?>">
	          	<a href="<?php echo esc_url($url_link['url']); ?>" target="<?php echo esc_attr($url_link['target']); ?>" rel="<?php echo esc_attr($url_link['rel']); ?>">
				  	<?php \Elementor\Icons_Manager::render_icon( $settings['icon_fontawesome'], [ 'aria-hidden' => 'true', 'class' => 'mt-addons-social-icon-box-img' ] ); ?>
	            </a>
	        	<h3 class="mt-addons-social-icon-box-title-text"><?php echo esc_html($title_text); ?></h3>
	        	<a href="<?php echo esc_url($url_link['url']); ?>" target="<?php echo esc_attr($url_link['target']); ?>" rel="<?php echo esc_attr($url_link['rel']); ?>"><span class="mt-addons-social-icon-box-button"><?php echo esc_html($button_text); ?> <i class="fas fa-arrow-right"></i></span>
	        	</a>
	      	</div>
	    </div>
        
    <?php
	}
	protected function content_template() {

    }
}