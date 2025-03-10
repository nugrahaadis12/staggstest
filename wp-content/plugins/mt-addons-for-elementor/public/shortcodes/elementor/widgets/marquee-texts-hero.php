<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_marquee_texts_hero extends Widget_Base {
	
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-marquee-texts-hero', MT_ADDONS_PUBLIC_ASSETS.'css/marquee-texts-hero.css');
        return [
            'mt-addons-marquee-texts-hero',
        ];
    }
	public function get_name() {
		return 'mtfe-marquee-texts-hero'; 
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__( 'MT - Marquee Texts Hero', 'mt-addons' );
	}
	
	public function get_icon() {
		return ' eicon-animation-text';
	}
	 
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_marquee_text();
        $this->section_help_settings();
    }

    private function section_marquee_text() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$this->add_control(
			'mix_blend_mode',
			[
				'label' 			=> esc_html__( 'Mix Blend Mode (Item Text Hover)', 'mt-addons' ),
                'description'       => esc_html__( 'This is a special CSS effect compatible with any major browser.', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'normal' 			=> esc_html__( 'normal', 'mt-addons' ),
					'multiply'			=> esc_html__( 'multiply', 'mt-addons' ),
					'overlay' 			=> esc_html__( 'overlay', 'mt-addons' ),
					'screen' 			=> esc_html__( 'screen', 'mt-addons' ),
					'darken' 			=> esc_html__( 'darken', 'mt-addons' ),
					'lighten' 			=> esc_html__( 'lighten', 'mt-addons' ),
					'color-dodge' 		=> esc_html__( 'color-dodge', 'mt-addons' ),
					'color-burn' 		=> esc_html__( 'color-burn', 'mt-addons' ),
					'hard-light' 		=> esc_html__( 'hard-light', 'mt-addons' ),
					'soft-light' 		=> esc_html__( 'soft-light', 'mt-addons' ),
					'difference' 		=> esc_html__( 'difference', 'mt-addons' ),
					'exclusion' 		=> esc_html__( 'exclusion', 'mt-addons' ),
					'hue' 				=> esc_html__( 'hue', 'mt-addons' ),
					'saturation' 		=> esc_html__( 'saturation', 'mt-addons' ),
					'color' 			=> esc_html__( 'color', 'mt-addons' ),
					'luminosity' 		=> esc_html__( 'luminosity', 'mt-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .mt-addons-marquee-texts-hero-marquee' => 'mix-blend-mode: {{VALUE}}',
				],
				'default' 			=> 'luminosity',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' 				=> 'text_stroke',
				'selector' 			=> '{{WRAPPER}} .mt-addons-marquee-texts-hero-menu__item-link',
			]
		);
    	$repeater = new Repeater();
		$repeater->add_control(
	    	'title',
	        [
	            'label' 			=> esc_html__('Title', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT,
	        ]
	    );
	    $repeater->add_control(
			'image',
			[
				'label' 			=> esc_html__( 'Image', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 			=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
	    $this->add_control( 
	        'items',
	        [
	            'label' 			=> esc_html__('Items', 'mt-addons'),
	            'type' 				=> Controls_Manager::REPEATER,
	            'fields' 			=> $repeater->get_controls(),
	            'default' 			=> [
                    [
                        'title' 		=> esc_html__( 'NFT World', 'mt-addons' ),
                    ],
                    [
                        'title' 		=> esc_html__( 'Art Works', 'mt-addons' ),
                    ],
                    [
                        'title' 		=> esc_html__( 'NFT World', 'mt-addons' ),
                    ],
                ],
	        ]
	    );
	$this->end_controls_section();
	}
         
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $mix_blend_mode 			= $settings['mix_blend_mode'];
        $items 						= $settings['items'];
    	$id 						= uniqid('texts-hero-shortcode-');
		?>

		<div class="mt-addons-marquee-texts-hero-shortcode" data-unique-id="<?php echo esc_attr($id); ?>">
	    	<nav class="mt-addons-marquee-texts-hero-menu">
	      		<?php if ($items) { ?>
	        		<?php foreach ($items as $item) { ?>
	            		<?php $image = $item['image']['url']; ?>
	        			<div class="mt-addons-marquee-texts-hero-menu__item">
	            			<a class="mt-addons-marquee-texts-hero-menu__item-link"><?php echo esc_html($item['title']); ?></a>
	            			<img class="mt-addons-marquee-texts-hero-menu__item-img" src="<?php echo esc_url($image); ?>"/>
		            		<div class="mt-addons-marquee-texts-hero-marquee">
		              			<div class="mt-addons-marquee-texts-hero-marquee__inner" aria-hidden="true">
		                			<span><?php echo esc_html($item['title']); ?></span>
		                			<span><?php echo esc_html($item['title']); ?></span>
		                			<span><?php echo esc_html($item['title']); ?></span>
		                			<span><?php echo esc_html($item['title']); ?></span>
		              			</div>
		            		</div>
	          			</div>
	        		<?php } ?>
	      		<?php } ?>
	    	</nav>
		</div>

	<?php
	}
	protected function content_template() {

    }
}