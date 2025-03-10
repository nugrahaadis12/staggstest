<?php

class wildnest_WC_Catalog_Designer {

	function product__title() {
	

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * @see    woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

	}

	function product__category() {
		global $post;

		$tax = 'product_cat';
		$num = 1;

		$terms = get_the_terms( $post, $tax );

		if ( is_wp_error( $terms ) ) {
			return $terms;
		}

		if ( empty( $terms ) ) {
			return false;
		}

		$links = array();

		foreach ( $terms as $term ) {
			$link = get_term_link( $term, $tax );
			if ( is_wp_error( $link ) ) {
				return $link;
			}
			$links[] = '<a class="text-uppercase text-xsmall link-meta" href="' . esc_url( $link ) . '" rel="tag">' . esc_html( $term->name ) . '</a>';
		}

		$categories_list = array_slice( $links, 0, $num );

		echo join( ' ', $categories_list );
	}

	function product__rating() {
		woocommerce_template_loop_rating();
	}

	function product__price() {
		woocommerce_template_loop_price();
	}

	function product__description() {
		echo '<div class="woocommerce-loop-product__desc">';

			$text = '';
			global $post;
			if ( $post ) {
				if ( $post->post_excerpt ) {
					$text = $post->post_excerpt;
				} else {
					$text = $post->post_content;
				}
			}
			if ( $excerpt ) {
				// WPCS: XSS OK.
				echo apply_filters( 'the_excerpt', $excerpt );
			} else {
				the_excerpt();
			}

		echo '</div>';

	}

	function product__add_to_cart() {
		$button_text = sanitize_text_field( wildnest()->get_setting( 'wildnest_shop_product_box_button_text' ) );
		if($button_text == 'only-icon') {
			wildnest_add_to_cart_text_to_icon();
		} else {
			echo '</a>';
			woocommerce_template_loop_add_to_cart();
		}
	}

	private $configs = array();

	function __construct() {
		add_filter( 'wildnest/customizer/config', array( $this, 'config' ), 100 );

		add_action( 'wildnest_wc_product_loop', array( $this, 'render' ) );

		// Add to cart button
		$show_button = sanitize_text_field( wildnest()->get_setting( 'wildnest_shop_product_box_button' ) );
		if($show_button == 'in-grid') {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product__add_to_cart' ) );
		} else if ($show_button == 'on-hover') {
			add_action('wildnest/wc-product/after-media' , array( $this, 'product__add_to_cart' ), 10);
		}

		// Product Price
		add_action('woocommerce_after_title_item' , array( $this, 'product__price' ), 20);

		$show_rating = sanitize_text_field( wildnest()->get_setting( 'wildnest_shop_product_box_rating' ) );
		if($show_rating) {
			add_action('woocommerce_after_title_item' , array( $this, 'product__rating' ), 10);
		}

		$show_category = sanitize_text_field( wildnest()->get_setting( 'wildnest_shop_product_box_category' ) );
		if($show_category) {
			add_action('woocommerce_before_shop_loop_item' , array( $this, 'product__category' ));
		}

		$show_description = sanitize_text_field( wildnest()->get_setting( 'wildnest_shop_product_box_description' ) );
		if($show_description) {
			add_action('woocommerce_after_title_item' , array( $this, 'product__description' ), 30);
		}
	}

	/**
	 * Get callback function for item part
	 *
	 * @param string $item_id ID of builder item.
	 *
	 * @return string|object|boolean
	 */
	function callback( $item_id ) {
		$cb = apply_filters( 'wildnest/product-designer/part', false, $item_id, $this );
		if ( ! is_callable( $cb ) ) {
			$cb = array( $this, 'product__' . $item_id );
		}
		if ( is_callable( $cb ) ) {
			return $cb;
		}

		return false;
	}

