<?php

/**
 * Fired during plugin activation
 *
 * @link       https://staggs.app
 * @since      1.0.0
 *
 * @package    Staggs
 * @subpackage Staggs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Staggs
 * @subpackage Staggs/includes
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$attributes = get_posts(array(
			'post_type' => 'sgg_attribute',
			'post_type' => 'any',
			'fields' => 'ids',
		));

		if ( count( $attributes ) == 0 ) {
			update_option( '_sgg_configurator_smart_nodes_lookup', 'yes' );
		}
	}
}
