<?php

/**
 * Provide a admin-facing view for the Product Builder Fields form of the plugin
 *
 * This file is used to markup the admin-facing product builder form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      2.5.1
 *
 * @package    Staggs
 * @subpackage Staggs/admin/blocks
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'STAGGS Configurator', 'staggs' ) )
	->add_fields( array(
		Field::make( 'select', 'staggs_product_id', __( 'Configurable product', 'staggs' ) )
			->set_options( 'get_staggs_block_product_list' ),
	) )
	->set_description( __( 'Displays the STAGGS Product Configurator on your page', 'staggs' ) )
	->set_category( 'media' )
	->set_keywords(['staggs', 'configurator'])
	->set_icon( 'icons-staggs' )
	->set_mode( 'edit' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		if ( isset( $fields['staggs_product_id'] ) && '' !== $fields['staggs_product_id'] ) {
			echo do_shortcode('[staggs_configurator product_id="' . esc_attr( $fields['staggs_product_id'] ) . '"]' );
		} else {
			echo do_shortcode('[staggs_configurator]');
		}
	});