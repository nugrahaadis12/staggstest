<?php

/**
 * The plugin import functions of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.2.0
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

/**
 * The plugin import functions of the plugin.
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

class Staggs_Importer {

	/**
	 * Handle CSV attribute import
	 *
	 * @since    1.4.0
	 */
	public function import_attribute_csv( $csv_file, $separator = ',' ) {
		if ( ! $csv_file ) {
			return;
		}

		/**
		 * Determine columns.
		 */
		$headings = array();
		$row_data = array();

		/**
		 * Read file.
		 */
		$row = 1;
		if ( ( $handle = fopen( $csv_file, 'r' ) ) !== false ) {
			while ( ( $data = fgetcsv( $handle, 3000, $separator ) ) !== false ) {
				$num = count( $data );

				if ( $row === 1 ) {
					for ( $h = 0; $h < $num; $h++ ) {
						$headings[] = $data[ $h ];
					}
				} else {
					$row_item_data = array();

					for ( $c = 0; $c < $num; $c++ ) {
						if ( ! isset( $headings[ $c ] ) ) {
							throw new Exception( esc_attr__( 'Error trying to map columns for selected file.', 'staggs' ) );
						}
						$row_item_data[ $headings[ $c ] ] = $data[ $c ];
					}

					$row_data[] = $row_item_data;
				}
				$row++;
			}

			fclose( $handle );
		}
		
		/**
		 * Check if required columns are present.
		 */
		if ( ! in_array( 'attr:id', $headings ) || ! in_array( 'attr:admin_title', $headings ) || ! in_array( 'attr:title', $headings ) ) {
			throw new Exception( esc_attr__( 'Invalid CSV format. When importing attributes, column attr:id, attr:admin_title or attr:title should be present. Please review your columns and try again.', 'staggs' ) );
		}
		if ( ! in_array( 'item:label', $headings ) ) {
			throw new Exception( esc_attr__( 'Invalid CSV format. When importing attributes, column item:label should be present. Please review your columns and try again.', 'staggs' ) );
		}

		/**
		 * Collect attribute data.
		 */
		$attributes = $this->format_attribute_data( $row_data );

		define( 'STAGGS_RUN_IMPORT', '1' );

		/**
		 * Import Attributes.
		 */
		$result = false;

		if ( count( $attributes ) > 0 ) {
			$column = sanitize_text_field( $_POST['update_values'] ) ?: 'id';
			$action = sanitize_text_field( $_POST['existing_values'] ) ?: 'update';
			$result = true;

			foreach ( $attributes as $attribute ) {
				if ( ! Staggs_Attribute::import( $attribute, $column, $action ) ) {
					$result = false;
					break; // failed. break.
				}
			}
		}

		return $result;
	}

	/**
	 * Format attribute import data
	 *
	 * @since    1.4.0
	 */
	public function format_attribute_data( $row_data ) {
		$attributes = array();

		foreach ( $row_data as $row_line ) {
			if ( isset( $row_line['attr:id'] ) ) {
				$admin_title_key = 'attr:id';
			} else if ( isset( $row_line['attr:admin_title'] ) ) {
				$admin_title_key = 'attr:admin_title';
			} else {
				$admin_title_key = 'attr:title';
			}

			if ( $admin_title_key === 'attr:id' ) {
				$attr_id = 'id-' . sanitize_title( $row_line[ $admin_title_key ] );
			} else {
				$attr_id = sanitize_title( $row_line[ $admin_title_key ] );
			}

			$item_data  = array();
			if ( ! array_key_exists( $attr_id, $attributes ) ) {
				$attributes[ $attr_id ] = array();
			}
			if ( ! array_key_exists( 'items', $attributes[ $attr_id ] ) ) {
				$attributes[ $attr_id ]['items'] = array();
			}
			
			foreach ( $row_line as $row_key => $row_val ) {
				if ( strpos( $row_key, 'attr:' ) !== false ) {
					$field_key = str_replace( 'attr:', 'sgg_step_', $row_key );

					if ( 'sgg_step_id' === $field_key ) {
						$field_key = 'id';
					}
					if ( 'sgg_step_type' === $field_key ) {
						$field_key = 'sgg_attribute_type';
					}
					if ( 'sgg_step_admin_title' === $field_key ) {
						$field_key = 'admin_title';
					}

					// Set if not exists (e.g. first row)
					if ( ! isset( $attributes[ $attr_id ][ $field_key ] ) ) {
						$attributes[ $attr_id ][ $field_key ] = $row_val;
					}

				} else if ( strpos( $row_key, 'item:' ) !== false ) {
					$field_key = str_replace( 'item:', 'sgg_option_', $row_key );

					if ( in_array( $field_key, array( 'sgg_option_id', 'sgg_option_title' ) ) ) {
						continue;
					}

					if ( 'sgg_option_type' === $field_key ) {
						$attributes[ $attr_id ]['sgg_step_type'] = $row_val;
						continue;
					}

					if ( 'sgg_option_field_label' === $field_key ) {
						$field_key = 'sgg_option_label';
					}

					$item_data[ $field_key ] = $row_val;
				}	
			}

			$attributes[ $attr_id ][ 'items' ][] = $item_data;
		}

		return $attributes;
	}
}
