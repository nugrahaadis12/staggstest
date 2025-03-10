<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_process extends Widget_Base {
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-process', MT_ADDONS_PUBLIC_ASSETS.'css/process.css');

        return [
            'mt-addons-process',
        ];
    }
	public function get_name() {
		return 'mtfe-process';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Process','mt-addons');
	}
	 
	public function get_icon() {
		return 'eicon-editor-list-ol';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_process();
        $this->section_help_settings();
    }

    private function section_process() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
    	$repeater = new Repeater();
	    $repeater->add_control(
	    	'step_title',
	        [
	            'label' 		=> esc_html__('Title', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT
	        ]
	    );
	    $repeater->add_control(
	    	'step_description',
	        [
	            'label' 		=> esc_html__('Description', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXTAREA
	        ]
	    );
		$this->add_control(
	        'process_groups',
	        [
	            'label' 		=> esc_html__('Items', 'mt-addons'),
	            'type' 			=> Controls_Manager::REPEATER,
	            'fields' 		=> $repeater->get_controls(),
	            'default' 		=> [
					[
						'step_title' 		=> esc_html__( 'Assess Your Health Needs', 'mt-addons' ),
						'step_description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mt-addons' )
					],
					[
						'step_title' 		=> esc_html__( 'Explore Medical Services', 'mt-addons' ),
						'step_description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mt-addons' )
					],
					[
						'step_title' 		=> esc_html__( 'Connect with Top Healthcare Providers', 'mt-addons' ),
						'step_description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mt-addons' )
					],
					[
						'step_title' 		=> esc_html__( 'Manage Your Health Records Securely', 'mt-addons' ),
						'step_description' 	=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mt-addons' )
					],
				],
	        ]
	    ); 
		$this->end_controls_section();

	    $this->start_controls_section(
            'style_sub_heading',
            [
                'label' 		=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     		=> 'fields_typography',
                'label'    		=> esc_html__( 'Title Typography', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-steps h3',
            ]
        );
        $this->add_control(
	      'fields_title_color',
	      [
	        'type' 				=> \Elementor\Controls_Manager::COLOR,
	        'label' 			=> esc_html__( 'Title Color', 'mt-addons' ),
	        'label_block' 		=> true,
	        'selectors' 		=> [
        		'{{WRAPPER}} .mt-addons-steps h3' => 'color: {{VALUE}};',
    		],
	      ]
	    );
	    $this->add_control(
	      'description_separator',
	      [
	        'type' 				=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     		=> 'fileds_typography_description',
                'label'    		=> esc_html__( 'Description Typography', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-steps p',
            ]
        );
        $this->add_control(
	      'fields_description_color',
	      [
	        'type' 				=> \Elementor\Controls_Manager::COLOR,
	        'label' 			=> esc_html__( 'Description Color', 'mt-addons' ),
	        'label_block' 		=> true,
	        'selectors' 		=> [
        		'{{WRAPPER}} .mt-addons-steps p' => 'color: {{VALUE}};',
    		],
	      ]
	    );
	    $this->add_control(
	      'process_separator',
	      [
	        'type' 				=> \Elementor\Controls_Manager::DIVIDER,
	      ]
	    );
	    $this->add_control(
	      'process_bg_color',
	      [
	        'type' 				=> \Elementor\Controls_Manager::COLOR,
	        'label' 			=> esc_html__( 'Process Background Color', 'mt-addons' ),
	        'label_block' 		=> true,
	        'selectors' 		=> [
        		'{{WRAPPER}} .mt-addons-process-wrapper:before, {{WRAPPER}} .mt-addons-steps-count span' => 'background-color: {{VALUE}};',
    		],
	      ]
	    );
	    $this->add_control(
	      'process_color',
	      [
	        'type' 				=> \Elementor\Controls_Manager::COLOR,
	        'label' 			=> esc_html__( 'Process Number Color', 'mt-addons' ),
	        'label_block' 		=> true,
	        'selectors' 		=> [
        		'{{WRAPPER}} .mt-addons-steps-count span' => 'color: {{VALUE}};',
    		],
	      ]
	    );
    $this->end_controls_tab();
	$this->end_controls_section();
	}

	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $process_groups 			= $settings['process_groups'];
      	?>
        <div class="mt-addons-process">
      		<?php $count = 1; ?>
      		<?php if ($process_groups) { ?>
        		<?php foreach ($process_groups as $step) { ?>
          			<div class="mt-addons-process-wrapper mt-addons-step-<?php echo esc_attr($count); ?>">
            			<div class="mt-addons-steps mt-addons-step-<?php echo esc_attr($count); ?>">
              				<h3><?php echo esc_html($step['step_title']); ?></h3>
              				<p><?php echo esc_html($step['step_description']); ?></p>
            			</div>
            			<div class="mt-addons-steps-count mt-addons-step-<?php echo esc_attr($count); ?>">
              				<span><?php echo esc_html($count); ?></span>
            			</div>
          			</div>
          			<?php $count++; ?>
        		<?php } ?>
      		<?php } ?>
    	</div>
    <?php
	}
	protected function content_template() {

    }
}