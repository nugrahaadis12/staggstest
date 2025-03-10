<?php

/**
 * The admin-specific tool functions of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.2.0
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/admin
 */

/**
 * The admin-specific tool functions of the plugin.
 *
 * Defines the plugin tools.
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/admin
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Tools {

	/**
	 * Instance.
	 *
	 * @var Staggs_Importer
	 */
	private $importer;

	/**
	 * Instance.
	 *
	 * @var Staggs_Exporter
	 */
	private $exporter;

	/**
	 * Constructor.
	 */
	public function __construct( $importer, $exporter ) {
		$this->importer = $importer;
		$this->exporter = $exporter;
	}

	/**
	 * Short description.
	 *
	 * @since    1.2.0
	 */
	public function register_sub_menu() {
		add_submenu_page(
			'edit.php?post_type=sgg_attribute',
			__( 'Import/Export', 'staggs' ),
			__( 'Import/Export', 'staggs' ),
			'edit_posts',
			'tools',
			array( $this, 'sub_menu_page_contents' )
		);
	}

	/**
	 * Short description.
	 *
	 * @since    1.0.0
	 */
	public function sub_menu_page_contents() {
		// Show page contents.
		include 'partials/staggs-tools-page.php';
	}

	/**
	 * Short description.
	 *
	 * @since    1.2.0
	 */
	public function display_import_notices() {
		// Display notices set during import process.
		if ( $message = get_transient( 'success_import_notice' ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>';
			echo esc_attr( $message );
			echo '</p></div>';

			delete_transient( 'success_import_notice' );
		}

		if ( $error = get_transient( 'failure_import_notice' ) ) {
			echo '<div class="notice notice-error is-dismissible"><p>';
			echo esc_attr( $error );
			echo '</p></div>';

			delete_transient( 'failure_import_notice' );
		}
	}

	/**
	 * Short description.
	 *
	 * @since    1.4.0
	 */
	public function process_attribute_import_form() {
		// Validate form submission.
		if ( ! isset( $_POST['backup_attr_notice'] ) ) {
			set_transient( 'failure_import_notice', __( 'Please accept database modification.', 'staggs' ) );
		}

		// Validate form submission.
		if ( ! isset( $_POST['sgg_import_attribute_nonce'] ) || ! wp_verify_nonce( $_POST['sgg_import_attribute_nonce'], 'sgg_import_attributes_form_nonce' ) ) {
			wp_die(
				esc_attr__( 'Invalid nonce specified', 'staggs' ),
				esc_attr__( 'Error', 'staggs' ),
				array(
					'response'  => 403,
					'back_link' => 'edit.php?post_type=sgg_attribute&page=tools',
				)
			);
		}

		// Get upload directory details.
		$uploads     = wp_upload_dir();
		$uploads_dir = trailingslashit( $uploads['basedir'] );

		// Sanitize input data.
		$separator = sanitize_text_field( $_POST['separator'] );
		if ( 'other' == $separator ) {
			$separator = sanitize_text_field( $_POST['other-separator'] );
		}

		// Do the processing.
		$file = $_FILES['importfile'];

		if ( $file['name'] && $file['name'] !== '' ) {
			try {
				if ( ! $this->handle_file_upload( $file, $uploads_dir ) ) {
					throw new Exception( esc_attr__( 'Error trying to upload selected file.', 'staggs' ) );
				}

				$processed = $this->importer->import_attribute_csv( $uploads_dir . basename( $file['name'] ), $separator );
				if ( ! $processed ) {
					throw new Exception( esc_attr__( 'Error trying to process selected file.', 'staggs' ) );
				}

				unlink( $uploads_dir . basename( $file['name'] ) );
				set_transient( 'success_import_notice', __( 'Succesfully imported selected attributes.', 'staggs' ) );
			} catch ( Exception $e ) {
				unlink( $uploads_dir . basename( $file['name'] ) );
				set_transient( 'failure_import_notice', $e->getMessage() );
			}
		} else {
			set_transient( 'failure_import_notice', __( 'Please select a file to import.', 'staggs' ) );
		}

		wp_safe_redirect( admin_url( 'edit.php?post_type=sgg_attribute&page=tools' ) );
		die();
	}

	/**
	 * Short description.
	 *
	 * @since    1.4.0
	 */
	public function process_attribute_export_form() {
		// Validate form submission.
		if ( ! isset( $_POST['sgg_export_attribute_nonce'] ) || ! wp_verify_nonce( $_POST['sgg_export_attribute_nonce'], 'sgg_export_attributes_form_nonce' ) ) {
			wp_die(
				esc_attr__( 'Invalid nonce specified', 'staggs' ),
				esc_attr__( 'Error', 'staggs' ),
				array(
					'response'  => 403,
					'back_link' => 'edit.php?post_type=sgg_attribute&page=tools',
				)
			);
		}

		// Sanitize the input.
		$attribute_id = '';
		if ( isset( $_POST['attribute'] ) ) {
			$attribute_id = sanitize_key( $_POST['attribute'] );
		}

		// Sanitize input data.
		$separator = sanitize_text_field( $_POST['separator'] );
		if ( 'other' == $separator ) {
			$separator = sanitize_text_field( $_POST['other-separator'] );
		}

		$export_group = isset(  $_POST['export_group'] ) ? $_POST['export_group'] : array();
		$filter_data = array_map( 'sanitize_text_field', $export_group );

		$this->exporter->export_attribute_csv( $attribute_id, $separator, $filter_data );

		wp_safe_redirect( admin_url( 'edit.php?post_type=sgg_attribute&page=tools' ) );
		die();
	}

	/**
	 * Short description.
	 *
	 * @since    1.2.0
	 */
	public function handle_file_upload( $file, $path ) {
		$file_name      = $file['name'];
		$file_size      = $file['size'];
		$file_tmp_name  = $file['tmp_name'];
		$file_type      = $file['type'];
		$file_parts     = explode( '.', $file['name'] );
		$file_extension = strtolower( end( $file_parts ) );
		$upload_path    = $path . basename( $file_name );

		$file_extensions_allowed = array( 'csv' ); // These will be the only file extensions allowed
		if ( ! in_array( $file_extension, $file_extensions_allowed ) ) {
			throw new Exception( esc_attr__( 'This file extension is not allowed. Please upload a CSV file', 'staggs' ) );
		}

		if ( $file_size > wp_max_upload_size() ) {
			throw new Exception( esc_attr( sprintf( __( 'File exceeds maximum size (%s)', 'staggs' ), wp_max_upload_size() ) ) );
		}

		return move_uploaded_file( $file_tmp_name, $upload_path );
	}

	/**
	 * Short description.
	 *
	 * @since    1.6.0
	 */
	public function process_generate_form() {

		// $product_id = $_POST['product'];
		// $attributes = $_POST['attributes'];

		// $builder_options = staggs_get_post_meta( $product_id, 'sgg_configurator_attributes' );

		// echo '<pre>';

		// $options = array();
		// foreach ( $builder_options as $attribute ) {
		// 	if ( 'attribute' !== $attribute['_type'] ) {
		// 		continue;
		// 	}

		// 	$attr_id = $attribute['sgg_step_attribute'];
		// 	$options = staggs_get_post_meta( $attr_id, 'sgg_attribute_items' );

		// 	$sorted_options[ $attr_id ] = array(
		// 		'options' => array(),
		// 		'rules' => array(),
		// 	);

		// 	if ( $attribute['sgg_step_conditional_rules'] ) {
		// 		foreach ( $attribute['sgg_step_conditional_rules'] as $rule ) {
		// 			$sorted_options[ $attr_id ]['rules'][ 'step-' . $rule['sgg_step_conditional_step'] ] = array(
		// 				'value' => $rule['sgg_step_conditional_value'],
		// 				'compare' => $rule['sgg_step_conditional_compare'],
		// 				'relation' => $rule['sgg_step_conditional_relation'],
		// 			);
		// 		}
		// 	}

		// 	foreach ( $options as $item ) {
		// 		$price = 0;
		// 		if ( isset( $item['sgg_option_sale_price'] ) ) {
		// 			$price = $item['sgg_option_sale_price'];
		// 		} else if ( isset(  $item['sgg_option_price'] ) ){
		// 			$price = $item['sgg_option_price'];
		// 		}

		// 		$image = '';
		// 		if ( is_array( $item['sgg_option_preview'] ) && count( $item['sgg_option_preview'] ) > 0 ) {
		// 			$image = wp_get_attachment_image_url( $item['sgg_option_preview'][0], 'full' );
		// 		}

		// 		$sorted_options[ $attr_id ]['options'][ staggs_sanitize_title( $item['sgg_option_label'] ) ] = array(
		// 			'label' => $item['sgg_option_label'],
		// 			'previews' => $image,
		// 			'price' => $price
		// 		);
		// 	}
		// }

		// Collect all possible variants.
		// Desired format
		// [options] => Array
		// (
		// 	[2-seater] => Array
		// 	(
		// 		[label] => 2 seater
		// 		[previews] => 
		// 		[price] => 
		// 	)
		// 	[fabric] => Array
		// 	(
		// 		[label] => Fabric
		// 		[previews] => 
		// 		[price] => 
		// 	)
		// 	[grey] => Array
		// 	(
		// 		[label] => Grey
		// 		[previews] => http://productconfigurator.test/wp-content/uploads/2023/03/Group-36.png
		// 		[price] => 
		// 	)
		// 	[default-legs] => Array
		// 		(
		// 			[label] => Default legs
		// 			[previews] => http://productconfigurator.test/wp-content/uploads/2023/03/Group-15.png
		// 			[price] => 
		// 		)
		// )
		
		// print_r($product_id);
		// print_r($builder_options);
		// print_r($sorted_options);

		// die();
		
	}
}
