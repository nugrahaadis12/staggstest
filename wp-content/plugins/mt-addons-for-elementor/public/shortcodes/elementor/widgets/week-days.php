<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_week_days extends Widget_Base {

		public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-week-days', MT_ADDONS_PUBLIC_ASSETS.'css/week-days.css');
        
        return [
            'mt-addons-week-days',
        ];
    }

    public function get_name()
    {
        return 'mtfe-week-days';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Week days', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-post';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'week', 'days', 'time'];
    }

	protected function register_controls() {
        $this->section_week_days();
        $this->section_help_settings();
    }

    private function section_week_days() {
		$this->start_controls_section(
			'header',
			[
				'label' 		=> esc_html__( 'Header', 'mt-addons' ),
			]
		);
		$this->add_control(
	    	'title',
	        [
	            'label' 		=> esc_html__('Title', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	            'default' 		=> esc_html__('Week Program', 'mt-addons'),
	        ]
	    );
	    $this->add_control(
	    	'subtitle',
	        [
	            'label' 		=> esc_html__('Subtitle', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	        ]
	    );
	    $this->end_controls_section();

	    $this->start_controls_section(
            'container_styling',
            [
                'label' 		=> esc_html__('Container', 'mt-addons'),
                'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 			=> 'container_background',
				'types' 		=> [ 'classic', 'gradient', 'video' ],
				'selector' 		=> '{{WRAPPER}} .mt-addons-week-days-shortcode',
			]
		);
		$this->add_control(
            'padding_container',
            [
                'label' 		=> esc_html__( 'Padding Container', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%', 'em' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-shortcode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' 		=> [
	                'unit' 			=> 'px',
	                'size' 			=> 0,
	            ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'label' 		=> esc_html__( 'Container Border', 'mt-addons' ),
				'name' 			=> 'container_border',
				'selector' 		=> '{{WRAPPER}} .mt-addons-week-days-shortcode',
			]
		);
        $this->add_control(
            'container_border_radius',
            [
                'label' 		=> esc_html__( 'Container Border Radius', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%', 'em' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-shortcode' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
            'title_subtitle_styling',
            [
                'label' 		=> esc_html__('Title/Subtitle', 'mt-addons'),
                'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            	'label' 		=> esc_html__( 'Title Typography', 'mt-addons' ),
                'name' 			=> 'title_typography',
                'selector' 		=> '{{WRAPPER}} .mt-addons-week-days-m-title',
            ]
        );
		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            	'label' 		=> esc_html__( 'Subtitle Typography', 'mt-addons' ),
                'name' 			=> 'subtitle_typography',
                'selector' 		=> '{{WRAPPER}} .mt-addons-week-days-m-subtitle',
            ]
        );
       	$this->end_controls_section();

		$this->start_controls_section(
            'menu_item_styling',
            [
                'label' 		=> esc_html__('Menu Item', 'mt-addons'),
                'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            	'label' 		=> esc_html__( 'Day Typography', 'mt-addons' ),
                'name' 			=> 'day_typography',
                'selector' 		=> '{{WRAPPER}} .mt-addons-week-days-day',
            ]
        );
        $this->add_control(
			'day_color',
			[
				'label' 		=> esc_html__( 'Day Color', 'mt-addons' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> 'rgba(0, 0, 0)',
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-day' => 'color: {{VALUE}};',
                ],
			]
		);
		$this->add_control(
			'separator_color',
			[
				'label' 		=> esc_html__( 'Separator Color', 'mt-addons' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> 'rgba(30, 30, 30, 0.2)',
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-line' => 'color: {{VALUE}};',
                ],
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            	'label' 		=> esc_html__( 'Hours Typography', 'mt-addons' ),
                'name' 			=> 'hours_typography',
                'selector' 		=> '{{WRAPPER}} .mt-addons-week-days-hours',
            ]
        );
		$this->add_control(
			'hours_color',
			[
				'label' 		=> esc_html__( 'Hours Color', 'mt-addons' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> 'rgba(0, 0, 0)',
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-hours' => 'color: {{VALUE}};',
                ],
			]
		);
		$this->add_control(
			'item_text_color',
			[
				'label' 		=> esc_html__( 'Text Color Hover', 'mt-addons' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-shortcode .mt-addons-week-days-item:hover .mt-addons-week-days-day' 	=> 'color: {{VALUE}};',
                    '{{WRAPPER}} .mt-addons-week-days-shortcode .mt-addons-week-days-item:hover .mt-addons-week-days-line' 	=> 'color: {{VALUE}};',
                    '{{WRAPPER}} .mt-addons-week-days-shortcode .mt-addons-week-days-item:hover .mt-addons-week-days-hours' => 'color: {{VALUE}};',
                ],
			]
		);
		$this->add_control(
			'item_bg_hover',
			[
				'label' 		=> esc_html__( 'Background Color Hover', 'mt-addons' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-shortcode .mt-addons-week-days-item:hover' => 'background-color: {{VALUE}};',
                ],
			]
		);
		$this->add_control(
            'padding_item',
            [
                'label' 		=> esc_html__( 'Padding', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%', 'em' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-week-days-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' 		=> [
	                'unit'		 	=> 'px',
	                'size' 			=> 0,
	            ],
            ]
        );        
        $this->end_controls_section();

		$this->start_controls_section(
			'section_items',
			[
				'label' 		=> esc_html__( 'List Area', 'mt-addons' ),
			]
		);
        $repeater = new \Elementor\Repeater();
   
		$repeater->add_control(
	    	'day',
	        [
	            'label' 		=> esc_html__('Week day', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	        ]
	    );
	    $repeater->add_control(
            'hours',
            [
                'label' 		=> esc_html__('Hours', 'mt-addons'),
                'type' 			=> Controls_Manager::TEXT,
            ]
        );
	    $this->add_control( 
	        'list',
	        [
	            'label' 		=> esc_html__('Menu Items', 'mt-addons'),
	            'type' 			=> Controls_Manager::REPEATER,
	            'fields' 		=> $repeater->get_controls(),
	            'default'	 	=> [
					[
						'day' 		=> esc_html__( 'Monday', 'mt-addons' ),
						'hours' 	=> esc_html__( '01:00-02:00', 'mt-addons' ),
					],
					[
						'day' 		=> esc_html__( 'Tuesday', 'mt-addons' ),
						'hours' 	=> esc_html__( '02:00-03:00', 'mt-addons' ),
					],
					[
						'day' 		=> esc_html__( 'Wednesday', 'mt-addons' ),
						'hours' 	=> esc_html__( '03:00-04:00', 'mt-addons' ),
					],
					[
						'day' 		=> esc_html__( 'Thursday', 'mt-addons' ),
						'hours' 	=> esc_html__( '04:00-05:00', 'mt-addons' ),
					],
					[
						'day' 		=> esc_html__( 'Friday', 'mt-addons' ),
						'hours' 	=> esc_html__( '05:00-06:00', 'mt-addons' ),
					],
					[
						'day' 		=> esc_html__( 'Saturday', 'mt-addons' ),
						'hours' 	=> esc_html__( '06:00-07:00', 'mt-addons' ),
					],
					[
						'day' 		=> esc_html__( 'Sunday', 'mt-addons' ),
						'hours' 	=> esc_html__( '07:00-08:00', 'mt-addons' ),
					],
				],
	        ]
	    );
		$this->end_controls_section();
	}

	protected function render() {
        $settings 	= $this->get_settings_for_display();
        $list 		= $settings['list'];
        $title 		= $settings['title'];
        $subtitle 	= $settings['subtitle'];
        ?>
       <div class="mt-addons-week-days-m  mt-addons-week-days-shortcode mt-addons-week-days-layout--standard mt-addons-week-days-line-type--between mt-addons-week-days-resposive--no mt-addons-week-days-text-underline">
       		<?php if (!empty($subtitle)){?>
	       		<h5 class="mt-addons-week-days-m-subtitle"><?php echo esc_html($subtitle); ?></h5>
	       	<?php }?>
	       	<?php if (!empty($title)){?>
				<h2 class="mt-addons-week-days-m-title"><?php echo esc_html($title); ?></h2>
			<?php }?>
			<?php if ($list) {
				foreach ( $list as $item ) {
	                $day 	= $item['day'];
	                $hours 	= $item['hours'];
	                ?>   
					<div class="mt-addons-week-days-m-items">
						<div class="mt-addons-week-days mt-addons-week-days-item">
							<div class="mt-addons-week-days-title-holder">
								<h5 class="mt-addons-week-days-day"><?php echo esc_html($day); ?></h5>
							</div>
							<div class="mt-addons-week-days-line"></div>
							<p class="mt-addons-week-days-hours"><?php echo esc_html($hours); ?></p>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div><?php
	}

    protected function content_template() {}
}

