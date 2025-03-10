<?php

class Wildnest_Builder_Item_Separator {
	public $id 		= 'separator';
	public $section = 'header_separator';
	function item() {
		$section  = $this->section;
		return array(
			'name'    => esc_html__( '|', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => $section,
		);
	}
	function customize() {
		$section  = $this->section;
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'Separator', 'wildnest' ),
			),
			array(
				'name'       	=> 'wildnest_header_separator_color',
				'type'       	=> 'color',
				'section' 		=> $section,
				'selector'   	=> '.header-separator::before',
				'default'		=> '#dee2e6',
				'css_format' 	=> 'background: {{value}};',
				'title'      	=> esc_html__( 'Color', 'wildnest' ),
			),
		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, $section ) );
	}

	function render() {
		echo '<div class="header-separator"></div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Separator() );

//Separator 2
class Wildnest_Builder_Item_Separator2 {
	public $id 		= 'separator2';
	public $section = 'header_separator2';
	function item() {
		$section  = $this->section;
		return array(
			'name'    => esc_html__( '|', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => $section,
		);
	}
	function customize() {
		$section  = $this->section;
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'Separator', 'wildnest' ),
			),
			array(
				'name'       	=> 'wildnest_header_separator_color2',
				'type'       	=> 'color',
				'section' 		=> $section,
				'selector'   	=> '.header-separator::before',
				'default'		=> '#dee2e6',
				'css_format' 	=> 'background: {{value}};',
				'title'      	=> esc_html__( 'Color', 'wildnest' ),
			),
		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, $section ) );
	}

	function render() {
		echo '<div class="header-separator"></div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Separator2() );

//Separator 3
class Wildnest_Builder_Item_Separator3 {
	public $id 		= 'separator3';
	public $section = 'header_separator3';
	function item() {
		$section  = $this->section;
		return array(
			'name'    => esc_html__( '|', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => $section,
		);
	}
	function customize() {
		$section  = $this->section;
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'Separator', 'wildnest' ),
			),
			array(
				'name'       	=> 'wildnest_header_separator_color3',
				'type'       	=> 'color',
				'section' 		=> $section,
				'selector'   	=> '.header-separator::before',
				'default'		=> '#dee2e6',
				'css_format' 	=> 'background: {{value}};',
				'title'      	=> esc_html__( 'Color', 'wildnest' ),
			),
		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, $section ) );
	}

	function render() {
		echo '<div class="header-separator"></div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Separator3() );