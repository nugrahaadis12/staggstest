<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class MT_Addons_Dash_Admin {


    protected $plugin_slug = 'mt_addons';

    public function __construct() {

        $this->includes();
        $this->init_hooks();

    }

    public function includes() {

        // load class admin ajax function
        require_once plugin_dir_path( __FILE__ ) . 'admin-ajax.php';

    }

    public function init_hooks() {

        // Build admin menu/pages
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

        // Load admin style sheet and JavaScript.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        add_action('current_screen', array($this, 'remove_admin_notices'));

    }

    public function remove_admin_notices($screen) {

        // If this screen is Addons for Elementor plugin options page, remove annoying admin notices
        if (strpos($screen->id, $this->plugin_slug) !== false && strpos($screen->id, $this->plugin_slug . '_license') === false) {
            add_action('admin_notices', array(&$this, 'remove_notices_start'));
            add_action('admin_notices', array(&$this, 'remove_notices_end'), 999);
        }
    }

    public function remove_notices_start() {

        // Turn on output buffering
        ob_start();

    }

    public function remove_notices_end() {

        // Get current buffer contents and delete current output buffer
        $content = ob_get_contents();
        ob_clean();

    }

    public function add_plugin_admin_menu() {

        add_menu_page(
            esc_html__('MT Addons for Elementor', 'mt-addons'),
            esc_html__('MT Addons', 'mt-addons'),
            'manage_options',
            $this->plugin_slug,
            array($this, 'display_settings_page'),
            MT_ADDONS_PLUGIN_URL.'admin/dashboard/assets/images/logo-icon.png',
            10
        );

        add_submenu_page(
            $this->plugin_slug,
            esc_html__('Widgets', 'mt-addons'),
            esc_html__('Widgets', 'mt-addons'),
            'manage_options',
            $this->plugin_slug,
            array($this, 'display_settings_page')
        );

    }


    public function display_settings_page() {
        require_once('views/banner.php');
        require_once('views/settings.php');
    }

    public function enqueue_admin_scripts() {

        // Use minified libraries if MTFE_SCRIPT_DEBUG is turned off
        $suffix = (defined('MTFE_SCRIPT_DEBUG') && MTFE_SCRIPT_DEBUG) ? '' : '.min';

        // get current admin screen
        $screen = get_current_screen();

        // If screen is a part of Addons for Elementor plugin options page
        if (strpos($screen->id, $this->plugin_slug) !== false) {

            wp_register_style('mt-addons-dash-styles', plugins_url( '/', __FILE__ ) . 'assets/css/mt-addons-dash.css', array());
            wp_enqueue_style('mt-addons-dash-styles');

            wp_register_script('mt-addons-dash-scripts', plugins_url( '/', __FILE__ ) . 'assets/js/mt-addons-dash' . $suffix . '.js', array(),  true);
            wp_enqueue_script('mt-addons-dash-scripts');
            
        }

        wp_register_style('mt-addons-dash-page-styles', plugins_url( '/', __FILE__ ) . 'assets/css/mt-addons-dash-page.css', array());
        wp_enqueue_style('mt-addons-dash-page-styles');

    }

}

new MT_Addons_Dash_Admin;