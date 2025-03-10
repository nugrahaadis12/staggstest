<?php

class Wildnest_Builder_Item_Navigation_2 {
	public $id = 'navigation2';

	function item() {
		return array(
			'name'    => esc_html__( 'Navigation 2', 'wildnest' ),
			'id'      => $this->id,
			'width'   => '6',
			'section' => 'header_navigation2',
		);
	}

	function customize() {
		$section = 'header_navigation2';
		$fn      = array( $this, 'render' );
		$config  = array(
			array(
				'name'           => 'header_navigation2',
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => esc_html__( 'Navigation 2', 'wildnest' ),
				'description'    => sprintf( __( 'Assign <a href="#menu_locations"  class="focus-section">Menu Location</a> for %1$s', 'wildnest' ), esc_html__( 'Navigation 2', 'wildnest' )),
			),

			array(
				'name'            => 'wildnest_navigation2_style',
				'type'            => 'image_select',
				'section'         => $section,
				'selector'        => '.builder-item--' . $this->id . " .{$this->id}",
				'render_callback' => $fn,
				'title'           => esc_html__( 'Menu Preset', 'wildnest' ),
				'default'         => 'style-plain',
				'css_format'      => 'html_class',
				'choices'         => array(
					'style-plain'         => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_1.svg',
					),
					'style-full-height'   => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_2.svg',
					),
					'style-border-bottom' => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_3.svg',
					),
					'style-border-top'    => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_4.svg',
					),
				),
			),

			array(
				'name'       => 'wildnest_navigation2_style_border_h',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'max'        => 20,
				'title'      => esc_html__( 'Border Height', 'wildnest' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li > a .link-before:before, .nav-menu-desktop.style-border-top .{$this->id}-ul > li > a .link-before:before  { height: {{value}}; }",
				'required'   => array(
					'wildnest_navigation2_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'       => 'wildnest_navigation2_style_border_pos',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'min'        => - 50,
				'max'        => 50,
				'title'      => esc_html__( 'Border Position', 'wildnest' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li > a .link-before:before { bottom: {{value}}; } .nav-menu-desktop.style-border-top .{$this->id}-ul > li > a .link-before:before { top: {{value}}; }",
				'required'   => array(
					'wildnest_navigation2_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'       => 'wildnest_navigation2_style_border_color',
				'type'       => 'color',
				'section'    => $section,
				'selector'   => 'format',
				'title'      => esc_html__( 'Border Color', 'wildnest' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li:hover > a .link-before:before, 
                .nav-menu-desktop.style-border-bottom .{$this->id}-ul > li.current-menu-item > a .link-before:before, 
                .nav-menu-desktop.style-border-bottom .{$this->id}-ul > li.current-menu-ancestor > a .link-before:before,
                .nav-menu-desktop.style-border-top .{$this->id}-ul > li:hover > a .link-before:before,
                .nav-menu-desktop.style-border-top .{$this->id}-ul > li.current-menu-item > a .link-before:before, 
                .nav-menu-desktop.style-border-top .{$this->id}-ul > li.current-menu-ancestor > a .link-before:before
                { background-color: {{value}}; }",
				'required'   => array(
					'wildnest_navigation2_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'           => 'wildnest_navigation2__hide-arrow',
				'type'           => 'checkbox',
				'section'        => $section,
				'selector'       => '.builder-item--' . $this->id . " .{$this->id}",
				'checkbox_label' => esc_html__( 'Hide menu dropdown arrow', 'wildnest' ),
				'css_format'     => 'html_class',
			),

			array(
				'name'            => 'wildnest_navigation2_arrow_size',
				'type'            => 'slider',
				'devices_setting' => true,
				'section'         => $section,
				'selector'        => 'format',
				'max'             => 20,
				'title'           => esc_html__( 'Arrow icon size', 'wildnest' ),
				'css_format'      => ".builder-item--navigation2 .nav-icon-angle { width: {{value}}; height: {{value}}; }",
				'required'        => array( 'wildnest_navigation2__hide-arrow', '!=', 1 ),
			),

			array(
				'name'    => 'wildnest_navigation2_top_heading',
				'type'    => 'heading',
				'section' => $section,
				'title'   => esc_html__( 'Top Menu', 'wildnest' ),
			),

			array(
				'name'        => 'wildnest_navigation2_item_styling',
				'type'        => 'styling',
				'section'     => $section,
				'title'       => esc_html__( 'Items Styling', 'wildnest' ),
				'description' => esc_html__( 'Styling level menu items', 'wildnest' ),
				'selector'    => array(
					'normal'        => ".navigation2 .nav-menu>li > a",
					'normal_text_color' 	=> ".navigation2 .nav-menu>li > a",
					'normal_margin' => ".navigation2 .nav-menu>li, .builder-item-sidebar .primary-menu-sidebar .primary-menu-ul .sub-menu a",
					'hover'         => ".header--row:not(.header--transparent) .navigation2 .nav-menu>li > a:hover, .header--row:not(.header--transparent) .builder-item--navigation2 .nav-menu-desktop .primary-menu-ul > li.current-menu-item > a, .header--row:not(.header--transparent) .builder-item--navigation2 .nav-menu-desktop .primary-menu-ul > li.current-menu-ancestor > a, .header--row:not(.header--transparent) .builder-item--navigation2 .nav-menu-desktop .primary-menu-ul > li.current-menu-parent > a",
				),
				'default'     => array(
					'normal' => array(
						'text_color' => '#fff'
					),
				),
				'css_format'  => 'styling',
				'fields'      => array(
					'tabs'          => array(
						'normal' => esc_html__( 'Normal', 'wildnest' ),
						'hover'  => esc_html__( 'Hover/Active', 'wildnest' ),
					),
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
				),
			),

			array(
				'name'        => 'wildnest_navigation2_typography',
				'type'        => 'typography',
				'section'     => $section,
				'title'       => esc_html__( 'Menu Items Typography', 'wildnest' ),
				'description' => esc_html__( 'Typography for menu', 'wildnest' ),
				'selector'    => ".navigation2 .nav-menu>li > a,.builder-item-sidebar .primary-menu-sidebar .primary-menu-ul > li > a, .navigation2-ul .sub-menu a",
				'css_format'  => 'typography'
			),

		);

		$config = apply_filters( 'wildnest/customize-menu-config-more', $config, $section, $this );

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, $section ) );
	}

	function menu_fallback_cb() {
		$pages = get_pages(
			array(
				'child_of'     => 0,
				'sort_order'   => 'ASC',
				'sort_column'  => 'menu_order, post_title',
				'hierarchical' => 0,
				'parent'       => 0,
				'exclude_tree' => array(),
				'number'       => 10,
			)
		);

		echo '<ul class="' . $this->id . '-ul menu nav-menu menu--pages">';
		foreach ( (array) $pages as $p ) {
			$class = '';
			if ( is_page( $p ) ) {
				$class = 'current-menu-item';
			}

			echo '<li id="menu-item--__id__-__device__-' . esc_attr( $p->ID ) . '" class="menu-item menu-item-type--page  menu-item-' . esc_attr( $p->ID . ' ' . $class ) . '"><a href="' . esc_url( get_the_permalink( $p ) ) . '"><span class="link-before">' . apply_filters( '', $p->post_title ) . '</span></a></li>';
		}
		echo '</ul>';
	}

	/**
	 * @see Walker_Nav_Menu
	 */
	function render() {
		$style = sanitize_text_field( Wildnest()->get_setting( 'wildnest_navigation2_style' ) );
		if ( $style ) {
			$style = sanitize_text_field( $style );
		}

		$hide_arrow = sanitize_text_field( Wildnest()->get_setting( 'wildnest_navigation2__hide-arrow' ) );
		if ( $hide_arrow ) {
			$style .= ' hide-arrow-active';
		}

		$container_classes = $this->id . ' ' . $this->id . '-__id__ nav-menu-__device__ ' . $this->id . '-__device__' . ( $style ? ' ' . $style : '' );
		echo '<nav class="site-navigation ' . $container_classes . '">';
		wp_nav_menu(
			array(
				'theme_location'  => 'hb-menu-navigation2',
				'container'       => false,
				'container_id'    => false,
				'container_class' => false,
				'menu_id'         => false,
				'menu_class'      => $this->id . '-ul menu nav-menu',
				'fallback_cb'     => '',
				'link_before'     => '<span class="link-before">',
				'link_after'      => '</span>',
			)
		);

		echo '</nav>';

	}
}

/**
 * Change menu item ID
 *
 * @see Walker_Nav_Menu::start_el();
 *
 * @param string $string_id
 * @param object $item
 * @param object $args An object of wp_nav_menu() arguments.
 *
 * @return mixed
 */
function wildnest_change_nav_menu_item_id_navigation2( $string_id, $item, $args ) {
	if ( 'primary' == 'hb-menu-navigation2' || 'menu-2' == 'hb-menu-navigation2' ) {
		$string_id = 'menu-item--__id__-__device__-' . $item->ID;
	}

	return $string_id;
}

add_filter( 'nav_menu_item_id', 'wildnest_change_nav_menu_item_id_navigation2', 55, 3 );

// Register header item.
Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Navigation_2() );
