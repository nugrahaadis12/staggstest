<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.5
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/admin
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Admin_PRO {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.3.5
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.3.5
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.3.5
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		// add_action( 'updated_option', array( $this, 'register_option_string_translation' ), 10, 3 );
	}

	/**
	 * Register PDF setting string translations to database
	 *
	 * @since    1.12.0
	 */
	public function register_option_string_translation( $option, $old_value, $value ) {
		if ( ! function_exists( 'icl_register_string' ) ) {
			return;
		}

		$strings = array(
			'sgg_pdf_custom_header_address',
			'sgg_pdf_custom_intro',
			'sgg_pdf_product_heading',
			'sgg_pdf_options_heading',
			'sgg_pdf_table_step_heading',
			'sgg_pdf_table_value_heading',
			'sgg_pdf_table_price_heading',
			'sgg_pdf_table_price_total_label',
			'sgg_pdf_forbidden_option_labels',
		);

		if ( ! in_array( $option, $strings ) ) {
			return;
		}

		icl_register_string( 'staggs', $option, staggs_get_theme_option( $value ) );
	}

	/**
	 * Adds buttons to product items listing page
	 *
	 * @since    1.3.5
	 */
	public function display_attribute_tool_buttons() {
		global $current_screen;
		// Not our post type, exit earlier
		// You can remove this if condition if you don't have any specific post type to restrict to.
		if ( 'sgg_attribute' !== $current_screen->post_type ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready( function($) {
				var html = jQuery(".wrap .page-title-action:last-of-type")
					.after("<a href='<?php echo esc_url( admin_url( 'edit.php?post_type=sgg_attribute&page=tools' ) ); ?>' class='page-title-action'><?php esc_attr_e( 'Import / Export', 'staggs' ); ?></a>");
			});
		</script>
		<?php
	}
	
	/**
	 * Catch Generate PDF product action
	 *
	 * @since    1.3.5
	 */
	public function ajax_do_pdf_download() {
		if ( isset( $_POST['generate_pdf'] ) ) {
			$product_id = sanitize_key( $_POST['generate_pdf'] );

			if ( 'product' === get_post_type( $product_id ) ) {
				// Get filtered POST data.
				if ( isset( $_POST['options'] ) ) {
					$string_options = sanitize_text_field( $_POST['options'] );
					$json_options   = json_decode( str_replace( '\\\'', '"', $string_options), true );
				} else {
					$json_options = array();
					foreach ( $_POST as $key => $value ) {
						if ( $key !== 'product_price' && $key !== 'product_image' && $key !== 'generate_pdf' ) {
							$json_options[] = array(
								'name' => $key,
								'value' => $value
							);
						}
					}
				}

				$image_url = '';
				if ( isset( $_POST['product_image'] ) ) {
					$image_url = sanitize_text_field( $_POST['product_image'] );
				} else if ( get_the_post_thumbnail_url( $product_id ) ) {
					$image_url = get_the_post_thumbnail_url( $product_id );
				}

				$pdf_data = array(
					'product_price' => isset( $_POST['product_price'] ) ? sanitize_text_field( $_POST['product_price'] ) : '',
					'product_image' => $image_url,
					'configuration' => $json_options,
				);

				$pdf_data = apply_filters( 'staggs_generate_pdf_data', $pdf_data, $product_id );

				do_action( 'staggs_generate_pdf', $product_id, $pdf_data );
			}
		}
	}

	/**
	 * Allow 3D model uploads
	 *
	 * @since    1.3.5
	 */
	public function modify_upload_mime_types( $mime_types ) {
		$mime_types['gltf'] = 'model/gltf+json';
		$mime_types['glb']  = 'model/gltf-binary';
		$mime_types['hdr']  = 'image/hdr';
		$mime_types['svg']  = 'image/svg';

		return $mime_types;
	}

	/**
	 * Modify mime file checks
	 *
	 * @since    1.3.5
	 */
	public function modify_mime_type_file_checks( $data, $file, $filename, $mime_types, $real_mime_type ) {
		if ( empty( $data['ext'] ) || empty( $data['type'] ) ) {
			$file_type = wp_check_filetype( $filename, $mime_types );
			
			if ( 'gltf' === $file_type['ext'] ) {
				$data['ext']  = 'gltf';
				$data['type'] = 'model/gltf+json';
			}

			if ( 'glb' === $file_type['ext'] ) {
				$data['ext']  = 'glb';
				$data['type'] = 'model/glb-binary';
			}

			if ( 'hdr' === $file_type['ext'] ) {
				$data['ext']  = 'hdr';
				$data['type'] = 'image/hdr';
			}

			if ( 'svg' === $file_type['ext'] ) {
				$data['ext']  = 'svg';
				$data['type'] = 'image/svg';
			}
		}

		return $data;
	}
}
