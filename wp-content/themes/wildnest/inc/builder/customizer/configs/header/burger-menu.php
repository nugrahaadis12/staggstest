<?php

class Wildnest_Builder_Item_Burger_Menu {
	public $id = 'burger-menu';

	function item() {
		return array(
			'name'    => esc_html__( 'Burger Menu', 'wildnest' ),
			'id'      => $this->id,
			'width'   => '3',
			'section' => 'header_burger_menu',
		);
	}

	function customize() {
		$fn       = array( $this, 'render' );
		$selector = '.builder-item--burger-menu';
		$config   = array(
			array(
				'name'            => 'header_burger_menu',
				'type'            => 'section',
				'panel'           => 'header_settings',
				'theme_supports'  => '',
				'title'           => esc_html__( 'Burger Menu', 'wildnest' ),
			),


			array(
				'name'     		  => 'wildnest_burger_icon_heading',
				'type'     		  => 'heading',
				'section'  		  => 'header_burger_menu',
				'title'    		  => esc_html__( 'Icon', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_burger_menu_size',
				'type'            => 'radio_group',
				'section'         => 'header_burger_menu',
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
				'name'       => 'wildnest_burger_menu_item_color',
				'type'       => 'color',
				'section'    => 'header_burger_menu',
				'title'      => esc_html__( 'Color', 'wildnest' ),
				'css_format' => 'color: {{value}};',
				'selector'   => ".header--row  {$selector} .hamburger",
			),
			array(
				'name'       => 'wildnest_burger_menu_item_color_hover',
				'type'       => 'color',
				'section'    => 'header_burger_menu',
				'css_format' => 'color: {{value}};',
				'selector'   	  => ".header--row {$selector} .hamburger:hover",
				'title'      	  => esc_html__( 'Color Hover', 'wildnest' ),
			),


			array(
				'name'     		  	=> 'wildnest_burger_content_heading',
				'type'     		  	=> 'heading',
				'section'  		  	=> 'header_burger_menu',
				'title'    		  	=> esc_html__( 'Content', 'wildnest' ),
			),
			array(
				'name'            	=> 'wildnest_burger_content_width',
				'type'            	=> 'slider',
				'section'    		=> 'header_burger_menu',
				'default'         	=> array(),
				'max'             	=> 1000,
				'device_settings' 	=> true,
				'title'           	=> esc_html__( 'Width', 'wildnest' ),
				'selector'        	=> 'format',
				'css_format'      	=> ".header--row  {$selector} .fixed-sidebar-menu.open { width: {{value}}; } ",
			),
			array(
				'name'       	  	=> 'wildnest_burger_content_bg',
				'type'       	  	=> 'color',
				'section'    		=> 'header_burger_menu',
				'title'      		=> esc_html__( 'Background', 'wildnest' ),
				'css_format' 		=> 'background: {{value}};',
				'selector'   		=> ".header--row  {$selector} .fixed-sidebar-menu",
			),
			array(
				'name'            	=> 'wildnest_burger_menu_padding',
				'type'            	=> 'css_ruler',
				'section'    		=> 'header_burger_menu',
				'device_settings' 	=> true,
				'css_format'      	=> array(
					'top'    => 'padding-top: {{value}};',
					'right'  => 'padding-right: {{value}};',
					'bottom' => 'padding-bottom: {{value}};',
					'left'   => 'padding-left: {{value}};',
				),
				'selector'        	=> ".header--row {$selector} .burger-sidebar-content",
				'label'           	=> esc_html__( 'Padding', 'wildnest' ),
			),
			array(
				'name'            	=> 'wildnest_burger_menu_align',
				'type'            	=> 'text_align_no_justify',
				'section'    		=> 'header_burger_menu',
				'selector'        	=> ".header--row {$selector} .burger-sidebar-content",
				'css_format'      	=> 'text-align: {{value}};',
				'title'           	=> esc_html__( 'Alignment', 'wildnest' ),
				'default'           => 'left',
			),
		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'header_burger_menu' ) );
	}

	function render() {
		$style      = sanitize_text_field( Wildnest()->get_setting( 'wildnest_burger_menu_style' ) );
		$sizes      = Wildnest()->get_setting( 'wildnest_burger_menu_size', 'all' );
		$classes       = array( 'menu-burger item-button' );

		if ( empty( $sizes ) ) {
			$sizes = 'is-size-' . $sizes;
		}

		if ( is_string( $sizes ) ) {
			$classes[] = 'is-size-' .$sizes;
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
		<!-- Fixed Sidebar Overlay -->
        <div class="fixed-sidebar-menu-overlay"></div>
        <!-- Fixed Sidebar Menu -->
        <div class="relative fixed-sidebar-menu-holder">
            <div class="fixed-sidebar-menu">
                <!-- Close Sidebar Menu + Close Overlay -->
                <i class="icon-close icons"></i>
                <div class="burger-sidebar-content">
                        <?php dynamic_sidebar("headerburgersidebar"); ?>
                </div>
            </div>
        </div>
		<?php
	}

}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Burger_Menu() );

