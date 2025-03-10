<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_highlighted_text extends Widget_Base {
	
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-highlighted-text', MT_ADDONS_PUBLIC_ASSETS.'css/highlighted-text.css');
        return [
            'mt-addons-highlighted-text',
        ];
    }
	public function get_name() {
		return 'mtfe-addons-highlighted-text';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Highlighted Text','mt-addons');
	}
	
	public function get_icon() {
		return ' eicon-code-highlight';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_highlighted_text();
        $this->section_help_settings();
    }

    private function section_highlighted_text() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
    	$repeater = new Repeater();
		$repeater->add_control(
			'text_type',
			[
				'label' 		=> esc_html__( 'Text Type', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'simple' 			=> esc_html__( 'Simple', 'mt-addons' ),
					'highlighted'		=> esc_html__( 'Highlighted', 'mt-addons'),
				]
			]
		);
		$repeater->add_control(
	    	'text_normal',
	        [
	            'label' 		=> esc_html__('Text', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	            'condition' 	=> [
					'text_type' 	=> 'simple',
				],
	        ]
	    );
	    $repeater->add_control(
	    	'text_highlighted',
	        [
	            'label' 		=> esc_html__('Text', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	            'condition' 	=> [
					'text_type' 	=> 'highlighted',
				],
	        ]
	    );
	    $this->add_control(
	        'texts_groups',
	        [
	            'label' 		=> esc_html__('Items', 'mt-addons'),
	            'type' 			=> Controls_Manager::REPEATER,
	            'fields' 		=> $repeater->get_controls(),
	            'default' 		=> [
					[
						'text_type' 	=> 'simple',
						'text_normal' 	=> esc_html__( 'We are', 'mt-addons' )
					],
					[
						'text_type' => 'highlighted',
						'text_highlighted' => esc_html__( 'on a mission', 'mt-addons' )
					],
					[
						'text_type' 	=> 'simple',
						'text_normal' 	=> esc_html__( 'to take the hassle out of home', 'mt-addons' )
					],
				],
	        ]
	    );
		$this->end_controls_section();
        $this->start_controls_section( 
            'style_highlighted',
            [
                'label' 		=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'aligment',
            [
                'label'   		=> esc_html__( 'Alignment', 'mt-addons' ),
                'type'    		=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left'   		=> [
                        'title' 		=> esc_html__( 'Left', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-left',
                    ],
                    'center'		=> [
                        'title' 		=> esc_html__( 'Center', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-center',
                    ],
                    'right'  		=> [
                        'title' 		=> esc_html__( 'Right', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-right',
                    ],
                ],
                'default' 			=> 'center',
                'selectors' 		=> [
        			'{{WRAPPER}} .mt-addons-highlighted-text' => 'text-align: {{VALUE}};',
    			],
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Typography', 'mt-addons' ),
				'name' 				=> 'title_typography',
				'selector' 			=> '{{WRAPPER}} .mt-addons-text-simple, {{WRAPPER}} .mt-addons-text-highlighted',
			]
		);
		$this->add_control(
			'highlight_bg_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Highlight Background Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-addons-text-highlighted' => 'background-color: {{VALUE}};',
	    		],
	    		'default' 			=> '#E1F4F7', 
			]
		);
		$this->add_control(
			'highlight_text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Highlight Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-addons-text-highlighted' => 'color: {{VALUE}};',
	    		],
	    		'default' 			=> '#F5904A',
			]
		);
		$this->add_control(
			'text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Simple Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-addons-text-simple' => 'color: {{VALUE}};',
	    		],
	    		'default' 			=> '#2F4875',
			]
		);
	$this->end_controls_section();

	}
       
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $texts_groups 				= $settings['texts_groups'];
        ?>

        <div class="mt-addons-highlighted-text">
      		<?php if ($texts_groups) { ?>
        		<?php foreach ($texts_groups as $text) {?>
          			<?php if($text['text_type'] == "simple"){ ?>
              			<?php if(!empty($text['text_normal'])){ ?>
                			<span class="mt-addons-text-simple"><?php echo esc_html($text['text_normal']); ?></span>
              			<?php } ?>
          			<?php } else if($text['text_type'] == "highlighted") { ?>
              			<?php if(!empty($text['text_highlighted'])){ ?>
                			<span class="mt-addons-text-highlighted"><?php echo esc_html($text['text_highlighted']); ?></span>
              			<?php } ?>
          			<?php } ?>
        		<?php } ?>
      		<?php } ?>
    	</div>
    <?php
	}
	protected function content_template() {

    }
}