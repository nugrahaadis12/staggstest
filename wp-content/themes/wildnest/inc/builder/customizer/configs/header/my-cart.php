<?php

class Wildnest_Builder_Item_My_Cart {
	public $id = 'my_cart';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'My Cart', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_my_cart',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_my_cart',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 200,
				'title'    => esc_html__( 'My Cart', 'wildnest' ),
			),
			array(
				'name'        => 'wildnest_header_my_cart_styling',
				'type'        => 'styling',
				'section'     => 'header_my_cart',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Styling', 'wildnest' ),
				'selector'    => array(
					'normal'            => ".builder-item--my_cart a.menu-grid-item, a.wildnest-cart-contents, .wildnest-cart-contents span.amount, .header_mini_cart_group",
					'hover'             => ".builder-item--my_cart:hover a.menu-grid-item, .builder-item--my_cart:hover .header_mini_cart_group"
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
						'bg_color'      => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
						'bg_color'      => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
				),
			),
			array(
				'name'        => "wildnest_header_my_cart_typography",
				'type'        => 'typography',
				'section'     => "header_my_cart",
				'title'       => esc_html__( 'Typography', 'wildnest' ),
				'css_format'  => 'typography',
				'selector'    => ".builder-item--my_cart .wildnest-header-group-label, a.wildnest-cart-contents, .wildnest-cart-contents span.amount",
			),
			array(
				'name'            => 'wildnest_header_my_cart_icon_max_height',
				'type'            => 'slider',
				'section'         => 'header_my_cart',
				'default'         => array(),
				'max'             => 100,
				'device_settings' => true,
				'title'           => esc_html__( 'Icon Max Height', 'wildnest' ),
				'selector'        => 'format',
				'css_format'      => ".builder-item--my_cart i { font-size: {{value}}; }",
			),
			array(
				'name'  		  => 'wildnest_header_my_cart_icon',
				'type'  		  => 'icon',
				'section'         => 'header_my_cart',
				'icon' 			  => 'fas fa-shopping-basket',
				'label' 		  => esc_html__( 'Icon', 'wildnest' ),
			),
			array(
				'name'           => 'wildnest_header_my_cart__hide_icon',
				'type'           => 'checkbox',
				'section'        => 'header_my_cart',
				'checkbox_label' => esc_html__( 'Hide icon', 'wildnest' ),
				'css_format'     => 'html_class',
			),
			array(
				'name'           => 'wildnest_header_my_cart__hide_text',
				'type'           => 'checkbox',
				'section'        => 'header_my_cart',
				'checkbox_label' => esc_html__( 'Hide "My Cart" text', 'wildnest' ),
				'css_format'     => 'html_class',
			),
			array(
				'name'           => 'wildnest_header_my_cart__cart_contents',
				'type'           => 'checkbox',
				'section'        => 'header_my_cart',
				'checkbox_label' => esc_html__( 'Cart Contents', 'wildnest' ),
				'css_format'     => 'html_class',
			),

		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'header_my_cart' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$cart_url = "#";
		if ( class_exists( 'WooCommerce' ) ) {
		    $cart_url = wc_get_cart_url();
		}
		$hide_icon = sanitize_text_field( Wildnest()->get_setting( 'wildnest_header_my_cart__hide_icon' ) );
		$hide_text = sanitize_text_field( Wildnest()->get_setting( 'wildnest_header_my_cart__hide_text' ) );
		$cart_contents = sanitize_text_field( Wildnest()->get_setting( 'wildnest_header_my_cart__cart_contents' ) );

		$icon = Wildnest()->get_setting( 'wildnest_header_my_cart_icon');
		if (empty(Wildnest()->get_setting( 'wildnest_header_my_cart_icon'))) {
			$icon = 'fas fa-shopping-basket';
		} else {
			$icon = $icon['icon'];
		}
		echo '<div class="header-group-wrapper h-cart text-center">';

  			if(!$hide_icon) {
  				echo '<a class="menu-grid-item" href="' . esc_url($cart_url) . '">';
					echo '<svg class="wildnest-cart-icon" fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 32 32" width="32px" height="32px"><path d="M 16 3 C 13.253906 3 11 5.253906 11 8 L 11 9 L 6.0625 9 L 6 9.9375 L 5 27.9375 L 4.9375 29 L 27.0625 29 L 27 27.9375 L 26 9.9375 L 25.9375 9 L 21 9 L 21 8 C 21 5.253906 18.746094 3 16 3 Z M 16 5 C 17.65625 5 19 6.34375 19 8 L 19 9 L 13 9 L 13 8 C 13 6.34375 14.34375 5 16 5 Z M 7.9375 11 L 11 11 L 11 14 L 13 14 L 13 11 L 19 11 L 19 14 L 21 14 L 21 11 L 24.0625 11 L 24.9375 27 L 7.0625 27 Z"/></svg>';
				echo '</a>';
			}
    		echo '<div class="header_mini_cart_group">';
        		if(!$hide_text) {
	        		echo '<a  class="menu-grid-item wildnest-header-group-label" href="'.esc_url($cart_url).'">'.esc_html__('My Cart', 'wildnest').'</a>';
            	} 
			
				if ($cart_contents){ ?>
	                <a class="wildnest-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wildnest'); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wildnest' ), WC()->cart->get_cart_contents_count() ); ?>, <?php echo WC()->cart->get_cart_total(); ?>
	                </a>
	            <?php }

    		echo '</div>';
	
    		echo '<div class="header_mini_cart">';
      			the_widget( 'WC_Widget_Cart' );
    		echo '</div>';
		echo '</div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_My_Cart() );
