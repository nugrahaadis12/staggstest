<?php

/**
 * The main functions of the PRO plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.7
 *
 * @package    Staggs
 * @subpackage Staggs/includes
 */

if ( ! function_exists( 'get_tablepress_tables' ) ) {
	/**
	 * Get TablePress tables
	 * 
	 * @since 1.3.7
	 */
	function get_tablepress_tables() {
		$all_tables = array( '' => '- Select a table -' );

		$table_options = json_decode( get_option( 'tablepress_tables' ), true );

		if ( isset( $table_options['table_post'] ) && is_array( $table_options['table_post'] ) ) {
			global $wpdb;

			$table_titles = $wpdb->get_results( $wpdb->prepare(
				'SELECT `ID`, `post_title` FROM %1$s WHERE `ID` IN (%2$s)',
				$wpdb->posts,
				implode( ',', $table_options['table_post'] )
			) );

			foreach ( $table_titles as $table_result ) {
				$all_tables[ $table_result->ID ] = $table_result->post_title;
			}
		}

		return apply_filters( 'staggs_tablepress_table_options', $all_tables );
	}
}

if ( ! function_exists( 'sgg_ajax_validate_file_upload' ) ) {
	function sgg_ajax_validate_file_upload() {
		$file = $_FILES['file'];
		$fileError = $file['error'];

		if ( UPLOAD_ERR_OK === $fileError ) {

			$result = store_final_product_file( $file );

		} else {

			switch ($fileError) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$result = array(
						'error' => 'The uploaded file exceeds the max allowed upload size.'
					);
					break;
				case UPLOAD_ERR_PARTIAL:
				case UPLOAD_ERR_NO_FILE:
				case UPLOAD_ERR_NO_TMP_DIR:
				case UPLOAD_ERR_CANT_WRITE:
				case UPLOAD_ERR_EXTENSION:
					$result = array(
						'error' => 'The file could not be processed.'
					);
					break;
				default:
					$result = array(
						'error' => 'An unknown error occurred.'
					);
					break;
			}
		}

		if ( $result['path'] ) {
			echo json_encode( array(
				'filename' => $file['name'],
				'filepath' => $result['path'],
			));
		} else {
			wp_send_json_error( $result['error'] );
		}
		die();
	}
}
add_action( 'wp_ajax_nopriv_staggs_validate_file_upload', 'sgg_ajax_validate_file_upload' );
add_action( 'wp_ajax_staggs_validate_file_upload', 'sgg_ajax_validate_file_upload' );

if ( ! function_exists( 'sgg_ajax_clear_uploaded_file' ) ) {
	function sgg_ajax_clear_uploaded_file() {
		$details = sanitize_text_field( $_POST['details'] );
		$file = explode('|', $details);
		$file_path = str_replace( trailingslashit( get_site_url() ), ABSPATH, $file[1] );

		if ( file_exists( $file_path ) ) {
			unlink( $file_path );
		}
		echo '1'; // Trigger success.
		die();
	}
}
add_action( 'wp_ajax_nopriv_staggs_clear_uploaded_file', 'sgg_ajax_clear_uploaded_file' );
add_action( 'wp_ajax_staggs_clear_uploaded_file', 'sgg_ajax_clear_uploaded_file' );

if ( ! function_exists( 'ajax_get_price_table_value' ) ) {
	function ajax_get_price_table_value() {
		$table_id = sanitize_key( $_POST['table_id'] );
		$index    = sanitize_text_field( $_POST['index'] );
		$value    = sanitize_text_field( $_POST['value'] );
		$price    = get_price_from_range_table( $table_id, $value );

		echo json_encode( array(
			'index' => $index,
			'value' => $value,
			'price' => $price,
		));
		die();
	}
}
add_action( 'wp_ajax_nopriv_get_price_table_value', 'ajax_get_price_table_value' );
add_action( 'wp_ajax_get_price_table_value', 'ajax_get_price_table_value' );

