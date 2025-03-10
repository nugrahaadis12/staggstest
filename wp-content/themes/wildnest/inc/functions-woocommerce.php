<?php


if ( ! function_exists( 'wildnest_woo_single_thumbnail_images_wrapper' ) ) {
	/**
	 * Function that add additional wrapper around thumbnail images on single product
	 */
	function wildnest_woo_single_thumbnail_images_wrapper() {
		echo '<div class="wildnest-woo-media-thumbs-wrapper">';
	}
}

if ( ! function_exists( 'wildnest_woo_single_thumbnail_images_wrapper_end' ) ) {
	/**
	 * Function that add additional wrapper around thumbnail images on single product
	 */
	function wildnest_woo_single_thumbnail_images_wrapper_end() {
		echo '</div>';
	}
}
// add additional tags around product single thumbnails
add_action( 'woocommerce_product_thumbnails', 'wildnest_woo_single_thumbnail_images_wrapper', 5 );
add_action( 'woocommerce_product_thumbnails', 'wildnest_woo_single_thumbnail_images_wrapper_end', 35 );

if (!function_exists('wildnest_mobile_shop_filters')) {
	add_action( 'woocommerce_before_shop_loop', 'wildnest_mobile_shop_filters', 30);
	function wildnest_mobile_shop_filters(){
		echo '<a href="#" class="wildnest-shop-filters-button hide-on-desktops"><i class="fas fa-filter"></i> '.esc_html__('Filters', 'wildnest').'</a>';
	}
}

if (!function_exists('wildnest_custom_search_form')) {
	function wildnest_custom_search_form(){ ?>
		<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label>
		        <input type="hidden" name="post_type" value="product" />
				<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search...', 'wildnest' ); ?>" value="" name="s">
				<input type="submit" class="search-submit" value="&#xf002">
			</label>
		</form>
	<?php }
}


// Ensure cart contents update when products are added to the cart via AJAX
if (!function_exists('wildnest_woocommerce_header_add_to_cart_fragment')) {
    function wildnest_woocommerce_header_add_to_cart_fragment( $fragments ) {
        ob_start();
        ?>
        <a class="wildnest-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart','wildnest' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'wildnest' ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
        <?php
        $fragments['a.wildnest-cart-contents'] = ob_get_clean();
        return $fragments;
    } 
    add_filter( 'woocommerce_add_to_cart_fragments', 'wildnest_woocommerce_header_add_to_cart_fragment' );
}


// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
if (!function_exists('wildnest_woocommerce_header_add_to_cart_fragment_qty_only')) {
    function wildnest_woocommerce_header_add_to_cart_fragment_qty_only( $fragments ) {
        ob_start();
        ?>
        <span class="wildnest-cart-contents_qty"><?php echo sprintf ( esc_html__('(%d)', 'wildnest'), WC()->cart->get_cart_contents_count() ); ?></span>
        <?php
        $fragments['span.wildnest-cart-contents_qty'] = ob_get_clean();
        return $fragments;
    } 
    add_filter( 'woocommerce_add_to_cart_fragments', 'wildnest_woocommerce_header_add_to_cart_fragment_qty_only' );
}


add_filter( 'woocommerce_widget_cart_is_hidden', 'wildnest_always_show_cart', 40, 0 );
function wildnest_always_show_cart() {
    return false;
}

if (!function_exists('wildnest_new_loop_shop_per_page')) {
    add_filter( 'loop_shop_per_page', 'wildnest_new_loop_shop_per_page', 20 );
    function wildnest_new_loop_shop_per_page( $cols ) {
      // $cols contains the current number of products per page based on the value stored on Options -> Reading
      // Return the number of products you wanna show per page.
    	if(Wildnest()->get_setting('wildnest_shop_no_products')){
      		$cols = Wildnest()->get_setting('wildnest_shop_no_products');
      	} else {
      		$cols = 9;
      	}
      return $cols;
    }
}


