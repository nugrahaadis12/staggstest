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

if ( get_field( 'staggs_product_id' ) && '' !== get_field( 'staggs_product_id' ) ) {
	echo do_shortcode('[staggs_configurator product_id="' . esc_attr( get_field( 'staggs_product_id' ) ) . '"]' );
} else {
	echo do_shortcode('[staggs_configurator]');
}
