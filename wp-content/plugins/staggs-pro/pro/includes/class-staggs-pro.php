<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://staggs.app
 * @since      1.0.0
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_PRO {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Staggs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'STAGGS_VERSION' ) ) {
			$this->version = STAGGS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'staggs';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Staggs_Loader. Orchestrates the hooks of the plugin.
	 * - Staggs_i18n. Defines internationalization functionality.
	 * - Staggs_Admin. Defines all hooks for the admin area.
	 * - Staggs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . '../includes/class-staggs-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/staggs-pro-functions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staggs-pdf.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staggs-importer.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staggs-exporter.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-staggs-wishlist.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/woocommerce/class-staggs-cart-pro.php';

		/**
		 * The classes responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-staggs-admin-pro.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-staggs-tools.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-staggs-acf-fields-pro.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-staggs-carbon-fields-pro.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/staggs-pro-template-functions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/staggs-pro-template-hooks.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-staggs-public-pro.php';

		$this->loader = new Staggs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Staggs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Staggs_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		/**
		 * Admin hooks.
		 */
		$plugin_admin = new Staggs_Admin_PRO( $this->get_plugin_name(), $this->get_version() );

		/**
		 * Allow GBL uploads
		 */
		$this->loader->add_filter( 'upload_mimes', $plugin_admin, 'modify_upload_mime_types' );
		$this->loader->add_filter( 'wp_check_filetype_and_ext', $plugin_admin, 'modify_mime_type_file_checks', 10, 5 );

		$this->loader->add_action( 'admin_head-edit.php', $plugin_admin, 'display_attribute_tool_buttons' );

		/**
		 * Link PDF actions
		 */
		$this->loader->add_action( 'init', $plugin_admin, 'ajax_do_pdf_download' );

		/**
		 * Plugin Admin Fields hooks.
		 */

		if ( defined( 'STAGGS_ACF' ) ) {

			$plugin_fields = new Staggs_ACF_Fields_PRO();

			$this->loader->add_action( 'acf/include_fields', $plugin_fields, 'sgg_load_field_groups' );

			$this->loader->add_action( 'acf/load_field/name=sgg_option_linked_product_id', $plugin_fields, 'sgg_load_simple_product_options' );
			
			$this->loader->add_action( 'acf/load_field/name=sgg_step_conditional_step', $plugin_fields, 'sgg_load_staggs_configurable_attributes' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_conditional_input', $plugin_fields, 'sgg_load_staggs_configurable_inputs' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_conditional_value', $plugin_fields,'sgg_load_staggs_configurable_options' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_tab_attribute', $plugin_fields, 'sgg_load_staggs_configurable_attributes' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_attribute_value', $plugin_fields, 'sgg_load_staggs_configurable_options' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_conditional_option', $plugin_fields, 'sgg_load_staggs_configurable_options' );

			$this->loader->add_action( 'acf/load_field/name=sgg_global_attribute', $plugin_fields, 'sgg_load_staggs_configurable_attributes' );
			$this->loader->add_action( 'acf/load_field/name=sgg_global_conditional_step', $plugin_fields, 'sgg_load_staggs_configurable_attributes' );
			$this->loader->add_action( 'acf/load_field/name=sgg_global_conditional_input', $plugin_fields, 'sgg_load_staggs_configurable_inputs' );
			$this->loader->add_action( 'acf/load_field/name=sgg_global_conditional_value', $plugin_fields, 'sgg_load_staggs_configurable_options' );
			$this->loader->add_action( 'acf/load_field/name=sgg_global_conditional_option', $plugin_fields, 'sgg_load_staggs_configurable_options' );

			$this->loader->add_action( 'acf/load_field/name=sgg_configurator_total_price_table', $plugin_fields, 'sgg_load_tablepress_tables' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_price_table', $plugin_fields, 'sgg_load_tablepress_tables' );
			$this->loader->add_action( 'acf/load_field/name=sgg_step_price_table_sale', $plugin_fields, 'sgg_load_tablepress_tables' );
			$this->loader->add_action( 'acf/load_field/name=sgg_option_price_table', $plugin_fields, 'sgg_load_tablepress_tables' );
			$this->loader->add_action( 'acf/load_field/name=sgg_configurator_total_price_table', $plugin_fields, 'sgg_load_tablepress_tables' );

			$this->loader->add_action( 'acf/load_field/name=sgg_pdf_image_size', $plugin_fields, 'sgg_load_staggs_image_sizes' );

		}

		if ( ! defined( 'STAGGS_ACF' ) || defined( 'STAGGS_RUN_MIGRATE' ) || defined( 'STAGGS_RUN_IMPORT' ) ) {

			$plugin_fields = new Staggs_Carbon_Fields_PRO();

			$this->loader->add_action( 'after_setup_theme', $plugin_fields, 'sgg_load' );
			$this->loader->add_action( 'carbon_fields_register_fields', $plugin_fields, 'sgg_attribute_fields' );
			$this->loader->add_action( 'carbon_fields_register_fields', $plugin_fields, 'sgg_appearance_page_options' );
			$this->loader->add_action( 'carbon_fields_register_fields', $plugin_fields, 'sgg_configurator_template_block' );
			$this->loader->add_action( 'carbon_fields_register_fields', $plugin_fields, 'sgg_init_product_configurator_options' );

			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$this->loader->add_action( 'carbon_fields_register_fields', $plugin_fields, 'sgg_product_fields' );
			}	
		}

		/**
		 * Plugin Tools page hooks.
		 */

		$plugin_importer = new Staggs_Importer();
		$plugin_exporter = new Staggs_Exporter();

		$plugin_tools = new Staggs_Tools( $plugin_importer, $plugin_exporter );

		$this->loader->add_action( 'admin_menu', $plugin_tools, 'register_sub_menu', 999 );
		$this->loader->add_action( 'admin_notices', $plugin_tools, 'display_import_notices' );

		$this->loader->add_action( 'admin_post_sgg_handle_product_generate', $plugin_tools, 'process_generate_form' );

		$this->loader->add_action( 'admin_post_sgg_handle_attribute_import', $plugin_tools, 'process_attribute_import_form' );
		$this->loader->add_action( 'admin_post_sgg_handle_attribute_export', $plugin_tools, 'process_attribute_export_form' );

		/**
		 * Plugin PDF hooks.
		 */
		$plugin_pdf = new Staggs_PDF();

		$this->loader->add_action( 'staggs_generate_pdf', $plugin_pdf, 'generate_pdf', 10, 2 );

		$this->loader->add_action( 'wp_ajax_nopriv_staggs_download_configuration_pdf', $plugin_pdf, 'download_pdf_result_ajax' );
		$this->loader->add_action( 'wp_ajax_staggs_download_configuration_pdf', $plugin_pdf, 'download_pdf_result_ajax' );

		$this->loader->add_action( 'wp_ajax_nopriv_staggs_get_configuration_pdf_url', $plugin_pdf, 'get_pdf_file_url_ajax' );
		$this->loader->add_action( 'wp_ajax_staggs_get_configuration_pdf_url', $plugin_pdf, 'get_pdf_file_url_ajax' );

		if ( defined( 'STAGGS_ACF' ) ) {
			$this->loader->add_action( 'after_setup_theme', $plugin_pdf, 'sgg_load_pdf' );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Staggs_Public_PRO( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 99 );
		$this->loader->add_filter( "script_loader_tag", $plugin_public, "add_module_to_scripts", 10, 3 );

		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {	
			$plugin_wishlist = new Staggs_Wishlist();
		}

		/**
		 * Plugin WooCommerce cart hooks.
		 */

		$plugin_cart = new Staggs_Cart_PRO();

		$this->loader->add_action( 'woocommerce_after_cart_item_quantity_update', $plugin_cart, 'staggs_add_to_cart_qty_validation', 10, 4 );
		$this->loader->add_filter( 'woocommerce_cart_item_permalink', $plugin_cart, 'staggs_modify_cart_link' , 10, 3 );

		$this->loader->add_action( 'woocommerce_thankyou', $plugin_cart, 'update_stock_status_on_thankyou_page', 10, 1 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Staggs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