if ( ! function_exists( 'ajax_get_matrix_price_table_value' ) ) {
	function ajax_get_matrix_price_table_value() {
		$required_keys = array( 'table_id', 'value_x', 'value_y', 'type_x', 'type_y', 'table_round', 'table_range' );
		$min_price = isset( $_POST['minprice'] ) ? sanitize_text_field( $_POST['minprice'] ) : false;
		foreach ( $required_keys as $post_key ) {
			if ( ! isset( $_POST[ $post_key ] ) ) {
				// Missing post key. Return price = 0
				echo esc_attr( $min_price ) ?: '0';
				die();
			}
		}

		$matrix_values = array(
			'matrix' => sanitize_key( $_POST['table_id'] ),
			'value_x' => sanitize_text_field( $_POST['value_x'] ),
			'value_y' => sanitize_text_field( $_POST['value_y'] ),
			'type_x' => sanitize_text_field( $_POST['type_x'] ),
			'type_y' => sanitize_text_field( $_POST['type_y'] ),
			'round' => sanitize_text_field( $_POST['table_round'] ),
			'range' => sanitize_text_field( $_POST['table_range'] )
		);

		$price = get_price_from_matrix_table( $matrix_values );
		if ( $min_price && $price < $min_price ) {
			$price = $min_price;
		}

		if ( isset( $_POST['table_sale'] ) && $_POST['table_sale'] ) {
			$matrix_values['matrix'] = sanitize_key( $_POST['table_sale'] );

			$sale_price = get_price_from_matrix_table( $matrix_values );
			if ( $min_price && $price < $min_price ) {
				$sale_price = $min_price;
			}

			if ( $sale_price < $price ) {
				$price .= '|' . $sale_price;
			}
		}
 
		echo esc_attr( $price );
		die();
	}
}
add_action( 'wp_ajax_nopriv_get_matrix_price_table_value', 'ajax_get_matrix_price_table_value' );
add_action( 'wp_ajax_get_matrix_price_table_value', 'ajax_get_matrix_price_table_value' );

if ( ! function_exists( 'get_price_from_matrix_table' ) ) {
	/**
	 * Get price from matrix table
	 * 
	 * @since 1.3.7
	 */
	function get_price_from_matrix_table( $matrix_values ) {
		$price = 0;
		
		$table_id = $matrix_values['matrix'];
		$value_x = $matrix_values['value_x'];
		$value_y = $matrix_values['value_y'];
		$type_x = isset( $matrix_values['type_x'] ) ? $matrix_values['type_x'] : 'numeric';
		$type_y = isset( $matrix_values['type_y'] ) ? $matrix_values['type_y'] : 'numeric';
		$table_round = isset( $matrix_values['round'] ) ? $matrix_values['round'] : 'down';
		$table_range = isset( $matrix_values['range'] ) ? $matrix_values['range'] : 'exclude';

		$table_contents = json_decode( get_post_field( 'post_content', $table_id ) );
		if ( ! is_array( $table_contents ) || 0 === count( $table_contents ) ) {
			return $price;
		}

		$found_col_index = -1;
		$found_row_index = -1;
		$exact_col_match = true;
		$exact_row_match = true;

		foreach ( $table_contents[0] as $col_index => $col_value ) {
			if ( 'text' === $type_x ) {
				if ( $value_x == $col_value ) {
					$found_col_index = $col_index;
					$exact_col_match = true;
				}
			} else {
				// Numeric col compare
				if ( ! isset( $table_contents[0][ $col_index + 1 ] ) ) {
					if ( $value_x >= $col_value ) {
						$found_col_index = $col_index;
						$exact_col_match = ( $value_x === $col_value );
						break;
					}
				} elseif ( $value_x >= $col_value && $value_x < $table_contents[0][ $col_index + 1 ] ) {
					$found_col_index = $col_index;
					$exact_col_match = ( $value_x === $col_value );
					break;
				}
			}
		}

		foreach ( $table_contents as $row_index => $table_row ) {
			if ( 'text' === $type_y ) {
				if ( $value_y == $table_row[0] ) {
					$found_row_index = $row_index;
					$exact_col_match = true;
				}
			} else {
				if ( ! isset( $table_contents[ $row_index + 1 ][0] ) ) {
					if ( $value_y >= $table_row[0] ) {
						$found_row_index = $row_index;
						$exact_row_match = ( $value_y === $table_row[0] );
						break;
					}
				} elseif ( $value_y >= $table_row[0] && $value_y < $table_contents[ $row_index + 1 ][0] ) {
					$found_row_index = $row_index;
					$exact_row_match = ( $value_y === $table_row[0] );
					break;
				}
			}
		}

		if ( 'up' === $table_round ) {
			if ( ! $exact_col_match ) {
				$found_col_index++;
			}
			if ( ! $exact_row_match ) {
				$found_row_index++;
			}
		}

		if ( $found_col_index > 0 && $found_row_index > 0 ) {
			$price = $table_contents[ $found_row_index ][ $found_col_index ];
		} else if ( 'include' === $table_range ) {
			if ( $value_x < $table_contents[0][1] && $value_y < $table_contents[1][0] ) {
				$price = $table_contents[1][1];
			} else if ( $value_x < $table_contents[0][1] ) {
				$price = $table_contents[ $found_row_index ][ 1 ];
			} else if ( $value_y < $table_contents[1][0] ) {
				$price = $table_contents[ 1 ][ $found_col_index ];
			}
		}

		return $price;
	}
}

