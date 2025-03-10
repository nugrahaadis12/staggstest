<?php

class Wildnest_Builder_Item_Footer_Widget_1 {
	public $id = 'footer-1';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 1', 'wildnest' ),
			'id'      => 'footer-1',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-1',
		);
	}

	function customize() {
		return wildnest_footer_layout_settings( 'footer-1', 'sidebar-widgets-footer-1' );
	}
}

class Wildnest_Builder_Item_Footer_Widget_2 {
	public $id = 'footer-2';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 2', 'wildnest' ),
			'id'      => 'footer-2',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-2',
		);
	}

	function customize() {
		return wildnest_footer_layout_settings( 'footer-2', 'sidebar-widgets-footer-2' );
	}
}

class Wildnest_Builder_Item_Footer_Widget_3 {
	public $id = 'footer-3';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 3', 'wildnest' ),
			'id'      => 'footer-3',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-3',
		);
	}

	function customize() {
		return wildnest_footer_layout_settings( 'footer-3', 'sidebar-widgets-footer-3' );
	}
}

class Wildnest_Builder_Item_Footer_Widget_4 {
	public $id = 'footer-4';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 4', 'wildnest' ),
			'id'      => 'footer-4',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-4',
		);
	}

	function customize() {
		return wildnest_footer_layout_settings( 'footer-4', 'sidebar-widgets-footer-4' );
	}
}

class Wildnest_Builder_Item_Footer_Widget_5 {
	public $id = 'footer-5';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 5', 'wildnest' ),
			'id'      => 'footer-5',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-5',
		);
	}

	function customize() {
		return wildnest_footer_layout_settings( 'footer-5', 'sidebar-widgets-footer-5' );
	}
}

class Wildnest_Builder_Item_Footer_Widget_6 { 
	public $id = 'footer-6';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 6', 'wildnest' ),
			'id'      => 'footer-6',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-6',
		);
	}

	function customize() {
		return wildnest_footer_layout_settings( 'footer-6', 'sidebar-widgets-footer-6' );
	}
}


function wildnest_change_footer_widgets_location( $wp_customize ) {
	for ( $i = 1; $i <= 6; $i ++ ) {
		if ( $wp_customize->get_section( 'sidebar-widgets-footer-' . $i ) ) {
			$wp_customize->get_section( 'sidebar-widgets-footer-' . $i )->panel = 'footer_settings';
		}
	}

}

add_action( 'customize_register', 'wildnest_change_footer_widgets_location', 999 );

/**
 * Always show footer widgets for customize builder
 *
 * @param bool   $active
 * @param string $section
 *
 * @return bool
 */
function wildnest_customize_footer_widgets_show( $active, $section ) {
	if ( strpos( $section->id, 'widgets-footer-' ) ) {
		$active = true;
	}

	return $active;
}

add_filter( 'customize_section_active', 'wildnest_customize_footer_widgets_show', 15, 2 );


/**
 * Display Footer widget
 *
 * @param string $footer_id
 */
function wildnest_builder_footer_widget_item( $footer_id = 'footer-1' ) {
	$show = false;
	if ( is_active_sidebar( $footer_id ) ) {
		echo '<div class="widget-area">';
		dynamic_sidebar( $footer_id );
		$show = true;
		echo '</div>';
	}
}

function wildnest_builder_footer_1_item() {
	wildnest_builder_footer_widget_item( 'footer-1' );
}

function wildnest_builder_footer_2_item() {
	wildnest_builder_footer_widget_item( 'footer-2' );
}

function wildnest_builder_footer_3_item() {
	wildnest_builder_footer_widget_item( 'footer-3' );
}

function wildnest_builder_footer_4_item() {
	wildnest_builder_footer_widget_item( 'footer-4' );
}

function wildnest_builder_footer_5_item() {
	wildnest_builder_footer_widget_item( 'footer-5' );
}

function wildnest_builder_footer_6_item() {
	wildnest_builder_footer_widget_item( 'footer-6' );
}

Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Item_Footer_Widget_1() );
Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Item_Footer_Widget_2() );
Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Item_Footer_Widget_3() );
Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Item_Footer_Widget_4() );
Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Item_Footer_Widget_5() );
Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Item_Footer_Widget_6() );
