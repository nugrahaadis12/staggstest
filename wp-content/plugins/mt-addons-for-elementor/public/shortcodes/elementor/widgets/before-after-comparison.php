<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Utils;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_before_after_comparison extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-before-after', MT_ADDONS_PUBLIC_ASSETS.'css/before-after-comparison.css');
        wp_enqueue_style( 'mt-addons-twentytwenty-no-compass', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/twentytwenty/twentytwenty-no-compass.css');
        wp_enqueue_style( 'mt-addons-twentytwenty', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/twentytwenty/twentytwenty.css');

        return [
            'mt-addons-before-after', 'mt-addons-twentytwenty-no-compass', 'mt-addons-twentytwenty'
        ];
    }
    
    public function get_script_depends() {
        
        wp_register_script( 'jquery-event-move', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/twentytwenty/jquery.event.move.js');
        wp_register_script( 'jquery-twentytwenty', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/twentytwenty/jquery.twentytwenty.js');
        
        return [ 'jquery', 'elementor-frontend', 'jquery-twentytwenty', 'jquery-event-move' ];
    }
    
	public function get_name() {
		return 'mtfe-before-after-comparison';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Before After Comparison','mt-addons');
	}
	 
	public function get_icon() {
		return 'eicon-image-before-after';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_before_after_content();
        $this->section_help_settings();
    }

    private function section_before_after_content() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		$this->add_control(
			'image_before',
			[
				'label' 		=> esc_html__( 'Image (Before)', 'mt-addons' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				]
			]
		); 
		$this->add_control( 
			'image_after',
			[
				'label' 		=> esc_html__( 'Image (After)', 'mt-addons' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				]
			]
		); 
		$this->add_control(
			'orientation',
			[
				'label' 		=> esc_html__( 'Alignment', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 				=> esc_html__( 'Select', 'mt-addons' ),
					'horizontal' 	=> esc_html__( 'Horizontal', 'mt-addons' ),
					'vertical'		=> esc_html__( 'Vertical', 'mt-addons' ),

				],
			]
		);
		$this->end_controls_section();
		
	}
	protected function render() {
        $settings 				= $this->get_settings_for_display();
        $image_before 			= $settings['image_before'];
        $image_after 			= $settings['image_after'];
        $orientation 			= $settings['orientation'];

		$orientation_attr = '';
		if ($orientation == 'vertical') {
			$orientation_attr = 'vertical';
		}
	
        $image_before 	= $settings['image_before']['url'];
        $image_after 	= $settings['image_after']['url'];
		?>

        <script type="text/javascript">
	    	jQuery(window).load(function(){
	      	jQuery(".mt-addons-before-after-comparison-container[data-orientation!='vertical']").twentytwenty({default_offset_pct: 0.7});
	      	jQuery(".mt-addons-before-after-comparison-container[data-orientation='vertical']").twentytwenty({default_offset_pct: 0.3, orientation: 'vertical'});
	    	});
  		</script>

		<div class="mt-addons-before-after-comparison-shortcode mt-addons-before-after-comparison-container" data-orientation="<?php echo esc_attr($orientation_attr); ?>">
		    <img src="<?php echo esc_url($image_before); ?>" alt="<?php esc_attr_e('Before', 'mt-addons'); ?>" />
		    <img src="<?php echo esc_url($image_after); ?>" alt="<?php esc_attr_e('After', 'mt-addons'); ?>" />
		</div>
        <?php 
	}
	protected function content_template() {

    }
}