if ( ! function_exists( 'get_price_from_range_table' ) ) {
	/**
	 * Get price from matrix table
	 * 
	 * @since 1.3.7
	 */
	function get_price_from_range_table( $table_id, $value ) {
		$price = 0;

		$table_contents = json_decode( get_post_field( 'post_content', $table_id ) );
		if ( ! is_array( $table_contents ) || 0 === count( $table_contents ) ) {
			return $price;
		}

		foreach ( $table_contents as $row_index => $table_row ) {
			if ( count( $table_row ) >= 3 ) {
				if ( $value >= $table_row[0] && $value <= $table_row[1] ) {
					$price = $table_row[2];
				}
			}
		}

		if ( $value && 0 === $price ) {
			// No price match. Get highest price.
			$price = $table_row[2];
		}

		return $price;
	}
}

if ( ! function_exists( 'staggs_get_configuration_file' ) ) {
	/**
	 * Get configuration content file.
	 * 
	 * Since 1.6.0
	 */
	function staggs_get_configuration_file() {
		$contents = '';

		$upload_dir = wp_get_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$save_path  = $base_dir . '/staggs';
        if ( ! file_exists( $save_path ) ) {
            mkdir( $save_path, 0777, true );
		}

		if (isset($_POST['filename'])) {
			$config_name = sanitize_text_field( $_POST['filename'] );

			if (file_exists(trailingslashit($save_path) . $config_name . '.json')) {
				$contents = file_get_contents(trailingslashit($save_path) . $config_name . '.json');
			}
		}

		echo $contents;
		die();
	}
}
add_action( 'wp_ajax_nopriv_get_configuration_file', 'staggs_get_configuration_file' );
add_action( 'wp_ajax_get_configuration_file', 'staggs_get_configuration_file' );

if ( ! function_exists( 'staggs_save_configuration_to_file' ) ) {
	/**
	 * Save configuration contents to file.
	 * 
	 * Since 1.6.0
	 */
	function staggs_save_configuration_to_file_ajax() {
		$new_contents = json_decode(str_replace('\\', '', $_POST['contents']));

		$upload_dir = wp_get_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$save_path  = $base_dir . '/staggs';
        if ( ! file_exists( $save_path ) ) {
            mkdir( $save_path, 0777, true );
		}

		$config_name = substr(md5(openssl_random_pseudo_bytes(20)), -32);
		$config_file = trailingslashit( $save_path ) . $config_name . '.json';

		// Create/override file
		file_put_contents($config_file, json_encode($new_contents, JSON_PRETTY_PRINT));

		echo json_encode( array( 'filename' => $config_name ) );
		die();
	}
}
add_action( 'wp_ajax_nopriv_staggs_save_configuration_to_file', 'staggs_save_configuration_to_file_ajax' );
add_action( 'wp_ajax_staggs_save_configuration_to_file', 'staggs_save_configuration_to_file_ajax' );

