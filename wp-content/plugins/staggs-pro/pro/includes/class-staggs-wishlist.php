<?php

/**
 * The product wishlist functions for the plugin.
 *
 * @link       https://staggs.app
 * @since      1.6.0
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

/**
 * The plugin wishlist functions
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Staggs_Wishlist {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wishlist_plugin_scripts_styles' ) );

		add_action( 'init', array( $this, 'my_account_new_endpoints' ) );
		add_action( 'woocommerce_account_my-configurations_endpoint', array( $this, 'wishlist_endpoint_content' ) );

		add_filter( 'query_vars', array( $this, 'account_wishlist_query_vars' ), 0 );
		add_filter( 'woocommerce_account_menu_items', array( $this, 'add_wishlist_link_my_account' ) );

		add_action( 'wp_ajax_staggs_fetch_customer_wishlist', array( $this, 'staggs_fetch_user_data_ajax' ) );
		add_action( 'wp_ajax_nopriv_staggs_fetch_customer_wishlist', array( $this, 'staggs_fetch_user_data_ajax' ) );

		add_action( 'wp_ajax_staggs_save_wishlist_item_for_user', array( $this, 'save_wishlist_item_for_user_ajax' ) );
		add_action( 'wp_ajax_nopriv_staggs_save_wishlist_item_for_user', array( $this, 'save_wishlist_item_for_user_ajax' ) );

		add_shortcode( 'staggs_wishlist_table', array( $this, 'wishlist_table_contents' ) );
		add_filter( 'rest_product_collection_params', array( $this, 'maximum_api_filter' ) );
	}

	function my_account_new_endpoints() {
		add_rewrite_endpoint( 'my-configurations', EP_ROOT | EP_PAGES );
	}

	function account_wishlist_query_vars( $vars ) {
		$vars[] = 'my-configurations';
		return $vars;
	}

	function add_wishlist_link_my_account( $items ) {
		$title = 'My configurations';
		if ( '' !== staggs_get_theme_option( 'sgg_account_configurations_page_title' ) ) {
			$title = sanitize_text_field( staggs_get_theme_option( 'sgg_account_configurations_page_title' ) );
		}

		$new_items = array();
		foreach ( $items as $item_key => $item_label ) {
			$new_items[ $item_key ] = $item_label;
			if ( 'downloads' === $item_key ) {
				$new_items['my-configurations'] = $title;
			}
		}

		return $new_items;
	}

	function wishlist_endpoint_content() {
		$title = __( 'My configurations', 'staggs' );
		if ( '' !== staggs_get_theme_option( 'sgg_account_configurations_page_title' ) ) {
			$title = sanitize_text_field( staggs_get_theme_option( 'sgg_account_configurations_page_title' ) );
		}

		echo '<h2>' . esc_attr( $title ) . '</h2>';
		echo do_shortcode( '[staggs_wishlist_table]' );
	}

	function wishlist_plugin_scripts_styles() {
		if ( function_exists( 'is_account_page' ) && ! is_account_page() ) {
			return;
		}

		wp_enqueue_style( 'staggs-wishlist', plugin_dir_url( __FILE__ ) . '../public/css/staggs-wishlist.min.css', array(), '1.0.0' );
		wp_enqueue_script( 'staggs-wishlist', plugin_dir_url( __FILE__ ) . '../public/js/staggs-wishlist.min.js', array( 'jquery' ), '', true );
		
		$wishlist_notice = __( 'Do you want to remove this item from your wishlist?', 'staggs' );
		if ( staggs_get_theme_option( 'sgg_product_wishlist_delete_notice' ) ) {
			$wishlist_notice = staggs_get_theme_option( 'sgg_product_wishlist_delete_notice' );
		}

		wp_localize_script(
			'staggs-wishlist',
			'opt',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'wishlistDelete' => $wishlist_notice,
			)
		);
	}

	// Get current user data
	function staggs_fetch_user_data_ajax() {
		$current_user_wishlist = array();

		if ( is_user_logged_in() ) {
			$current_user          = wp_get_current_user();
			$current_user_wishlist = get_user_meta( $current_user->ID, 'staggs_configurations_wishlist', true );
		}
		
		echo json_encode($current_user_wishlist);
		die();
	}

	function save_wishlist_item_for_user_ajax() {
		$user_id = get_current_user_id();
		if ( $user_id ) {
			$user_obj = get_user_by( 'id', $user_id );

			if ( ! is_wp_error( $user_obj ) && is_object( $user_obj ) ) {
				update_user_meta( $user_id, 'staggs_configurations_wishlist', $_POST['wishlist'] );
			}
		}

		wp_send_json_success( array( '1' ) );
		die();
	}

	function wishlist_table_contents( $atts, $content = null ) {
		extract( shortcode_atts( array(), $atts ) );

		$table_heading = __( 'Configuration details', 'staggs' );
		if ( staggs_get_theme_option( 'sgg_account_configurations_table_heading' ) ) {
			$table_heading = staggs_get_theme_option( 'sgg_account_configurations_table_heading' );
		}

		$table_price = __( 'Total price', 'staggs' );
		if ( staggs_get_theme_option( 'sgg_account_configurations_table_price' ) ) {
			$table_price = staggs_get_theme_option( 'sgg_account_configurations_table_price' );
		}

		$table = '<div class="staggs-wishlist-table-wrapper">
			<table class="shop_table shop_table_responsive staggs-wishlist-table loading">
				<thead>
					<tr>
						<th><!-- Left for image --></th>
						<th>' . $table_heading . '</th>
						<th>' . $table_price . '</th>
						<th><!-- Left for button --></th>
					</tr>
				</thead>
				<tbody>';

		$current_user          = wp_get_current_user();
		$current_user_wishlist = get_user_meta( $current_user->ID, 'staggs_configurations_wishlist', true );

		if ( $current_user_wishlist ) {
			foreach ( $current_user_wishlist as $wishlist_index => $wishlist_item_json ) {
				$wishlist_item = json_decode($wishlist_item_json,true);
				$product_id = sanitize_key($wishlist_item['product']);

				$details_html = '';
				foreach ( $wishlist_item['values'] as $value_pair ) {
					if ( $value_pair['name'] === 'original_post_id' ) {
						$product_id = sanitize_key($value_pair['value']);
						continue;
					}

					$details_html .= sprintf(
						'<dl class="variation"><dt>%s</dt><dd>%s</dd></dl>',
						trim( $value_pair['label'] ) . ':',
						trim( $value_pair['value'] ),
					);
				}

				$progress = '';
				if ( is_array( $wishlist_item['progress'] ) ) {
					$progress = '&progress=' . urlencode( str_replace('"', "'", json_encode( $wishlist_item['progress'] ) ) );
				}

				$table .= sprintf(
					'<tr data-id="%1$s">
						<td class="product-thumbnail"><a href="%2$s"><img src="%3$s" width="100" height="100" alt="%4$s"></a></td>
						<td class="product-name" data-title="%8$s"><a href="%2$s">%4$s</a>%5$s</td>
						<td class="product-price" data-title="%9$s">%6$s</td>
						<td class="product-remove"><a class="wishlist-remove" data-index="%1$s" href="#">%7$s</a></td>
					</tr>',
					$wishlist_index,
					get_permalink( $product_id ) . '?options=' . urlencode( str_replace('"', "'", json_encode( $wishlist_item['values'] ) ) ) . $progress,
					$wishlist_item['image'],
					get_the_title( $product_id ),
					$details_html,
					staggs_format_price( $wishlist_item['total'] ),
					staggs_get_icon( 'sgg_wishlist_delete_icon', 'trash' ),
					$table_heading,
					$table_price
				);
			}
		}

		$empty_notice = __( 'You have not saved any configurations yet.', 'staggs' );
		if ( staggs_get_theme_option( 'sgg_product_wishlist_empty_notice' ) ) {
			$empty_notice = staggs_get_theme_option( 'sgg_product_wishlist_empty_notice' );
		}

		$table .= '</tbody>';
		$table .= '</table>';
		$table .= '<div class="staggs-wishlist-table-empty hidden"><p>' . $empty_notice . '</div></div>';

		return $table;
	}

	function maximum_api_filter( $query_params ) {
		$query_params['per_page']['maximum'] = 100;
		return $query_params;
	}
}
