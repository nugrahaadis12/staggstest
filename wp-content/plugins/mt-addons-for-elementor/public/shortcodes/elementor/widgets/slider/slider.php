<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once('includes/ContentControl.php');
require_once('includes/class-assets.php');
require_once('includes/class-elementor.php');
require_once('includes/class-helper.php');

/**
 * The main plugin class
 */
final class MT_Addons_Slider {

    private function __construct() {
        $this->define_constants();

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \MT_Addons_Slider
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'MT_ADDONS_SLIDER_FILE', __FILE__ );
        define( 'MT_ADDONS_SLIDER_PATH', __DIR__ );
        define( 'MT_ADDONS_SLIDER_URL', plugins_url( '', MT_ADDONS_SLIDER_FILE ) );
        define( 'MT_ADDONS_SLIDER_ASSETS', MT_ADDONS_SLIDER_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        if ( is_admin() ) {
            new \MT_Addons\includes\MT_Addons_Slider_Elementor();
        }
        new \MT_Addons\includes\MT_Addons_Slider_Assets();
    }

}

function MT_ADDONS_SLIDER_init() {
    return MT_Addons_Slider::init();
}

MT_ADDONS_SLIDER_init();
