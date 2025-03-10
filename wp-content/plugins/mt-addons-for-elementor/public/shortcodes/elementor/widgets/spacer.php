<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_spacer extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-spacer', MT_ADDONS_PUBLIC_ASSETS.'css/spacer.css');
        return [
            'mt-addons-spacer',
        ];
    }

	public function get_name() {
		return 'mtfe-spacer';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Spacer');
	}
	
	public function get_icon() {
	    return 'eicon-spacer'; 
	}
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_spacer();
        $this->section_help_settings();
    }

    private function section_spacer() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		
		$this->add_control(
			'desktop_height',
			[
				'label' 		=> esc_html__( 'Desktop Height', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-empty-spacer-desktop' => 'height: {{VALUE}}px;',
    			],
				'default' 		=> '60',
			]
		);
		$this->add_control(
			'mobile_height',
			[
				'label' 		=> esc_html__( 'Mobile Height', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-empty-spacer-mobile' => 'height: {{VALUE}}px;',
    			],
				'default' 		=> '40',
			]
		);
		$this->add_control(
			'tablet_height',
			[
				'label' 		=> esc_html__( 'Tablet Height', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-empty-spacer-tablet' => 'height: {{VALUE}}px;',
    			],
				'default' 		=> '20',
			]
		);

		$this->end_controls_section();

	}
	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="mt-addons-flexible-spacer">
      		<div class="mt-addons-empty-spacer-desktop"></div>
      		<div class="mt-addons-empty-spacer-mobile"></div>
      		<div class="mt-addons-empty-spacer-tablet"></div>
    	</div>
    <?php
	}
	protected function content_template() {

    }
}