<?php
/**
 * Plugin Name:       Campspot Campgrounds, RV parks Availability Checker
 * Plugin URI:        https://plugins.modeltheme.com/campspot-property-availability-checker/
 * Description:        This powerful tool is designed for Campspot Campgrounds & RV Parks Availability Checker to easily find and manage available spots for your next trip.
 * Version:           1.0
 * Author:            Modeltheme
 * Author URI:        https://modeltheme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ccrpac
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


require_once( 'inc/shortcode.php' );


/**
||-> Function: LOAD PLUGIN TEXTDOMAIN
*/
function ccrpac_load_textdomain(){
    $domain = 'ccrpac';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'ccrpac_load_textdomain' );