<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlElementorIcons;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_icon_box_grid_item extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-icon-box-grid-item', MT_ADDONS_PUBLIC_ASSETS.'css/icon-box-grid-item.css');
        return [
            'mt-addons-icon-box-grid-item',
        ];
    }
	
	public function get_name() { 
		return 'mtfe-icon-box-grid-item';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Icon Box Grid Item','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-nerd';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_icon_box_grid();
        $this->section_help_settings();
    }

    private function section_icon_box_grid() {

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
				'default' 			=> esc_html__( 'Safe', 'mt-addons' ),
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
		$this->add_control(
			'title_separator',
			[
				'label' 			=> esc_html__( 'Title Separator', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
		$this->add_control(
		'separator_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Separator Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .title-separator' => 'border-color: {{VALUE}}',
                ],
                'default' 			=> '#D8D8D8',
                'condition' 		=> [
                	'title_separator' 	=> 'yes',
                ],
			]
		);
		$this->add_control(
			'separator_hover_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Separator Hover Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .title-separator' => 'border-color: {{VALUE}}',
                ],
                'condition' 		=> [
                	'title_separator' 	=> 'yes',
                ],
                'default' 			=> '#000000',
			]
		);
		$this->add_control(
            'separator_padding',
            [
                'label'      		=> esc_html__( 'Padding', 'mt-addons' ),
                'type'       		=> Controls_Manager::DIMENSIONS,
                'condition' 		=> [
					'title_separator' 	=> 'yes',
				],
                'size_units' 		=> ['px', '%', 'em'],
				'default' 			=> [
					'top' 				=> 15,
					'right' 			=> 15,
					'bottom' 			=> 15,
					'left' 				=> 15,
					'unit' 				=> 'px',
					'isLinked' 		=> false,
				],
                'selectors'  => [
                    '{{WRAPPER}} .title-separator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
		$this->add_control(
            'separator_margin',
            [
                'label'      		=> esc_html__( 'Margin', 'mt-addons' ),
                'type'       		=> Controls_Manager::DIMENSIONS,
                'condition' 		=> [
					'title_separator' 	=> 'yes',
				],
                'size_units' 		=> ['px', '%', 'em'],
				'default' 			=> [
					'top' 				=> 15,
					'right' 			=> 15,
					'bottom' 			=> 15,
					'left' 				=> 15,
					'unit' 				=> 'px',
					'isLinked' 		=> false,
				],
                'selectors'  => [
                    '{{WRAPPER}} .title-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Typography', 'mt-addons' ),
				'name' 				=> 'title_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-grid-class-title',
			]
		);
		$this->add_control(
		'title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-grid-class-title a' => 'color: {{VALUE}}',
                ],
                'default' 			=> '#000000',
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Hover Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-grid-class-title a:hover' => 'color: {{VALUE}}',
                ],
                'default' 			=> '#000000',
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
				'default' 			=> esc_html__( 'Your dog will be walked in a safe, open space & will return home happy and tired.', 'mt-addons' ),
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
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Typography', 'mt-addons' ),
				'name' 				=> 'subtitle_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-grid-class-subtitle',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-grid-class-subtitle' => 'color: {{VALUE}}',
                ],
                'default' 			=> '#000000',
			]
		);
		$this->add_control(
			'subtitle_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Hover Color ', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors'		 	=> [
                    '{{WRAPPER}} .mt-addons-grid-class-single:hover .mt-addons-grid-class-subtitle' => 'color: {{VALUE}}',
                ],
                'default' 			=> '#000000',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'image_tab',
			[
				'label' 			=> esc_html__( 'Container', 'mt-addons' ),
			]
		);
		$this->add_control(
            'general_align',
            [
                'label' 			=> esc_html__( 'Alignment', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::CHOOSE,
                'options' 			=> [
                    'flex-start' 		=> [
                        'title' 		=> esc_html__( 'Left', 'mt-addons' ),
                        'icon' 			=> 'eicon-text-align-left',
                    ],
                    'center' 			=> [
                        'title' 		=> esc_html__( 'Center', 'mt-addons' ),
                        'icon' 			=> 'eicon-text-align-center',
                    ],
                    'flex-end' 			=> [
                        'title' 		=> esc_html__( 'Right', 'mt-addons' ),
                        'icon' 			=> 'eicon-text-align-right',
                    ],
                ],
               	'selectors' => [
               		'{{WRAPPER}} .mt-addons-title-wrapper'  	=> 'justify-content: {{VALUE}}',
               		'{{WRAPPER}} .mt-addons-subtitle-wrapper'   => 'justify-content: {{VALUE}}',
               		'{{WRAPPER}} .mt-addons-subtitle-wrapper'   => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-img-wrapper' 	    => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-icon-btn-zone'      => 'justify-content: {{VALUE}}',
                ],
                'default'			 	=> 'flex-start',
                'toggle' 				=> true,
            ]
        );
		$this->add_control(
          	'icon',
          	[
            	'label' 				=> esc_html__( 'Icon', 'mt-addons' ),
            	'type' 					=> \Elementor\Controls_Manager::MEDIA,
            	'default' 				=> [
            	'url' 					=> \Elementor\Utils::get_placeholder_image_src(),
            ],
          ]
        );
        $this->add_control(
			'bg_hover',
			[
				'label' 				=> esc_html__( 'Hover Background?', 'mt-addons' ),
				'type' 					=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 				=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 			=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 			=> 'yes',
				'default' 				=> 'no',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'label' 				=> esc_html__( 'Background', 'mt-addons' ),
				'name' 					=> 'normal_background',
				'types' 				=> ['classic', 'gradient', 'image'],
				'exclude' 				=> ['video'],
				'selector' 				=> '{{WRAPPER}} .mt-addons-class-post-details',
			]
		);
       	$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'label' 				=> esc_html__( 'Background Hover', 'mt-addons' ),
				'name' 					=> 'hover_background',
				'types' 				=> ['classic', 'gradient', 'image'],
				'exclude' 				=> ['video'],
				'fields_options' 		=> [
			        'background' 		=> [
			            'label' 		=> esc_html__('Background Hover', 'mt-addons'),
			        ],
			    ],
				'selector' 				=> '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-class-expandable-overlay',
				'condition' 			=> [
					'bg_hover' 			=> 'yes',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 					=> 'container_border',
				'selector' 				=> '{{WRAPPER}} .mt-addons-class-post-details',
			]
		);
		$this->add_responsive_control(
            'container_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .mt-addons-class-post-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-class-expandable-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
			'container_shadow',
			[
				'label' 				=> esc_html__( 'Box Shadow', 'textdomain' ),
				'type' 					=> \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' 			=> [
               		'{{WRAPPER}} .mt-addons-class-post-details' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                ],
			] 
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'btn_tab',
			[
				'label' 				=> esc_html__( 'Button', 'mt-addons' ),
			]
		);
        $this->add_control(
			'read_more_text',
			[
				'type' 					=> \Elementor\Controls_Manager::TEXT,
				'label' 				=> esc_html__( 'Button text', 'mt-addons' ),
				'label_block' 			=> true,
				'default' 				=> esc_html__( 'Read More', 'mt-addons' ),
			]
		);
        $this->add_control(
			'read_more_link',
			[
				'label' 				=> esc_html__( 'Button Link', 'mt-addons' ),
				'type' 					=> \Elementor\Controls_Manager::URL,
				'placeholder' 			=> esc_html__( 'https://your-link.com', 'mt-addons' ),
				'options' 				=> [ 'url', 'is_external', 'nofollow' ],
				'default' 				=> [
					'url' 				=> '',
					'is_external' 		=> true,
					'nofollow' 			=> true,
				],
				'label_block' 			=> true,
			]
		);
		$this->add_control(
			'btn_color',
			[
				'type' 					=> \Elementor\Controls_Manager::COLOR,
				'label' 				=> esc_html__( 'Read More Color', 'mt-addons' ),
				'label_block' 			=> true,
				'selectors' 			=> [
                    '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-grid-btn-more' => 'color: {{VALUE}}',
                ],
			]
		);
		$this->add_control(
			'btn_hover_color',
			[
				'type' 					=> \Elementor\Controls_Manager::COLOR,
				'label' 				=> esc_html__( 'Read More Hover Color', 'mt-addons' ),
				'label_block' 			=> true,
				'selectors' 			=> [
                    '{{WRAPPER}} .mt-addons-grid-class-single:hover .mt-addons-grid-btn-more' => 'color: {{VALUE}}',
                ],
			]
		);
		$this->add_control(
            'button_padding',
            [
                'label'      		=> esc_html__( 'Padding', 'mt-addons' ),
                'type'       		=> Controls_Manager::DIMENSIONS,
                'size_units' 		=> ['px', '%', 'em'],
				'default' 			=> [
					'top' 				=> 15,
					'right' 			=> 15,
					'bottom' 			=> 15,
					'left' 				=> 15,
					'unit' 				=> 'px',
					'isLinked' 		=> false,
				],
                'selectors'  => [
                    '{{WRAPPER}} .mt-addons-grid-class-single .mt-addons-grid-btn-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
		$this->end_controls_section();
	}
	   protected function render() {
        $settings 				= $this->get_settings_for_display();
        $title 					= $settings['title'];
        $title_tag 				= $settings['title_tag'];
        $title_separator        = $settings['title_separator'];
        $subtitle 				= $settings['subtitle'];
        $subtitle_tag 			= $settings['subtitle_tag'];
        $icon 					= $settings['icon']['id'];
        $bg_hover               = $settings['bg_hover'];
        $read_more_text 		= $settings['read_more_text'];
        $read_more_link 		= $settings['read_more_link']['url'];

		if($icon) {
		    $thumb = wp_get_attachment_image_src($icon, "full");
		    if ($thumb) {
		      $thumb_src  = $thumb[0];
		    }
		} 

		if($bg_hover == 'yes') { 
            $bg_hover = 'hover-bg';
            $container_hover = 'container-hover';
        } else {
			$bg_hover = 'no-hover';
			$container_hover = 'no-container-hover';
        } 

        if($title_separator == 'yes') {
         	$title_separator_class = 'title-separator';
        } else {
         	$title_separator_class = '';
        }
		?>

      	<div class="mt-addons-grid-item">
        	<div class="mt-addons-grid-class-single">
            	<div class="mt-addons-class-post-details relative">
          			<div class="mt-addons-class-expandable-overlay <?php echo esc_attr($bg_hover); ?>"></div>
	        		<div class="mt-addons-class-metas">
	        			<div class="mt-addons-img-wrapper">
	        				<?php if(!empty($thumb_src)){ ?>
	        					<img class="<?php echo esc_attr($container_hover); ?>" src="<?php echo esc_url($thumb_src); ?>" alt="<?php echo esc_html($title); ?>" />
	  						<?php } ?>
	        			</div>
		        		<div class="mt-addons-title-wrapper">
		          			<<?php echo Utils::validate_html_tag( $title_tag ); ?> class="mt-addons-grid-class-title <?php echo esc_html($title_separator_class); ?>"><a href="<?php echo esc_url($read_more_link); ?>"><?php echo esc_html($title); ?></a></<?php echo Utils::validate_html_tag( $title_tag ); ?>>
		          		</div>
		          		<div class="mt-addons-subtitle-wrapper">
		          			<<?php echo Utils::validate_html_tag( $subtitle_tag ); ?> class="mt-addons-grid-class-subtitle"><?php echo esc_html($subtitle); ?></<?php echo Utils::validate_html_tag( $subtitle_tag ); ?>>
		          		</div>

		      			<?php if(!empty($read_more_link) && !empty($read_more_text)){ ?>
		      				<div class="mt-addons-icon-btn-zone">
		          				<a class="mt-addons-grid-btn-more" href="<?php echo esc_url($read_more_link); ?>"><?php echo esc_html($read_more_text); ?> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i></a>
		          			</div>
						<?php } ?>
		        	</div>
            	</div>
        	</div>
      	</div>
    <?php } 
    protected function content_template() {}

}