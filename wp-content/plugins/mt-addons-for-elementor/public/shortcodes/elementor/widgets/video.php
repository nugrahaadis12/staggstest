<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_video extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-video', MT_ADDONS_PUBLIC_ASSETS.'css/video.css');

        return [
            'mt-addons-video',
        ];
    }

	public function get_name() {
		return 'mtfe-video';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Video','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-video-playlist';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_video();
        $this->section_help_settings();
    }

    private function section_video() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		
		$this->add_control(
			'button_image',
			[
				'label' 			=> esc_html__( 'Choose image', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 				=> MT_ADDONS_ASSETS.'play_btn.png',
				],
			]
		);
		$this->add_control(
			'image_width',
			[
				'label' 			=> esc_html__( 'Image Width', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
				'min' 				=> 1,
				'max' 				=> 9999,
				'step' 				=> 1,
				'selectors' 			=> [
                    '{{WRAPPER}} .mt-addons-video-img' => 'width: {{VALUE}}px !important;',
                ],
				'default' 			=> '100',
			]
		);
		$this->add_control(
			'image_position',
			[
				'label' 			=> esc_html__( 'Image Position', 'mt-addons' ),
				'label_block'		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'text-start' 		=> esc_html__( 'Left', 'mt-addons' ),
					'text-center'		=> esc_html__( 'Center', 'mt-addons' ),
					'text-end' 			=> esc_html__( 'Right', 'mt-addons' ),
				],
				'default' 			=> 'text-start',
			] 
		);
		$this->add_control(
			'video_source',
			[
				'label' 			=> esc_html__( 'Video source', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'options' 			=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'source_youtube' 	=> esc_html__( 'Youtube', 'mt-addons' ),
					'source_vimeo'		=> esc_html__( 'Vimeo', 'mt-addons' ),
				],
				'default' => 'source_youtube',
			]
		);
		$this->add_control(
	    	'vimeo_link_id',
	        [
	            'label' 			=> esc_html__('Vimeo id link', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT,
	            'condition' 		=> [
					'video_source' 		=> 'source_vimeo',
				],
	        ]
	    );
	    $this->add_control(
	    	'youtube_link_id',
	        [
	            'label' 			=> esc_html__('Youtube id link', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT,
	            'condition' 		=> [
					'video_source' 		=> 'source_youtube',
				],
				'default' 			=> 'LXb3EKWsInQ',
	        ]
	    );

		$this->end_controls_section();

	}
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $button_image 			= $settings['button_image']['url'];
        $image_position 		= $settings['image_position'];
        $video_source 			= $settings['video_source'];
        $vimeo_link_id 			= $settings['vimeo_link_id'];
        $youtube_link_id 		= $settings['youtube_link_id'];
	 
		$modal_id = uniqid('mt-addons-modal-');

	    $link = '';
	    if($video_source == 'source_vimeo') {
	      $link = 'https://vimeo.com/'.esc_attr($vimeo_link_id);
	    } elseif($video_source == 'source_youtube'){
	      $link = 'https://www.youtube.com/embed/'.esc_attr($youtube_link_id).'?autoplay=0&amp;modestbranding=1&amp;showinfo=0&rel=0&cc_load_policy=1&cc_lang_pref=en';
	    } ?>

		<div class="mt-addons-video-group">
		    <div class="mt-addons-video <?php echo esc_attr($image_position); ?>">
		        <div class="mt-addons-video-link" data-src="<?php echo esc_url($link); ?>" data-target="#<?php echo esc_attr($modal_id); ?>">
		            <img class="mt-addons-video-img" src="<?php echo esc_url($button_image); ?>" data-src="<?php echo esc_url($button_image); ?>" alt="<?php esc_html__('Video', 'mt-addons'); ?>">
		        </div>
		    </div>
		</div>

		<div id="<?php echo esc_attr($modal_id); ?>" class="mt-addons-video-modal">
		    <div class="mt-addonsvideo-modal-content">
		        <span class="close">&times;</span>
		        <iframe width="800" height="400" class="embed-responsive-item" src="<?php echo esc_url($link); ?>" allowscriptaccess="always"></iframe>
		    </div>
		</div>
	    <?php
	} 
	protected function content_template() {}
}