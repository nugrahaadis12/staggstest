<?php
/**
 * Assets class
 *
 * @package MT_Addons_Slider
 */
namespace MT_Addons\includes;

defined( 'ABSPATH' ) || die();

class MT_Addons_Slider_Assets {

    function __construct() {
        add_action( "elementor/frontend/after_enqueue_styles", [$this, 'register_styles'] );
        add_action( "elementor/frontend/after_register_scripts", [$this, 'register_scripts'], 100 );
    }


    /**
     * Register styles
     *
     * @return void
     */
    public function register_styles() {
        $min = ( WP_DEBUG === true ) ? '' : '.min';
        wp_register_style( 'splitting', MT_ADDONS_SLIDER_ASSETS . '/css/lib/splitting.min.css', false, '1.0' );
        wp_register_style( 'mtaddons-slider-style', MT_ADDONS_SLIDER_ASSETS . '/css/widgets/slider' . $min . '.css', false, '1.0.2' );
    }

    /**
     * Register Scripts
     *
     * @return void
     */
    public function register_scripts() {
        $min = ( WP_DEBUG === true ) ? '' : '.min';
        wp_register_script( 'splitting', MT_ADDONS_SLIDER_ASSETS . '/js/lib/splitting.min.js', [], '1.0', true );
        wp_register_script( 'mtaddons-slider-script', MT_ADDONS_SLIDER_ASSETS . '/js/slider'. $min .'.js', ['jquery', 'elementor-frontend'], '1.0.2', true );
    }

}