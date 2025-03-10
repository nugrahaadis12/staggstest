<?php

/**
 * The admin-specific ACF functionality of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.5.0
 *
 * @package    Staggs
 * @subpackage Staggs/admin
 */

/**
 * The admin-specific ACF functionality of the plugin.
 *
 * Defines the ACF fields
 *
 * @package    Staggs
 * @subpackage Staggs/admin
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_ACF_Fields {

	/**
	 * Registers the settings options page
	 *
	 * @since    1.5.0
	 */
	public function sgg_register_settings_page() {

        acf_add_options_sub_page(array(
			'page_title'  => __('Staggs Settings', 'staggs'),
			'menu_title'  => __('Settings', 'staggs'),
			'menu_slug'   => 'acf-options-settings',
			'parent_slug' => 'edit.php?post_type=sgg_attribute',
			'capability'  => 'edit_posts'
        ));

	}

	/**
	 * Registers the ACF fields groups.
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_field_groups() {

		require STAGGS_BASE . '/admin/fields/acf/settings.php';
		require STAGGS_BASE . '/admin/fields/acf/attribute.php';
		require STAGGS_BASE . '/admin/fields/acf/builder.php';
		require STAGGS_BASE . '/admin/fields/acf/theme.php';
		require STAGGS_BASE . '/admin/fields/acf/block.php';

		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			require STAGGS_BASE . '/admin/fields/acf/product.php';
		}

	}

	/**
	 * Registers the ACF blocks.
	 *
	 * @since    2.5.0
	 */
	public function sgg_register_gutenberg_blocks() {
		if (function_exists('acf_register_block_type')) {
			acf_register_block_type(array(
				'name'            => 'block-staggs',
				'title'           => __('STAGGS Configurator'),
				'description'     => __('Displays the STAGGS Product Configurator on your page'),
				'render_template' => __DIR__ . '/blocks/acf/block-staggs.php',
				'category'        => 'media',
				'icon'            => 'icons-staggs',
				'keywords'        => array('staggs', 'configurator'),
				'mode'            => 'edit'
			));
		}
	}

	/**
	 * Get Staggs Block product list.
	 *
	 * @since    2.5.0
	 */
	public function sgg_load_block_product_options( $field ) {
		if ( isset( $field['choices'] ) ) {
			$new_choices = get_staggs_block_product_list();
			$field['choices'] = $new_choices;
		}
		return $field;
	}
}
