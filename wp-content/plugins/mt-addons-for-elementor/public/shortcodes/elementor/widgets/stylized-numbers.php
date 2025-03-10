<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_stylized_numbers extends Widget_Base { 
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-stylized-numbers', MT_ADDONS_PUBLIC_ASSETS.'css/stylized-numbers.css');
        return [
            'mt-addons-stylized-numbers',
        ];
    }
	public function get_name() {
		return 'mtfe-stylized-numbers';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Stylized Numbers','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-number-field';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_stylized_numbers();
        $this->section_help_settings();
    }

    private function section_stylized_numbers() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$this->add_control(
			'custom_number',
			[
				'label' 		=> esc_html__( 'Number', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'default' 		=> '100',
			]
		);
		$this->add_control(
			'custom_number_desc',
			[
				'label' 		=> esc_html__( 'Description', 'mt-addons' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> esc_html__('Successful projects delivered this year','mt-addons'),
			]
		);
		$this->add_control(
            'number_padding',
	        [
	            'label' 		=> esc_html__( 'Padding', 'mt-addons' ),
	            'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	            'size_units' 	=> [ 'px', '%', 'em' ],
	            'selectors' 	=> [
	                '{{WRAPPER}} .mt-addons-numbers-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 		=> 'px',
	                'size' 		=> 0,
	            ],
	        ]
	    ); 
		$this->end_controls_section();
        $this->start_controls_section(
            'style_number',
            [
                'label' 		=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'section_align',
            [
                'label'   		=> esc_html__( 'Alignment', 'mt-addons' ),
                'type'    		=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left'   		=> [
                        'title' 		=> esc_html__( 'Left', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-left',
                    ],
                    'center' 		=> [
                        'title' 		=> esc_html__( 'Center', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-center',
                    ],
                    'right'  		=> [
                        'title' 		=> esc_html__( 'Right', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-right',
                    ],
                ],
                'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-numbers-group, {{WRAPPER}} .mt-addons-description-number' => 'text-align: {{VALUE}};',
    			],
                'default' 		=> 'left',
                'toggle'  		=> false,
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 		=> esc_html__( 'Number Typography', 'mt-addons' ),
				'name' 			=> 'number_typography',
				'selector' 		=> '{{WRAPPER}} .mt-addons-numbers-item span',
			]
		);
		$this->add_control(
			'number_text_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Number Text Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
	        		'{{WRAPPER}} .mt-addons-numbers-group' => 'color: {{VALUE}};',
	    		],
	    		'default' 		=> '#fff',
			]
		);
		$this->add_control(
			'number_background',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Number Background Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
	        		'{{WRAPPER}} .mt-addons-numbers-item' => 'background-color: {{VALUE}};',
	    		],
	    		'default' 		=> '#FF7E06',
			]
		);
		$this->add_control(
	      'description_separator',
	      [
	        'type' 				=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
	    $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 		=> esc_html__( 'Description Typography', 'mt-addons' ),
				'name' 			=> 'description_typography',
				'selector' 		=> '{{WRAPPER}} .mt-addons-description-number p',
			]
		);
		$this->add_control(
			'description_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Description Text Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
	        		'{{WRAPPER}} .mt-addons-description-number p' => 'color: {{VALUE}};',
	    		],
			]
		);
	$this->end_controls_section();

	}
	            
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $custom_number 			= $settings['custom_number'];
        $custom_number_desc 	= $settings['custom_number_desc'];

        if ($custom_number) {
    		$split_numbers = str_split($custom_number); ?>
    		<div class="mt-addons-numbers-group">
      			<div class="mt-addons-numbers-digit"> 
         			<?php  foreach ($split_numbers as $number) { ?>
        				<div class="mt-addons-numbers-item">
          					<span><?php echo esc_html($number); ?></span>
        				</div>
      				<?php } ?>
      			</div>
    		</div>
    	<?php }

    	if ($custom_number_desc) { ?>
    		<div class="mt-addons-description-number">
          		<p><?php echo esc_html($custom_number_desc); ?></p>
        	</div>
    	<?php } ?>
    <?php
	}
	protected function content_template() {

    }
}