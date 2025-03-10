<?php

class Wildnest_Builder_Item_Primary_Menu {
	public $id = 'primary-menu';

	function item() {
		return array(
			'name'    => esc_html__( 'Primary Menu', 'wildnest' ),
			'id'      => $this->id,
			'width'   => '6',
			'section' => 'header_menu_primary',
		);
	}

	function customize() {
		$section = 'header_menu_primary';
		$fn      = array( $this, 'render' );
		$config  = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => esc_html__( 'Primary Menu', 'wildnest' ),
				'description'    => sprintf( __( 'Assign <a href="#menu_locations"  class="focus-section">Menu Location</a> for %1$s', 'wildnest' ), esc_html__( 'Primary Menu', 'wildnest' ) ),
			),

			array(
				'name'            => 'wildnest_primary_menu_style',
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
				'name'       => 'wildnest_primary_menu_style_border_h',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'max'        => 20,
				'title'      => __( 'Border Height', 'wildnest' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li > a .link-before:before, .nav-menu-desktop.style-border-top .{$this->id}-ul > li > a .link-before:before  { height: {{value}}; }",
				'required'   => array(
					'wildnest_primary_menu_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'       => 'wildnest_primary_menu_style_border_pos',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'min'        => - 50,
				'max'        => 50,
				'title'      => esc_html__( 'Border Position', 'wildnest' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li > a .link-before:before { bottom: {{value}}; } .nav-menu-desktop.style-border-top .{$this->id}-ul > li > a .link-before:before { top: {{value}}; }",
				'required'   => array(
					'wildnest_primary_menu_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'       => 'wildnest_primary_menu_style_border_color',
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
					'wildnest_primary_menu_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'    => 'wildnest_primary_menu_top_heading',
				'type'    => 'heading',
				'section' => $section,
				'title'   => esc_html__( 'Menu', 'wildnest' ),
			),
			array(
				'name'        => 'wildnest_primary_menu_typography',
				'type'        => 'typography',
				'section'     => $section,
				'title'       => esc_html__( 'Menu Items Typography', 'wildnest' ),
				'description' => esc_html__( 'Typography for menu', 'wildnest' ),
				'selector'    => ".builder-item--primary-menu .nav-menu-desktop .sub-menu li a, .builder-item--primary-menu .nav-menu-desktop .sub-menu li a:visited, .builder-item--primary-menu .nav-menu-desktop .menu>li>a",
				'css_format'  => 'typography',
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
		$style = sanitize_text_field( Wildnest()->get_setting( 'wildnest_primary_menu_style' ) );
		if ( $style ) {
			$style = sanitize_text_field( $style );
		}

		$hide_arrow = sanitize_text_field( Wildnest()->get_setting( 'wildnest_primary_menu__hide-arrow' ) );
		if ( $hide_arrow ) {
			$style .= ' hide-arrow-active';
		}

		$container_classes = $this->id . ' ' . $this->id . '-__id__ nav-menu-__device__ ' . $this->id . '-__device__' . ( $style ? ' ' . $style : '' );

		if ( has_nav_menu( 'hb-primary-navigation' ) ) {
			echo '<nav  id="site-navigation-__id__-__device__" class="container site-navigation ' . $container_classes . '"><div class="row">';
			wp_nav_menu(
				array(
					'theme_location'  => 'hb-primary-navigation',
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

			echo '</div></nav>';
		} else {
			echo '<p class="no-menu">';
                echo esc_html__('Primary navigation menu is missing.', 'wildnest');
            echo '</p>';
		}

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
function wildnest_change_nav_menu_item_id( $string_id, $item, $args ) {
	if ( 'hb-primary-navigation' == 'hb-primary-navigation' || 'menu-2' == 'hb-primary-navigation' ) {
		$string_id = 'menu-item--__id__-__device__-' . $item->ID;
	}

	return $string_id;
}

add_filter( 'nav_menu_item_id', 'wildnest_change_nav_menu_item_id', 55, 3 );


/**
 * Add Nav icon to menu
 *
 * @param string $title
 * @param object $item
 * @param array  $args
 * @param int    $depth
 *
 * @return string
 */
function wildnest_add_icon_to_menu( $title, $item, $args, $depth ) {
	if ( in_array( 'menu-item-has-children', $item->classes ) ) { // phpcs:ignore
		$title .= '<span class="nav-icon-angle"><i class="fas fa-caret-down"></i></span>';

	}

	return $title;
}

add_filter( 'nav_menu_item_title', 'wildnest_add_icon_to_menu', 25, 4 );


// Register header item.
Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Primary_Menu() );
