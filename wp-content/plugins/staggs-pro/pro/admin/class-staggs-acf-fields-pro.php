<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.5
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/admin
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_ACF_Fields_PRO {

	/**
	 * Registers the ACF fields for the settings page
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_field_groups() {

		require STAGGS_BASE . '/pro/admin/fields/acf/settings.php';
		require STAGGS_BASE . '/pro/admin/fields/acf/attribute.php';
		require STAGGS_BASE . '/pro/admin/fields/acf/builder.php';
		require STAGGS_BASE . '/pro/admin/fields/acf/theme.php';
		require STAGGS_BASE . '/admin/fields/acf/block.php';

		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			include STAGGS_BASE . '/admin/fields/acf/product.php';
		}

	}

	/**
	 * Get WooCommerce simple products.
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_simple_product_options( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = get_woocommerce_simple_product_list();
			$field['choices'] = $new_choices;
		}
		return $field;
	}

	/**
	 * Get available configurable attributes
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_staggs_configurable_attributes( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = get_configurator_attribute_conditional_values();
			$field['choices'] = $new_choices;
		}
		return $field;
	}

	/**
	 * Get available configurable attributes
	 *
	 * @since    2.9.0
	 */
	public function sgg_load_staggs_configurable_inputs( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = get_configurator_attribute_conditional_inputs();
			$field['choices'] = $new_choices;
		}
		return $field;
	}

	/**
	 * Get available configurable attribute options
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_staggs_configurable_options( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = get_configurator_attribute_item_values();
			$field['choices'] = $new_choices;
		}
		return $field;
	}

	/**
	 * Get available configurable attribute options
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_tablepress_tables( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = get_tablepress_tables();
			$field['choices'] = $new_choices;
		}
		return $field;
	}

	/**
	 * Get available builder attributes
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_staggs_image_sizes( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = staggs_get_image_size_choices();
			$field['choices'] = $new_choices;
		}

		return $field;
	}
}
