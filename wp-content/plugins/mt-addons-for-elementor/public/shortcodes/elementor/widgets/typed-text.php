<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_typed_text extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-typed-text', MT_ADDONS_PUBLIC_ASSETS.'css/typed-text.css');
        return [
            'mt-addons-typed-text',
        ];
    }

	public function get_name() {
		return 'mtfe-typed-text';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Typed Text','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-typography';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	public function get_script_depends() {
    	wp_enqueue_script( 'typed', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/typed/typed.js');
        return [ 'jquery', 'elementor-frontend', 'typed' ];
    }

	protected function register_controls() {
        $this->section_typed_text();
        $this->section_help_settings();
    }

    private function section_typed_text() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
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
                'selectors' => [
        			'{{WRAPPER}} .mt-addons-typed-text' => 'text-align: {{VALUE}};',
    			],
    			'default' 			=> 'left',
            ]
        );
        $this->add_control( 
			'texts', 
			[
				'label' 			=> esc_html__( 'Typed Texts', 'mt-addons' ),
				'description' 		=> esc_html__( "Eg: 'String Text 1', 'String Text 2', 'String Text 3'", 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default' 			=> "'organization','enterprise','business'",
			]
		);
        $this->add_control(
			'beforetext',
			[
				'label' 			=> esc_html__( 'Before Typed Texts', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default'			=> esc_html__('Company that works for your','mt-addons'),
			]
		);
        $this->add_control(
			'aftertext',
			[
				'label' 			=> esc_html__( 'After Typed Texts', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
			]
		);
		$this->end_controls_section();
        $this->start_controls_section(
            'style_typed_text',
            [
                'label' 			=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
	    $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 			=> esc_html__( 'Typography', 'mt-addons' ),
				'name' 				=> 'font_size',
				'selector' 			=> '{{WRAPPER}} .mt-addons-typed-text span',
			]
		);
		$this->add_control(
			'color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-addons-typed-text span' => 'color: {{VALUE}};',
	    		],
			]
		); 
		
		$this->end_controls_section();

	}
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $texts 					= $settings['texts'];
        $beforetext 			= $settings['beforetext'];
        $aftertext 				= $settings['aftertext'];
 
    	$typed_unique_id = 'mt_addons_typed_text_'.uniqid(); ?>
    	<script type="text/javascript">
      		jQuery(function(){
        		jQuery(".<?php echo esc_attr($typed_unique_id); ?>").typed({
          		strings: [<?php echo strip_tags($texts);?>],
          		loop: true
        	});
      	}); 
    	</script>

    	<div class="mt-addons-typed-text">
      		<span class="mt_addons_typed_text-beforetext"><?php echo esc_html($beforetext); ?></span>
      		<span class="mt_addons_typed_text <?php echo esc_attr($typed_unique_id); ?>"></span>
      		<span class="mt_addons_typed_text-aftertext"><?php echo esc_html($aftertext); ?></span>
    	</div>
    <?php
	}
	protected function content_template() {

    }
}