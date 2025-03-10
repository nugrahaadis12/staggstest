<?php

class Wildnest_Builder_Header extends Wildnest_Customize_Builder_Panel {
	public $id = 'header';

	/**
	 * Panel builder configs.
	 *
	 * @since 0.0.1
	 * @since 0.2.9
	 *
	 * @return array
	 */
	function get_config() {
		return array(
			'id'            => $this->id,
			'title'         => esc_html__( 'Header Builder', 'wildnest' ),
			'control_id'    => 'header_builder_panel', // Control ID for ver 1.
			'version_id'    => 'header_builder_version', // The control id where store version.
			'panel'         => 'header_settings',
			'section'       => 'header_builder_panel',
			// Versions support, can choice v1 or v2.
			'versions'      => array(
				'v1' => array(
					'control_id' => 'header_builder_panel',
					'label' => esc_html__( 'Version 1', 'wildnest' ),
				),
				'v2' => array(
					'control_id' => 'header_builder_panel_v2',
					'label' => esc_html__( 'Version 2', 'wildnest' ),
				),
			),
			'devices'       => array(
				'desktop'      => esc_html__( 'Desktop', 'wildnest' ),
				'mobile'       => esc_html__( 'Mobile/Tablet', 'wildnest' ),
			),
		);
	}

	function get_rows_config() {
		return array(
			'top'     => esc_html__( 'Header Top', 'wildnest' ),
			'main'    => esc_html__( 'Header Main', 'wildnest' ),
			'bottom'  => esc_html__( 'Header Bottom', 'wildnest' ),
			'sidebar' => esc_html__( 'Menu Sidebar', 'wildnest' ),
		);
	}

	function customize() {

		$fn     = 'wildnest_customize_render_header';
		$config = array(
			array(
				'name'     => 'header_settings',
				'type'     => 'panel',
				'priority' => 1,
				'title'    => esc_html__( 'Header Builder', 'wildnest' ),
			),

			array(
				'name'  => 'header_builder_panel',
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => esc_html__( 'Header Builder', 'wildnest' ),
			),

			// Header Builder v1 store data key.
			array(
				'name'                => 'header_builder_panel',
				'type'                => 'js_raw',
				'section'             => 'header_builder_panel',
				'theme_supports'      => '',
				'title'               => esc_html__( 'Header Builder', 'wildnest' ),
				'selector'            => '#masthead',
				'render_callback'     => $fn,
				'container_inclusive' => true,
			),

			// Header Builder v2 store data key.
			array(
				'name'                => 'header_builder_panel_v2',
				'type'                => 'js_raw',
				'section'             => 'header_builder_panel',
				'theme_supports'      => '',
				'title'               => '',
				'selector'            => '#masthead',
				'render_callback'     => $fn,
				'container_inclusive' => true,
			),

			// Header Builder v2 store data key.
			array(
				'name'                => 'header_builder_version',
				'type'                => 'js_raw',
				'section'             => 'header_builder_panel',
				'theme_supports'      => '',
				'title'               => '',
				'selector'            => '#masthead',
				'sanitize_callback'   => 'sanitize_text_field',
				'render_callback'     => $fn,
				'container_inclusive' => true,
			),

		);

		return $config;
	}

	function row_config( $section = false, $section_name = false ) {

		if ( ! $section ) {
			$section = 'header_top';
		}
		if ( ! $section_name ) {
			$section_name = esc_html__( 'Header Top', 'wildnest' );
		}

		$selector           = '.header--row.' . str_replace( '_', '-', $section );
		$skin_selector      = '.header--row.' . str_replace( '_', '-', $section );
		$skin_selector      = '.header--row:not(.header--transparent).' . str_replace( '_', '-', $section );

		$fn           = 'wildnest_customize_render_header';
		$selector_all = '#masthead';

		$config = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => $section_name,
			),
			array(
				'name'            => $section . '_width_container',
				'type'            => 'slider',
				'section'         => $section,
				'theme_supports'  => '',
				'device_settings' => true,
				'max'             => 2250,
				'min'             => 1600,
				'selector'        => " {$skin_selector} .header--row-inner .container",
				'css_format'      => 'max-width: {{value}};',
				'title'           => esc_html__( 'Container Width', 'wildnest' ),
			),
			array(
				'name'            => $section . '_height',
				'type'            => 'slider',
				'section'         => $section,
				'theme_supports'  => '',
				'device_settings' => true,
				'max'             => 250,
				'selector'        => " {$skin_selector} .header--row-inner",
				'css_format'      => 'min-height: {{value}};',
				'title'           => esc_html__( 'Height', 'wildnest' ),
			),