if ( ! function_exists( 'staggs_get_attribute_pricing_details' ) ) {
	/**
	 * Get configuration pricing data details
	 * 
	 * Since 1.6.0
	 */
	function staggs_output_attribute_pricing_details( $sanitized_step, $price_type ) {
		$price_key = isset( $sanitized_step['calc_price_key'] ) ? $sanitized_step['calc_price_key'] : '';
		$formula = isset( $sanitized_step['price_formula'] ) ? $sanitized_step['price_formula'] : '';
		$price_table = isset( $sanitized_step['price_table'] ) ? $sanitized_step['price_table'] : '';
		$sale_table = isset( $sanitized_step['price_table_sale'] ) ? $sanitized_step['price_table_sale'] : '';
		
		if ( $price_type === 'formula' || $price_type === 'formula-matrix' ) {
			echo ' data-formula="' . esc_attr( str_replace( ' ', '', $formula ) ) . '"';
		}

		if ( $price_type === 'matrix' || $price_type === 'formula-matrix') {
			if ( isset( $sanitized_step['price_table_val_x'] ) && isset( $sanitized_step['price_table_val_y'] ) ) {
				echo ' data-table="' . esc_attr( $price_table ) . '"';
				echo ' data-table-sale="' . esc_attr( $sale_table ) . '"';
				echo ' data-table-type="' . esc_attr( $sanitized_step['price_table_type'] ) . '"';
				echo ' data-table-round="' . esc_attr( $sanitized_step['price_table_rounding'] ) . '"';
				echo ' data-table-range="' . esc_attr( $sanitized_step['price_table_range'] ) . '"';
				echo ' data-table-x="' . esc_attr( $sanitized_step['price_table_val_x'] ) . '"';
				echo ' data-table-type-x="' . esc_attr( $sanitized_step['price_table_type_x'] ) . '"';
				echo ' data-table-y="' . esc_attr( $sanitized_step['price_table_val_y'] ) . '"';
				echo ' data-table-type-y="' . esc_attr( $sanitized_step['price_table_type_y'] ) . '"';
			}

			if ( isset($sanitized_step['price_table_val_min']) ) {
				echo ' data-table-min="' . esc_attr( $sanitized_step['price_table_val_min'] ) . '"';
			}
		}

		if ( '' !== $price_key ) {
			echo ' data-price-key="' . esc_attr( $price_key ) . '"';
		}
	}
}

if ( ! function_exists( 'staggs_display_attribute_price_details_html' ) ) {
	/**
	 * Get configuration pricing data details html
	 * 
	 * Since 1.6.0
	 */
	function staggs_display_attribute_price_details_html( $sanitized_step, $price_label_position ) {
		$price_label = isset( $sanitized_step['calc_price_label'] ) ? $sanitized_step['calc_price_label'] : '';

		echo '<div class="option-group-price-details option-group-price-details-' . esc_attr( $price_label_position ) . '">';
		if ( '' !== $price_label ) {
			echo '<p class="option-group-price-label">' . esc_attr( $price_label ) . '</p>';
		}
		echo '<p class="option-group-price"></p></div>';
	}
}

