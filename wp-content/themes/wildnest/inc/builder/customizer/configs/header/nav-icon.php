<?php

class Wildnest_Builder_Item_Nav_Icon {
	public $id = 'nav-icon';

	function item() {
		return array(
			'name'    => esc_html__( 'Menu Icon', 'wildnest' ),
			'id'      => $this->id,
			'width'   => '3',
			'section' => 'header_menu_icon',
		);
	}

	function customize() {
		$fn       = array( $this, 'render' );
		$selector = '.menu-mobile-toggle';
		$config   = array(
			array(
				'name'           => 'header_menu_icon',
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => esc_html__( 'Menu Icon', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_nav_icon_size',
				'type'            => 'radio_group',
				'section'         => 'header_menu_icon',
				'selector'        => $selector,
				'render_callback' => $fn,
				'title'           => esc_html__( 'Icon Size', 'wildnest' ),
				'default'         => array(
					'desktop' => 'medium',
					'tablet'  => 'medium',
					'mobile'  => 'medium',
				),
				'choices'         => array(
					'small'  => esc_html__( 'Small', 'wildnest' ),
					'medium' => esc_html__( 'Medium', 'wildnest' ),
					'large'  => esc_html__( 'Large', 'wildnest' ),
				),
			),

			array(
				'name'       => 'wildnest_nav_icon_item_color',
				'type'       => 'color',
				'section'    => 'header_menu_icon',
				'title'      => esc_html__( 'Color', 'wildnest' ),
				'css_format' => 'color: {{value}};',
				'selector'   => ".header--row:not(.header--transparent) {$selector}",

			),

			array(
				'name'       => 'wildnest_nav_icon_item_color_hover',
				'type'       => 'color',
				'section'    => 'header_menu_icon',
				'css_format' => 'color: {{value}};',
				'selector'   => ".header--row:not(.header--transparent) {$selector}:hover",
				'title'      => esc_html__( 'Color Hover', 'wildnest' ),
			),
		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'header_menu_icon' ) );
	}

	function render() {
		$style      = sanitize_text_field( Wildnest()->get_setting( 'wildnest_nav_icon_style' ) );
		$sizes      = Wildnest()->get_setting( 'wildnest_nav_icon_size', 'all' );
		$classes       = array( 'menu-mobile-toggle item-button' );

		if ( empty( $sizes ) ) {
			$sizes = 'is-size-' . $sizes;
		}

		if ( is_string( $sizes ) ) {
			$classes[] = $sizes;
		} else {
			foreach ( $sizes as $d => $s ) {
				if ( ! is_string( $s ) ) {
					$s = 'is-size-medium';
				}
				$classes[] = 'is-size-' . $d . '-' . $s;
			}
		}

		if ( $style ) {
			$classes[] = $style;
		}
		?>
		<a class="<?php echo esc_attr( join( ' ', $classes ) ); ?>">
			<span class="hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</span>
		</a>
		<?php
	}

}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Nav_Icon() );

