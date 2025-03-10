<?php

/**
 * 
 * Plugin Name:       MT Addons for Elementor
 * Plugin URI:        https://mt-addons.modeltheme.com/
 * Description:       MT Addons is one of the largest databases of Elementor Widgets. Can be used with Elementor Free or Pro.
 * Version:           1.0.8
 * Requires at least: 5.2
 * Tested up to:      6.5
 * Requires PHP:      7.0
 * Author:            Modeltheme
 * Author URI:        https://modeltheme.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mt-addons
 * Domain Path:       /languages
 * 
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// The free version should be deactivated if premium version is active and running
if ( function_exists( 'mtfe_fs' ) ) {
    mtfe_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'mtfe_fs' ) ) {
        // Create a helper function for easy SDK access.
        function mtfe_fs() {
            global $mtfe_fs;
            if ( !isset( $mtfe_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $mtfe_fs = fs_dynamic_init( array(
                    'id'             => '15091',
                    'slug'           => 'mt-addons-for-elementor',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_9ba44ea65e7f680a9d12195b1f204',
                    'is_premium'     => false,
                    'premium_suffix' => 'Premium',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                        'slug'       => 'mt_addons',
                        'first-path' => 'admin.php?page=mt_addons',
                        'support'    => false,
                    ),
                    'is_live'        => true,
                ) );
            }
            return $mtfe_fs;
        }

        // Init Freemius.
        mtfe_fs();
        // Signal that SDK was initiated.
        do_action( 'mtfe_fs_loaded' );
    }
    // ... Your plugin's main file logic ...
    DEFINE( 'MT_ADDONS_VERSION', '1.0.0' );
    DEFINE( 'MT_ADDONS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    DEFINE( 'MT_ADDONS_ASSETS', MT_ADDONS_PLUGIN_URL . 'assets/' );
    DEFINE( 'MT_ADDONS_PUBLIC_ASSETS', MT_ADDONS_PLUGIN_URL . 'public/' );
    DEFINE( 'MT_ADDONS_LIVE_URL', 'https://mt-addons.modeltheme.com/' );
    include_once 'admin/dashboard/admin-init.php';
    function mtfe_get_option(  $option_name, $default = null  ) {
        $settings = get_option( 'mtfe_settings' );
        if ( !empty( $settings ) && isset( $settings[$option_name] ) ) {
            $option_value = $settings[$option_name];
        } else {
            $option_value = $default;
        }
        return apply_filters(
            'mtfe_get_option',
            $option_value,
            $option_name,
            $default
        );
    }

    function mtfe_update_option(  $option_name, $option_value  ) {
        $settings = get_option( 'mtfe_settings' );
        if ( empty( $settings ) ) {
            $settings = array();
        }
        $settings[$option_name] = $option_value;
        update_option( 'mtfe_settings', $settings );
    }

    function mtfe_update_options(  $setting_data  ) {
        $settings = get_option( 'mtfe_settings' );
        if ( empty( $settings ) ) {
            $settings = array();
        }
        foreach ( $setting_data as $setting => $value ) {
            // because of get_magic_quotes_gpc()
            $value = stripslashes( $value );
            $settings[$setting] = $value;
        }
        update_option( 'mtfe_settings', $settings );
    }

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-mt-addons-activator.php
     */
    function mt_addons_activate() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-mt-addons-activator.php';
        MT_Addons_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-mt-addons-deactivator.php
     */
    function mt_addons_deactivate() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-mt-addons-deactivator.php';
        MT_Addons_Deactivator::deactivate();
    }

    register_activation_hook( __FILE__, 'mt_addons_activate' );
    register_deactivation_hook( __FILE__, 'mt_addons_deactivate' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-mt-addons.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0
     */
    function mt_addons_run() {
        $plugin = new MT_Addons();
        $plugin->run();
    }

    mt_addons_run();
    // number parameter
    include_once 'includes/helpers.elementor.php';
    include_once 'includes/ContentControlSlider.php';
    include_once 'includes/ContentControlHelp.php';
    include_once 'includes/ContentControlElementorIcon.php';
    //Elementor Widgets
    if ( is_plugin_active( 'elementor/elementor.php' ) ) {
        require_once 'public/shortcodes/elementor/functions-elementor.php';
    }
    /* ========= LIMIT POST CONTENT ===================================== */
    function mt_addons_excerpt_limit(  $string, $word_limit  ) {
        $words = explode( ' ', $string, $word_limit + 1 );
        if ( count( $words ) > $word_limit ) {
            array_pop( $words );
        }
        return implode( ' ', $words );
    }

    if ( !function_exists( 'mt_addons_kses_allowed_html' ) ) {
        function mt_addons_kses_allowed_html(  $tags, $context  ) {
            switch ( $context ) {
                case 'link':
                    $tags = array(
                        'a'   => array(
                            'href'                => array(),
                            'class'               => array(),
                            'title'               => array(),
                            'target'              => array(),
                            'rel'                 => array(),
                            'data-commentid'      => array(),
                            'data-postid'         => array(),
                            'data-belowelement'   => array(),
                            'data-respondelement' => array(),
                            'data-replyto'        => array(),
                            'aria-label'          => array(),
                            'data-border'         => array(),
                            'data-border-hover'   => array(),
                        ),
                        'img' => array(
                            'src'    => array(),
                            'alt'    => array(),
                            'style'  => array(),
                            'height' => array(),
                            'width'  => array(),
                        ),
                    );
                    return $tags;
                    break;
                case 'icon':
                    $tags = array(
                        'i' => array(
                            'class' => array(),
                        ),
                    );
                    return $tags;
                    break;
                case 'price':
                    $tags = array(
                        'span' => array(
                            'class' => array(),
                        ),
                        'bdi'  => array(),
                        'ins'  => array(),
                        'del'  => array(
                            'aria-hidden' => array(),
                        ),
                    );
                    return $tags;
                    break;
                case 'onlytag':
                    $tags = array(
                        'h1'  => array(),
                        'h2'  => array(),
                        'h3'  => array(),
                        'img' => array(),
                    );
                    return $tags;
                    break;
                default:
                    return $tags;
            }
        }

        add_filter(
            'wp_kses_allowed_html',
            'mt_addons_kses_allowed_html',
            10,
            2
        );
    }
}