if ( ! function_exists( 'staggs_display_3d_viewer_attributes' ) ) {
	/**
	 * Display 3d configurator viewer attributes
	 * 
	 * Since 2.2.0
	 */
	function staggs_display_3d_viewer_attributes( $theme_id ) {
		
		$touch_action = staggs_get_post_meta( $theme_id, 'sgg_configurator_camera_touch_action' ) ?: 'pan-y';
		echo ' touch-action="' . esc_attr( $touch_action ) . '"';

		if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_interaction_prompt' ) ) {
			echo ' interaction-prompt="none"';
			// echo ' interaction-prompt-threshold="1"';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_display_ar_button' ) ) {
			echo ' ar';

			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_model_placement' ) ) {
				echo ' ar-placement="' . esc_attr( staggs_get_post_meta( $theme_id, 'sgg_configurator_model_placement' ) ) . '"';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_disable_ar_zoom' ) ) {
				echo ' ar-scale="fixed"';
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_model_env_image' ) ) {
			$env_image_url = staggs_get_post_meta( $theme_id, 'sgg_model_env_image' );
			echo ' environment-image="' . esc_attr( $env_image_url ) . '"';

			if ( staggs_get_post_meta( $theme_id, 'sgg_show_model_env_image' ) ) {
				echo ' skybox-image="' . esc_attr( $env_image_url ) . '"';
			}

			if ( $sky_height = staggs_get_post_meta( $theme_id, 'sgg_configurator_env_image_height' ) ) {
				echo ' skybox-height="' . esc_attr( $sky_height ) . '"';
			}
		}

		if ( strlen( staggs_get_post_meta( $theme_id, 'sgg_configurator_env_image_exposure' ) ) > 0 ) {
			$exposure = staggs_get_post_meta( $theme_id, 'sgg_configurator_env_image_exposure' );
			echo ' exposure="' . esc_attr( $exposure ) . '"';
		}

		$loading_image_id = false;
		if ( get_post_thumbnail_id() ) {
			$loading_image_id = get_post_thumbnail_id();
		}
		if ( staggs_get_post_meta( get_the_ID(), 'sgg_configurator_3d_model_poster' ) ) {
			$loading_image_id = staggs_get_post_meta( get_the_ID(), 'sgg_configurator_3d_model_poster' );
		}

		if ( $loading_image_id ) {
			$preview_size = apply_filters( 'staggs_product_image_size', 'full' );
			echo ' poster="' . esc_url( wp_get_attachment_image_url( $loading_image_id, $preview_size ) ) . '"';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_custom_shadow' ) ) {
			$intensity = (float) staggs_get_post_meta( $theme_id, 'sgg_configurator_shadow_intensity' );
			$softness = (float) staggs_get_post_meta( $theme_id, 'sgg_configurator_shadow_softness' );

			if ( $intensity ) {
				echo ' shadow-intensity="' . esc_attr( $intensity ) . '"';
			}
			if ( $softness ) {
				echo ' shadow-softness="' . esc_attr( $softness ) . '"';
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_initial_target' ) ) {
			$target_x = staggs_get_post_meta( $theme_id, 'sgg_configurator_target_x' );
			$target_y = staggs_get_post_meta( $theme_id, 'sgg_configurator_target_y' );
			$target_z = staggs_get_post_meta( $theme_id, 'sgg_configurator_target_z' );

			if ( $target_x && $target_y && $target_z ) {
				echo ' camera-target="' . esc_attr( $target_x ) . ' ' . esc_attr( $target_y ) . ' ' . esc_attr( $target_z ) . '"';
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_initial_view' ) ) {
			$pos_x = staggs_get_post_meta( $theme_id, 'sgg_configurator_initial_pos_x' );
			$pos_y = staggs_get_post_meta( $theme_id, 'sgg_configurator_initial_pos_y' );
			$zoom  = staggs_get_post_meta( $theme_id, 'sgg_configurator_initial_zoom' );
			$fov  = staggs_get_post_meta( $theme_id, 'sgg_configurator_initial_fov' );

			if ( $pos_x && $pos_y && $zoom ) {
				echo ' camera-orbit="' . esc_attr( $pos_x ) . ' ' . esc_attr( $pos_y ) . ' ' . esc_attr( $zoom ) . '"';
			}

			if ( $fov ) {
				echo ' field-of-view="' . esc_attr( $fov ) . '"';
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_custom_view_limits' ) ) {
			$counter_clockwise = staggs_get_post_meta( $theme_id, 'sgg_configurator_counter_clockwise_limit' );
			$clockwise = staggs_get_post_meta( $theme_id, 'sgg_configurator_clockwise_limit' );
			$topdown = staggs_get_post_meta( $theme_id, 'sgg_configurator_topdown_limit' );
			$bottomup = staggs_get_post_meta( $theme_id, 'sgg_configurator_bottomup_limit' );
			$minzoom = staggs_get_post_meta( $theme_id, 'sgg_configurator_min_zoom' );

			if ( ! $minzoom ) {
				$minzoom = 'auto';
			}

			if ( ! $counter_clockwise ) {
				$counter_clockwise = 'auto';
			} else {
				$counter_clockwise .= 'deg';
			}
			if ( ! $clockwise ) {
				$clockwise = 'auto';
			} else {
				$clockwise .= 'deg';
			}
			if ( ! $topdown ) {
				$topdown = 'auto';
			} else {
				$topdown .= 'deg';
			}
			if ( ! $bottomup ) {
				$bottomup = 'auto';
			} else {
				$bottomup .= 'deg';
			}

			echo ' min-camera-orbit="' . esc_attr( $counter_clockwise ) . ' ' . esc_attr( $topdown ) . ' ' . esc_attr( $minzoom ) . '"';
			echo ' max-camera-orbit="' . esc_attr( $clockwise ) . ' ' . esc_attr( $bottomup ) . ' auto"';
		} else if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_min_zoom' ) ) {
			$minzoom = staggs_get_post_meta( $theme_id, 'sgg_configurator_min_zoom' );
			if ( ! $minzoom ) {
				$minzoom = 'auto';
			}
			
			echo ' min-camera-orbit="auto auto ' . esc_attr( $minzoom ) . '"';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_auto_rotation' ) ) {
			echo ' auto-rotate';

			if ( '' !== staggs_get_post_meta( $theme_id, 'sgg_configurator_auto_rotation_speed' ) ) {
				$rotation_speed = staggs_get_post_meta( $theme_id, 'sgg_configurator_auto_rotation_speed' );
				echo ' rotation-per-second="' . esc_attr( $rotation_speed ) . '"';
			}
			
			if ( '' !== staggs_get_post_meta( $theme_id, 'sgg_configurator_auto_rotation_delay' ) ) {
				$rotation_delay = staggs_get_post_meta( $theme_id, 'sgg_configurator_auto_rotation_delay' );
				echo ' auto-rotate-delay="' . esc_attr( $rotation_delay ) . '"';
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_disable_zoom' ) ) {
			echo ' disable-zoom';
		}
	}
}

if ( ! function_exists( 'staggs_get_product_stock_quantity' ) ) {
	/**
	 * Get low stock quantity for given product configuration
	 * 
	 * Since 1.3.2
	 */
	function staggs_get_product_stock_quantity( $product_options ) {
		// Start with unusually high value to find lowest pair.
		$low_stock = 999999;

		if ( ! is_array( $product_options ) || count( $product_options ) === 0 ) {
			return $low_stock;
		}

		foreach ( $product_options as $option ) {
			$option_id = '';

			if ( isset( $option['_id'] ) ) {
				$option_id = sanitize_key( $option['_id'] );
			} else if ( isset( $option['id'] ) ) {
				$option_id = sanitize_key( $option['id'] );
			}

			if ( ! is_numeric( $option_id ) ) {

				// Attribute item.
				$parent_id = '';

				if ( isset( $option['_step_id'] ) ) {
					$parent_id = sanitize_key( $option['_step_id'] );
				} else if ( isset( $option['step_id'] ) ) {
					$parent_id = sanitize_key( $option['step_id'] );
				}

				if ( $parent_id ) {
					$attribute_items = staggs_get_post_meta( $parent_id, 'sgg_attribute_items' );
					$option_stock    = $low_stock;

					foreach ( $attribute_items as $item ) {
						$item_id = sanitize_title( $item['sgg_option_label'] );

						if ( $item_id === $option_id ) {
							if ( '' !== $item['sgg_option_stock_qty'] ) {
								$option_stock = sanitize_key( $item['sgg_option_stock_qty'] );
							}
							break;
						}
					}

					if ( $option_stock < $low_stock) {
						$low_stock = $option_stock;
					}
				}
			}
		}

		return $low_stock;
	}
}

if ( ! function_exists( 'get_attribute_column_header' ) ) {
	/**
	 * Get a list of all PRO attribute fields for import/export tool
	 *
	 * @since    1.5.0
	 */
	function get_attribute_column_header( $filter_data = array() ) {

		/**
		 * List of all attribute columns for import/export
		 */

		$attr_columns = array(
			'attr:id',
			'attr:admin_title',
			'attr:title',
			'attr:template',
			'attr:type',
			'attr:allowed_options',
			'attr:sku',
			'attr:custom_class',
			'attr:shared_group',
			'attr:short_description',
			'attr:description',
			'attr:field_info',
			'attr:style',
			'attr:option_layout',
			'attr:card_template',
			'attr:show_image',
			'attr:show_summary',
			'attr:field_required',
			'attr:field_placeholder',
			'attr:option_price',
			'attr:swatch_size',
			'attr:swatch_style',
			'attr:show_swatch_label',
			'attr:show_tick_all',
			'attr:show_option_price',
			'attr:show_tooltip',
			'attr:tooltip_template',
			'attr:product_template',
			'attr:enable_zoom',
			'attr:button_view',
			'attr:button_add',
			'attr:button_del',
			'attr:calc_price_type',
			'attr:calc_price_key',
			'attr:calc_price_label',
			'attr:calc_price_label_position',
			'attr:price_formula',
			'attr:price_table',
			'attr:price_table_sale',
			'attr:price_table_rounding',
			'attr:price_table_val_x',
			'attr:price_table_type_x',
			'attr:price_table_val_y',
			'attr:price_table_type_y',
			'attr:price_table_val_min',
			'attr:include_option_descriptions',
			'attr:shared_field_min',
			'attr:shared_field_max',
			'attr:gallery_type',
			'attr:preview_order',
			'attr:preview_slide',
			'attr:preview_index',
			'attr:preview_ref',
			'attr:preview_ref_props',
			'attr:preview_bundle',
			'attr:preview_height',
			'attr:model_group',
			'attr:model_image_type',
			'attr:model_image_material',
			'attr:model_material_metalness',
			'attr:model_material_roughness',
			'attr:model_image_target',
			'attr:model_image_orbit',
			'attr:model_image_view',
		);

		$attribute_column_map = array(
			'details' => array(
				'attr:allowed_options',
				'attr:field_placeholder',
				'attr:shared_group',
				'attr:short_description',
				'attr:description',
				'attr:include_option_descriptions',
				'attr:field_required',
				'attr:option_price',
				'attr:button_add',
				'attr:button_del',
			),
			'presentation' => array(
				'attr:swatch_size',
				'attr:swatch_style',
				'attr:button_view',
				'attr:field_info',
				'attr:style',
				'attr:custom_class',
				'attr:show_swatch_label',
				'attr:show_tick_all',
				'attr:show_option_price',
				'attr:show_tooltip',
				'attr:tooltip_template',
				'attr:product_template',
				'attr:enable_zoom',
				'attr:option_layout',
				'attr:card_template',
				'attr:show_image',
				'attr:show_summary',
			),
			'calculation' => array(
				'attr:calc_price_type',
				'attr:calc_price_key',
				'attr:calc_price_label',
				'attr:calc_price_label_position',
				'attr:price_formula',
				'attr:price_table',
				'attr:price_table_sale',
				'attr:price_table_rounding',
				'attr:price_table_val_x',
				'attr:price_table_type_x',
				'attr:price_table_val_y',
				'attr:price_table_type_y',
				'attr:price_table_val_min',
			),
			'gallery' => array(
				'attr:gallery_type',
				'attr:preview_order',
				'attr:preview_slide',
				'attr:preview_index',
				'attr:preview_ref',
				'attr:preview_ref_props',
				'attr:preview_bundle',
				'attr:preview_height',
				'attr:model_group',
				'attr:model_image_type',
				'attr:model_image_material',
				'attr:model_image_target',
				'attr:model_image_orbit',
				'attr:model_image_view',
				'attr:model_material_metalness',
				'attr:model_material_roughness',
			)
		);

		if ( is_array( $filter_data ) && count( $filter_data ) > 0 ) {
			foreach ( $attribute_column_map as $group => $data_columns ) {
				if ( ! in_array( $group, $filter_data )) {
					foreach ( $data_columns as $data_column ) {
						if (($key = array_search($data_column, $attr_columns)) !== false) {
							unset($attr_columns[$key]);
						}
					}
				}
			}
			$attr_columns = array_values($attr_columns);
		}

		/**
		 * List of all attribute options columns for import/export
		 */

		$item_columns = array(
			'item:label',
			'item:note',
			'item:description',
			'item:image',
			'item:sku',
			'item:field_type',
			'item:field_required',
			'item:linked_product_id',
			'item:page_url',
			'item:enable_preview',
			'item:preview',
			'item:preview_node',
			'item:preview_hotspot',
			'item:preview_animation',
			'item:preview_top',
			'item:preview_left',
			'item:preview_width',
			'item:preview_height',
			'item:preview_overflow',
			'item:preview_image_fill',
			'item:preview_custom_mobile',
			'item:preview_top_mobile',
			'item:preview_left_mobile',
			'item:preview_width_mobile',
			'item:product_quantity',
			'item:font_source',
			'item:font_family',
			'item:font_weight',
			'item:datepicker_show_icon',
			'item:datepicker_show_inline',
			'item:datepicker_format',
			'item:preview_ref_selector',
			'item:field_key',
			'item:material_key',
			'item:allowed_file_types',
			'item:max_file_size',
			'item:range_increments',
			'item:range_bubble',
			'item:field_min',
			'item:field_max',
			'item:field_unit',
			'item:field_placeholder',
			'item:field_value',
			'item:field_color',
			'item:base_price',
			'item:calc_price_type',
			'item:price_table',
			'item:calc_price_value',
			'item:price',
			'item:sale_price',
			'item:percentage',
			'item:percentage_field',
			'item:price_formula',
			'item:stock_qty',
		);

		if ( is_array( $filter_data ) && count( $filter_data ) > 0 && ! in_array( 'items', $filter_data ) ) {
			return $attr_columns;
		}

		return array_merge( $attr_columns, $item_columns );
	}
}
