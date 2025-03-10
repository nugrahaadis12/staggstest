<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.0.0
 *
 * @package    Staggs
 * @subpackage Staggs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Staggs
 * @subpackage Staggs/public
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_action( 'wp_head', array( $this, 'add_scripts_to_head' ), 90 );
	}

	/**
	 * Register the configurator stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * Register plugin styles
		 */

		wp_register_style( $this->plugin_name . '_swiper', plugin_dir_url( __FILE__ ) . 'css/staggs-swiper.min.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name . '_jquery_ui', plugin_dir_url( __FILE__ ) . 'css/staggs-jquery-ui.min.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name . '_lightbox', plugin_dir_url( __FILE__ ) . 'css/staggs-lightbox.min.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name . '_public', plugin_dir_url( __FILE__ ) . 'css/staggs-public.min.css', array(), $this->version, 'all' );

		wp_register_script( $this->plugin_name . '_swiper', plugin_dir_url( __FILE__ ) . 'js/staggs-swiper.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_jquery_ui', plugin_dir_url( __FILE__ ) . 'js/staggs-jquery-ui.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_jquery_touch', plugin_dir_url( __FILE__ ) . 'js/staggs-jquery-touch.min.js', array( 'jquery-ui-slider' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_lightbox', plugin_dir_url( __FILE__ ) . 'js/staggs-lightbox.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_canvas', plugin_dir_url( __FILE__ ) . 'js/staggs-canvas.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_repeater', plugin_dir_url( __FILE__ ) . 'js/staggs-repeater.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_public', plugin_dir_url( __FILE__ ) . 'js/staggs-public.min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Only load styles and scripts directly when configurable product template is active.
	 *
	 * @since    1.7.0
	 */
	public function add_scripts_to_head() {
		if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) && is_product() && product_is_configurable( get_the_ID() ) ) || is_singular( 'sgg_product' ) ) {
			$this->output_scripts();
		}
	}

	/**
	 * Actually output registered scripts to frontend.
	 *
	 * @since    1.4.4.
	 */
	public function output_scripts() {
		
		$theme_id = staggs_get_theme_id();
		$template = staggs_get_configurator_page_template( $theme_id );
		if ( $theme_id && 'none' === $template ) {
			// don't load in swiper
		} else {
			wp_enqueue_style( $this->plugin_name . '_swiper' );
		}

		wp_enqueue_style( $this->plugin_name . '_lightbox' );
		wp_enqueue_style( $this->plugin_name . '_jquery_ui' );
		wp_enqueue_style( $this->plugin_name . '_public' );
		wp_add_inline_style( $this->plugin_name . '_public', $this->enqueue_inline_styles() );

		if ( $theme_id && 'none' === $template ) {
			// don't load in swiper
		} else {
			wp_enqueue_script( $this->plugin_name . '_swiper' );
			wp_enqueue_script( $this->plugin_name . '_canvas' );
		}

		wp_enqueue_script( $this->plugin_name . '_jquery_ui' );
		wp_enqueue_script( $this->plugin_name . '_jquery_touch' );
		wp_enqueue_script( $this->plugin_name . '_lightbox' );
		wp_enqueue_script( $this->plugin_name . '_repeater' );
		wp_enqueue_script( $this->plugin_name . '_public' );
		wp_add_inline_script( $this->plugin_name . '_public', $this->enqueue_inline_scripts(), 'before' );

		$this->enqueue_font_scripts();

		do_action( 'staggs_output_public_scripts' );
	}

	/**
	 * Add body class for configurator page.
	 *
	 * @since    1.3.1
	 */
	public function set_body_configurator_class( $classes ) {
		if ( 'sgg_product' === get_post_type() || 
			( function_exists( 'is_product' ) && is_product() && product_is_inline_configurator( get_the_ID() ) && staggs_get_theme_id( get_the_ID() ) ) ) {
			$classes[] = 'staggs-product-configurator-page';
		}
		return $classes;
	}

	/**
	 * Register shortcodes for outputting configurator on custom page.
	 *
	 * @since    1.3.7
	 */
	public function register_shortcodes() {
		add_shortcode( 'staggs_configurator', array( $this, 'output_product_configurator_template' ) );
		add_shortcode( 'staggs_configurator_gallery', array( $this, 'output_product_configurator_gallery' ) );
		add_shortcode( 'staggs_configurator_form', array( $this, 'output_product_configurator_form_options' ) );
		add_shortcode( 'staggs_configurator_totals', array( $this, 'output_product_configurator_form_totals' ) );
		add_shortcode( 'staggs_configurator_total_price', array( $this, 'output_product_configurator_form_total_price' ) );
		add_shortcode( 'staggs_configurator_popup_button', array( $this, 'output_product_configurator_popup_button' ) );
		add_shortcode( 'staggs_configurator_summary', array( $this, 'output_product_configurator_summary_widget' ) );
	}

	/**
	 * Output product configurator template.
	 *
	 * @since    1.3.7
	 */
	public function output_product_configurator_template( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		// Start collecting output.
		ob_start();
		if ( isset( $atts['product_id'] ) ) {

			// Keep reference to original post ID.
			global $original_post_id;
			$original_post_id = get_the_ID();

			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();

					if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
						global $product;
						$product = wc_get_product( get_the_ID() );
					}

					do_action( 'staggs_modify_wc_hooks' );

					global $sanitized_steps;
					$sanitized_steps = Staggs_Formatter::get_formatted_step_content( get_the_ID() );
	
					$this->output_scripts();

					$template = staggs_get_configurator_page_template( staggs_get_theme_id() );
					$view_layout = staggs_get_configurator_view_layout( staggs_get_theme_id() );
	
					if ( 'staggs' === $template ) {

						if ( file_exists( STAGGS_BASE . '/public/templates/inline/template-' . $view_layout . '.php' ) ) {
						
							include STAGGS_BASE . '/public/templates/inline/template-' . $view_layout . '.php';
						
						} else if ( file_exists( STAGGS_BASE . '/public/templates/popup/template-' . $view_layout . '.php' ) ) {
				
							include STAGGS_BASE . '/public/templates/popup/template-' . $view_layout . '.php';
						
						} else if ( file_exists( STAGGS_BASE . '/pro/public/templates/inline/template-' . $view_layout . '.php' ) ) {
						
							include STAGGS_BASE . '/pro/public/templates/inline/template-' . $view_layout . '.php';
						
						} else {
						
							include STAGGS_BASE . '/public/templates/inline/template-classic.php';
		
						}

					} else if ( 'woocommerce' === $template && class_exists( 'WooCommerce' ) ) {

						// No Staggs template match.
						if ( file_exists( $dir . WC()->template_path() . 'single-product.php' ) ) {
							// Check if template is overridden in active theme.
							include $dir . WC()->template_path() . 'single-product.php';
						}
		
					} else {
		
						do_action( 'staggs_before_configurator_form_shortcode' );
							
						include STAGGS_BASE . '/public/templates/shared/form.php';
		
						do_action( 'staggs_after_configurator_form_shortcode' );
		
						do_action( 'staggs_before_configurator_totals_shortcode' );
							
						include STAGGS_BASE . '/public/templates/shared/totals.php';
		
						do_action( 'staggs_after_configurator_totals_shortcode' );
		
					}
				}
			}
			
			wp_reset_postdata();
			wp_reset_postdata();

		} else {

			do_action( 'staggs_modify_wc_hooks' );

			global $sanitized_steps;
			$sanitized_steps = Staggs_Formatter::get_formatted_step_content( get_the_ID() );

			$this->output_scripts();

			$template = staggs_get_configurator_page_template( staggs_get_theme_id() );
			$view_layout = staggs_get_configurator_view_layout( staggs_get_theme_id() );
	
			if ( 'staggs' === $template ) {

				if ( file_exists( STAGGS_BASE . '/public/templates/inline/template-' . $view_layout . '.php' ) ) {
			
					include STAGGS_BASE . '/public/templates/inline/template-' . $view_layout . '.php';
				
				} else if ( file_exists( STAGGS_BASE . '/public/templates/popup/template-' . $view_layout . '.php' ) ) {
				
					include STAGGS_BASE . '/public/templates/popup/template-' . $view_layout . '.php';
				
				} else if ( file_exists( STAGGS_BASE . '/pro/public/templates/inline/template-' . $view_layout . '.php' ) ) {
				
					include STAGGS_BASE . '/pro/public/templates/inline/template-' . $view_layout . '.php';
				
				} else {
				
					include STAGGS_BASE . '/public/templates/inline/template-classic.php';

				}

			} else if ( 'woocommerce' === $template && class_exists( 'WooCommerce' ) ) {

				// No Staggs template match.
				if ( file_exists( $dir . WC()->template_path() . 'single-product.php' ) ) {
					// Check if template is overridden in active theme.
					include $dir . WC()->template_path() . 'single-product.php';
				}

			} else {

				do_action( 'staggs_before_configurator_form_shortcode' );
					
				include STAGGS_BASE . '/public/templates/shared/form.php';

				do_action( 'staggs_after_configurator_form_shortcode' );

				do_action( 'staggs_before_configurator_totals_shortcode' );
					
				include STAGGS_BASE . '/public/templates/shared/totals.php';

				do_action( 'staggs_after_configurator_totals_shortcode' );

			}
		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Output product configurator gallery view.
	 *
	 * @since    1.3.7
	 */
	public function output_product_configurator_gallery( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		global $inline_style;
		$inline_style = '';
		if ( isset( $atts['width'] ) && '' !== $atts['width'] ) {
			$inline_style .= 'width: ' . $atts['width'] . ';';
		}
		if ( isset( $atts['height'] ) && '' !== $atts['height'] ) {
			$inline_style .= 'height: ' . $atts['height'] . ';';
		}

		ob_start();

		if ( isset( $atts['product_id'] ) ) {

			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();

					if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
						global $product;
						$product = wc_get_product( get_the_ID() );
					}

					do_action( 'staggs_modify_wc_hooks' );

					$this->output_scripts();

					do_action( 'staggs_before_configurator_gallery_shortcode' );
					
					include STAGGS_BASE . '/public/templates/shared/gallery.php';

					do_action( 'staggs_after_configurator_gallery_shortcode' );

				}
			}

			wp_reset_postdata();
			wp_reset_postdata();

		} else {
			
			do_action( 'staggs_modify_wc_hooks' );

			$this->output_scripts();

			do_action( 'staggs_before_configurator_gallery_shortcode' );
					
			include STAGGS_BASE . '/public/templates/shared/gallery.php';

			do_action( 'staggs_after_configurator_gallery_shortcode' );

		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Output product configurator form options.
	 *
	 * @since    1.3.7
	 */
	public function output_product_configurator_form_options( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		ob_start();

		if ( isset( $atts['product_id'] ) ) {
			
			// Keep reference to original post ID.
			global $original_post_id;
			$original_post_id = get_the_ID();

			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();

					if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
						global $product;
						$product = wc_get_product( get_the_ID() );
					}

					do_action( 'staggs_modify_wc_hooks' );

					$this->output_scripts();

					do_action( 'staggs_before_configurator_form_shortcode' );
					
					include STAGGS_BASE . '/public/templates/shared/form.php';

					do_action( 'staggs_after_configurator_form_shortcode' );

				}
			}

			wp_reset_postdata();
			wp_reset_postdata();
			
		} else {

			do_action( 'staggs_modify_wc_hooks' );

			$this->output_scripts();

			do_action( 'staggs_before_configurator_form_shortcode' );
					
			include STAGGS_BASE . '/public/templates/shared/form.php';

			do_action( 'staggs_after_configurator_form_shortcode' );

		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Output product configurator form totals.
	 *
	 * @since    1.3.7
	 */
	public function output_product_configurator_form_totals( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		ob_start();

		if ( isset( $atts['product_id'] ) ) {

			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();
	
					if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
						global $product;
						$product = wc_get_product( get_the_ID() );
					}

					do_action( 'staggs_modify_wc_hooks' );

					$this->output_scripts();

					do_action( 'staggs_before_configurator_totals_shortcode' );
					
					include STAGGS_BASE . '/public/templates/shared/totals.php';

					do_action( 'staggs_after_configurator_totals_shortcode' );

				}
			}
	
			wp_reset_postdata();
			wp_reset_postdata();

		} else {

			do_action( 'staggs_modify_wc_hooks' );

			$this->output_scripts();

			do_action( 'staggs_before_configurator_totals_shortcode' );
					
			include STAGGS_BASE . '/public/templates/shared/totals.php';

			do_action( 'staggs_after_configurator_totals_shortcode' );

		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Output product configurator form total price list.
	 *
	 * @since    2.9.0
	 */
	public function output_product_configurator_form_total_price( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		ob_start();

		if ( isset( $atts['product_id'] ) ) {
			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();
	
					$theme_id = staggs_get_theme_id();
					$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
					if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
						$display_price = 'hide';
					}

					if ( 'hide' !== $display_price ) {
						echo '<div class="totals-list">';
		
						if ( staggs_get_theme_option( 'sgg_product_totals_show_tax' ) ) {
							$tax_label = staggs_get_theme_option( 'sgg_product_totals_alt_tax_label' ) ?: 'Total tax:';
							echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_tax_label', __( $tax_label, 'staggs' ) ) ) . '<span class="sgg_total_tax_price"></span></div>';	
						}
			
						$view = staggs_get_configurator_view_layout( $theme_id );
						if ( 'summary' === staggs_get_post_meta( $theme_id, 'sgg_configurator_price_display_template' ) && in_array( $view, array( 'classic', 'floating', 'full' ) ) ) {
							$product_label  = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_product_label' ) ?: __( 'Product total:', 'staggs' );
							$options_label  = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_options_label' ) ?: __( 'Options total:', 'staggs' );
							$combined_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_combined_label' ) ?: __( 'Grand total:', 'staggs' );
		
							echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_label', sgg__( $product_label ) ) ) . '<span class="sgg_product_price"></span></div>';	
							echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_configuration_label', sgg__( $options_label ) ) ) . '<span class="sgg_options_price"></span></div>';
							echo '<div class="totals-row totals-row-last">' . esc_attr( apply_filters( 'staggs_total_combined_label', sgg__( $combined_label ) ) );
							echo '<span class="totals-row-price"><span class="sgg_total_price"></span>';
							echo '</span></div>';
		
						} else {
							$totals_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_label' ) ?: __( 'Total:', 'staggs' );
							echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_row_label', sgg__( $totals_label ) ) ) . '<span class="sgg_total_price"></span></div>';
						}
						echo '</div>';
					}
				}
			}
	
			wp_reset_postdata();
			wp_reset_postdata();
		} else {
			$theme_id = staggs_get_theme_id();
			$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
			if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
				$display_price = 'hide';
			}
	
			if ( 'hide' !== $display_price ) {
				echo '<div class="totals-list">';

				if ( staggs_get_theme_option( 'sgg_product_totals_show_tax' ) ) {
					$tax_label = staggs_get_theme_option( 'sgg_product_totals_alt_tax_label' ) ?: 'Total tax:';
					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_tax_label', __( $tax_label, 'staggs' ) ) ) . '<span class="sgg_total_tax_price"></span></div>';	
				}
	
				$view = staggs_get_configurator_view_layout( $theme_id );
				if ( 'summary' === staggs_get_post_meta( $theme_id, 'sgg_configurator_price_display_template' ) && in_array( $view, array( 'classic', 'floating', 'full' ) ) ) {
					$product_label  = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_product_label' ) ?: __( 'Product total:', 'staggs' );
					$options_label  = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_options_label' ) ?: __( 'Options total:', 'staggs' );
					$combined_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_combined_label' ) ?: __( 'Grand total:', 'staggs' );

					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_label', sgg__( $product_label ) ) ) . '<span class="sgg_product_price"></span></div>';	
					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_configuration_label', sgg__( $options_label ) ) ) . '<span class="sgg_options_price"></span></div>';
					echo '<div class="totals-row totals-row-last">' . esc_attr( apply_filters( 'staggs_total_combined_label', sgg__( $combined_label ) ) );
					echo '<span class="totals-row-price"><span class="sgg_total_price"></span>';
					echo '</span></div>';
				} else {
					$totals_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_label' ) ?: __( 'Total:', 'staggs' );
					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_row_label', sgg__( $totals_label ) ) ) . '<span class="sgg_total_price"></span></div>';
				}
				echo '</div>';
			}
		}

		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Output product configurator popup button.
	 *
	 * @since    1.3.7
	 */
	public function output_product_configurator_popup_button( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		$button = '';
		if ( isset( $atts['product_id'] ) ) {
			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();

					if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
						global $product;
						$product = wc_get_product( get_the_ID() );
					}

					$view_layout = staggs_get_configurator_view_layout( staggs_get_theme_id() );
					if ( 'popup' === $view_layout ) {
						$button_text = staggs_get_post_meta( staggs_get_theme_id(), 'sgg_step_popup_button_text' );
						if ( ! $button_text ) {
							$button_text = __( 'Configure', 'staggs' );
						}

						echo wp_kses_post( apply_filters( 
							'staggs_configurator_popup_button_html',
							'<a href="#" class="button staggs-configure-product-button">' . $button_text . '</a>'
						) );
					} else {
						$button = esc_attr__( 'Note: the popup button can only be used in combination with popup template', 'staggs' );
					}
				}
			}

			wp_reset_postdata();
		} else {
			$view_layout = staggs_get_configurator_view_layout( staggs_get_theme_id() );
			if ( 'popup' === $view_layout ) {
				$button_text = staggs_get_post_meta( staggs_get_theme_id(), 'sgg_step_popup_button_text' );
				if ( ! $button_text ) {
					$button_text = __( 'Configure', 'staggs' );
				}

				echo wp_kses_post( apply_filters( 
					'staggs_configurator_popup_button_html',
					'<a href="#" class="button staggs-configure-product-button">' . $button_text . '</a>'
				) );
			} else {
				$button = esc_attr__( 'Note: the popup button can only be used in combination with popup template', 'staggs' );
			}
		}

		return $button;
	}

	/**
	 * Output product configurator summary widget.
	 *
	 * @since    1.5.3
	 */
	public function output_product_configurator_summary_widget( $atts ) {
		// Validate shortcode.
		$check = $this->can_use_shortcode( $atts );
		if ( ! $check['valid'] ) {
			return $check['note'];
		}

		$summary = '';
		if ( isset( $atts['product_id'] ) ) {
			$post_type = get_post_type( $atts['product_id'] );
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$post_type = 'product'; // Force product types when WooCommerce is active.
			}

			$product_query = new WP_Query( array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => array( $atts['product_id'] )
			) );

			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();

					global $product;
					$product = wc_get_product( get_the_ID() );
			
					if ( staggs_get_post_meta( staggs_get_theme_id(), 'sgg_configurator_display_summary' ) ) {
						$location = staggs_get_post_meta( staggs_get_theme_id(), 'sgg_configurator_summary_location' );

						if ( 'shortcode' == $location ) {
							ob_start();
							staggs_output_options_summary_widget();
							$summary = ob_get_contents();
							ob_end_clean();
						}
					}
				}
			}

			wp_reset_postdata();
			wp_reset_postdata();
		} else {
			if ( staggs_get_post_meta( staggs_get_theme_id(), 'sgg_configurator_display_summary' ) ) {
				$location = staggs_get_post_meta( staggs_get_theme_id(), 'sgg_configurator_summary_location' );

				if ( 'shortcode' == $location ) {
					ob_start();
					staggs_output_options_summary_widget();
					$summary = ob_get_contents();
					ob_end_clean();
				}
			}
		}

		return $summary;
	}

	/**
	 * Register the configurator inline JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function enqueue_inline_styles() {
		global $sgg_is_shortcode, $sgg_shortcode_id;

		if ( $sgg_is_shortcode ) {
			$theme_id = staggs_get_theme_id( $sgg_shortcode_id );
		} else {
			$theme_id = staggs_get_theme_id();
		}

		$style  = '';
		$layout = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_layout' ) );

		if ( 'right' === $layout ) {
			$style .= ' section.staggs-product-view { order: 1; }';
			$style .= ' div.product-view-wrapper { left: auto; right: 0; }';
		} else {
			$style .= ' div.staggs-configurator-bottom-bar .option-group-step-buttons { order: 1; }';
		}

		$select_icon = staggs_get_icon( 'sgg_select_arrow', 'chevron-down', true );
		$left_icon = staggs_get_icon( 'sgg_slider_arrow_left', 'chevron-left', true );
		$right_icon = staggs_get_icon( 'sgg_slider_arrow_right', 'chevron-right', true );
		$check_icon = staggs_get_icon( 'sgg_checkmark', 'checkmark', true );
		$notice_close_icon = apply_filters( 'staggs_notice_close_icon', plugin_dir_url( __FILE__ ) . '/img/close.svg' );
		$input_preview_close_icon = staggs_get_icon( 'sgg_group_close_icon', 'panel-close', true );
		$loader_icon = staggs_get_icon( 'sgg_loader_icon', 'loader', true );

		$style .= ' div.staggs-product-options .select .ui-selectmenu-button .ui-selectmenu-icon,';
		$style .= ' div.staggs-product-options .select:after { background-image: url(' . $select_icon . '); }';

		$style .= ' div.swiper.staggs-view-gallery .swiper-button-prev { background-image: url(' . $left_icon . '); }';
		$style .= ' div.swiper.staggs-view-gallery .swiper-button-next { background-image: url(' . $right_icon . '); }';

		$style .= ' div.ui-widget.ui-datepicker .ui-datepicker-prev { background-image: url(' . $left_icon . '); }';
		$style .= ' div.ui-widget.ui-datepicker .ui-datepicker-next { background-image: url(' . $right_icon . '); }';

		$style .= ' .option-group-wrapper .option-group-content.loading:after { background-image: url(' . $loader_icon . '); }';

		$style .= ' div.staggs-product-options .tickboxes label input[type=checkbox]:checked + .box:before,';
		$style .= ' div.staggs-product-options .options input:checked { background-image: url(' . $check_icon . '); }';
		$style .= ' div.staggs-message-wrapper .hide-notice { background-image: url(' . $notice_close_icon . '); }';
		$style .= ' div.option-group-wrapper .image-input .input-image-thumbnail .remove-input-image { background-image: url(' . $input_preview_close_icon . '); }';

		$theme = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_theme' ) );

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_buttons_hide_disabled' ) ) {
			$style .= ' .option-group-step-buttons .button.disabled { visibility: hidden !important; }';
		} 

		$bg_size = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_bg_image_size' ) );
		if ( 'cover' === $bg_size ) {
			$style .= ' div.product-view-inner { background-size: cover; background-position: center; }';
		}

		/**
		 * Template colors
		 */

		$primary_color   = '#fff';
		$secondary_color = '#f6f6f6';
		$tertiary_color  = '#f6f6f6';

		$heading_color   = '#000';
		$text_color      = '#000';
		$icon_theme      = 'dark';
		
		$option_text_color = '#000';
		$option_border_color = '#f6f6f6';
		$option_hover_color = '#f6f6f6';
		$option_active_color = '#f6f6f6';
		$option_active_text_color = '#000';

		$accent = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_accent_color' ) ) ?: '#000';
		$accent_hover = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_accent_hover_color' ) ) ?: $accent;

		$input_bg = $tertiary_color;
		$input_border = $tertiary_color;
		$input_active_bg = $tertiary_color;
		$input_active_border = $accent;

		$button_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_button_text_color' ) ) ?: '#fff';
		$button_hover_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_button_hover_text_color' ) ) ?: $button_color;

		if ( 'dark' === $theme ) {

			$primary_color   = '#111';
			$secondary_color = '#333';
			$tertiary_color  = '#333';

			$heading_color   = '#fff';
			$text_color      = '#fff';
			$icon_theme      = 'light';

			$option_text_color = '#fff';
			$option_border_color = '#333';
			$option_hover_color = '#333';
			$option_active_color = '#333';
			$option_active_text_color = '#fff';

			$accent = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_accent_color' ) ) ?: '#fff';
			$accent_hover = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_accent_hover_color' ) ) ?: $accent;
			
			$input_bg = $tertiary_color;
			$input_border = $tertiary_color;
			$input_active_bg = $tertiary_color;
			$input_active_border = $accent;

			$button_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_button_text_color' ) ) ?: '#000';
			$button_hover_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_button_hover_text_color' ) ) ?: $button_color;
	
		} else if ( 'custom' === $theme ) {

			$primary_color   = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_primary_color' ) ) ?: '#fff';
			$secondary_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_secondary_color' ) ) ?: '#f6f6f6';
			$tertiary_color  = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_tertiary_color' ) ) ?: '#f6f6f6';
			if ( ! $tertiary_color ) {
				$tertiary_color = $secondary_color;
			}

			$heading_color   = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_heading_color' ) ) ?: '#000';
			$text_color      = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_text_color' ) ) ?: '#000';
			$icon_theme      = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_icon_theme' ) );

			$option_text_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_tertiary_text_color' ) ) ?: '#000';
			$option_hover_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_tertiary_hover_color' ) ) ?: $tertiary_color;
			$option_border_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_tertiary_border_color' ) ) ?: $tertiary_color;
			$option_active_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_tertiary_active_color' ) ) ?: $tertiary_color;
			$option_active_text_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_tertiary_active_text_color' ) ) ?: $option_text_color;

			$input_bg = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_input_bg_color' ) ) ?: $tertiary_color;
			$input_border = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_input_border_color' ) ) ?: $tertiary_color;
			$input_active_bg = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_input_active_bg_color' ) ) ?: $tertiary_color;
			$input_active_border = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_input_active_border_color' ) ) ?: $accent;
		}

		if ( 'light' === $icon_theme ) {
			$style .= ' .fieldset .fieldset-legend .icon-plus path, .fieldset .fieldset-legend .icon-minus path,';
			$style .= ' .staggs-product-options .option-group .close-panel svg { fill: #fff !important; }';
		}

		list($r, $g, $b) = sscanf($accent, "#%02x%02x%02x");
		$luma = luma( $r, $g, $b );
		if ( $luma < 0.5) {
			// Apply light icon theme (dark theme).
			$check_icon = staggs_get_icon( 'sgg_checkmark', 'checkmark', true, 'dark' );

			$style .= ' div.staggs-product-options .tickboxes label input[type=checkbox]:checked + .box:before,';
			$style .= ' div.staggs-product-options .options input:checked { background-image: url(' . $check_icon . '); }';
		}

		$style .= ' :root {';
		$style .= ' --sgg-template-background: ' . $primary_color . ';';
		$style .= ' --sgg-template-gallery: ' . $secondary_color . ';';
		$style .= ' --sgg-template-title-color: ' . $heading_color . ';';
		$style .= ' --sgg-template-color: ' . $text_color . ';';
		$style .= ' --sgg-option-background: ' . $tertiary_color . ';';
		$style .= ' --sgg-option-hover-background: ' . $option_hover_color . ';';
		$style .= ' --sgg-option-border: ' . $option_border_color . ';';
		$style .= ' --sgg-option-color: ' . $option_text_color . ';';
		$style .= ' --sgg-option-active-background: ' . $option_active_color . ';';
		$style .= ' --sgg-option-active-color: ' . $option_active_text_color . ';';
		$style .= ' --sgg-input-background: ' . $input_bg . ';';
		$style .= ' --sgg-input-border: ' . $input_border . ';';
		$style .= ' --sgg-input-active-background: ' . $input_active_bg . ';';
		$style .= ' --sgg-input-active-border: ' . $input_active_border . ';';
		$style .= ' --sgg-button-background: ' . $accent . ';';
		$style .= ' --sgg-button-color: ' . $button_color . ';';
		$style .= ' --sgg-button-hover-background: ' . $accent_hover . ';';
		$style .= ' --sgg-button-hover-color: ' . $button_hover_color . ';';

		/**
		 * Template spacing
		 */

		$attribute_space_top = staggs_get_post_meta( $theme_id, 'sgg_attribute_spacing_top' ) ?: '60px';
		$attribute_space_bottom = staggs_get_post_meta( $theme_id, 'sgg_attribute_spacing_bottom' ) ?: '60px';

		$attribute_space_top_mb = staggs_get_post_meta( $theme_id, 'sgg_attribute_spacing_top_mobile' ) ?: '30px';
		$attribute_space_bottom_mb = staggs_get_post_meta( $theme_id, 'sgg_attribute_spacing_bottom_mobile' ) ?: '30px';

		if ( 'compact' === staggs_get_post_meta( $theme_id, 'sgg_configurator_step_density' ) ) {
			$attribute_space_top = staggs_get_post_meta( $theme_id, 'sgg_attribute_spacing_top' ) ?: '25px';
			$attribute_space_bottom = staggs_get_post_meta( $theme_id, 'sgg_attribute_spacing_bottom' ) ?: '25px';
		}

		$form_width_tb = staggs_get_post_meta( $theme_id, 'sgg_template_form_options_width_tablet' ) ?: '400px';
		$form_width = staggs_get_post_meta( $theme_id, 'sgg_template_form_options_width' ) ?: '540px';

		if ( 'classic' === staggs_get_post_meta( $theme_id, 'sgg_configurator_view' ) ) {
			$form_width = staggs_get_post_meta( $theme_id, 'sgg_template_form_options_width' ) ?: '440px';
		}

		$form_padding = staggs_get_post_meta( $theme_id, 'sgg_template_form_options_padding' ) ?: '50px';
		$form_padding_tb = staggs_get_post_meta( $theme_id, 'sgg_template_form_options_padding_tablet' ) ?: '40px';

		$form_panel_width = staggs_get_post_meta( $theme_id, 'sgg_template_form_panel_width' ) ?: '450px';
		$form_panel_width_tb = staggs_get_post_meta( $theme_id, 'sgg_template_form_panel_width_tablet' ) ?: '370px';

		$style .= ' --sgg-group-spacing-top: ' . $attribute_space_top . ';';
		$style .= ' --sgg-group-spacing-bottom: ' . $attribute_space_bottom . ';';
		$style .= ' --sgg-group-spacing-top-mb: ' . $attribute_space_top_mb . ';';
		$style .= ' --sgg-group-spacing-bottom-mb: ' . $attribute_space_bottom_mb . ';';
		$style .= ' --sgg-template-form-padding: ' . $form_padding . ';';
		$style .= ' --sgg-template-form-padding-tb: ' . $form_padding_tb . ';';
		$style .= ' --sgg-template-form-width: ' . $form_width . ';';
		$style .= ' --sgg-template-form-width-tb: ' . $form_width_tb . ';';
		$style .= ' --sgg-template-panel-width: ' . $form_panel_width . ';';
		$style .= ' --sgg-template-panel-width-tb: ' . $form_panel_width_tb . ';';

		/**
		 * Template Fonts
		 */

		$base_font = 'Helvetica Now Display';
		$base_font_weight = '400';
		$base_font_style = 'normal';

		$heading_font = 'Helvetica Now Display Bold';
		$heading_font_weight = '700';
		$heading_font_style = 'normal';

		$button_font = 'Helvetica Now Display Bold';
		$button_font_weight = '700';
		$button_font_style = 'normal';

		$post_font = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_font_family' ) );
		$post_font_weight = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_font_weight' ) );
		$post_font_style = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_font_style' ) );

		$global_font = sanitize_text_field( staggs_get_theme_option( 'sgg_font_family' ) );
		$global_font_weight = sanitize_text_field( staggs_get_theme_option( 'sgg_font_weight' ) );
		$global_font_style = sanitize_text_field( staggs_get_theme_option( 'sgg_font_style' ) );

		if ( '' !== $post_font ) {
			$base_font = $post_font;
			$base_font_weight = $post_font_weight;
			$base_font_style = $post_font_style;

			$heading_font = $post_font;
			$button_font = $post_font;
		}
		else if ( '' !== $global_font ) {
			$base_font = $global_font;
			$base_font_weight = $global_font_weight;
			$base_font_style = $global_font_style;

			$heading_font = $global_font;
			$button_font = $global_font;
		}
		
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_custom_font' ) ) {
			// Custom font defined
			$heading_font = staggs_get_post_meta( $theme_id, 'sgg_heading_font_family' ) ?: $post_font;
			$heading_font_weight = staggs_get_post_meta( $theme_id, 'sgg_heading_font_weight' ) ?: $post_font_weight;
			$heading_font_style = staggs_get_post_meta( $theme_id, 'sgg_heading_font_style' ) ?: $post_font_style;
			
			$button_font = staggs_get_post_meta( $theme_id, 'sgg_button_font_family' ) ?: $post_font;
			$button_font_weight = staggs_get_post_meta( $theme_id, 'sgg_button_font_weight' ) ?: $post_font_weight;
			$button_font_style = staggs_get_post_meta( $theme_id, 'sgg_button_font_style' ) ?: $post_font_style;
		}

		$style .= ' --sgg-base-font: ' . $base_font . ';';
		$style .= ' --sgg-base-font-weight: ' . $base_font_weight . ';';
		$style .= ' --sgg-base-font-style: ' . $base_font_style . ';';
		$style .= ' --sgg-heading-font: ' . $heading_font . ';';
		$style .= ' --sgg-heading-font-weight: ' . $heading_font_weight . ';';
		$style .= ' --sgg-heading-font-style: ' . $heading_font_style . ';';
		$style .= ' --sgg-button-font: ' . $button_font . ';';
		$style .= ' --sgg-button-font-weight: ' . $button_font_weight . ';';
		$style .= ' --sgg-button-font-style: ' . $button_font_style . ';';

		/**
		 * Font Sizes.
		 */

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_custom_font_sizes' ) ) {
			$base_font_size = staggs_get_post_meta( $theme_id, 'sgg_font_size' ) ?: '16px';
			$base_font_size_tb = staggs_get_post_meta( $theme_id, 'sgg_font_size_tb' ) ?: '16px';
			$base_font_size_mb = staggs_get_post_meta( $theme_id, 'sgg_font_size_mb' ) ?: '16px';

			$heading_font_size = staggs_get_post_meta( $theme_id, 'sgg_heading_font_size' ) ?: '19px';
			$heading_font_size_tb = staggs_get_post_meta( $theme_id, 'sgg_heading_font_size_tb' ) ?: '17px';
			$heading_font_size_mb = staggs_get_post_meta( $theme_id, 'sgg_heading_font_size_mb' ) ?: '17px';

			$button_font_size = staggs_get_post_meta( $theme_id, 'sgg_button_font_size' ) ?: '18px';
			$button_font_size_tb = staggs_get_post_meta( $theme_id, 'sgg_button_font_size_tb' ) ?: '16px';
			$button_font_size_mb = staggs_get_post_meta( $theme_id, 'sgg_button_font_size_mb' ) ?: '16px';
		} else {
			$base_font_size = '16px';
			$base_font_size_tb = '16px';
			$base_font_size_mb = '14px';
	
			$heading_font_size = '19px';
			$heading_font_size_tb = '17px';
			$heading_font_size_mb = '17px';

			$button_font_size = '18px';
			$button_font_size_tb = '16px';
			$button_font_size_mb = '16px';
		}

		$style .= ' --sgg-base-font-size: ' . $base_font_size . ';';
		$style .= ' --sgg-base-font-size-tb: ' . $base_font_size_tb . ';';
		$style .= ' --sgg-base-font-size-mb: ' . $base_font_size_mb . ';';
		$style .= ' --sgg-heading-font-size: ' . $heading_font_size . ';';
		$style .= ' --sgg-heading-font-size-tb: ' . $heading_font_size_tb . ';';
		$style .= ' --sgg-heading-font-size-mb: ' . $heading_font_size_mb . ';';
		$style .= ' --sgg-button-font-size: ' . $button_font_size . ';';
		$style .= ' --sgg-button-font-size-tb: ' . $button_font_size_tb . ';';
		$style .= ' --sgg-button-font-size-mb: ' . $button_font_size_mb . ';';
		$style .= ' }';

		/**
		 * Custom CSS.
		 */

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_css' ) ) {
			$style .= staggs_get_post_meta( $theme_id, 'sgg_configurator_css' );
		}

		if ( staggs_get_theme_option( 'sgg_custom_css' ) ) {
			$style .= staggs_get_theme_option( 'sgg_custom_css' );
		}

		$style = apply_filters( 'staggs_public_style', $style );

		if ( ( is_plugin_active( 'breakdance/plugin.php' ) && $sgg_is_shortcode ) || wp_is_block_theme() ) {
			echo '<style type="text/css">' . esc_attr( $style ) . '</style>';
		} else {
			return $style;
		}
	}

	/**
	 * Register the configurator inline JavaScript for the public-facing side of the site.
	 *
	 * @since    1.3.0
	 */
	public function enqueue_font_scripts() {
		global $sgg_is_shortcode, $sgg_shortcode_id;
        
        if ( $sgg_is_shortcode ) {
        	$theme_id = staggs_get_theme_id( $sgg_shortcode_id );
        } else {    
	        $theme_id = staggs_get_theme_id();
        }

		global $sanitized_steps;
		if ( isset( $sanitized_steps ) && count( $sanitized_steps ) > 0 ){
			foreach ( $sanitized_steps as $group ) {
				// Check if configuration contains fonts.
				if ( ! isset( $group['options'] ) || ! is_array( $group['options'] ) || count( $group['options'] ) < 1 || $group['options'][0]['type'] !== 'font' ) {
					continue;
				}

				if ( isset( $group['options'] ) && is_array( $group['options'] ) ) {
					/**
					 * Parent options
					 */
					foreach ( $group['options'] as $option ) {
						if ( 'font' === $option['type'] && isset( $option['font_source'] ) ) {
							echo '<link rel="stylesheet" crossorigin="anonymous" href="' . esc_url( $option['font_source'] ) . '">';
						}
					}
				} else if ( isset( $group['attributes'] ) && is_array( $group['attributes'] ) ) {
					/**
					 * Repeater options
					 */
					foreach ( $group['attributes'] as $sub_group ) {
						if ( isset( $sub_group['options'] ) && is_array( $sub_group['options'] ) ) {
							foreach ( $sub_group['options'] as $sub_option ) {
								if ( 'font' === $sub_option['type'] && isset( $sub_option['font_source'] ) ) {
									echo '<link rel="stylesheet" crossorigin="anonymous" href="' . esc_url( $sub_option['font_source'] ) . '">';
								}
							}
						} 
					}
				}
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_header_scripts' ) ) {
			echo wp_kses( 
				staggs_get_post_meta( $theme_id, 'sgg_header_scripts' ),
				array(
					'link' => array(
						'rel' => true,
						'crossorigin' => true,
						'href' => true,
					),
					'style' => array(
						'id' => true,
						'type' => true,
					),
					'script' => array(
						'crossorigin' => true,
						'src' => true,
					),
				)
			);
		}
	}

	/**
	 * Register the configurator inline JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_inline_scripts() {
		global $product, $staggs_price_settings, $sgg_is_shortcode, $sgg_shortcode_id;
		
		if ( ! $staggs_price_settings ) {
			staggs_define_price_settings();
		}

        if ( $sgg_is_shortcode ) {
        	$theme_id = staggs_get_theme_id( $sgg_shortcode_id );
        } else {    
	        $theme_id = staggs_get_theme_id();
        }

		$price = 0;
		$altprice = 0;
		$inc_price_label = '';
		$weight_unit = get_option( 'woocommerce_weight_unit' ) ?: 'kg';
		$weight_value = 0;
		$tax_value = 0;

		if ( staggs_get_post_meta( $theme_id, 'sgg_step_set_included_option_text' ) ) {
			$inc_price_label = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_included_text' ) );
		}

		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			if ( ! is_object( $product ) ) {
				$product = wc_get_product( get_the_ID() );
			}

			if ( is_object( $product ) ) {
				$altprice = $product->get_regular_price();

				if ( $product->is_on_sale() ) {
					$price = $product->get_sale_price();
				} else {
					$price = $product->get_regular_price();
				}

				if ( 'yes' === get_option( 'woocommerce_calc_taxes' ) ) {
					// Take only the item rate and round it. 
					$tax = new WC_Tax();
					$taxes = $tax->get_rates($product->get_tax_class());
					if ( $taxes && is_array($taxes)) {
						$rates = array_shift($taxes);
						if ( is_array( $rates ) ) {
							$tax_value = round(array_shift($rates));
						}
					}

					if ( 'no' === $staggs_price_settings['include_tax'] && 'incl' === $staggs_price_settings['price_display'] ) {
						$altprice = wc_get_price_including_tax( $product, array( 'price' => $altprice ) );
						$price = wc_get_price_including_tax( $product, array( 'price' => $price ) );
					} else if ( 'yes' === $staggs_price_settings['include_tax'] && 'excl' === $staggs_price_settings['price_display'] ) {
						$altprice = wc_get_price_excluding_tax( $product, array( 'price' => $altprice ) );
						$price = wc_get_price_excluding_tax( $product, array( 'price' => $price ) );
					}
				}
			}
			
			$weight_value = $product->get_weight() ?: 0;
	
			$cart_url = wc_get_cart_url();
			$cart_redirect = get_option( 'woocommerce_cart_redirect_after_add' );
			// Add to cart redirect plugin support.
			if ( is_plugin_active( 'woocommerce-direct-checkout/woocommerce-direct-checkout.php' ) ) {
				if ( get_option( 'qlwcdc_add_to_cart_redirect_page' ) && 'checkout' == get_option( 'qlwcdc_add_to_cart_redirect_page' ) ) {
					$cart_url = wc_get_checkout_url();
					$cart_redirect = 'yes';
				}
			}
		} else {
			$cart_redirect   = '';
			$cart_url        = '';

			$price = staggs_get_post_meta( get_the_ID(), 'sgg_product_regular_price' ) ?: 0;
			$altprice = $price;
			if ( '' !== staggs_get_post_meta( get_the_ID(), 'sgg_product_sale_price' ) ) {
				$price = staggs_get_post_meta( get_the_ID(), 'sgg_product_sale_price' );
			}
		}

		$currency_symbol = $staggs_price_settings['currency_symbol'];
		$currency_pos    = $staggs_price_settings['currency_pos'];
		$thousand_sep    = $staggs_price_settings['thousand_sep'];
		$decimal_sep     = $staggs_price_settings['decimal_sep'];
		$decimal_num     = $staggs_price_settings['decimal_num'];

		$tax_label = sgg__( staggs_get_theme_option( 'sgg_product_tax_label' ) ) ?: '';
		$alt_tax_label = sgg__( staggs_get_theme_option( 'sgg_product_alt_tax_label' ) ) ?: '';
		$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
		if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
			$display_price = 'hide';
		}

		$summary_message  = staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_empty_message' );
		$invalid_message  = staggs_get_theme_option( 'sgg_product_invalid_error_message' );
		$required_message = staggs_get_theme_option( 'sgg_product_required_error_message' );
		$invalid_field_message  = staggs_get_theme_option( 'sgg_product_invalid_field_message' );
		$required_field_message = staggs_get_theme_option( 'sgg_product_required_field_message' );
		if ( '' == $summary_message ) {
			$summary_message ='No options selected';
		}
		if ( '' == $invalid_message ) {
			$invalid_message = 'Please make sure all fields are filled out correctly!';
		}
		if ( '' == $required_message ) {
			$required_message = 'Please fill out all required fields!';
		}
		if ( '' == $invalid_field_message ) {
			$invalid_field_message = 'This field is invalid.';
		}
		if ( '' == $required_field_message ) {
			$required_field_message = 'This field is required.';
		}

		$share_notice_label  = staggs_get_theme_option( 'sgg_product_share_notice_label' );
		$share_notice_button = staggs_get_theme_option( 'sgg_product_share_notice_button' );
		$share_notice_copied = staggs_get_theme_option( 'sgg_product_share_notice_copied' );
		if ( '' == $share_notice_label ) {
			$share_notice_label = 'Configuration succesfully saved';
		}
		if ( '' == $share_notice_button ) {
			$share_notice_button = 'Copy Link';
		}
		if ( '' == $share_notice_copied ) {
			$share_notice_copied = 'Copied!';
		}

		$wishlist_notice_page_url = esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '/my-configurations/' );
		$wishlist_notice_label    = staggs_get_theme_option( 'sgg_product_wishlist_notice' );
		$wishlist_notice_button   = staggs_get_theme_option( 'sgg_product_wishlist_button' );
		if ( '' == $wishlist_notice_label ) {
			$wishlist_notice_label = 'Configuration succesfully added to "My Configurations"';
		}
		if ( '' == $wishlist_notice_button ) {
			$wishlist_notice_button = 'View my configurations';
		}

		$sgg_loader_icon = staggs_get_icon( 'sgg_loader_icon', 'loader' );
		$price_sign = '';
		if ( staggs_get_theme_option( 'sgg_product_additional_price_sign' ) ) {
			$price_sign = '<span class="sign">+</span>';
		}		

		$image_scale = 1;
		$image_scale_tb = 1.5;
		$image_scale_mb = 2;
		if ( staggs_get_theme_option( 'sgg_desktop_image_capture_scale' ) ) {
			$image_scale = staggs_get_theme_option( 'sgg_desktop_image_capture_scale' );
		}
		if ( staggs_get_theme_option( 'sgg_tablet_image_capture_scale' ) ) {
			$image_scale_tb = staggs_get_theme_option( 'sgg_tablet_image_capture_scale' );
		}
		if ( staggs_get_theme_option( 'sgg_mobile_image_capture_scale' ) ) {
			$image_scale_mb = staggs_get_theme_option( 'sgg_mobile_image_capture_scale' );
		}

		$product_ignore_attr_ids = apply_filters( 'staggs_ignore_attribute_ids', '' );
		$product_attribute_display = 'label_value';
		if ( staggs_get_theme_option( 'sgg_product_attribute_value_display' ) ) {
			$product_attribute_display = staggs_get_theme_option( 'sgg_product_attribute_value_display' );
		}

		$script = array(
			"AJAX_URL" => admin_url('/admin-ajax.php'),
			"PRODUCT_ID" => get_the_ID(),
			"PRODUCT_NAME" => get_the_title(get_the_ID()),
			"PRODUCT_PRICE" => floatval( $price ),
			"PRODUCT_ALT_PRICE" => floatval( $altprice ),
			"USE_PRODUCT_PRICE" => staggs_get_theme_option('sgg_product_exclude_base_price') ? false : true,
			"SHOW_PRODUCT_PRICE" => $display_price === 'hide' ? false : true,
			"SHOW_PRODUCT_SALE_PRICE" => staggs_get_theme_option('sgg_product_price_hide_sale_price') ? false : true,
			"SHOW_PRICE_DIFFERENCE" => staggs_get_theme_option('sgg_product_price_show_difference_only') ? true : false,
			"BASE_UNIT_MIN_VAL" => staggs_get_theme_option('sgg_product_price_unit_min_based') ? true : false,
			"PRODUCT_PRICE_SIGN" => wp_kses_post($price_sign),
			"DISABLE_PRODUCT_PRICE_UPDATE" => staggs_get_post_meta($theme_id, 'sgg_configurator_disable_product_price_update') ? true : false,
			"PRODUCT_THUMBNAIL_URL" => wp_get_attachment_image_url(get_post_thumbnail_id()),
			"USE_PRODUCT_THUMBNAIL" => staggs_get_post_meta($theme_id, 'sgg_use_product_image') ? true : false,
			"POPUP_UPDATE_PAGE" => staggs_get_post_meta($theme_id, 'sgg_configurator_button_close_popup') ? true : false,
			"DISABLE_DEFAULTS" => staggs_get_post_meta($theme_id, 'sgg_step_disable_default_option') ? true : false,
			"ALLOW_UNCHECK_DEFAULTS" => staggs_get_theme_option('sgg_step_allow_uncheck_default_option') ? true : false,
			"KEEP_CONDITIONAL_OPTIONS" => staggs_get_theme_option('sgg_product_show_invalid_conditional_options') ? true : false,
			"SELECT_MENU_MOBILE" => staggs_get_theme_option('sgg_product_dropdown_disable_mobile_ui') ? true : false,
			"CAPTURE_PREVIEW_IMAGE" => staggs_get_post_meta($theme_id, 'sgg_configurator_generate_cart_image') ? true : false,
			"CURRENCY_SYMBOL" => html_entity_decode($currency_symbol),
			"CURRENCY_POS" => $currency_pos,
			"THOUSAND_SEPARATOR" => $thousand_sep,
			"DECIMAL_SEPARATOR" => $decimal_sep,
			"NUMBER_OF_DECIMALS" => $decimal_num,
			"TRIM_PRICE_DECIMALS" => staggs_get_theme_option('sgg_product_price_trim_decimals') ? true : false,
			"REDIRECT_TO_CART" => $cart_redirect,
			"CART_URL" => $cart_url,
			"INC_PRICE_LABEL" => $inc_price_label,
			"TAX_PRICE_SUFFIX" => $tax_label,
			"ALT_TAX_PRICE_SUFFIX" => $alt_tax_label,
			"PRODUCT_TAX_DISPLAY" => $staggs_price_settings['price_display'],
			"PRODUCT_TAX" => floatval( $tax_value ),
			"TRACK_OPTIONS" => staggs_get_theme_option('sgg_product_track_conditional_values') ? true : false,
			"TRACK_GLOBAL_OPTIONS" => staggs_get_theme_option('sgg_product_track_global_conditional_values') ? true : false,
			"IMAGE_STACK" => staggs_get_post_meta($theme_id, 'sgg_preview_image_type') === 'stacked',
			"MOBILE_HEADER_HEIGHT" => staggs_get_post_meta($theme_id, 'sgg_configurator_fixed_header_height'),
			"REQUIRED_MESSAGE" => sgg__($required_message),
			"INVALID_MESSAGE" => sgg__($invalid_message), 
			"REQUIRED_FIELD_MESSAGE" => sgg__($required_field_message),
			"INVALID_FIELD_MESSAGE" => sgg__($invalid_field_message),
			"EMPTY_SUMMARY_MESSAGE" => sgg__($summary_message),
			"SINGLE_ERROR_MESSAGE" => !staggs_get_theme_option('sgg_product_show_individual_error_messages'),
			"SUMMARY_SHOW_NOTES" => (bool)staggs_get_post_meta($theme_id, 'sgg_configurator_summary_include_notes'),
			"SUMMARY_SHOW_PRICES" => (bool)staggs_get_post_meta($theme_id, 'sgg_configurator_summary_include_prices'),
			"SUMMARY_SINGLE_TITLE" => (bool)staggs_get_theme_option('sgg_product_summary_hide_duplicate_titles'),
			"DISABLE_URL_CLICK" => staggs_get_theme_option('sgg_product_url_option_disable_click') ? true : false,
			"COPY_NOTICE_MESSAGE" => sgg__($share_notice_label),
			"COPY_NOTICE_BUTTON_TEXT" => sgg__($share_notice_button),
			"COPY_NOTICE_BUTTON_COPIED" => sgg__($share_notice_copied),
			"WISHLIST_PAGE_URL" => $wishlist_notice_page_url,
			"WISHLIST_NOTICE_MESSAGE" => sgg__($wishlist_notice_label),
			"VIEW_WISHLIST_BUTTON_TEXT" => sgg__($wishlist_notice_button),
			"STEPPER_DISABLE_SCROLL_TOP" => staggs_get_post_meta($theme_id, 'sgg_configurator_step_disable_scroll_top') ? true : false,
			"DISABLE_MESSAGE_WRAPPER" => staggs_get_post_meta($theme_id, 'sgg_configurator_disable_floating_notice') ? true : false,
			"SGG_LOADER_ICON" => $sgg_loader_icon,
			"PRODUCT_WEIGHT_UNIT" => $weight_unit,
			"PRODUCT_WEIGHT" => floatval( $weight_value ),
			"PRODUCT_ATTR_DISPLAY" => $product_attribute_display,
			"IGNORE_ATTR_IDS" => $product_ignore_attr_ids,
			"CAP_IMAGE_SCALE" => floatval( $image_scale ),
			"CAP_IMAGE_SCALE_TB" => floatval( $image_scale_tb ),
			"CAP_IMAGE_SCALE_MB" => floatval( $image_scale_mb ),
		);

		$js_vars = sprintf('var %s;', implode(';var ', array_map(
			function($key, $value) {
				return $key . '=' . wp_json_encode($value);
			},
			array_keys($script),
			$script
		)));
		
		if ((is_plugin_active('breakdance/plugin.php') || wp_is_block_theme()) && $sgg_is_shortcode) {
			printf('<script type="text/javascript">%s</script>', $js_vars);
		} else {
			return $js_vars;
		}
	}

	/**
	 * Loads the main template for the configurator.
	 *
	 * @since    1.0.0
	 */
	public function load_main_template( $templates, $template_name ) {
		// Capture/cache the $template_name which is a file name like single-product.php
		wp_cache_set( 'staggs_wc_main_template', $template_name ); // cache the template name
		return $templates;
	}

	/**
	 * Utilizes the main configurator template when applicable for the given product.
	 *
	 * @since    1.0.0
	 */
	public function include_main_template( $template ) {
		// Check if configurable product
		$is_configurable = ( get_post_meta( get_the_ID(), 'is_configurable', true ) === 'yes' );
		if ( ! $is_configurable ) {
			return $template;
		}

		if ( post_password_required() && ! is_user_logged_in() ) {
			return $template;
		}

		// Don't override default WooCommerce template.
		if ( staggs_get_post_meta( staggs_get_theme_id(), 'sgg_configurator_disable_template_override' ) ) {
			return $template;
		}

		// Custom template. No shortcode.
		global $sgg_is_shortcode;
		$sgg_is_shortcode = false;

		if ( $template_name = wp_cache_get( 'staggs_wc_main_template' ) ) {
			wp_cache_delete( 'staggs_wc_main_template' ); // delete the cache

			if ( file_exists( STAGGS_BASE . 'woocommerce/' . $template_name ) ) {
				return apply_filters( 'staggs_template_main', STAGGS_BASE . 'woocommerce/' . $template_name );
			}
		} 

		return $template;
	}

	/**
	 * Utilizes the main configurator template when applicable for the given post type.
	 *
	 * @since    1.5.3
	 */
	public function include_single_product_template( $template ) {
		if ( 'sgg_product' !== get_post_type() ) {
			return $template;
		}

		if ( post_password_required() && ! is_user_logged_in() ) {
			return $template;
		}

		$template_name = 'single-product.php';
		if ( file_exists( STAGGS_BASE . 'woocommerce/' . $template_name ) ) {
			return apply_filters( 'staggs_template_main', STAGGS_BASE . 'woocommerce/' . $template_name );
		}

		return $template;
	}

	/**
	 * Check if the provided shortcode can be used.
	 * 
	 * @since 1.5.0
	 */
	private function can_use_shortcode( $atts ) {
		// Run shortcode check so we shortcode.
		global $sgg_is_shortcode;
		$sgg_is_shortcode = false;

		// Admin page.
		if ( is_admin() ) {
			return array( 'valid' => false, 'note' => '' );
		}

		// Admin update request.
		if ( strpos( $_SERVER['REQUEST_URI'], '/wp-json/' ) !== false ) {
			return array( 'valid' => false, 'note' => '' );
		}

		// Not on product page and no product ID set.
		if ( ! isset( $atts['product_id'] ) && 'product' !== get_post_type() && 'sgg_product' !== get_post_type() ) {
			return array(
				'valid' => false,
				'note' => __( 'Please provide a product ID using the "product_id" option or output the shortcode on a product page.', 'staggs')
			);
		}

		// Check if current or provided product is a configurable product.
		global $sgg_shortcode_id;
		$sgg_shortcode_id = isset( $atts['product_id'] ) ? sanitize_key( $atts['product_id'] ) : get_the_ID();
		$sgg_is_shortcode = true;

		if ( ! product_is_configurable( $sgg_shortcode_id ) && 'sgg_product' !== get_post_type( $sgg_shortcode_id ) ) {
			return array(
				'valid' => false,
				'note' => __( 'This shortcode can only be used for configurable products. Make sure you have checked the box "Enable Staggs Product Configurator".', 'staggs')
			);
		}

		return array( 'valid' => true, 'note' => '' );
	}
}