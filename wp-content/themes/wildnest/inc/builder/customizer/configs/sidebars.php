<?php

class Wildnest_Builder_Header_Sidebars {
	public $id = 'header_sidebars';

	function customize() {
		$section = 'header_sidebars';

		return array(
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'general_settings_panel',
				'priority' => 299,
				'title'    => esc_html__( 'Sidebars', 'wildnest' ),
			),
			array(
				'name'             => 'wildnest_general_sidebars',
				'type'             => 'repeater',
				'section'        	=> $section,
				'title'            => esc_html__( 'Custom Sidebars', 'wildnest' ),
				'live_title_field' => 'title',
				'default'          => array(
					array(
						'title' => esc_html__( 'Header Burger Sidebar', 'wildnest' ),
					),
				),
				'fields'           => array(
					array(
						'name'  => 'title',
						'type'  => 'text',
						'label' => esc_html__( 'Sidebar Name', 'wildnest' ),
					),
				),
			),
		);
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Header_Sidebars() );
