<?php

/**
 * The plugin export functions of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.2.0
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

/**
 * The plugin export functions of the plugin.
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */
class Staggs_Exporter {

	/**
	 * Export all attribute data to CSV file.
	 *
	 * @since    1.4.0
	 */
	public function export_attribute_csv( $filter_attribute_id = '', $separator = ',', $filter_data = array() ) {
		$filename = 'staggs-attributes';
		$columns  = get_attribute_column_header( $filter_data );
		$data     = $this->get_attribute_column_data( $columns, $filter_attribute_id, $filter_data );

		if ( $columns && $data ) {
			header( 'Content-Type: text/csv; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename=' . $filename . '-' . date('Y-m-d') . '.csv' );

			$output = fopen( 'php://output', 'w' );
			ob_end_clean();

			fputcsv( $output, $columns, $separator );
			foreach ( $data as $data_item ) {
				fputcsv( $output, $data_item, $separator );
			}
			exit;
		}
	}

	/**
	 * Collect all attribute column data.
	 *
	 * @since    1.4.0
	 */
	public function get_attribute_column_data( $columns, $filter_attribute_id = '', $filter_data = array() ) {
		$data = array();

		$attribute_args = array(
			'post_type'      => 'sgg_attribute',
			'post_status'    => 'publish',
			'posts_per_page' => 999999,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		);

		if ( '' !== $filter_attribute_id ) {
			$attribute_args['post__in'] = array( $filter_attribute_id );
		}

		$attributes = get_posts( $attribute_args );
		if ( is_array( $attributes ) && count( $attributes ) > 0 ) {
			foreach ( $attributes as $attribute_id ) {
				$attribute_data = array();
				$parent_row = true;

				foreach ( $columns as $column ) {
					if ( strpos( $column, 'attr:' ) !== false ) {
						if ( $column === 'attr:id' ) {
							$attribute_data[ $column ] = sanitize_key( $attribute_id );
						} else if ( $column === 'attr:admin_title' ) {
							$attribute_data[ $column ] = sanitize_text_field( get_the_title( $attribute_id ) );
						} else if ( $column === 'attr:description' ) {
							$attribute_data[ $column ] = wp_kses( staggs_get_post_meta( $attribute_id, 'sgg_step_description' ), 'post' );
						} else if ( $column === 'attr:type' ) {
							$attribute_data[ $column ] = sanitize_text_field( staggs_get_post_meta( $attribute_id, 'sgg_attribute_type' ) );
						} else {
							$field_key = str_replace( 'attr:', 'sgg_step_', $column );
							$attribute_data[ $column ] = sanitize_text_field( staggs_get_post_meta( $attribute_id, $field_key ) );
						}
					}
				}

				$step_options = staggs_get_post_meta( $attribute_id, 'sgg_attribute_items' );
				if ( is_array( $step_options ) && count( $step_options ) > 0 ) {
					foreach ( $step_options as $option ) {
						$item_data = array();
	
						foreach ( $attribute_data as $key => $val ) {
							if ( $parent_row ) {
								$item_data[ $key ] = $val;
							} else {
								if ( in_array( $key, array( 'attr:id', 'attr:admin_title', 'attr:title', 'attr:sku' ) ) ) {
									$item_data[ $key ] = $val;
								} else {
									$item_data[ $key ] = '';
								}
							}
						}

						foreach ( $columns as $column ) {
							if ( strpos( $column, 'item:' ) !== false && ( in_array( 'items', $filter_data ) || count( $filter_data ) === 0 ) ) {
								$field_key = str_replace( 'item:', 'sgg_option_', $column );

								if ( isset( $option[ $field_key ] ) ) {
									$optval = $option[ $field_key ];

									if ( $optval ) {
										if ( 'item:image' === $column ) {
											$item_data['item:image'] = sanitize_url( wp_get_attachment_image_url( $optval, 'full' ) );
										} else if ( 'item:preview' === $column ) {
											$preview_urls = array();
											foreach ( $optval as $preview_id ) {
												$preview_urls[] = sanitize_url( wp_get_attachment_image_url( $preview_id, 'full' ) );
											}
											$item_data['item:preview'] = sanitize_text_field( implode( '|', $preview_urls ) );
										} else {
											$item_data[ $column ] = sanitize_text_field( $optval );
										}
									} else {
										$item_data[ $column ] = sanitize_text_field( $optval );
									}
								} else {
									$item_data[ $column ] = '';
								}
							}
						}

						$data[] = array_values( $item_data );

						$parent_row = false;
					}
				}
			}
		}

		return $data;
	}
}
