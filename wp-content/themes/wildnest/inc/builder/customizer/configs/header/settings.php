<?php

class Wildnest_Builder_Header_Settings {
	public $id = 'header_settings';

	function customize() {
		$section = 'header_settings';

		return array(
			array(
				'name'     		=> $section,
				'type'     		=> 'section',
				'panel'    		=> 'header_settings',
				'priority' 		=> 299,
				'title'    		=> esc_html__( 'Settings', 'wildnest' ),
			),
			array(
				'name'          => 'wildnest_header_status',
				'type'          => 'checkbox',
				'section'   	=> $section,
				'title'         => esc_html__( 'Header Status', 'wildnest' ),
				'description'   => esc_html__('Enable or disable the Header. This will disable the Header completely across the entire website.', 'wildnest'),
				'default'       => 1,
			),
			array(
				'name'          => 'wildnest_general_settings_look_htransparent',
				'type'          => 'checkbox',
				'section'   	=> $section,
				'title'         => esc_html__( 'Transparent Header', 'wildnest' ),
				'description'   => esc_html__('Enable or disable Transparent Header', 'wildnest'),
				'default'       => 0,
			),
			array(
				'name'      	=> 'wildnest_is_nav_sticky',
				'type'      	=> 'checkbox',
				'section'   	=> $section,
				'title'     	=> esc_html__( 'Fixed Navigation menu?', 'wildnest' ),
				'description'   => esc_html__('Enable or disable Sticky Header', 'wildnest'),
			),
		);
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Header_Settings() );