	function render() {
		
		do_action('wildnest/before_render_woocommerce_product');

		$this->configs = apply_filters( 'wildnest_wc_catalog_designer/configs', $this->configs );

		$cb = $this->callback( 'media' );
		if ( $cb ) {
			call_user_func( $cb, array( null, $this ) );
		}
		
		
		echo '<div class="woocommerce-title-metas '.apply_filters( 'wildnest_woocommerce_title_metas', 'wildnest-alignment-left').'">';
			do_action( 'woocommerce_before_shop_loop_item' );

			$this->product__title();

			do_action( 'woocommerce_after_title_item' );

			do_action( 'woocommerce_after_shop_loop_item' );

		echo '</div>';


		do_action('wildnest/after_render_woocommerce_product');


	}

	function config( $configs ) {

		$section = 'wildnest_catalog_designer';
		$configs[] = array(
			'name'     => $section,
			'type'     => 'section',
			'panel'    => 'woocommerce',
			'priority' => 10,
			'label'    => esc_html__( 'Product Box', 'wildnest' ),
		);
		$configs[] = array(
			'name'    => 'wildnest_box_settings',
			'type'    => 'heading',
			'section' => $section,
			'title'   => esc_html__( 'Box Styling', 'wildnest' ),
		);
		$configs[] = array(
			'name'            => 'wildnest_shop_product_box_layout',
			'type'            => 'text_align_no_justify',
			'section'         => $section,
			'selector'        => '.woocommerce-title-metas',
			'css_format'      => 'text-align: {{value}};',
			'title'           => esc_html__( 'Box Layout', 'wildnest' ),
			'default'           => 'left',
		);

		$configs[] = array(
			'name'        => 'wildnest_shop_product_box_styling',
			'type'        => 'styling',
			'section'     => $section,
			'css_format'  => 'styling',
			'title'       => esc_html__( 'Box Styling', 'wildnest' ),
			'selector'    => array(
				'normal'            => ".products-wrapper",
				'hover'         	=> ".products-wrapper:hover",
				'normal_bg_color' => ".products-wrapper",
				'normal_border_style' => ".products-wrapper",
				'normal_border_width' => ".products-wrapper",
				'normal_border_color' => ".products-wrapper",
				'normal_border_radius' => ".products-wrapper",
				'normal_box_shadow' => ".products-wrapper",
			),
			'fields'      => array(
				'normal_fields' => array(
					'link_color'    => false,
					'bg_cover'      => false,
					'bg_image'      => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
					'margin'        => false,
					'text_color'    => false
				)
			)
		);

		$configs[] = array(
			'name'        => 'wildnest_shop_product_box_categ_styling',
			'type'        => 'typography',
			'section'     => $section,
			'css_format'  => 'typography',
			'title'       => esc_html__( 'Category Typography', 'wildnest' ),
			'selector'    => ".woocommerce-title-metas .text-xsmall"
		);
		$configs[] = array(
			'name'        => 'wildnest_shop_product_box_categ_color',
			'type'        => 'color',
			'section' 	  => $section,
			'selector'    => ".woocommerce-title-metas .text-xsmall",
			'css_format'  => 'color: {{value}};',
			'title'       => esc_html__( 'Category Color', 'wildnest' )
		);
		$configs[] = array(
			'name'        => 'wildnest_shop_product_box_title_styling',
			'type'        => 'typography',
			'section'     => $section,
			'css_format'  => 'typography',
			'title'       => esc_html__( 'Title Typography', 'wildnest' ),
			'selector'    => ".woocommerce .woocommerce-loop-product__title a"
		);
		$configs[] = array(
			'name'        => 'wildnest_shop_product_box_price_styling',
			'type'        => 'typography',
			'section'     => $section,
			'css_format'  => 'typography',
			'title'       => esc_html__( 'Price Typography', 'wildnest' ),
			'selector'    => ".woocommerce-Price-amount bdi"
		);
		$configs[] = array(
			'name'        => 'wildnest_shop_product_box_price_color',
			'type'        => 'color',
			'section' 	  => $section,
			'selector'    => ".woocommerce-Price-amount bdi",
			'css_format'  => 'color: {{value}};',
			'title'       => esc_html__( 'Price Color', 'wildnest' )
		);
		$configs[] = array(
			'name'    => 'wildnest_box_options',
			'type'    => 'heading',
			'section' => $section,
			'title'   => esc_html__( 'Custom Options', 'wildnest' ),
		);
		$configs[] = array(
			'name'           => 'wildnest_shop_product_box_category',
			'type'           => 'checkbox',
			'section'        => $section,
			'checkbox_label' => esc_html__( 'Show Category', 'wildnest' ),
			'css_format'     => 'html_class',
		);

		$configs[] = array(
			'name'           => 'wildnest_shop_product_box_description',
			'type'           => 'checkbox',
			'section'        => $section,
			'checkbox_label' => esc_html__( 'Show Description', 'wildnest' ),
			'css_format'     => 'html_class',
		);

		$configs[] = array(
			'name'           => 'wildnest_shop_product_box_rating',
			'type'           => 'checkbox',
			'section'        => $section,
			'default'         => 1,
			'checkbox_label' => esc_html__( 'Show Rating', 'wildnest' ),
			'css_format'     => 'html_class',
		);

		$configs[] = array(
			'name'    => 'wildnest_box_button_settings',
			'type'    => 'heading',
			'section' => $section,
			'title'   => esc_html__( 'Add to Cart Button Settings', 'wildnest' ),
		);
		$configs[] = array(
				'name'            => 'wildnest_shop_product_box_button',
				'type'            => 'radio_group',
				'section'         => $section,
				'default'         => 'in-grid',
				'title'           => esc_html__( 'Add to Cart button', 'wildnest' ),
				'choices'         => array(
					'no-button'  	=> esc_html__( 'No Button', 'wildnest' ),
					'on-hover'  	=> esc_html__( 'On Hover', 'wildnest' ),
					'in-grid'  		=> esc_html__( 'In Grid', 'wildnest' ),
				),
		);
		$configs[] = array(
				'name'            => 'wildnest_shop_product_box_button_text',
				'type'            => 'radio_group',
				'section'         => $section,
				'default'         => 'only-icon',
				'title'           => esc_html__( 'Add to Cart button type', 'wildnest' ),
				'choices'         => array(
					'only-text'  	=> esc_html__( 'Only text', 'wildnest' ),
					'only-icon' 	=> esc_html__( 'Only Icon', 'wildnest' )
				),
		);

		$configs[] = array(
			'name'     => 'wildnest_single_product',
			'type'     => 'section',
			'panel'    => 'woocommerce',
			'priority' => 10,
			'label'    => esc_html__( 'Product Single', 'wildnest' ),
		);
		$configs[] = array(
			'name'        	=> 'wildnest_single_product_gallery_styling',
			'type'        	=> 'styling',
			'section'     	=> 'wildnest_single_product',
			'css_format'  	=> 'styling',
			'title'       	=> esc_html__( 'Main Image & Gallery Styling', 'wildnest' ),
			'selector'    	=> array(
				'normal'        => ".woocommerce .product .images .woocommerce-product-gallery__image",
				'hover'         => ".woocommerce .product .images .woocommerce-product-gallery__image:hover",
			),
			'fields'      	=> array(
				'normal_fields' => array(
					'margin'    => false,
					'padding'    => false,
					'bg_heading'    => false,
					'text_color'    => false,
					'link_color'    => false,
					'bg_color'      => false,
					'bg_cover'      => false,
					'bg_image'      => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
					'margin'        => false,
				),
				'hover_fields'  => array(
					'margin'    => false,
					'padding'    => false,
					'bg_heading'    => false,
					'text_color'    => false,
					'link_color'    => false,
					'bg_color'      => false,
					'bg_cover'      => false,
					'bg_image'      => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
					'margin'        => false,
				)
			)
		);
		$configs[] = array(
			'name'           => 'wildnest_single_product_related',
			'type'           => 'checkbox',
			'section'        => 'wildnest_single_product',
			'default'         => 1,
			'checkbox_label' => esc_html__( 'Related Products', 'wildnest' ),
			'css_format'     => 'html_class',
		);
		$configs[] = array(
				'name'            => 'wildnest_single_product_related_nr',
				'type'            => 'select',
				'section'         => 'wildnest_single_product',
				'default'         => 'circle',
				'title'           => esc_html__( 'Number of related products', 'wildnest' ),
				'choices'         => array(
					'4' => esc_html__( '4', 'wildnest' ),
					'5'  => esc_html__( '5', 'wildnest' ),
					'6'  => esc_html__( '6', 'wildnest' )
				),
		);

		$configs[] = array(
			'name'     =>  'wildnest_shop_archives',
			'type'     => 'section',
			'panel'    => 'woocommerce',
			'priority' => 10,
			'label'    => esc_html__( 'Shop Archives', 'wildnest' ),
		);
		$configs[] = array(
            'name'        => 'wildnest_shop_grid_list_switcher',
            'type'      => 'radio_group',
            'section'   => 'wildnest_shop_archives', 
            'title'     => esc_html__('Grid / List default', 'wildnest'),
            'description'  => esc_html__('Choose which format products should display in by default.', 'wildnest'),
            'choices'   => array(
                'grid'      => esc_html__( 'Grid', 'wildnest' ),
                'list'      => esc_html__( 'List', 'wildnest' ),
            ),
            'default'   => 'grid',
        );
        $configs[] = array(
            'name'      	=> 'wildnest_shop_layout',
            'type'      	=> 'radio_group',
            'section'   	=> 'wildnest_shop_archives', 
            'title'     	=> esc_html__('Sidebar', 'wildnest'),
            'description'  	=> esc_html__('Choose the position of the sidebar.', 'wildnest'),
            'choices'   	=> array(
                'left-sidebar'	=> esc_html__( 'Left Sidebar', 'wildnest' ),
                'no-sidebar'    => esc_html__( 'No Sidebar', 'wildnest' ),
                'right-sidebar' => esc_html__( 'Right Sidebar', 'wildnest' ),
            ),
            'default'   	=> 'left-sidebar',
        );
        $configs[] = array(
            'name'        	=> 'wildnest_shop_columns',
            'type'      	=> 'select',
            'section'   	=> 'wildnest_shop_archives', 
            'title'     	=> esc_html__('Number of shop columns', 'wildnest'),
            'description'  => esc_html__('Number of products per column to show on shop list template.', 'wildnest'),
            'choices'   => array(
                '2'         => esc_html__('2 columns','wildnest'),
                '3'         => esc_html__('3 columns','wildnest'),
                '4'         => esc_html__('4 columns','wildnest')
            ),
            'default'   => '3',
        );
        $configs[] = array(
            'name'       	=> 'wildnest_shop_no_products',
            'type'     		=> 'text',
			'section'   	=> 'wildnest_shop_archives',
            'title'    		=> esc_html__('No. of products per page', 'wildnest'),
           	'description' 	=> esc_html__('Number of products to show on shop list template.', 'wildnest'),
            'default'  		=> '9'
        );
		return $configs;
	}

	function product__media() {
		echo '<div class="thumbnail-and-details">';
		/**
		 * Hook: wildnest/wc-product/before-media
		 * hooked: woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'wildnest/wc-product/before-media' );
		woocommerce_show_product_loop_sale_flash();
		woocommerce_template_loop_product_thumbnail();
		do_action( 'wildnest_after_loop_product_media' );
		/**
		 * Hook: wildnest/wc-product/after-media
		 * hooked: woocommerce_template_loop_product_link_close - 10
		 */
		do_action( 'wildnest/wc-product/after-media' );
		echo '</div>';
	}

}

new wildnest_WC_Catalog_Designer();
