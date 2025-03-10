<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_button_widget extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-button', MT_ADDONS_PUBLIC_ASSETS.'css/button.css');
        return [
            'mt-addons-button',
        ];
    }
	public function get_name() {
		return 'mtfe-button-widget';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Button','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-button';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	} 

	protected function register_controls() {
        $this->section_button_widget();
        $this->section_help_settings();
    }

    private function section_button_widget() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Button', 'mt-addons' ),
			]
		);
		
		$this->add_control(
			'btn_url',
			[
				'label' 			=> esc_html__( 'Link', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::URL,
				'placeholder' 		=> esc_html__( 'https://your-link.com', 'mt-addons' ),
				'default' 			=> [
					'url' 				=> '#',
					'is_external' 		=> true,
					'nofollow' 			=> true,
					'custom_attributes' => '',
				],
				'label_block' 		=> true,
			]
		);
		$this->add_control(
			'title',
			[
				'label' 			=> esc_html__( 'Text', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::TEXT,
				'default' 			=> esc_html__('Read More', 'mt-addons'),
				'placeholder' 		=> esc_html__( 'Type your title here', 'mt-addons' ),
			]
		);
		$this->add_control(
			'btn_size',
			[
				'label' 			=> esc_html__( 'Size', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'mt-addons-btn-lg',
				'options' 			=> [
					'mt-addons-btn-sm' 			=> esc_html__( 'Small', 'mt-addons' ),
					'mt-addons-btn-medium' 		=> esc_html__( 'Medium', 'mt-addons' ),
					'mt-addons-btn-lg'			=> esc_html__( 'Large', 'mt-addons' ),
					'mt-addons-btn-extra-large' => esc_html__( 'Extra-Large', 'mt-addons' ),
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Typography', 'mt-addons' ),
				'name' 				=> 'button_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons_button',
			]
		);
		$this->add_control(
            'button_radius',
	            [
	                'label' 		=> esc_html__( 'Shape Radius', 'mt-addons' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mt-addons_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 			=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
	        ]
	    );
		$this->add_control(
			'align',
			[
				'label' 			=> esc_html__( 'Alignment', 'mt-addons' ),
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'text-left',
				'options' 			=> [
					'left' 			=> esc_html__( 'Left', 'mt-addons' ),
					'center' 		=> esc_html__( 'Center', 'mt-addons' ),
					'right' 		=> esc_html__( 'Right', 'mt-addons' ),
				],
				'selectors' => [
        			'{{WRAPPER}} .mt-addons_button_holder' => 'text-align: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'display_type',
			[
				'label' 			=> esc_html__( 'Inline Block', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SELECT,
				'options' 			=> [
					'inline-block' 		=> esc_html__( 'Show', 'mt-addons' ),
					'block' 			=> esc_html__( 'Hide', 'mt-addons' ),
				],
				'selectors' => [
        			'{{WRAPPER}} .mt-addons_button_holder' => 'display: {{VALUE}};',
    			],
				'placeholder' 		=> esc_html__( 'If checked, the button will allow other content next to it', 'mt-addons' ),

			]
		);
		$this->add_control(
            'button_margin',
	        [
	            'label' 			=> esc_html__( 'Margin', 'mt-addons' ),
	            'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
	            'size_units' 		=> [ 'px', '%', 'em' ],
	            'selectors' 		=> [
	                '{{WRAPPER}} .mt-addons_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' => [
	                'unit' => 'px',
	                'size' => 0,
	            ],
	        ]
	    );
		$this->add_control(
            'button_padding',
	        [
	            'label' 			=> esc_html__( 'Padding', 'mt-addons' ),
	            'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
	            'size_units' 		=> [ 'px', '%', 'em' ],
	            'selectors' 		=> [
	                '{{WRAPPER}} .mt-addons_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' => [
	                'unit' => 'px',
	                'size' => 0,
	            ],
	        ]
	    );
		$this->end_controls_section();

		$this->start_controls_section(
			'style_tab',
			[
				'label' 			=> esc_html__( 'Styling', 'mt-addons' ),
			]
		);
		$this->add_control(
			'button_bg_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background color', 'mt-addons' ),
				'default' 			=> '#000000',
				'selectors' => [
        			'{{WRAPPER}} .mt-addons_button_holder a' => 'background-color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text color', 'mt-addons' ),
				'default' 			=> '#ffffff',
				'selectors' => [
        			'{{WRAPPER}} .mt-addons_button_holder a' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'button_bg_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background color - hover', 'mt-addons' ),
				'default' 			=> '#555555',
				'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons_button_holder a:hover' => 'background-color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'text_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text color - hover', 'mt-addons' ),
				'default' 			=> '#fafafa',
				'selectors' => [
        			'{{WRAPPER}} .mt-addons_button_holder a:hover' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
	      'button_box_border_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     			=> 'button_border',
                'label'    			=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons_button_holder a',
            ]
        );
		$this->add_control(
			'border_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Border Color - Hover', 'mt-addons' ),
				'condition' 		=> [
            		'button_border_border' 	=> 'solid',
        		],
        		'selectors' => [
        			'{{WRAPPER}} .mt-addons_button_holder a:hover' => 'border-color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
	      'button_box_shadow_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     			=> 'button_box_shadow',
                'label' 			=> esc_html__( 'Box Shadow', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons_button_holder a',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     			=> 'button_box_shadow_hover',
                'label' 			=> esc_html__( 'Box Shadow - Hover', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons_button_holder a:hover',
            ]
        );
        $this->add_control(
	      'button_box_transform_separator',
	      [
	        'type' 					=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
	    $this->add_control(
	      'button_box_transform_hover',
	      [
	        'label' 				=> esc_html__( 'Transform(px) - Hover', 'mt-addons' ),
	        'type' 					=> \Elementor\Controls_Manager::NUMBER,
	        'selectors' => [
        		'{{WRAPPER}} .mt-addons_button_holder a:hover' => 'transform: translateY(-{{VALUE}}px);',
    		],
	      ]
	    );
	    $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 				=> 'image_gradient',
				'label' 			=> esc_html__( 'Button Background Gradient', 'mt-addons' ),
				'types' 			=> ['gradient'],
				'selector' 			=> '{{WRAPPER}} .mt-addons_button_holder a',
			]
		);
		$this->end_controls_section();
	}
	
	protected function render() {
        $settings 	= $this->get_settings_for_display();
        $btn_url 	= $settings['btn_url'];
        $title 		= $settings['title'];
        $btn_size 	= $settings['btn_size'];

		$btn_atts 	= '';
		$btn_atts 	.= $btn_url['url'].',';
		$btn_atts 	.= $btn_url['is_external'].',';
		$btn_atts 	.= $btn_url['nofollow'].',';
		$btn_atts 	.= $title.',';

   		$url_link = mt_addons_build_link(esc_attr($btn_atts));
  		?>

  		<div class="mt-addons_button_holder">
    		<a target="<?php echo esc_attr($url_link['target']); ?>" rel="<?php echo esc_attr($url_link['rel']); ?>" href="<?php echo esc_url($url_link['url']); ?>" class="mt-addons_button <?php echo esc_attr($btn_size); ?>" ><?php echo esc_html($url_link['title']); ?></a>
  		</div>
  		
  	<?php
	}
	protected function content_template() {

    }
}