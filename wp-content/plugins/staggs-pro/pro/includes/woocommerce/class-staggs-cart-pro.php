<?php

/**
 * The file that defines the core plugin cart class
 *
 * @link       https://staggs.app
 * @since      1.0.0
 *
 * @package    Staggs/pro/includes
 * @subpackage Staggs/pro/includes/woocommerce
 */

/**
 * The core plugin cart handler class.
 *
 * This is used to define all WooCommerce cart hooks.
 *
 * @since      1.0.0
 * @package    Staggs/pro/includes
 * @subpackage Staggs/pro/includes/woocommerce
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Cart_PRO {

	/**
	 * If stock is enabled, validate product items stock quantities.
	 * 
	 * @since 1.2.6
	 */
	public function staggs_add_to_cart_qty_validation( $cart_item_key, $quantity, $old_quantity, $cart ) {

		// Make sure it is configurable product with custom product parts.
		$cart_item_data = $cart->cart_contents[ $cart_item_key ];
		if ( ! isset( $cart_item_data['product_parts'] ) ) {
			return;
		}

		// Get low stock for configuration.
		$low_stock = staggs_get_product_stock_quantity( $cart_item_data['product_parts'] );

		// Check quantity.
		if ( $quantity > $low_stock ) {
			// Change the quantity to the limit allowed
			$cart->cart_contents[ $cart_item_key ]['quantity'] = (int) $low_stock;

			// Add a custom notice
			wc_add_notice( 
				sprintf(
					__( 'Sorry, we do not have enough "%1$s" in stock to fulfill your order (%2$s available).', 'staggs' ), 
					get_the_title( $cart_item_data['product_id'] ),
					$low_stock
				),
				'error'
			);
		}
	}

	/**
	 * Modify product item link when in cart.
	 *
	 * @since    1.0.0
	 */
	public function staggs_modify_cart_link( $permalink, $cart_item, $cart_item_key ) {
		if ( isset( $cart_item['product_parts'] ) ) {
			$parts = array();

			foreach ( $cart_item['product_parts'] as $part ) {
				if ( is_array( $part['value']) ) {
					// Repeatable value.
					foreach ( $part['value'] as $sub_part ) {
						if ( isset( $sub_part['_id'] ) ) {
							$new_sub_part = array(
								'name'    => $sub_part['name'],
								'value'   => $sub_part['value'],
								'id'      => $sub_part['_id'],
								'step_id' => $sub_part['_step_id']
							);
						} else {
							$new_sub_part = array(
								'name'    => $sub_part['name'],
								'value'   => $sub_part['value']
							);
						}

						if ( isset( $sub_part['value_url'] ) ) {
							$new_part['url'] = $sub_part['value_url'];
						}
	
						$parts[] = $new_sub_part;
					}
				} else {
					// Single value.
					if ( isset( $part['_id'] ) ) {
						$new_part = array(
							'name'    => $part['name'],
							'value'   => $part['value'],
							'id'      => $part['_id'],
							'step_id' => $part['_step_id']
						);
					} else {
						$new_part = array(
							'name'    => $part['name'],
							'value'   => $part['value']
						);
					}

					if ( isset( $part['value_url'] ) ) {
						$new_part['url'] = $part['value_url'];
					}

					$parts[] = $new_part;
				}
			}

			if ( isset( $cart_item['original_id'] ) ) {
				$permalink = get_permalink( $cart_item['original_id'] ) . '?options=' . urlencode( str_replace( '"', "'", json_encode( $parts ) ) ) . '&sgg_key=' . $cart_item_key;
			} else {
				$permalink = get_permalink( $cart_item['product_id'] ) . '?options=' . urlencode( str_replace( '"', "'", json_encode( $parts ) ) ) . '&sgg_key=' . $cart_item_key;
			}
		}

		return $permalink;
	}

	/**
	 * Update stock quantities if manageable.
	 *
	 * @since    1.1.0
	 */
	public function update_stock_status_on_thankyou_page( $order_id ) {
		// Can't do no nothing without order id.
		if ( ! $order_id ) {
			return;
		}

		// Get an instance of the WC_Order object
		$order = wc_get_order( $order_id );

		// Stock notification settings.
		$send_notifications = staggs_get_theme_option( 'sgg_send_notifications' );
		$notify_stock_qty   = staggs_get_theme_option( 'sgg_low_stock_qty' );

		// Bail early if already updated.
		if ( get_post_meta( $order_id, '_configurator_stock_updated' ) ) {
			return;
		}

		// Loop through order items
		foreach ( $order->get_items() as $item_id => $item ) {
			// Get the product object
			// $product = $item->get_product();

			if ( $order_item_ids = $item->get_meta( '_configurator_item_ids' ) ) {
				$order_item_ids = explode( ',', $order_item_ids );
				$quantity       = $item->get_quantity();

				foreach ( $order_item_ids as $order_item_id ) {
					if ( strpos( $order_item_id, '::' ) !== false ) {
						$order_item_id_pair = explode( '::', $order_item_id );

						$parent_id = $order_item_id_pair[0];
						$option_id = $order_item_id_pair[1];

						if ( ! $parent_id ) {
							continue;
						}

						$new_stock_qty   = false;
						$attribute_items = staggs_get_post_meta( $parent_id, 'sgg_attribute_items' );
						$attribute_type  = staggs_get_post_meta( $parent_id, 'sgg_attribute_type' );

						foreach ( $attribute_items as $attr_item_key => $attr_item ) {
							$item_id = staggs_sanitize_title( $attr_item['sgg_option_label'] );
							$order_item_title = $attr_item['sgg_option_label'];

							if ( $item_id === $option_id ) {
	
								if ( '' !== $attr_item['sgg_option_stock_qty'] ) {

									if ( 'link' !== $attribute_type ) {

										$current_stock  = sanitize_key( $attr_item['sgg_option_stock_qty'] );
										$new_stock_qty  = $current_stock - $quantity;

										$attribute_items[ $attr_item_key ]['sgg_option_stock_qty'] = $new_stock_qty;
									}

								} else if ( 'link' === $attribute_type ) {

									$product_id = sanitize_key( $attr_item['sgg_option_linked_product_id'] );
									$product_qty = sanitize_key( $attr_item['sgg_option_linked_product_qty'] ) ?: 1;

									$product_quantity = $quantity;
									foreach ( $item->get_meta_data() as $item_meta_val ) {
										$item_meta_key = staggs_sanitize_title( $item_meta_val->key );
										if ( $item_meta_key === $option_id ) {
											$product_quantity = (int) $item_meta_val->value;
										}
									}

									// Calculate total item quantity (cart item quantity times defined product quantity)
									$total_quantity = $product_qty * $product_quantity;

									$current_stock = (int) get_post_meta( $product_id, '_stock', true );
									$new_stock_qty = $current_stock - $total_quantity;
									
									update_post_meta( $product_id, '_stock', $new_stock_qty );
								}
							}
						}

						if ( $send_notifications && $new_stock_qty && ( $new_stock_qty <= $notify_stock_qty ) ) {
							$this->send_stock_notification( $order_item_title, $new_stock_qty );
						}

						staggs_set_post_meta( $parent_id, 'sgg_attribute_items', $attribute_items );
					}
				}
			}
		}

		// Mark as updated. Prevents stock updates on page refreshes.
		add_post_meta( $order_id, '_configurator_stock_updated', 'updated' );
	}

	/**
	 * Send a notification to the configured email address when low stock quantity is reached.
	 *
	 * @since    1.2.0
	 */
	public function send_stock_notification( $item_title, $stock_qty ) {
		$to = staggs_get_theme_option( 'sgg_notification_email' );

		if ( '' === $to ) {
			$to = get_option( 'admin_email' );
		}

		$title   = __( 'Low Stock Quantity For', 'staggs' ) . ' ' . $item_title;
		$content = sprintf( __( 'Note: stock quantity for %s is now: %d', 'staggs' ), $item_title, $stock_qty );

		$email   = apply_filters( 'staggs_stock_notification_email', $to );
		$subject = apply_filters( 'staggs_stock_notification_email_subject', $title );
		$content = apply_filters( 'staggs_stock_notification_email_content', $content );

		wp_mail( $email, $subject, $content );
	}
}