if (!function_exists('wildnest_account_login_lightbox')) {
    function wildnest_account_login_lightbox(){
        if ( class_exists( 'WooCommerce' ) ) {
            if (!is_user_logged_in() && !is_account_page()) {
                ?>
                <div class="modeltheme-modal-holder">
                    <div class="modeltheme-overlay-inner"></div>
                    <div class="modeltheme-modal-container">
                        <div class="modeltheme-modal" id="modal-log-in">
                            <div class="modeltheme-content" id="login-modal-content">
                                <h3 class="relative text-center">
                                    <?php echo esc_html__('Access Your Account', 'wildnest'); ?>
                                </h3>
                                <div class="modal-content row">
                                    <div class="col-md-12">
                                        <?php wc_get_template_part('myaccount/form-login'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <?php
            }
        }
    }
    add_action('wildnest_after_body_open_tag', 'wildnest_account_login_lightbox');
}

/**
 * Reset default WC action hooks.
 */
function wildnest_wc_reset_default_hooks()
{
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

	if (Wildnest()->get_setting('wc_single_layout_breadcrumb')) {
		if (!has_action('woocommerce_single_product_summary_before', 'woocommerce_breadcrumb')) {
			add_action('woocommerce_single_product_summary_before', 'woocommerce_breadcrumb', 5);
		}
	}
	if (!Wildnest()->get_setting('wildnest_single_product_related')) {
	    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	}
	if (!has_action('wildnest/wc-product/before-media', 'woocommerce_template_loop_product_link_open')) {
		add_action('wildnest/wc-product/before-media', 'woocommerce_template_loop_product_link_open', 10);
	}

	if (!has_action('wildnest/wc-product/after-media')) {
		add_action('wildnest/wc-product/after-media', 'woocommerce_template_loop_product_link_close', 10);
	}
}

add_action('wp', 'wildnest_wc_reset_default_hooks');
/**
 * @since 0.3.9
 */
add_action('wildnest_wc_loop_start', 'wildnest_wc_reset_default_hooks');


/**
 * Display secondary thumbnail.
 */
function wildnest_wc_secondary_product_thumbnail()
{
	$setting = wc_get_loop_prop('media_secondary');
	if ('none' == $setting) {
		return;
	}
	global $product;
	$image_ids = $product->get_gallery_image_ids();
	if (count($image_ids)) {
		$secondary_img_id = 'last' == $setting ? end($image_ids) : reset($image_ids);
		$size             = 'shop_catalog';
		$classes          = 'attachment-' . $size . ' secondary-image image-transition';
		echo wp_get_attachment_image($secondary_img_id, $size, false, array('class' => $classes));
	}
}

class Wildnest_WC {
	static $_instance;

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function is_active() {
		return Wildnest()->is_woocommerce_active();
	}

	function __construct() {
		if ( class_exists('WooCommerce') ) {
			/**
			 * Filter shop layout
			 *
			 * @see Wildnest_WC::shop_layout
			 */
			add_filter( 'wildnest_get_layout', array( $this, 'shop_layout' ) );
			/**
			 * Filter special meta values for shop pages.
			 *
			 * @see Wildnest_WC::get_post_metadata
			 */
			add_filter( 'get_post_metadata', array( $this, 'get_post_metadata' ), 999, 4 );

			add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
			add_filter( 'wildnest/customizer/config', array( $this, 'customize_shop_sidebars' ) );
			add_filter( 'wildnest/sidebar-id', array( $this, 'shop_sidebar_id' ), 15, 2 );

			add_filter( 'wildnest_is_header_display', array( $this, 'show_shop_header' ), 15 );
			add_filter( 'wildnest_is_footer_display', array( $this, 'show_shop_footer' ), 15 );
			add_filter( 'wildnest_site_content_class', array( $this, 'shop_content_layout' ), 15 );
			add_filter( 'wildnest_builder_row_display_get_post_id', array( $this, 'builder_row_get_id' ), 15 );

			add_filter( 'wildnest/titlebar/args', array( $this, 'titlebar_args' ) );
			add_filter( 'wildnest/titlebar/config', array( $this, 'titlebar_config' ), 15, 2 );
			add_filter( 'wildnest/titlebar/is-showing', array( $this, 'titlebar_is_showing' ), 15 );
			add_filter( 'wildnest/page-header/get-settings', array( $this, 'get_page_header_settings' ) );

			add_filter( 'woocommerce_output_related_products_args', array( $this,  'wildnest_related_products_args' ) );
			add_filter( 'loop_shop_columns', array( $this, 'wildnest_wc_loop_shop_columns'), 1, 13 );
			/**
			 * Woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			add_action( 'wp', array( $this, 'wp' ) );
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_fragments' ) );
			add_filter( 'Wildnest_JS', array( $this, 'Wildnest_JS' ) );

			add_filter( 'woocommerce_get_script_data', array( $this, 'woocommerce_get_script_data' ), 15, 2 );

			// Load theme style.
			add_filter( 'woocommerce_enqueue_styles', array( $this, 'custom_styles' ) );

			// Add body class.
			add_filter( 'post_class', array( $this, 'post_class' ), 190, 3 );
			add_filter( 'product_cat_class', array( $this, 'post_cat_class' ), 15 );

			// Change number repleate product.
			add_action( 'wildnest_wc_loop_start', array( $this, 'loop_start' ) );
			add_action( 'woocommerce_sidebar', array( $this, 'wildnest_woocommerce_get_sidebar' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'wildnest_related_products_args' ) );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		}
	}

	function woocommerce_get_script_data( $data, $handle ) {
		if ( 'woocommerce' == $handle ) {
			$data['qty_pm'] = apply_filters( 'wildnest_qty_add_plus_minus', 1 );
		}

		return $data;
	}

	/**
	 * Custom number layout
	 */
	function loop_start() {

		/**
		 * @see wc_set_loop_prop
		 */
		$name = wc_get_loop_prop( 'name' );

		wc_set_loop_prop( 'media_secondary', Wildnest()->get_setting( 'wc_cd_media_secondary' ) );

		if ( ! $name ) { // Main loop.
			wc_set_loop_prop( 'columns', get_option( 'woocommerce_catalog_columns' ) );
			wc_set_loop_prop( 'tablet_columns', get_theme_mod( 'woocommerce_catalog_tablet_columns' ) );
			wc_set_loop_prop( 'mobile_columns', Wildnest()->get_setting( 'woocommerce_catalog_mobile_columns' ) );

		} elseif ( 'related' == $name || 'up-sells' == $name || 'cross-sells' == $name ) {

			if ( 'up-sells' == $name ) {
				$columns = Wildnest()->get_setting( 'wc_single_product_upsell_columns', 'all' );
			} else {
				$columns = Wildnest()->get_setting( 'wc_single_product_related_columns', 'all' );
			}

			$columns = wp_parse_args(
				$columns,
				array(
					'desktop' => 3,
					'tablet'  => 3,
					'mobile'  => 1,
				)
			);

			if ( ! $columns ) {
				$columns['desktop'] = 3;
			}

			wc_set_loop_prop( 'columns', $columns['desktop'] );
			wc_set_loop_prop( 'tablet_columns', $columns['tablet'] );
			wc_set_loop_prop( 'mobile_columns', $columns['mobile'] );
		}

	}


	/* Function: Related Products */
	function wildnest_related_products_args( $args ) {
	    if (Wildnest()->get_setting('wildnest_single_product_related')) {
	        $args['posts_per_page'] = Wildnest()->get_setting('wildnest_single_product_related_nr');
	        $args['columns'] = Wildnest()->get_setting('wildnest_single_product_related_nr');
	    }	
	    return $args;
	}


	/* Function: Shop columns */
	function wildnest_wc_loop_shop_columns( $number_columns ) {
	    if (Wildnest()->get_setting('wildnest_shop_columns')) {
	        return Wildnest()->get_setting('wildnest_shop_columns');
	    }else{
	         return 3;
	    }
	}


	/* Function: Shop sidebar */
	function wildnest_woocommerce_get_sidebar() {
	    if ( is_shop() || is_product_category() || is_product_tag() ) {
	        if (is_active_sidebar('woocommerce')) {
	            dynamic_sidebar( 'woocommerce' );
	        } 
	    }elseif ( is_product() ) {
	       if (is_active_sidebar('woocommerce')) {
	            dynamic_sidebar( 'woocommerce' );
	        }
	    }
	}

	/* Function: Body classes */
	function post_cat_class( $classes ) {
		$classes[] = 'wildnest-col';

		return $classes;
	}

	function post_class( $classes, $class, $post_id ) {

		global $post;
		if ( ! $post_id ) {
			if ( is_object( $post ) && property_exists( $post, 'ID' ) ) {
				$post_id = $post->ID;
			}
		}

		if ( ! $post_id || get_post_type( $post ) !== 'product' ) {
			return $classes;
		}

		global $product;

		if ( is_object( $product ) ) { // Do not add class if is single product.

			if ( isset( $GLOBALS['woocommerce_loop'] ) && ! empty( $GLOBALS['woocommerce_loop'] ) ) {
				if ( is_product() ) {
					if ( $GLOBALS['woocommerce_loop']['name'] ) {
						$classes[] = 'wildnest-col';
					}
				} else {
					$classes[] = 'wildnest-col';
				}
			}
		}

		if ( is_object( $product ) ) {
			$setting = wc_get_loop_prop( 'media_secondary' );
			if ( 'none' != $setting ) {
				$image_ids = $product->get_gallery_image_ids();
				if ( $image_ids ) {
					$classes[] = 'product-has-gallery';
				}
			}
		}

		return $classes;
	}

	/**
	 * Load load theme styling instead.
	 *
	 * @param array $enqueue_styles List enqueue styles.
	 *
	 * @return mixed
	 */
	function custom_styles( $enqueue_styles ) {
		if ( isset( $enqueue_styles['woocommerce-layout'] ) ) {
			unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout.
		}

		return $enqueue_styles;
	}

	/**
	 * Add more settings to Wildnest JS
	 *
	 * @param array $args JS settings.
	 *
	 * @return mixed
	 */
	function Wildnest_JS( $args ) {
		$args['wc_open_cart'] = false;
		if ( isset( $_REQUEST['add-to-cart'] ) && ! empty( $_REQUEST['add-to-cart'] ) ) {
			$args['wc_open_cart'] = true;
		}

		return $args;
	}

	/**
	 * Add more args for cart
	 *
	 * @see WC_AJAX::get_refreshed_fragments();
	 *
	 * @param array $cart_fragments
	 *
	 * @return array
	 */
	function cart_fragments( $cart_fragments = array() ) {
		$sub_total = WC()->cart->get_cart_subtotal();

		$cart_fragments['.wildnest-wc-sub-total'] = '<span class="wildnest-wc-sub-total">' . $sub_total . '</span>';
		$quantities                                = WC()->cart->get_cart_item_quantities();

		$qty   = array_sum( $quantities );
		$class = 'wildnest-wc-total-qty';
		if ( $qty <= 0 ) {
			$class .= ' hide-qty';
		}

		$cart_fragments['.wildnest-wc-total-qty'] = '<span class="' . $class . '">' . $qty . '</span>';

		return $cart_fragments;
	}

	function wp() {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
	}

	function get_shop_page_meta( $meta_key ) {
		return get_post_meta( wc_get_page_id( 'shop' ), $meta_key, true );
	}

	function is_shop_pages() {
		return ( is_shop() || is_product_category() || is_product_tag() || is_product() );
	}

	function builder_row_get_id( $id ) {
		if ( $this->is_shop_pages() ) {
			$id = wc_get_page_id( 'shop' );
		}

		return $id;
	}

	function shop_content_layout( $classes = array() ) {
		if ( $this->is_shop_pages() ) {
			$page_layout = $this->get_shop_page_meta( '_wildnest_content_layout' );
			if ( $page_layout ) {
				$classes['content_layout'] = 'content-' . sanitize_text_field( $page_layout );
			}
		}

		return $classes;
	}

	function show_shop_header( $show = true ) {
		if ( $this->is_shop_pages() ) {
			$disable = $this->get_shop_page_meta( '_wildnest_disable_header' );
			if ( $disable ) {
				$show = false;
			}
		}

		return $show;
	}

	function show_shop_footer( $show = true ) {
		if ( $this->is_shop_pages() ) {
			$rows    = array( 'main', 'bottom' );
			$count   = 0;
			$shop_id = wc_get_page_id( 'shop' );
			foreach ( $rows as $row_id ) {
				if ( ! wildnest_is_builder_row_display( 'footer', $row_id, $shop_id ) ) {
					$count ++;
				}
			}
			if ( $count >= count( $rows ) ) {
				$show = false;
			}
		}

		return $show;
	}

	function show_shop_title( $show = true ) {
		if ( $this->is_shop_pages() ) {
			$disable = $this->get_shop_page_meta( '_wildnest_disable_page_title' );
			if ( $disable ) {
				$show = false;
			}
		}

		if ( $this->titlebar_is_showing() ) {
			$show = false;
		}

		return apply_filters( 'wildnest_is_shop_title_display', $show );
	}


	/**
	 * Filter header settings pargs
	 *
	 * @TODO display category thumbnail as header cover if set.
	 *
	 * @param array $args
	 *
	 * @return mixed
	 */
	function get_page_header_settings( $args ) {
		if ( is_product_taxonomy() ) {
			global $wp_query;
			$cat          = $wp_query->get_queried_object();
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image        = Wildnest()->get_media( $thumbnail_id, 'full' );
			if ( $image ) {
				$args['image'] = $image;
			}
		}

		return $args;
	}

	function titlebar_is_showing( $show = true ) {

		if ( is_shop() ) {
			// Do not show if page settings disable page title.
			if ( Wildnest_Breadcrumb::get_instance()->support_plugins_active() && ! Wildnest()->get_setting( 'titlebar_display_product' ) ) {
				$show = false;
			} else {
				$show = true;
			}
			if ( Wildnest()->is_using_post() ) {
				$breadcrumb_display = get_post_meta( wc_get_page_id( 'shop' ), '_wildnest_breadcrumb_display', true );
				if ( 'hide' == $breadcrumb_display ) {
					$show = false;
				} elseif ( 'show' == $breadcrumb_display ) {
					$show = true;
				}
			}
		} elseif ( is_product_taxonomy() ) {
			if ( Wildnest()->get_setting( 'titlebar_display_product_tax' ) ) {
				$show = true;
			} else {
				$show = false;
			}
		} elseif ( is_product() ) {
			if ( Wildnest()->get_setting( 'titlebar_display_product' ) ) {
				$show = true;
			} else {
				$show = false;
			}
		}

		return $show;
	}

	function titlebar_config( $config, $titlebar ) {
		$section = 'titlebar';

		$config[] = array(
			'name'           => "{$section}_display_product_tax",
			'type'           => 'checkbox',
			'default'        => 1,
			'section'        => $section,
			'checkbox_label' => __( 'Display on product taxonomies (categories/tags,..)', 'wildnest' ),
		);

		$config[] = array(
			'name'           => "{$section}_display_product",
			'type'           => 'checkbox',
			'default'        => 1,
			'section'        => $section,
			'checkbox_label' => __( 'Display on single product', 'wildnest' ),
		);

		return $config;
	}

	function titlebar_args( $args ) {
		if ( is_product_taxonomy() ) {
			$t             = get_queried_object();
			$args['title'] = $t->name;
		} elseif ( is_singular( 'product' ) ) {
			$args['title'] = get_the_title( wc_get_page_id( 'shop' ) );
			$args['tag']   = 'h2';
		}

		return $args;
	}

	function shop_sidebar_id( $id, $sidebar_type = null ) {
		if ( $this->is_shop_pages() ) {
			switch ( $sidebar_type ) {
				case 'secondary':
					return 'shop-sidebar-2';
				default:
					return 'shop-sidebar-1';
			}
		}

		return $id;
	}

	function customize_shop_sidebars( $configs = array() ) {
		return $configs;
	}

	function register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'WooCommerce Primary Sidebar', 'wildnest' ),
				'id'            => 'shop-sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'wildnest' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'WooCommerce Secondary Sidebar', 'wildnest' ),
				'id'            => 'shop-sidebar-2',
				'description'   => esc_html__( 'Add widgets here.', 'wildnest' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}


	/**
	 * Filter meta key for shop pages
	 *
	 * @param string $value
	 * @param string $object_id
	 * @param string $meta_key
	 * @param bool   $single
	 *
	 * @return mixed
	 */
	function get_post_metadata( $value, $object_id, $meta_key, $single ) {
		$meta_keys = array(
			'_wildnest_page_header_display' => '',
			'_wildnest_breadcrumb_display'  => '',
		);

		if ( ! isset( $meta_keys[ $meta_key ] ) ) {
			return $value;
		}

		if ( wc_get_page_id( 'cart' ) == $object_id || wc_get_page_id( 'checkout' ) == $object_id ) {

			$meta_type = 'post';

			$meta_cache = wp_cache_get( $object_id, $meta_type . '_meta' );

			if ( ! $meta_cache ) {
				$meta_cache = update_meta_cache( $meta_type, array( $object_id ) );
				$meta_cache = $meta_cache[ $object_id ];
			}

			if ( ! $meta_key ) {
				return $value;
			}

			if ( isset( $meta_cache[ $meta_key ] ) ) {
				if ( $single ) {
					$value = maybe_unserialize( $meta_cache[ $meta_key ][0] );
				} else {
					$value = array_map( 'maybe_unserialize', $meta_cache[ $meta_key ] );
				}
			}

			if ( ! is_array( $value ) ) {
				$value = array( $value );
			}

			switch ( $meta_key ) {
				case '_wildnest_page_header_display':
					if ( empty( $value ) || 'default' == $value[0] || 'normal' == $value[0] || ! $value[0] ) {
						$value[0] = 'normal';
					}
					break;
				case '_wildnest_breadcrumb_display':
					if ( empty( $value ) || 'default' == $value[0] || ! $value[0] ) {
						$value[0] = 'hide';
					}
					break;

			}
		}

		return $value;
	}

	/**
	 * Special shop layout
	 *
	 * @param bool $layout
	 *
	 * @return string
	 */
	function shop_layout( $layout = false ) {
		if ( $this->is_shop_pages() ) {
			$default     = Wildnest()->get_setting( 'sidebar_layout' );
			$page        = Wildnest()->get_setting( 'page_sidebar_layout' );
			$page_id     = wc_get_page_id( 'shop' );
			$page_custom = get_post_meta( $page_id, '_wildnest_sidebar', true );
			if ( $page_custom ) {
				$layout = $page_custom;
			} elseif ( $page ) {
				$layout = $page;
			} else {
				$layout = $default;
			}
		}

		if ( is_product() ) {
			$product_sidebar = get_post_meta( get_the_ID(), '_wildnest_sidebar', true );
			if ( ! $product_sidebar ) {
				$product_custom = Wildnest()->get_setting( 'product_sidebar_layout' );
				if ( $product_custom && 'default' != $product_custom ) {
					$layout = $product_custom;
				}
			} else {
				$layout = $product_sidebar;
			}
		}

		return $layout;
	}
}

function Wildnest_WC() {
	return Wildnest_WC::get_instance();
}

if ( class_exists('WooCommerce') ) {
	Wildnest_WC();
}

/**
 * Get default view for product catalog
 *
 * @return string
 */
function wildnest_get_default_catalog_view_mod() {
	$name    = wc_get_loop_prop( 'name' );
	$default = Wildnest()->get_setting( 'wc_cd_default_view' );
	if ( $name ) {
		return apply_filters( 'wildnest_get_default_catalog_view_mod', 'grid' );
	}

	$use_cookies = true;
	if ( is_customize_preview() ) {
		$use_cookies = false;
	}

	if ( ! Wildnest()->get_setting( 'wc_cd_show_view_mod' ) ) {
		$use_cookies = false;
	}

	if ( $use_cookies ) { // Do not use cookie in customize.
		$cookie_mod = ( isset( $_COOKIE['wildnest_wc_pl_view_mod'] ) && $_COOKIE['wildnest_wc_pl_view_mod'] ) ? sanitize_text_field( $_COOKIE['wildnest_wc_pl_view_mod'] ) : false; // WPCS: sanitization ok.
		if ( $cookie_mod ) {
			if ( 'grid' == $cookie_mod || 'list' == $cookie_mod ) {
				$default = $cookie_mod;
			}
		}
	}

	if ( ! $default ) {
		$default = 'grid';
	}

	return apply_filters( 'wildnest_get_default_catalog_view_mod', $default );
}


if ( ! function_exists( 'woocommerce_template_loop_product_link_open' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 *
	 * @param string $classs
	 */
	function woocommerce_template_loop_product_link_open( $classs = '' ) {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	}
}

if ( ! function_exists( 'woocommerce_shop_loop_item_title' ) ) {
	/**
	 * Show the product title in the product loop. By default this is an H2.
	 * Overridden function `woocommerce_shop_loop_item_title`
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h2 class="woocommerce-loop-product__title">';
		woocommerce_template_loop_product_link_open();
		echo get_the_title();
		woocommerce_template_loop_product_link_close();
		echo '</h2>';
	}
}

/**
 * Template pages
 */

if ( ! function_exists( 'woocommerce_content' ) ) {
	/**
	 * Output WooCommerce content.
	 *
	 * This function is only used in the optional 'woocommerce.php' template.
	 * which people can add to their themes to add basic woocommerce support.
	 * without hooks or modifying core templates.
	 */
	function woocommerce_content() {
		if ( is_singular( 'product' ) ) {
			while ( have_posts() ) :
				the_post();
				wc_get_template_part( 'content', 'single-product' );
			endwhile;
		} else {
			$view = wildnest_get_default_catalog_view_mod();
			?>
			<div class="woocommerce-listing wc-product-listing <?php echo esc_attr( 'wc-' . $view . '-view' ); ?>">
				<?php
				if ( Wildnest_WC()->show_shop_title() ) {
					if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
						<?php
					endif;
					do_action( 'woocommerce_archive_description' );
				}
				if ( have_posts() ) {
					do_action( 'woocommerce_before_shop_loop' );
					woocommerce_product_loop_start();
					while ( have_posts() ) :
						the_post();
						wc_get_template_part( 'content', 'product' );
						endwhile; // end of the loop.
					woocommerce_product_loop_end();
					do_action( 'woocommerce_after_shop_loop' );
				} elseif ( ! woocommerce_product_subcategories(
					array(
						'before' => woocommerce_product_loop_start( false ),
						'after'  => woocommerce_product_loop_end( false ),
					)
				) ) {
					do_action( 'woocommerce_no_products_found' );
				}
				?>
			</div>
			<?php
		}
	}
}



function wildnest_customizer_product_card_alignment() {
	$alignment = Wildnest()->get_setting( 'wildnest_shop_product_box_layout' );
	if ($alignment) {
    	return 'wildnest-alignment-'.esc_attr($alignment);
	}
}
add_filter( 'wildnest_woocommerce_title_metas', 'wildnest_customizer_product_card_alignment' );


// function wildnest_add_to_cart_text_to_icon() {
// 	global $product;

// 	$add_to_cart_attr = esc_attr__('Add to cart', 'wildnest');
// 	$add_to_cart_icon = 'fa-shopping-basket'; 
// 	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
// 		sprintf( '<a href="%s" data-quantity="%s" class="%s product_type_%s add_to_cart_button ajax_add_to_cart" %s aria-label="Add %s to your cart" data-product_sku="%s" data-product_id="%d" rel="nofollow"><i class="fa '.esc_attr($add_to_cart_icon).'"></i></a>',
// 			esc_url( $product->add_to_cart_url() ),
// 			esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
// 			esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
// 			esc_attr($product->get_type()),
// 			isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
// 			esc_attr( $product->get_name() ),
// 			esc_attr( $product->get_sku() ),
// 			esc_attr( $product->get_id() )
// 		), $product, $args );
// }
function wildnest_add_to_cart_text_to_icon($args = array()) {
    global $product;

    $add_to_cart_attr = esc_attr__('Add to cart', 'wildnest');
    $add_to_cart_icon = 'fa-shopping-basket';

    // Ensure $args has defaults
    $args = wp_parse_args($args, array(
        'quantity'   => 1,
        'class'      => 'button',
        'attributes' => array(),
    ));

    echo apply_filters('woocommerce_loop_add_to_cart_link',
        sprintf(
            '<a href="%s" data-quantity="%s" class="%s product_type_%s add_to_cart_button ajax_add_to_cart" %s aria-label="Add %s to your cart" data-product_sku="%s" data-product_id="%d" rel="nofollow"><i class="fa %s"></i></a>',
            esc_url($product->add_to_cart_url()),
            esc_attr($args['quantity']),
            esc_attr($args['class']),
            esc_attr($product->get_type()),
            wc_implode_html_attributes($args['attributes']),
            esc_attr($product->get_name()),
            esc_attr($product->get_sku()),
            esc_attr($product->get_id()),
            esc_attr($add_to_cart_icon)
        ),
        $product,
        $args
    );
}


// Always display rating stars
if (!function_exists('wildnest_woocommerce_product_get_rating_html')) {
    function wildnest_woocommerce_product_get_rating_html( $rating_html, $rating, $count ) { 
        $rating_html  = '<div class="star-rating">';
        $rating_html .= wc_get_star_rating_html( $rating, $count );
        $rating_html .= '</div>';

        return $rating_html; 
    };
}
add_filter( 'woocommerce_product_get_rating_html', 'wildnest_woocommerce_product_get_rating_html', 10, 3 );

// WPC Smart Compare
add_filter( 'woosc_button_position_single', '__return_false' );

if ( ! function_exists( 'wildnest_wpc_compare_button' ) ) {
	function wildnest_wpc_compare_button() {
		if ( class_exists( 'WPCleverWoosc' ) ) {
			echo do_shortcode( '[woosc]' );
		}
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'wildnest_wpc_compare_button', 20 );


// WPC Smart Wishlist
add_filter( 'woosw_button_position_single', '__return_false' );

if ( ! function_exists( 'wildnest_wpc_wishlist_button' ) ) {
	function wildnest_wpc_wishlist_button() {
		if ( class_exists( 'WPCleverWoosw' ) ) {
			echo do_shortcode( '[woosw]' );
		}
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'wildnest_wpc_wishlist_button', 30 );


/**
 * @snippet       Hide Cross-sells @ Cart
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


if (!function_exists('wildnest_search_form_categories_dropdown')) {

	function wildnest_search_form_categories_dropdown(){
		if(isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
			$optsetlect=$_REQUEST['product_cat'];
		} else {
			$optsetlect=0;  
		}
		$args = array(
			'show_option_none' => esc_html__( 'Category', 'wildnest' ),
			'option_none_value'  => '',
			'hierarchical' => true,
			'class' => 'cat',
			'echo' => 1,
			'value_field' => 'slug',
			'orderby' => 'name',
			'show_count' => true,
			'hide_empty' => true,
			'selected' => $optsetlect
		);

		$args['taxonomy'] = 'product_cat';
		$args['name'] = 'product_cat';              
		$args['class'] = 'form-control1';
		wp_dropdown_categories($args);
	}
	add_action('wildnest_search_form_before', 'wildnest_search_form_categories_dropdown');
}

/**
 * Checkbox to the Layered Navigation
 */
add_filter('woocommerce_layered_nav_term_html', 'wildnest_add_checkbox_woocommerce_attribute_filters', 10, 5);
function wildnest_add_checkbox_woocommerce_attribute_filters($term_html, $term, $link, $count) {
    echo '<input class="checkbox wildnest-layered-nav-checkbox" type="checkbox" />' . $term_html;
}
