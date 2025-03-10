<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_circle_text extends Widget_Base {

	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-circle-text', MT_ADDONS_PUBLIC_ASSETS.'css/circle-text.css');
        return [
            'mt-addons-circle-text',
        ];
    }
	
	public function get_name() {
		return 'mtfe-circle-text';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Circle Text','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-circle';
	}
	
	public function get_categories() { 
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_circle_text();
        $this->section_help_settings();
    }

    private function section_circle_text() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Text Circle', 'mt-addons' ),
			]
		);
		$this->add_control(
			'circle_animation',
			[
				'label' 			=> esc_html__( 'Enable Text Animation', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'yes',
			]
		);
		$this->add_control(
	    	'text_animate',
	        [
	            'label' 			=> esc_html__('Text Animate', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT,
	            'default' 			=> esc_html__( 'Exploare Artworks • Exploare Artworks • Exploare Artworks •', 'mt-addons' ),
	        ]
	    );
	    $this->add_responsive_control(
			'left_percent', 
			[
				'label' 			=> esc_html__( 'Left', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 35,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-circle-svg-text' => 'left: {{VALUE}}%',
                ],
			]
		);
		$this->add_responsive_control(
			'top_percent',
			[
				'label' 			=> esc_html__( 'Top', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 45,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-circle-svg-text' => 'top: {{VALUE}}px',
                ],
			]
		);
		$this->add_control(
			'circle_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color Text Animate', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#111111',
				'selectors' 		=> [
					'{{WRAPPER}} g.mt-addons-text-circle-animate' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'text_circle_size', 
			[
				'label' 			=> esc_html__( 'Text Animate - Font size', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 25,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-text-circle-animate text' => 'font-size: {{VALUE}}px',
                ],
			] 
		);
		$this->add_control(
			'y_offset', 
			[
				'label' 			=> esc_html__( 'Defines the y offset', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 30,
			]
		);
		$this->add_control(
			'text_length', 
			[
				'label' 			=> esc_html__( 'Title - Text Length', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 1290,
			]
		);
		$this->add_control(
			'letter_spacing',
			[
				'label' 			=> esc_html__( 'Title - Letter Spacing', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 30,
			]
		); 
		$this->add_control(
			'circle_width',
			[
				'label' 			=> esc_html__( 'Circle - Width', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 80,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'middle_tab',
			[
				'label' 			=> esc_html__( 'Middle Element', 'mt-addons' ),
			]
		);
		$this->add_control(
		    'static_text',
		        [
		            'label' 		=> esc_html__('Title Text', 'mt-addons'),
		            'type' 			=> Controls_Manager::TEXT,
	            	'default' 		=> esc_html__( '35K', 'mt-addons' ),
		        ]
		    );
		$this->add_control( 
			'text_static_size',
			[
				'label' 			=> esc_html__( "Title  - Font size", 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 100,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-text-circle-static text' => 'font-size: {{VALUE}}px',
                ],
			]
		);
		$this->add_control(
			'title_x_offset',
			[
				'label' 			=> esc_html__( "Title - y offset", 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 160,
			]
		);
		$this->add_control(
			'title_y_offset',
			[
				'label' 			=> esc_html__( "Title - x offset", 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 270,
			]
		);
		$this->add_control( 
			'text_static_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#111111',
				'selectors' 		=> [
					'{{WRAPPER}} g.mt-addons-text-circle-static' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'subtitle_tab',
			[
				'label' 			=> esc_html__( 'Subtitle Middle', 'mt-addons' ),
			]
		);
		$this->add_control(
		    'static_sub_text',
		        [
		            'label' 		=> esc_html__('Subtitle Text', 'mt-addons'),
		            'type' 			=> Controls_Manager::TEXT,
	            	'default' 		=> esc_html__( 'Items', 'mt-addons' ),
		        ]
		    );
		$this->add_control(
			'text_sub_static_size', 
			[
				'label' 			=> esc_html__( 'Subtitle - Font size', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 30,
				'selectors' 		=> [
                    '{{WRAPPER}} text.mt-addons-circle-svg-subtitle' => 'font-size: {{VALUE}}px',
                ],
			]
		);
		$this->add_control(
			'subtitle_x_offset',
			[
				'label' 			=> esc_html__( 'Subtitle - x offset', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 210,
			]
		);
		$this->add_control(
			'subtitle_y_offset',
			[
				'label' 			=> esc_html__( 'Subtitle - y offset', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'default' 			=> 320,
			]
		);
		$this->add_control(
			'text_sub_static_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Subtitle Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#111111',
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-text-circle-sub-static text' => 'fill: {{VALUE}}',
				],
			]
		);
	$this->end_controls_section();

	}
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $text_animate 			= $settings['text_animate'];
        $left_percent 			= $settings['left_percent'];
        $top_percent 			= $settings['top_percent'];
        $text_circle_size 		= $settings['text_circle_size'];
        $y_offset 				= $settings['y_offset'];
        $text_length 			= $settings['text_length'];
        $letter_spacing 		= $settings['letter_spacing'];
        $circle_width 			= $settings['circle_width'];
        $static_text 			= $settings['static_text'];
        $text_static_size 		= $settings['text_static_size'];
        $title_x_offset 		= $settings['title_x_offset'];
        $title_y_offset 		= $settings['title_y_offset'];
        $text_static_color 		= $settings['text_static_color'];
        $static_sub_text 		= $settings['static_sub_text'];
        $text_sub_static_size 	= $settings['text_sub_static_size'];
        $subtitle_x_offset 		= $settings['subtitle_x_offset'];
        $subtitle_y_offset 		= $settings['subtitle_y_offset'];
        $text_sub_static_color 	= $settings['text_sub_static_color'];
        $circle_animation 		= $settings['circle_animation'];
		?>

	    <div class="mt-addons-circle-svg-text">
	      	<svg xmlns="http://www.w3.org/2000/svg"xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 2300 1000" width="<?php echo esc_attr($circle_width); ?>%">
	        	<defs>
	          		<path d="M50,250c0-110.5,89.5-200,200-200s200,89.5,200,200s-89.5,200-200,200S50,360.5,50,250" id="textcircle">
	          		</path>
	        	</defs>
	        	<g class="mt-addons-text-circle-animate <?php echo esc_attr($circle_animation); ?>">
	          		<text dy="<?php echo esc_attr($y_offset); ?>" textLength="<?php echo esc_attr($text_length); ?>"letter-spacing="<?php echo esc_attr($letter_spacing); ?>"><textPath xlink:href="#textcircle"><?php echo esc_html($text_animate); ?></textPath>
	          		</text>
	        	</g>
	        	<g class="mt-addons-text-circle-static">     
	          		<text class="mt-addons-circle-svg-text-static" x="<?php echo esc_attr($title_x_offset); ?>" y="<?php echo esc_attr($title_y_offset); ?>" ><?php echo esc_html($static_text); ?></text>
	        	</g>
	        	<g class="mt-addons-text-circle-sub-static">     
	          		<text class="mt-addons-circle-svg-subtitle" x="<?php echo esc_attr($subtitle_x_offset); ?>" y="<?php echo esc_attr($subtitle_y_offset); ?>" ><?php echo esc_html($static_sub_text); ?></text>
	        	</g>
	      	</svg>
	    </div>
	    
	<?php
	}
	protected function content_template() {

    }
}