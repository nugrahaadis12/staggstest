<?php

class Wildnest {

	static $_instance;
	static $version;
	static $theme_url;
	static $theme_name;
	static $theme_author;
	static $path;

	/**
	 * @var Wildnest_Customizer
	 */
	public $customizer = null;

	/**
	 * Add functions to hooks
	 */
	function init_hooks() {
		add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 95 );
	}

	/**
	 * Main Wildnest Instance.
	 *
	 * Ensures only one instance of Wildnest is loaded or can be loaded.
	 *
	 * @return Wildnest Main instance.
	 */
	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance    = new self();
			$theme              = wp_get_theme();
			self::$version      = $theme->get( 'Version' );
			self::$theme_url    = $theme->get( 'ThemeURI' );
			self::$theme_name   = $theme->get( 'Name' );
			self::$theme_author = $theme->get( 'Author' );
			self::$path         = get_template_directory();

			self::$_instance->init();
		}

		return self::$_instance;
	}

	/**
	 * Get data from method of property
	 *
	 * @param string $key
	 *
	 * @return bool|mixed
	 */
	function get( $key ) {
		if ( method_exists( $this, 'get_' . $key ) ) {
			return call_user_func_array( array( $this, 'get_' . $key ), array() );
		} elseif ( property_exists( $this, $key ) ) {
			return $this->{$key};
		}

		return false;
	}


	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'wildnest_content_width', 843 );
	}

	

	/**
	 * Get asset suffix `.min` or empty if WP_DEBUG enabled
	 *
	 * @return string
	 */
	function get_asset_suffix() {
		$suffix = '.min';
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$suffix = '';
		}

		return $suffix;
	}

	/**
	 * Get theme style.css url
	 *
	 * @return string
	 */
	function get_style_uri() {
		$suffix     = $this->get_asset_suffix();
		$style_dir  = get_template_directory();
		$suffix_css = $suffix;
		$css_file   = false;
		if ( is_rtl() ) {
			$suffix_css = '-rtl' . $suffix;
		}

		$min_file = $style_dir . '/style' . $suffix_css . '.css';
		if ( file_exists( $min_file ) ) {
			$css_file = esc_url( get_template_directory_uri() ) . '/style' . $suffix_css . '.css';
		}

		if ( ! $css_file ) {
			$css_file = get_stylesheet_uri();
		}

		return $css_file;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	function scripts() {

		if ( ! class_exists( 'Wildnest_Font_Icons' ) ) {
			require_once get_template_directory() . '/inc/builder/customizer/class-customizer-icons.php';
		}
		Wildnest_Font_Icons::get_instance()->enqueue();

		$suffix = $this->get_asset_suffix();

		do_action( 'wildnest/load-scripts' );

		$css_files = apply_filters(
			'wildnest/theme/css',
			array(
				'google-font' => Wildnest_Customizer_Auto_CSS::get_instance()->get_font_url(),
				'style'       => $this->get_style_uri(),
			)
		);

		$js_files = apply_filters(
			'wildnest/theme/js',
			array(
				'wildnest-theme' => array(
					'url' => esc_url( get_template_directory_uri() ) . '/assets/js/customizer/theme.js',
					'ver' => self::$version,
				),
			)
		);

		foreach ( $css_files as $id => $url ) {
			$deps = array();
			if ( is_array( $url ) ) {
				$arg = wp_parse_args(
					$url,
					array(
						'deps' => array(),
						'url'  => '',
						'ver'  => self::$version,
					)
				);
				wp_enqueue_style( 'wildnest-' . $id, $arg['url'], $arg['deps'], $arg['ver'] );
			} elseif ( $url ) {
				wp_enqueue_style( 'wildnest-' . $id, $url, $deps, self::$version );
			}
		}

		foreach ( $js_files as $id => $arg ) {
			$deps = array();
			$ver  = '';
			if ( is_array( $arg ) ) {
				$arg = wp_parse_args(
					$arg,
					array(
						'deps' => '',
						'url'  => '',
						'ver'  => '',
					)
				);

				$deps = $arg['deps'];
				$url  = $arg['url'];
				$ver  = $arg['ver'];
			} else {
				$url = $arg;
			}

			if ( ! $ver ) {
				$ver = self::$version;
			}

			wp_enqueue_script( $id, $url, $deps, $ver, true );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_add_inline_style( 'wildnest-style', Wildnest_Customizer_Auto_CSS::get_instance()->auto_css() );
		wp_localize_script(
			'wildnest-themejs',
			'Wildnest_JS',
			apply_filters( // phpcs:ignore
				'Wildnest_JS',
				array(
					'is_rtl'                     => is_rtl(),
					'css_media_queries'          => Wildnest_Customizer_Auto_CSS::get_instance()->media_queries,
					'sidebar_menu_no_duplicator' => Wildnest()->get_setting( 'header_sidebar_menu_no_duplicator' ),
				)
			)
		);

		do_action( 'wildnest/theme/scripts' );
	}

	function admin_scripts() {

	}

	private function includes() {
		$files = array(
			'/inc/builder/template-functions.php',
			'/inc/builder/customizer/class-customizer.php',
			'/inc/builder/panel-builder/class-panel-builder.php'
		);

		foreach ( $files as $file ) {
			require_once self::$path . $file;
		}

		$this->load_configs();
		$this->admin_includes();
	}

	/**
	 * Load admin files
	 *
	 * @since 0.0.1
	 * @since 0.2.6 Load editor style.
	 *
	 * @return void
	 */
	private function admin_includes() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Load configs
	 */
	private function load_configs() {

		$config_files = array(
			'404',
			'blog',
			'social-media',
			'general',
			'styling',
			'sidebars',
			// Header Builder Panel.
			'header/panel',
			'header/html',
			'header/separator',
			'header/logo',
			'header/nav-icon',
			'header/primary-menu',
			'header/burger-menu',
			'header/logo',
			'header/navigation',
			'header/navigation2',
			'header/navigation-mobile',
			'header/category-button',
			'header/search-icon',
			'header/search-box',
			'header/menus',
			'header/nav-icon',
			'header/button',
			'header/social-icons',
			'header/wishlist',
			'header/compare',
			'header/templates',
			'header/settings',
			// Footer Builder Panel.
			'footer/panel',
			'footer/widgets',
			'footer/copyright',
			'footer/social-icons',
			'footer/settings',
		);
		if ( class_exists( 'WooCommerce' ) ) {
			array_push($config_files,'header/my-account','header/my-cart','header/my-orders', 'woocommerce/catalog-designer');
		}
		if ( class_exists( 'WPCleverWoosc' ) && class_exists( 'WC_Product' ) ) {
			array_push($config_files,'header/compare');
		}
		if (class_exists( 'WPCleverWoosw' ) ) {
			array_push($config_files,'header/wishlist');
		}
		$path = get_template_directory();
		// Load default config values.
		require_once $path . '/inc/builder/customizer/configs/config-default.php';

		// Load site configs.
		foreach ( $config_files as $f ) {
			$file = $path . "/inc/builder/customizer/configs/{$f}.php";
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}

	}

	function init() {
		$this->init_hooks();
		$this->includes();
		$this->customizer = Wildnest_Customizer::get_instance();
		$this->customizer->init();
		do_action( 'wildnest/init' );
	}

	function get_setting( $id, $device = 'desktop', $key = null ) {
		return Wildnest_Customizer::get_instance()->get_setting( $id, $device, $key );
	}

	function get_media( $value, $size = null ) {
		return Wildnest_Customizer::get_instance()->get_media( $value, $size );
	}

	function get_setting_tab( $name, $tab = null ) {
		return Wildnest_Customizer::get_instance()->get_setting_tab( $name, $tab );
	}

	function get_post_types( $_builtin = true ) {
		if ( 'all' === $_builtin ) {
			$post_type_args = array(
				'publicly_queryable' => true,
			);
		} else {
			$post_type_args = array(
				'publicly_queryable' => true,
				'_builtin'           => $_builtin,
			);
		}

		$_post_types = get_post_types( $post_type_args, 'objects' );

		$post_types = array();

		foreach ( $_post_types as $post_type => $object ) {
			$post_types[ $post_type ] = array(
				'name'          => $object->label,
				'singular_name' => $object->labels->singular_name,
			);
		}

		return $post_types;
	}

}
