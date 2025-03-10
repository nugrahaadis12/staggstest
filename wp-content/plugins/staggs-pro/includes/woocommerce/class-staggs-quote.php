<?php

/**
 * The file that defines the core plugin quote class
 *
 * @link       https://staggs.app
 * @since      2.9.0
 *
 * @package    Staggs
 * @subpackage Staggs/includes
 */

/**
 * The core plugin quote handler class.
 *
 * This is used to define all plugin quote hooks.
 *
 * @since      2.9.0
 * @package    Staggs
 * @subpackage Staggs/includes
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Quote {

	/**
	 * Add custom Staggs configuration data to quote item
	 *
	 * @since    2.9.0
	 */
	public function add_ywraq_item_to_quote( $raq, $post_data ) {
		$product_id = $post_data['product_id'];

		if ( product_is_configurable( $product_id ) ) {
			$raq['item_data'] = array();
			$raq['price_data'] = array();
	
			foreach ( $post_data as $post_key => $post_value ) {
				if ( str_contains( $post_key, 'sgg_' ) ) {
					$key = str_replace( 'sgg_', '', $post_key );
	
					if ( str_contains( $key, 'price' ) ) {
						$raq['price_data'][$key] = $post_value;
					} else if ( str_contains( $key, 'image' ) ) {
						$raq['image'] = $post_value;
					} else {
						$raq['item_data'][$key] = $post_value;
					}
				}
			}
		}

		return $raq;
	}

	/**
	 * Show custom configuration image in quote item
	 *
	 * @since    2.9.0
	 */
	public function get_ywraq_product_image( $image, $raq, $_product ) {
		if ( isset( $raq['image'] ) ) {
			// don't scan base64 images for smileys
			global $wp_smiliessearch;
			$wp_smiliessearch = null;

			$image = '<img src="' . urldecode( $raq['image'] ) . '">';
		}

		return $image;
	}

	/**
	 * Return the price of the product.
	 *
	 * @param array      $values   .
	 * @param WC_Product $_product .
	 * @param string     $taxes    .
	 */
	public function adjust_ywraq_quote_item_price( $values, $_product ) {
		if ( isset( $values['product_price'] ) && ! empty( $values['product_price'] ) ) {
			$_product->set_price( $values['product_price'] );
		}
	}

	/**
	 * Show custom configuration item options in quote item
	 *
	 * @since    2.9.0
	 */
	public function get_ywraq_quote_item_data( $item_data, $raq, $_product, $show_price ) {
		if ( isset( $raq['item_data'] ) ) {
			foreach ( $raq['item_data'] as $key => $val ) {
				$item_data[] = array(
					'key' => ucfirst( str_replace('-', ' ', $key ) ),
					'value' => $val
				);
			}
		}
		return $item_data;
	}

	/**
	 * Add order item meta when creating the order
	 *
	 * @param array  $values        .
	 * @param string $cart_item_key Cart item key.
	 * @param int    $item_id       Item id.
	 */
	public function add_order_item_meta( $values, $cart_item_key, $item_id ) {
		if ( ! empty( $values['item_data'] ) ) {
			foreach ( $values['item_data'] as $key => $val ) {
				$name = ucfirst( str_replace('-', ' ', $key ) );
				$value = $val;

				wc_add_order_item_meta( $item_id, $name, $value );
			}
		}
		wc_add_order_item_meta( $item_id, '_sgg_price', $values['product_price'] );
		wc_add_order_item_meta( $item_id, '_sgg_image', $values['image'] );
	}

	/**
	 * Show addon image replaced on product page
	 *
	 * @param string  $image   The image URL.
	 * @param Object  $raq     The RAQ content.
	 * @param boolean $get_src Boolean, true to get the src of the image.
	 *
	 * @return mixed|string
	 */
	public function get_ywraq_quote_item_image( $image, $raq ) {
		if ( isset( $raq['image'] ) ) {
			global $wp_smiliessearch;
			$wp_smiliessearch = null;

			$image_src = urldecode( $raq['image'] );
			$image     = '<img src="' . $image_src . '" />';
		}
		return $image;
	}

	/**
	 * Fee product image on admin order page
	 *
	 * @param string $product_image The product image HTML.
	 * @param int    $item_id       The cart item array.
	 * @param bool   $item          The cart item key.
	 */
	public function change_ywraq_quote_item_image( $product_image, $item_id, $item ) {
		$image_url = urldecode( wc_get_order_item_meta( $item_id, '_sgg_image' ) );
		if ( $image_url ) {
			global $wp_smiliessearch;
			$wp_smiliessearch = null;

			$product_image =  '<img src="' . $image_url . '" />';
		}

		return $product_image;
	}
}
