<?php

class Wildnest_Builder_Item_Social_Icons {
	public $id = 'social-icons';
	public $class = 'header-social-icons';
	public $selector = '';

	function __construct() {
		$this->selector = '.' . $this->class;
		add_filter( 'wildnest/icon_used', array( $this, 'used_icon' ) );
	}

	function used_icon( $list = array() ) {
		$list[ $this->id ] = 1;

		return $list;
	}

	function item() {
		return array(
			'name'    => esc_html__( 'Social Icons', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_social_icons',
		);
	}

	function customize() {
		$fn       = array( $this, 'render' );
		$selector = "{$this->selector}.wildnest-builder-social-icons";
		$config   = array(
			array(
				'name'           => 'header_social_icons',
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => esc_html__( 'Social Icons', 'wildnest' ),
			),

			array(
				'name'             => 'wildnest_header_social_icons_items',
				'type'             => 'repeater',
				'section'          => 'header_social_icons',
				'selector'         => $this->selector,
				'render_callback'  => $fn,
				'title'            => esc_html__( 'Social Profiles', 'wildnest' ),
				'live_title_field' => 'title',
				'default'          => array(
					array(
						'title' => 'Facebook',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-facebook',
						),
					),
					array(
						'title' => 'Twitter',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-twitter',
						),
					),
					array(
						'title' => 'Youtube',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-youtube-play',
						),
					),
					array(
						'title' => 'Instagram',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-instagram',
						),
					),
					array(
						'title' => 'Pinterest',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-pinterest',
						),
					),
				),
				'fields'           => array(
					array(
						'name'  => 'title',
						'type'  => 'text',
						'label' => esc_html__( 'Title', 'wildnest' ),
					),
					array(
						'name'  => 'icon',
						'type'  => 'icon',
						'label' => esc_html__( 'Icon', 'wildnest' ),
					),

					array(
						'name'  => 'url',
						'type'  => 'text',
						'label' => esc_html__( 'URL', 'wildnest' ),
					),

				),
			),

			array(
				'name'            => 'wildnest_header_social_icons_target',
				'type'            => 'checkbox',
				'section'         => 'header_social_icons',
				'selector'        => $this->selector,
				'render_callback' => $fn,
				'default'         => 1,
				'checkbox_label'  => esc_html__( 'Open link in a new tab.', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_header_social_icons_nofollow',
				'type'            => 'checkbox',
				'section'         => 'header_social_icons',
				'render_callback' => $fn,
				'default'         => 1,
				'checkbox_label'  => esc_html__( 'Adding rel="nofollow" for social links.', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_header_social_icons_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_social_icons',
				'min'             => 10,
				'step'            => 1,
				'max'             => 100,
				'selector'        => 'format',
				'css_format'      => "$selector li a { font-size: {{value}}; }",
				'label'           => esc_html__( 'Size', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_header_social_icons_padding',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_social_icons',
				'min'             => .1,
				'step'            => .1,
				'max'             => 5,
				'selector'        => "$selector li a",
				'unit'            => 'em',
				'css_format'      => 'padding: {{value_no_unit}}em;',
				'label'           => esc_html__( 'Padding', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_header_social_icons_spacing',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_social_icons',
				'min'             => 0,
				'max'             => 30,
				'selector'        => "$selector li",
				'css_format'      => 'margin-left: {{value}}; margin-right: {{value}};',
				'label'           => esc_html__( 'Icon Spacing', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_header_social_icons_shape',
				'type'            => 'select',
				'section'         => 'header_social_icons',
				'selector'        => '.header-social-icons',
				'default'         => 'circle',
				'render_callback' => $fn,
				'title'           => esc_html__( 'Shape', 'wildnest' ),
				'choices'         => array(
					'rounded' => esc_html__( 'Rounded', 'wildnest' ),
					'square'  => esc_html__( 'Square', 'wildnest' ),
					'circle'  => esc_html__( 'Circle', 'wildnest' ),
					'none'    => esc_html__( 'None', 'wildnest' ),
				),
			),

			array(
				'name'            => 'wildnest_header_social_icons_color_type',
				'type'            => 'select',
				'section'         => 'header_social_icons',
				'selector'        => $this->selector,
				'default'         => 'default',
				'render_callback' => $fn,
				'title'           => esc_html__( 'Color', 'wildnest' ),
				'choices'         => array(
					'default' => esc_html__( 'Official Color', 'wildnest' ),
					'custom'  => esc_html__( 'Custom', 'wildnest' ),
				),
			),

			array(
				'name'       => 'wildnest_header_social_icons_custom_color',
				'type'       => 'modal',
				'section'    => 'header_social_icons',
				'selector'   => "{$this->selector} li a",
				'required'   => array( 'wildnest_header_social_icons_color_type', '==', 'custom' ),
				'css_format' => 'styling',
				'title'      => esc_html__( 'Custom Color', 'wildnest' ),
				'fields'     => array(
					'tabs'           => array(
						'default' => esc_html__( 'Normal', 'wildnest' ),
						'hover'   => esc_html__( 'Hover', 'wildnest' ),
					),
					'default_fields' => array(
						array(
							'name'       => 'primary',
							'type'       => 'color',
							'label'      => esc_html__( 'Background Color', 'wildnest' ),
							'selector'   => "$selector.color-custom li a",
							'css_format' => 'background-color: {{value}};',
						),
						array(
							'name'       => 'secondary',
							'type'       => 'color',
							'label'      => esc_html__( 'Icon Color', 'wildnest' ),
							'selector'   => "$selector.color-custom li a",
							'css_format' => 'color: {{value}};',
						),
					),
					'hover_fields'   => array(
						array(
							'name'       => 'primary',
							'type'       => 'color',
							'label'      => esc_html__( 'Background Color', 'wildnest' ),
							'selector'   => "$selector.color-custom li a:hover",
							'css_format' => 'background-color: {{value}};',
						),
						array(
							'name'       => 'secondary',
							'type'       => 'color',
							'label'      => esc_html__( 'Icon Color', 'wildnest' ),
							'selector'   => "$selector.color-custom li a:hover",
							'css_format' => 'color: {{value}};',
						),
					),
				),
			),

			array(
				'name'        => 'wildnest_header_social_icons_border',
				'type'        => 'modal',
				'section'     => 'header_social_icons',
				'selector'    => "{$this->selector} li a",
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Border', 'wildnest' ),
				'description' => esc_html__( 'Border & border radius', 'wildnest' ),
				'fields'      => array(
					'tabs'           => array(
						'default' => '_',
					),
					'default_fields' => array(
						array(
							'name'       => 'border_style',
							'type'       => 'select',
							'class'      => 'clear',
							'label'      => esc_html__( 'Border Style', 'wildnest' ),
							'default'    => 'none',
							'choices'    => array(
								''       => esc_html__( 'Default', 'wildnest' ),
								'none'   => esc_html__( 'None', 'wildnest' ),
								'solid'  => esc_html__( 'Solid', 'wildnest' ),
								'dotted' => esc_html__( 'Dotted', 'wildnest' ),
								'dashed' => esc_html__( 'Dashed', 'wildnest' ),
								'double' => esc_html__( 'Double', 'wildnest' ),
								'ridge'  => esc_html__( 'Ridge', 'wildnest' ),
								'inset'  => esc_html__( 'Inset', 'wildnest' ),
								'outset' => esc_html__( 'Outset', 'wildnest' ),
							),
							'css_format' => 'border-style: {{value}};',
							'selector'   => "$selector li a",
						),

						array(
							'name'       => 'border_width',
							'type'       => 'css_ruler',
							'label'      => esc_html__( 'Border Width', 'wildnest' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'selector'   => "$selector li a",
							'css_format' => array(
								'top'    => 'border-top-width: {{value}};',
								'right'  => 'border-right-width: {{value}};',
								'bottom' => 'border-bottom-width: {{value}};',
								'left'   => 'border-left-width: {{value}};',
							),
						),
						array(
							'name'       => 'border_color',
							'type'       => 'color',
							'label'      => esc_html__( 'Border Color', 'wildnest' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'selector'   => "$selector li a",
							'css_format' => 'border-color: {{value}};',
						),

						array(
							'name'       => 'border_radius',
							'type'       => 'slider',
							'label'      => esc_html__( 'Border Radius', 'wildnest' ),
							'selector'   => "$selector li a",
							'css_format' => 'border-radius: {{value}};',
						),
					),
				),
			),

		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'header_social_icons' ) );
	}

	function render( $item_config = array() ) {

		$shape        = Wildnest()->get_setting( 'wildnest_header_social_icons_shape', 'all' );
		$color_type   = Wildnest()->get_setting( 'wildnest_header_social_icons_color_type' );
		$items        = Wildnest()->get_setting( 'wildnest_header_social_icons_items' );
		$nofollow     = Wildnest()->get_setting( 'wildnest_header_social_icons_nofollow' );
		$target_blank = Wildnest()->get_setting( 'wildnest_header_social_icons_target' );

		$rel = '';
		$rel_val = array();
		if ( 1 == $nofollow ) {
			//$rel = 'rel="nofollow" ';
			$rel_val[] = 'nofollow';
		}

		$target = '_self';
		if ( 1 == $target_blank ) {
			$target = '_blank';
			$rel_val[] = 'noopener';
		}

		if ( ! empty( $rel_val ) ) {
			$rel = 'rel="' . implode( ' ', $rel_val ) . '" ';
		}

		if ( ! empty( $items ) ) {
			$classes   = array();
			$classes[] = $this->class;
			$classes[] = 'wildnest-builder-social-icons';
			if ( $shape ) {
				$shape = ' shape-' . sanitize_text_field( $shape );
			}
			if ( $color_type ) {
				$classes[] = 'color-' . sanitize_text_field( $color_type );
			}

			echo '<ul class="' . esc_attr( join( ' ', $classes ) ) . '">';
			foreach ( (array) $items as $index => $item ) {
				$item = wp_parse_args(
					$item,
					array(
						'title'       => '',
						'icon'        => '',
						'url'         => '',
						'_visibility' => '',
					)
				);

				if ( 'hidden' !== $item['_visibility'] ) {
					echo '<li>';
					if ( ! $item['url'] ) {
						$item['url'] = '#';
					}

					$icon = wp_parse_args(
						$item['icon'],
						array(
							'type' => '',
							'icon' => '',
						)
					);

					if ( $item['url'] && $icon['icon'] ) {
						echo '<a class="social-' . str_replace(
							array( ' ', 'fa-fa' ),
							array(
								'-',
								'icon',
							),
							esc_attr( $icon['icon'] )
						) . $shape . '" ' . $rel . 'target="' . esc_attr( $target ) . '" href="' . esc_url( $item['url'] ) . '" aria-label="' . esc_attr( $item['title']) . '">';
					}

					if ( $icon['icon'] ) {
						echo '<i class="icon ' . esc_attr( $icon['icon'] ) . '" title="' . esc_attr( $item['title'] ) . '"></i>';
					}

					if ( $item['url'] ) {
						echo '</a>';
					}
					echo '</li>';
				}
			}

			echo '</ul>';
		}

	}

}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Social_Icons() );