			array(
				'name'             => $section . '_styling',
				'type'             => 'styling',
				'section'          => $section,
				'title'            => esc_html__( 'Advanced Styling', 'wildnest' ),
				'description'      => sprintf( __( 'Advanced styling for %s', 'wildnest' ), $section_name ),
				'live_title_field' => 'title',
				'selector'         => array(
					'normal' => "{$skin_selector} .header--row-inner",
				),
				'css_format'       => 'styling',
				'fields'           => array(
					'normal_fields' => array(
						'text_color' => false,
						'link_color' => false,
						'padding'    => false,
						'margin'     => false,
					),
					'hover_fields'  => false,
				), // disable hover tab and all fields inside.
			),
			array(
				'name'           => $section . '_sticky_status',
				'type'           => 'checkbox',
				'section'          => $section,
				'default'          => '1',
				'title'            => esc_html__( 'Visible on Sticky Header?', 'wildnest' ),
				'checkbox_label' => esc_html__( 'Show/Hide', 'wildnest' ),
				'description'      => esc_html__( '*If sticky header is enabled', 'wildnest' ),
				'css_format'     => 'html_class',
			)
		);

		return $config;

	}

	function row_sidebar_config( $section, $section_name ) {
		$selector = '#header-menu-sidebar-bg';

		$config = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => $section_name,
			),
			array(
				'name'             => $section . '_styling',
				'type'             => 'styling',
				'section'          => $section,
				'title'            => esc_html__( 'Styling', 'wildnest' ),
				'description'      => sprintf( __( 'Advanced styling for %s', 'wildnest' ), $section_name ),
				'live_title_field' => 'title',
				'selector'         => array(
					'normal'               => $selector,
					'normal_link_color'    => "{$selector} .menu li a, {$selector} .item--html a, {$selector} .cart-item-link, {$selector} .nav-toggle-icon",
					'hover_link_color'     => "{$selector} .menu li a:hover, {$selector} .item--html a:hover, {$selector} .cart-item-link:hover, {$selector} li.open-sub .nav-toggle-icon",
					'normal_bg_color'      => '#header-menu-sidebar-bg:before',
					'normal_bg_image'      => '#header-menu-sidebar-bg:before',
					'normal_bg_attachment' => '#header-menu-sidebar-bg:before',
					'normal_bg_cover'      => '#header-menu-sidebar-bg:before',
					'normal_bg_repeat'     => '#header-menu-sidebar-bg:before',
					'normal_bg_position'   => '#header-menu-sidebar-bg:before',
					'normal_box_shadow'    => '#header-menu-sidebar',
				),
				'css_format'       => 'styling', // styling.
				'fields'           => array(
					'normal_fields' => array(
						'border_color'  => false,
						'border_radius' => false,
						'border_width'  => false,
						'border_style'  => false,
					),
					'hover_fields'  => array(
						'text_color'     => false,
						'padding'        => false,
						'bg_color'       => false,
						'bg_heading'     => false,
						'bg_cover'       => false,
						'bg_image'       => false,
						'bg_repeat'      => false,
						'border_heading' => false,
						'border_color'   => false,
						'border_radius'  => false,
						'border_width'   => false,
						'border_style'   => false,
						'box_shadow'     => false,
					), // disable hover tab and all fields inside.
				),
			)
		);

		return $config;
	}
}

if ( ! function_exists( 'wildnest_header_layout_settings' ) ) {
	function wildnest_header_layout_settings( $item_id = '', $section = '', $cb = '', $name_prefix = 'header_' ) {

		if ( ! $cb ) {
			$cb = 'wildnest_customize_render_header';
		}

		$class    = '.header--row';
		$selector = '#masthead';
		if ( ! $name_prefix ) {
			$name_prefix = 'header_';
		} else {
			if ( strpos( $item_id, 'footer' ) !== false ) {
				$class       = '.footer--row';
				$name_prefix = 'footer_';
				$cb          = 'wildnest_customize_render_footer';
			}
		}

		$layout = array(
			array(
				'name'     => $name_prefix . $item_id . '_l_heading',
				'type'     => 'heading',
				'priority' => 800,
				'section'  => $section,
				'title'    => esc_html__( 'Item Layout', 'wildnest' ),
			),

			array(
				'name'            => $name_prefix . $item_id . '_margin',
				'type'            => 'css_ruler',
				'priority'        => 810,
				'section'         => $section,
				'device_settings' => true,
				'css_format'      => array(
					'top'    => 'margin-top: {{value}};',
					'right'  => 'margin-right: {{value}};',
					'bottom' => 'margin-bottom: {{value}};',
					'left'   => 'margin-left: {{value}};',
				),
				'selector'        => "{$class} .builder-item--{$item_id}, .builder-item.builder-item--group .item--inner.builder-item--{$item_id}",
				'label'           => esc_html__( 'Margin', 'wildnest' ),
			),

			/**
			 * Apply for version 1 only
			 *
			 * @since 0.2.9
			 */
			array(
				'name'            => $name_prefix . $item_id . '_align',
				'type'            => 'text_align_no_justify',
				'section'         => $section,
				'priority'        => 820,
				'device_settings' => true,
				'selector'        => "{$class} .builder-first--" . $item_id,
				'css_format'      => 'text-align: {{value}};',
				'title'           => esc_html__( 'Align', 'wildnest' ),
				'required' => array( 'header_builder_version', '!=', 'v2' ),
			),
		);

		return $layout;
	}
}

Wildnest_Customize_Layout_Builder()->register_builder( 'header', new Wildnest_Builder_Header() );
