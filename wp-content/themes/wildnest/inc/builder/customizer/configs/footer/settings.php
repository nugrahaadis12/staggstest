<?php

class Wildnest_Builder_Footer_Settings {
	public $id = 'footer_settings';

	function customize() {
		$section = 'footer_settings';

		return array(
			array(
				'name'     		=> $section,
				'type'     		=> 'section',
				'panel'    		=> 'footer_settings',
				'priority' 		=> 299,
				'title'    		=> esc_html__( 'Settings', 'wildnest' ),
			),
			array(
				'name'          => 'wildnest_footer_status',
				'type'          => 'checkbox',
				'section'   	=> $section,
				'title'         => esc_html__( 'Footer Status', 'wildnest' ),
				'description'   => esc_html__('Enable or disable the Footer. This will disable the Footer completely across the entire website.', 'wildnest'),
				'default'       => 1,
			)
		);
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Footer_Settings() );
