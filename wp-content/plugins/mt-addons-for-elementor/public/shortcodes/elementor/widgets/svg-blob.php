<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_svg_blob extends Widget_Base {
	public function get_name() {
		return 'mtfe-svg-blob';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - SVG Blob','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-image-bold';
	} 
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_svg_blob();
        $this->section_help_settings();
    }

    private function section_svg_blob() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
	    $this->add_control(
			'color_or_image',
			[
				'label' 		=> esc_html__( 'Background Type', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'choosed_image' 	=> esc_html__( 'Use an image', 'mt-addons' ),
					'choosed_color'		=> esc_html__( 'Use a color', 'mt-addons' ),
				],
				'default' => 'choosed_color',
			] 
		);
		$this->add_control(
			'bg_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Background color', 'mt-addons' ),
				'label_block' 	=> true,
				'condition' 	=> [
					'color_or_image' => 'choosed_color',
				],
				'default' 		=> '#474BFF'
			]
		);
		$this->add_control(
			'image',
			[
				'label' 		=> esc_html__( 'Image', 'mt-addons' ),
          		'description' 	=> esc_attr__( "Choose background image", 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::MEDIA,
				'default' 		=> [
					'url' 			=> \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' 	=> [
					'color_or_image' => 'choosed_image',
				],
			]
		);
		$this->add_control(
	    	'clip_path',
	        [
	            'label' 		=> esc_html__('Clip Path', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
          		'description' 	=> esc_attr__("Create the blob shape at https://10015.io/tools/svg-blob-generator",'mt-addons'),
          		'default' => 'M374.5,320Q332,400,236.5,406Q141,412,115,326Q89,240,127,175Q165,110,262,71.5Q359,33,388,136.5Q417,240,374.5,320Z',
	        ]
	    );
	    $this->add_control(
	    	'blob_width',
	        [
	            'label' 		=> esc_html__('Blob Width', 'mt-addons'),
	            'type' 			=> Controls_Manager::NUMBER,
         	 	'description' 	=> esc_html__("Set width by %.",'mt-addons'),
         	 	'selectors' 	=> [
	        		'{{WRAPPER}} .mt-svg-block svg' => 'width: {{VALUE}}%;',
	    		],
	    		'default' 		=> '50',
	        ]
	    );
	    $this->add_control(
			'svg_position',
			[
				'label' 		=> esc_html__( 'Position', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'absolute' 			=> esc_html__( 'Absolute', 'mt-addons' ),
					'relative'			=> esc_html__( 'Relative', 'mt-addons' ),
				],
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-svg-block ' => 'position: {{VALUE}};',
    			]
			]
		);
		$this->add_responsive_control(
	    	'svg_position_top',
	        [
	            'label' 		=> esc_html__('Horizontal', 'mt-addons'),
	            'type' 			=> Controls_Manager::NUMBER,
         	 	'description' 	=> esc_html__("Set by %.",'mt-addons'),
         	 	'selectors' 	=> [
	        		'{{WRAPPER}} .mt-svg-block' => 'top: {{VALUE}}%;',
	    		],
	    		'condition' 	=> [
					'svg_position' => 'absolute',
				],
	        ]
	    );
	    $this->add_responsive_control(
	    	'svg_position_right',
	        [
	            'label' 		=> esc_html__('Vertical', 'mt-addons'),
	            'type' 			=> Controls_Manager::NUMBER,
         	 	'description' 	=> esc_html__("Set by %.",'mt-addons'),
         	 	'selectors' 	=> [
	        		'{{WRAPPER}} .mt-svg-block' => 'right: {{VALUE}}%;',
	    		],
	    		'condition' 	=> [
					'svg_position' => 'absolute',
				],
	        ]
	    ); 
	    $this->add_control(
	    	'extra_class',
	        [
	            'label' 		=> esc_html__('Extra Class', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT,
	        ]
	    );

	$this->end_controls_section();

	}
	         
	protected function render() {
        $settings 			= $this->get_settings_for_display();
        $color_or_image 	= $settings['color_or_image'];
        $bg_color 			= $settings['bg_color'];
        $image 				= $settings['image'];
        $clip_path 			= $settings['clip_path'];
        $extra_class 		= $settings['extra_class'];


		$image_id = '';
		if(!empty($image)) {
			$image_id .= $image['url'].',';
	    }
    
    	$id = uniqid(); ?>
    	
    	<div class="mt-svg-block <?php echo esc_attr($extra_class);?>" >
      		<svg viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        		<?php if($color_or_image == 'choosed_color'){ ?>
          			<path fill="<?php echo esc_attr($bg_color);?>" d="<?php echo esc_attr($clip_path);?>" />
        		<?php } else if ($color_or_image == 'choosed_image') { ?>
        			<defs>
          				<clipPath id="blob-<?php echo esc_attr($id);?>">
              				<path fill="#474bff" d="<?php echo esc_attr($clip_path);?>"/>
          				</clipPath>
        			</defs>
        			<image x="0" y="0" width="100%" height="100%" alt="svg-blob" clip-path="url(#blob-<?php echo esc_attr($id); ?>)" xlink:href="<?php echo esc_url($image_id);?>" preserveAspectRatio="xMidYMid slice"></image>
        		<?php } ?>
      		</svg>
    	</div>
    <?php
	}
	protected function content_template() {

    }
}