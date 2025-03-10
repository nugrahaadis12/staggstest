<?php
/**
 *
 * @package MT_Addons_Slider
 */
namespace MT_Addons\includes;

defined( 'ABSPATH' ) || die();

class MT_Addons_Slider_Elementor {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'elementor/init', [ $this, 'elementor_init' ] );
    }

    /**
     * Elementor Init
     */
    public function elementor_init(){
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'mt-addons',
            [
                'title'  => esc_html__( 'MT - Slider', 'mt-addons'),
                'icon' => 'eicon-slides'
            ],
            1
        );

    }
}
