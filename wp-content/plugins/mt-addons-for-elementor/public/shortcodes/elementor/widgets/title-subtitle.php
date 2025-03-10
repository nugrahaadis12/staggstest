<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_title_subtitle extends Widget_Base {

	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-title-subtitle', MT_ADDONS_PUBLIC_ASSETS.'css/title-subtitle.css');

        return [
            'mt-addons-title-subtitle',
        ];
    }
	
	public function get_name() {
		return 'mtfe-title-subtitle';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Title & Subtitle', 'mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-post-title';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_title_subtitle();
        $this->section_help_settings();
    }

    private function section_title_subtitle() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		
		$this->add_control(
            'section_align',
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
                'selectors' 			=> [
        			'{{WRAPPER}} .mt-addons-subtitle-section, {{WRAPPER}} .mt-addons-title-border, {{WRAPPER}} .mt-addons-title-svg-border, {{WRAPPER}} .mt-addons-title-section' => 'text-align: {{VALUE}};',
    			],
                'default' 			=> 'center',
                'toggle'  			=> false,
            ]
        );
		$this->add_control(
			'title',
			[
				'label' 			=> esc_html__( 'Normal Text', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default' 			=> esc_html__('What Solutions ','mt-addons'),
			]
		);
        $this->add_control(
            'title_underline',
            [
                'label' 			=> esc_html__( 'Underline Text', 'mt-addons' ),
                'label_block' 		=> true,
                'type' 				=> Controls_Manager::TEXT,
                'default' 			=> esc_html__('We Best','mt-addons'),
            ]
        );
        $this->add_control(
            'underline_style',
            [
                'label' 			=> esc_html__( 'Underline Style', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::SELECT,
                'default' 			=> 'curved',
                'options' 			=> [
                    'curved'  			=> esc_html__( 'Curved', 'mt-addons' ),
                    'straight'  		=> esc_html__( 'Straight', 'mt-addons' ),
                    'double'    		=> esc_html__( 'Double', 'mt-addons' ),
                    'square'    		=> esc_html__( 'Square', 'mt-addons' ),
                ],
            ]
        );
        $this->add_control(
            'line_color',
            [
                'label' 			=> esc_html__( 'Line Color', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::COLOR,
				'default' 			=> '#1C0AEB',
                'selectors' 		=> [
                    '{{WRAPPER}} .curved:after' 	=> 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .straight:after' 	=> 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .double:before' 	=> 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .double:after' 	=> 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .square:after' 	=> 'color: {{VALUE}}; text-shadow: 15px 0 {{VALUE}}, -15px 0 {{VALUE}};',
                
                ],
            ]
        );
        $this->add_control(
            'line_text_color',
            [
                'label' 			=> esc_html__( 'Line Text Color', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::COLOR,
				'default' 			=> '#000000',
                'selectors' 		=> [
                    '{{WRAPPER}} .mt-underline-text' => 'color: {{VALUE}} !important;',

                ],
            ]
        );
        $this->add_control(
            'title_2',
            [
                'label' 			=> esc_html__( 'Normal Text 2', 'mt-addons' ),
                'label_block' 		=> true,
                'type' 				=> Controls_Manager::TEXT,
                'default' 			=> esc_html__('Offer','mt-addons'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' 				=> 'titles_typography',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-title-section',
            ]
        );
        $this->add_control(
			'title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-addons-title-section, {{WRAPPER}} .mt-underline-text' => 'color: {{VALUE}};',
	    		]
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
				'default' 			=> 'h2',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'label' 			=> esc_html__( 'Title Stroke', 'mt-addons' ),
				'name' 				=> 'title_stroke',
				'selector' 			=> '{{WRAPPER}} .mt-addons-title-section',
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
				'label' 			=> esc_html__( 'Subtitle', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXT,
				'default' 			=> esc_html__('Our Powerful Solutions','mt-addons'),
			]
		);
		$this->add_control(
			'subtitle_position',
			[
				'label' 			=> esc_html__( 'Subtitle placement', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'down',
				'options' 			=> [
					''       			=> esc_html__( 'Select Option', 'mt-addons' ),
					'up'     			=> esc_html__( 'Above Heading', 'mt-addons' ),
					'down' 	 			=> esc_html__( 'Below Heading', 'mt-addons' ),
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     			=> 'fileds_typography_subtitle',
                'label'    			=> esc_html__( 'Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-subtitle-section',
            ]
        );
        $this->add_control(
			'subtitle_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Color', 'mt-addons' ),
				'label_block' 		=> true,
				'default' 			=> '#848484',
				'selectors' 		=> [
	        		'{{WRAPPER}} .mt-addons-subtitle-section' => 'color: {{VALUE}};',
	    		]
			]
		); 
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'label' 			=> esc_html__( 'Subtitle Stroke', 'mt-addons' ),
				'name' 				=> 'subtitle_stroke',
				'selector' 			=> '{{WRAPPER}} .mt-addons-subtitle-section',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'separator_tab',
			[
				'label' 			=> esc_html__( 'Separator', 'mt-addons' ),
			]
		);
		$this->add_control(
			'separator_status',
			[
				'label' 			=> esc_html__( 'Status', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
		$this->add_control(
			'separator_type',
			[
				'label' 			=> esc_html__( 'Type', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> '',
				'options' 			=> [
					''       			=> esc_html__( 'Select Option', 'mt-addons' ),
					'svg'       		=> esc_html__( 'SVG', 'mt-addons' ),
					'image' 			=> esc_html__( 'Image', 'mt-addons' ),
				],
				'condition' 		=> [
					'separator_status' 	=> 'yes',
				],
			]
		);
		$this->add_control(
			'separator',
			[
				'label' 			=> esc_html__( 'Separator', 'mt-addons' ),
				'type' 				=> Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 				=> \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' 		=> [
					'separator_type' 	=> 'image',
				],
			]
		);
		$this->add_control(
			'content_svg',
			[
				'label' 			=> esc_html__( 'HTML SVG', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::TEXTAREA,
				'default' 			=> '',
				'condition' 		=> [
					'separator_type' 	=> 'svg',
					'separator_status' 	=> 'yes',
				],
				'default' 			=> '<svg width="133" height="13" viewBox="0 0 133 13" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M30.257 13L0.879883 5.37062L10.7336 1.71944L30.257 6.78982L54.7123 0.439941L79.1625 6.78982L103.618 0.439941L133 8.06932L123.146 11.7205L103.618 6.65012L79.1625 13L54.7123 6.65012L30.257 13Z" fill="#FFD789"/>
					</svg>'
			]
		);
		$this->end_controls_section();

	}
	
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $title 					= $settings['title'];
        $title_underline        = $settings['title_underline'];
        $title_2 				= $settings['title_2'];
        $title_tag 				= $settings['title_tag'];
        $underline_style        = $settings['underline_style'];
        $subtitle 				= $settings['subtitle'];
        $subtitle_position 		= $settings['subtitle_position'];
        $separator_status 		= $settings['separator_status'];
        $separator_type 		= $settings['separator_type'];
        $separator 				= $settings['separator'];
        $content_svg 			= $settings['content_svg'];
		$btn_atts = '';

        if(!empty($separator)){ 
			$btn_atts .= $separator['id'].',';
		}
        $separator = wp_get_attachment_image_src($separator, "large"); ?>

    	<div class="mt-addons-title-subtile">
      		<?php if ($subtitle != '' && $subtitle_position == 'up') { ?>
        		<div class="mt-addons-subtitle-section"><?php echo esc_html($subtitle); ?></div>
      		<?php } ?>

      		<?php if (($separator_status && $subtitle_position == 'up')) { ?>
        		<?php if ($separator_type == "image") { ?>
          			<div class="mt-addons-title-border" style="background: url(<?php echo esc_url($separator[0]); ?>) no-repeat center center;"></div>
        		<?php } else if ($separator_type == "svg") {?>
          			<?php if($content_svg) { ?>
            			<div class="mt-addons-title-svg-border"><?php echo esc_attr($content_svg); ?></div>
          			<?php } ?>
        		<?php } ?>
      		<?php } ?>

      		<?php 
      		if ($underline_style == 'curved') { 
        		$underline = 'curved';
      		} elseif ($underline_style == 'straight') {
        		$underline = 'straight';
      		} elseif ($underline_style == 'double') {
        		$underline = 'double';
      		} elseif ($underline_style == 'square') {
        		$underline = 'square';
      		} ?>
 
      		<<?php echo Utils::validate_html_tag( $title_tag ); ?> class="mt-addons-title-section"><?php echo esc_html($title); ?> <span class="mt-underline-text <?php echo esc_attr($underline); ?>"><?php echo esc_html($title_underline); ?></span> <?php echo esc_html($title_2); ?></<?php echo Utils::validate_html_tag( $title_tag ); ?>>

      		<?php if (($separator_status && $subtitle_position == 'down') || ($separator_status && $subtitle_position == '')) { ?>
        		<?php if ($separator_type == "image") { ?>
          			<div class="mt-addons-title-border" style="background: url(<?php echo esc_attr($separator[0]); ?>) no-repeat center center;"></div>
        		<?php } else if ($separator_type == "svg") {?>
          			<?php if($content_svg) { ?>
            			<div class="mt-addons-title-svg-border"><?php echo esc_attr($content_svg); ?></div>
          			<?php } ?>
        		<?php } ?>
      		<?php } ?>

      		<?php if (($subtitle != '' && $subtitle_position == 'down') || ($subtitle != '' && $subtitle_position == '')) { ?>
        		<div class="mt-addons-subtitle-section"><?php echo esc_html($subtitle); ?></div>
      		<?php } ?>
    	</div>
	<?php
	}
	protected function content_template() {

    }
}