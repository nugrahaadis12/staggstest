<?php

class Wildnest_Builder_Footer extends Wildnest_Customize_Builder_Panel {
	public $id = 'footer';

	function get_config() {
		return array(
			'id'         => 'footer',
			'title'      => esc_html__( 'Footer Builder', 'wildnest' ),
			'control_id' => 'footer_builder_panel',
			'panel'      => 'footer_settings',
			'section'    => 'footer_builder_panel',
			'devices'    => array(
				'desktop' => esc_html__( 'Footer Layout', 'wildnest' ),
			),
		);
	}

	function get_rows_config() {
		return array(
			'main'   => esc_html__( 'Footer Main', 'wildnest' ),
			'bottom' => esc_html__( 'Footer Bottom', 'wildnest' ),
		);
	}

	function customize() {
		$fn     = 'wildnest_customize_render_footer';
		$config = array(
			array(
				'name'     => 'footer_settings',
				'type'     => 'panel',
				'priority' => 98,
				'title'    => esc_html__( 'Footer', 'wildnest' ),
			),

			array(
				'name'  => 'footer_builder_panel',
				'type'  => 'section',
				'panel' => 'footer_settings',
				'title' => esc_html__( 'Footer Builder', 'wildnest' ),
			),

			array(
				'name'                => 'footer_builder_panel',
				'type'                => 'js_raw',
				'section'             => 'footer_builder_panel',
				'theme_supports'      => '',
				'title'               => esc_html__( 'Footer Builder', 'wildnest' ),
				'selector'            => '#site-footer',
				'render_callback'     => $fn,
				'container_inclusive' => true,
			),

		);

		return $config;
	}

	function row_config( $section = false, $section_name = false ) {
		$selector           = '#cb-row--' . str_replace( '_', '-', $section );
		$skin_mode_selector = '.footer--row-inner.' . str_replace( '_', '-', $section ) . '-inner';

		$fn = 'wildnest_customize_render_footer';

		$config = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'footer_settings',
				'theme_supports' => '',
				'title'          => $section_name,
			),

			array(
				'name'            => $section . '_layout',
				'type'            => 'select',
				'section'         => $section,
				'title'           => esc_html__( 'Layout', 'wildnest' ),
				'selector'        => $selector,
				'render_callback' => $fn,
				'css_format'      => 'html_class',
				'default'         => 'layout-full-contained',
				'choices'         => array(
					'layout-full-contained' => esc_html__( 'Full width - Contained', 'wildnest' ),
					'layout-fullwidth'      => esc_html__( 'Full Width', 'wildnest' ),
					'layout-contained'      => esc_html__( 'Contained', 'wildnest' ),
				),
			),
			array(
				'name'       => "{$section}_background_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Background Color', 'wildnest' ),
				'selector'   => "{$selector} .footer--row-inner",
				'css_format' => 'background-color: {{value}}',
			),
			array(
				'name'       => "{$section}_title_typography",
				'type'       => 'typography',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Typography', 'wildnest' ),
				'selector'   => "{$selector} .footer--row-inner .widget-title",
				'css_format' => 'typography',
			),
			array(
				'name'       => "{$section}_title_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Title', 'wildnest' ),
				'selector'   => "{$selector} .footer--row-inner .widget-title",
				'css_format' => 'color: {{value}}',
			),
			array(
				'name'       => "{$section}_items_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Items', 'wildnest' ),
				'selector'   => "{$selector} .footer--row-inner .menu-item a",
				'css_format' => 'color: {{value}}',
			),
			array(
				'name'       => "{$section}_items_color_hover",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Items (Hover)', 'wildnest' ),
				'selector'   => "{$selector} .footer--row-inner .menu-item a:hover",
				'css_format' => 'color: {{value}}',
			),
			array(
				'name'       => "{$section}_separator_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Separator', 'wildnest' ),
				'selector'   => "{$selector} .footer--row-inner .container",
				'css_format' => 'border-color: {{value}}',
			),
			array(
				'name'       	=> "{$section}_mobile_aligment",
				'type'          => 'text_align_no_justify',
				'section'    	=> $section,
				'title'         => esc_html__( 'Mobile Alignment', 'wildnest' ),
				'default'		=> 'left',
				'selector'      => "@media screen and (max-width: 1170px) { {$selector} div",
				'css_format' 	=> "text-align: {{value}};}",	
			),
		);
		$config = apply_filters( 'wildnest/builder/' . $this->id . '/rows/section_configs', $config, $section, $section_name );
		return $config;
	}
}

function wildnest_footer_layout_settings( $item_id, $section ) {

	global $wp_customize;

	if ( is_object( $wp_customize ) ) {
		global $wp_registered_sidebars;
		$name = $section;
		if ( is_array( $wp_registered_sidebars ) ) {
			if ( isset( $wp_registered_sidebars[ $item_id ] ) ) {
				$name = $wp_registered_sidebars[ $item_id ]['name'];
			}
		}
		$wp_customize->add_section(
			$section,
			array(
				'title' => $name,
			)
		);
	}

	if ( function_exists( 'wildnest_header_layout_settings' ) ) {
		return wildnest_header_layout_settings( $item_id, $section, 'wildnest_customize_render_footer', 'footer_' );
	}

	return false;
}

Wildnest_Customize_Layout_Builder()->register_builder( 'footer', new Wildnest_Builder_Footer() );



