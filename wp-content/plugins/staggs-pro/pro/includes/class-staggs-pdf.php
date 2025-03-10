<?php

/**
 * The product PDF export functions for the plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.1
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

if ( ! defined('ABSPATH') ) {
	die();
}

use Dompdf\Dompdf;

/**
 * The plugin PDF export functions
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

class Staggs_PDF {

	/**
	 * Load PDF dependencies
	 *
	 * @since    1.5.0
	 */
	public function sgg_load_pdf() {
		if ( ! class_exists('Dompdf') ) {
			require_once( STAGGS_BASE . 'vendor/autoload.php' );
		}
	}

	/**
	 * PDF AJAX get url callback
	 *
	 * @since    1.8.2
	 */
	public function get_pdf_file_url_ajax() {
		$pdf_data = $_POST['pdf'];
		$pdf_url  = $this->generate_pdf_file_url( $pdf_data['product_id'], $pdf_data, md5( microtime() ) );

		wp_send_json(array(
			'url' => $pdf_url
		));
	}

	/**
	 * PDF get generated PDF file url
	 *
	 * @since    1.7.3
	 */
	public function generate_pdf_file_url( $pdf_product_id, $pdf_data, $cart_hash ) {
		$template = staggs_get_theme_option( 'sgg_pdf_layout' );

		$pdf_data = apply_filters( 'staggs_generate_pdf_data', $pdf_data, $pdf_product_id );

		$pdf_html = $this->get_pdf_html( $pdf_product_id, $pdf_data, $template );

		$pdf = new Dompdf(
			array(
				'enable_remote' => true
			)
		);
		if ( 'wide' === $template ) {
			$pdf->setPaper('A3', 'landscape');
		} else {
			$pdf->setPaper('A3', 'portrait');
		}
		$pdf->loadHtml( $pdf_html );
		$pdf->render();

		// Create PDF file.
		$upload_dir = wp_get_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$save_path  = $base_dir . '/staggs';
		$filename   = staggs_sanitize_title( get_the_title( $pdf_product_id ) ) . '-' . $cart_hash . '.pdf';
		$pdf_file   = trailingslashit($save_path) . $filename;
		
		file_put_contents( $pdf_file, $pdf->output() );

		return str_replace( ABSPATH, trailingslashit( get_site_url() ), $pdf_file );
	}

	/**
	 * PDF AJAX download callback
	 *
	 * @since    1.6.0
	 */
	public function download_pdf_result_ajax() {

		$pdf_data = $_POST['pdf'];

		$pdf_data = apply_filters( 'staggs_generate_pdf_data', $pdf_data, $pdf_data['product_id'] );

		$template = staggs_get_theme_option( 'sgg_pdf_layout' );
		$pdf_html = $this->get_pdf_html( $pdf_data['product_id'], $pdf_data, $template );

		$pdf = new Dompdf(
			array(
				'enable_remote' => true
			)
		);

		if ( 'wide' === $template ) {
			$pdf->setPaper('A3', 'landscape');
		} else {
			$pdf->setPaper('A3', 'portrait');
		}

		$pdf->loadHtml( $pdf_html );
		$pdf->render();

		$filename = get_the_title( $pdf_data['product_id'] ) . '.pdf';

		if ( isset( $pdf_data['pdf_user_email'] ) ) {
			// PDF generation success. Send out email notification if set.
			$email      = sanitize_text_field( $pdf_data['pdf_user_email'] );
			$theme_id   = $this->get_theme_id( $pdf_data['product_id'] );
			$admin_mail = get_option( 'admin_email' );
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_email_recipient' ) ) {
				$admin_mail = staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_email_recipient' );
			}

			$subject = staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_email_subject' ) ?: __( 'New PDF download', 'staggs' );
			$subject = apply_filters( 'staggs_admin_pdf_mail_subject', $subject );

			$content = staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_email_content' ) ?: __( '%s has downloaded a configuration PDF.', 'staggs' );
			$content = sprintf( $content, $email ); // Replace '%s' with email.
			$content = apply_filters( 'staggs_admin_pdf_mail_content', $content );

			// Create PDF file.
			$pdf_save_file = STAGGS_BASE . time() . $filename;
			file_put_contents( $pdf_save_file, $pdf->output() );

			// Add attachment.
			$attachments = array( $pdf_save_file );

			wp_mail( $admin_mail, $subject, $content, '', $attachments );

			do_action( 'staggs_send_admin_pdf_notification', $email, $subject, $content, '', $attachments );

			// Delete file again to preserve server disk space.
			unlink( $pdf_save_file );
		}
		
		wp_send_json(array(
			'file_name' => $filename,
			'file' => 'data:application/pdf;base64,' . base64_encode( $pdf->output() )
		));
	}

	/**
	 * Generate PDF
	 *
	 * @since    1.3.1
	 */
	public function generate_pdf( $product_id, $product_values ) {
		$template = staggs_get_theme_option( 'sgg_pdf_layout' );
		$pdf_html = $this->get_pdf_html( $product_id, $product_values, $template );

		$pdf = new Dompdf(
			array(
				'enable_remote' => true
			)
		);

		if ( 'wide' === $template ) {
			$pdf->setPaper('A3', 'landscape');
		} else {
			$pdf->setPaper('A3', 'portrait');
		}

		$pdf->loadHtml( $pdf_html );
		$pdf->render();
		$pdf->stream( get_the_title( $product_id ) . '.pdf' );
		die();
	}

	/**
	 * Get PDF html content
	 *
	 * @since    1.3.1
	 */
	public function get_pdf_html( $product_id, $product_values, $template ) {
		$pdf_html = sprintf(
			'<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title>%1$s</title>
				<style type="text/css">%2$s</style>
			</head>
			<body>',
			get_the_title( $product_id ),
			$this->get_pdf_styles()
		);

		if ( 'wide' === $template ) {
			$pdf_html .= '<table class="pdf-content pdf-content-wide pdf-content-header">';
			$pdf_html .= $this->get_pdf_header( $product_values );
			$pdf_html .= '</table>';

			$pdf_html .= '<table class="pdf-content pdf-content-wide pdf-content-main">';
			$pdf_html .= '<tr>';
			$pdf_html .= '<td>';
			$pdf_html .= '<table class="pdf-product-content-image">';

			$pdf_html .= $this->get_pdf_product_details( $product_id, $product_values );

			$pdf_html .= '</table>';
			$pdf_html .= '</td>';
			$pdf_html .= '<td>';

			$pdf_html .= $this->get_pdf_product_configuration( $product_id, $product_values, $template );

			$pdf_html .= '</td>';
			$pdf_html .= '</tr>';
			$pdf_html .= '</table>';

			$pdf_html .= '<table class="pdf-content pdf-content-wide pdf-content-footer">';
			$pdf_html .= $this->get_pdf_footer( $product_values );
			$pdf_html .= '</table>';
		} else {
			$pdf_html .= '<table class="pdf-content pdf-content-small pdf-content-header">';
			$pdf_html .= $this->get_pdf_header( $product_values );
			$pdf_html .= '</table>';

			$pdf_html .= '<table class="pdf-content-small pdf-product-content-image">';
			$pdf_html .= $this->get_pdf_product_details( $product_id, $product_values );
			$pdf_html .= '</table>';

			$pdf_html .= $this->get_pdf_product_configuration( $product_id, $product_values, $template );

			$pdf_html .= '<table class="pdf-content pdf-content-small pdf-content-footer">';
			$pdf_html .= $this->get_pdf_footer( $product_values );
			$pdf_html .= '</table>';
		}

		$pdf_html .= '</body>';
		$pdf_html .= '</html>';

		// Allow plugins to modify HTML.
		$pdf_html = apply_filters( 'staggs_pdf_html', $pdf_html );

		return $pdf_html;
	}

	/**
	 * Get product configurator theme ID
	 *
	 * @since    1.4.3
	 */
	public function get_theme_id( $product_id ) {
		$theme_id = staggs_get_post_meta( $product_id, 'sgg_product_configurator_theme_id' );
		return $theme_id;
	}

	/**
	 * Render product information html
	 *
	 * @since    1.3.1
	 */
	public function get_pdf_product_details( $product_id, $product_values ) {

		$theme_id = $this->get_theme_id( $product_id );
		$price    = '';

		$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
		if ( staggs_get_theme_option( 'sgg_pdf_hide_price_totals' ) ) {
			$display_price = 'hide';
		}
		if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
			$display_price = 'hide';
		}

		if ( 'hide' !== $display_price ) {
			$display_base_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_disable_product_price_update' );
			if ( $display_base_price ) {
				$total_price = $product_values['base_price'];
			} else {
				$total_price = $product_values['product_price'];
			}
			
			$tax_label = __( staggs_get_theme_option( 'sgg_product_tax_label' ), 'staggs' ) ?: '';
			if ( '' !== $tax_label ) {
				$tax_label = ' <small>' . $tax_label . '</small>';
			}
			
			if ( get_post_type( $product_id ) === 'product' && 'yes' === get_option( 'woocommerce_calc_taxes' ) ) {
				global $staggs_price_settings;
				if ( ! $staggs_price_settings ) {
					staggs_define_price_settings();
				}
				
				$tax_price_display = staggs_get_theme_option( 'sgg_pdf_total_price_tax' );
				$product = wc_get_product( $product_id );
				if ( 'no' === $staggs_price_settings['include_tax'] && 'incl' === $tax_price_display ) {
					$total_price = wc_get_price_including_tax( $product, array( 'price' => $total_price ) );
				} else if ( 'yes' === $staggs_price_settings['include_tax'] && 'excl' === $tax_price_display ) {
					$total_price = wc_get_price_excluding_tax( $product, array( 'price' => $total_price ) );
				}
			}

			$price = staggs_format_price( $total_price ) . $tax_label;
		}

		$image_html  = '';
		$width       = 800;
		$height      = 0;
		$image_width = staggs_get_theme_option( 'sgg_pdf_image_width' );
		if ( is_numeric( $image_width ) ) {
			$width = $image_width;
		}

		$image_url = isset( $product_values['product_image'] ) ? $product_values['product_image'] : '';
		if ( ! $image_url && get_post_thumbnail_id( $product_id ) ) {
			$image_url = wp_get_attachment_image_url( get_post_thumbnail_id( $product_id ), 'full' );
		}

		if ( $image_url && ! staggs_get_theme_option( 'sgg_pdf_hide_product_image' ) ) {
			$image_html = '<img src="' . $image_url . '"';
			$style = ' style="';
			if ( 0 !== $width ) {
				$style .= ' width:' . $width . 'px;';
			} else {
				$style .= ' width: auto';
			}
			if ( 0 !== $height ) {
				$style .= ' height:' . $height . 'px;';
			} else {
				$style .= ' height: auto;';
			}
			$image_html .= $style . '">';
		}

		$product_title = get_the_title( $product_id );
		if ( isset( $product_values['order_id'] ) && '' !== $product_values['order_id'] ) {
			$product_title = '#' . $product_values['order_id'] . ' - ' . $product_title;
		}
		$product_title = apply_filters( 'staggs_pdf_product_title', $product_title, $product_id, $product_values );

		$intro_html = '';
		if ( staggs_get_theme_option( 'sgg_pdf_custom_intro' ) ) {
			$intro_html .= staggs_get_theme_option( 'sgg_pdf_custom_intro' );
		}
		if ( staggs_get_theme_option( 'sgg_pdf_include_product_description' ) ) {
			$intro_html .= wpautop( get_the_excerpt( $product_id ) );
		}
		if ( '' !== $intro_html ) {
			$intro_html = '<tr><td id="details_intro" colspan="2">' . $intro_html . '</td></tr>';
		}

		$pdf_product_html = sprintf(
			'<tr class="details-title-wrapper">
				<td colspan="2">
					<h3 class="details-title">%1$s</h3>
				</td>
			</tr>
			<tr id="details" class="clearfix">
				<td id="details_title">
					<h1>%2$s</h1>
				</td>
				<td id="details_price">
					<p>%3$s</p>
				</td>
			</tr>
			%5$s
			<tr>
				<td id="details_image" colspan="2">
					%4$s
				</td>
			</tr>',
			staggs_get_theme_option( 'sgg_pdf_product_heading' ) ?: __( 'Your design', 'staggs' ),
			$product_title,
			$price,
			$image_html,
			$intro_html,
		);

		return apply_filters( 'staggs_pdf_product_details', $pdf_product_html, $product_id, $product_values );
	}

	/**
	 * Render product details html
	 *
	 * @since    1.3.1
	 */
	public function get_pdf_product_configuration( $product_id, $product_values, $template = 'default' ) {
		$inc_price_label = '';
		if ( staggs_get_post_meta( $product_id, 'sgg_step_set_included_option_text' ) ) {
			$inc_price_label = sanitize_text_field( staggs_get_post_meta( $product_id, 'sgg_step_included_text' ) );
		}

		$option_html = '';
		$current_row = 0;
		$first_page  = true;
		$first_page_row_count = apply_filters( 'staggs_pdf_first_page_row_count', 11 );
		$full_page_row_count  = apply_filters( 'staggs_pdf_full_page_row_count', 16 );

		$forbidden_options = array();
		if ( $hidden_options = staggs_get_theme_option( 'sgg_pdf_forbidden_option_labels' ) ) {
			$forbidden_options = array_map( 'trim', explode( ',', $hidden_options ) );
			$forbidden_options = array_map( 'strtolower', $forbidden_options );
		}

		$show_option_skus = staggs_get_theme_option( 'sgg_pdf_show_option_skus' );
		$show_option_notes = staggs_get_theme_option( 'sgg_pdf_show_option_notes' );
		$show_option_prices = 'show';
		if ( ! staggs_get_theme_option( 'sgg_pdf_show_option_prices' ) ) {
			$show_option_prices = 'hide';
		}
		if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
			$show_option_prices = 'hide';
		}

		$text_transform = sanitize_text_field( staggs_get_theme_option( 'sgg_pdf_text_style' ) );
		if ( ! $text_transform || 'default' === $text_transform ) {
			$text_transform = 'inherit';
		}

		if ( staggs_get_theme_option( 'sgg_pdf_include_default_attributes' ) ) {
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$product = wc_get_product( $product_id );

				if ( $product->has_attributes() ) {
					$attributes = $product->get_attributes();

					foreach($attributes as $attr => $attr_deets){
						$attribute_label = wc_attribute_label($attr);

						if ( 'wide' == $template ) {
							if ( ( $first_page && $current_row >= $first_page_row_count ) || $current_row >= $full_page_row_count ) {
								$option_html .= '</td></tr></table>';
								$option_html .= '<table class="pdf-content pdf-content-wide pdf-content-main">';
								$option_html .= '<tr><td>';
								$option_html .= '<table class="pdf-product-content-image"></table>';
								$option_html .= '</td><td>';

								$current_row = 0;
								if ( $first_page ) {
									$first_page = false;
								}
							}
						}
			
						if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {
							$attribute  = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];
							$attr_value = '';

							if ( $attribute['is_taxonomy'] ) {
								$attr_value = implode( ', ', wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) ) );
							} else {
								$attr_value = $attribute['value'];
							}

							$price_col = '';
							if ( 'hide' !== $show_option_prices ) {
								$price_col = '<td class="details-option-price"></td>';
							}

							$option_html .= '<table class="pdf-content-' . $template . ' pdf-product-content-details table_content">
								<tr class="table_row clearfix">
									<td class="details-option-name">' . $attribute_label . '</td>
									<td>' . $attr_value . '</td>
									' . $price_col . '
								</tr>
							</table>';
						}
					}
				}
			}
		}

		$pdf_configuration_values = $product_values['configuration'];
		if ( 'hide' !== $show_option_prices ) {
			$configuration_totals = get_configurator_cart_totals(
				array(
					'options' => $product_values['configuration']
				),
				$product_values['product_price'],
				$product_id
			);
			$pdf_configuration_values = $configuration_totals['options'];
		}

		$product_attr_display = staggs_get_theme_option( 'sgg_product_attribute_value_display' ) ?: 'label_value';
		$pdf_configuration_values = apply_filters( 'staggs_get_pdf_configuration_values', $pdf_configuration_values );
		foreach ( $pdf_configuration_values as $option ) {
			$price_html = '';

			if ( 'original_post_id' == $option['name'] ) {
				continue;
			}
			if ( isset( $option['hidden'] ) && $option['hidden'] == 'true' ) {
				continue;
			}

			$formatted_option_name = str_replace( '-', ' ', $option['name'] );
			if ( is_array( $forbidden_options ) && in_array( $formatted_option_name, $forbidden_options ) ) {
				continue;
			}

			if ( 'inherit' === $text_transform ) {
				$formatted_option_name = ucfirst( $formatted_option_name );
			} else if ( 'capitalize' === $text_transform ) {
				$formatted_option_name = ucwords( $formatted_option_name );
			} else if ( 'uppercase' === $text_transform ) {
				$formatted_option_name = strtoupper( $formatted_option_name );
			}

			if ( isset( $option['label'] ) && '' !== $option['label'] ) {
				$formatted_option_name = $option['label'];
			}

			if ( 'wide' == $template ) {
				if ( ( $first_page && $current_row >= $first_page_row_count ) || $current_row >= $full_page_row_count ) {
					$option_html .= '</td></tr></table>';
					$option_html .= '<table class="pdf-content pdf-content-wide pdf-content-main">';
					$option_html .= '<tr><td>';
					$option_html .= '<table class="pdf-product-content-image"></table>';
					$option_html .= '</td><td>';

					$current_row = 0;
					if ( $first_page ) {
						$first_page = false;
					}
				}
			}

			if ( is_array( $option['value'] ) ) {

				/**
				 * Repeater value
				 */
				$option_value_html = '';
				$option_group_price = 0;

				foreach ( $option['value'] as $sub_index => $sub_attribute ) {
					if ( '0' == $sub_attribute['value'] ) {
						continue;
					}
					if ( isset( $sub_attribute['product_qty'] ) && '0' == $sub_attribute['product_qty'] ) {
						continue;
					}
					
					if ( strpos( $sub_attribute['value'], 'base64' ) ) {
						$image_parts = explode( '|', $sub_attribute['value'] );
						$image_name  = $image_parts[0];
						$image_url   = $image_parts[1];
		
						if ( preg_match( '/^data:image\/(\w+);base64,/', $image_url, $type ) ) {
							$image_html = '<br><img src="' . $image_url . '" style="height: 60px; width: auto;">';
						} else {
							$image_html = '';
						}

						$option_value_html .= $sub_attribute['label'] . ': ' . $image_name . $image_html;
					} else {
						if ( isset( $sub_attribute['product'] ) && is_numeric( $sub_attribute['value'] ) && 'title_label' === $product_attr_display ) {
							$option_value_html .= $sub_attribute['step_title'] . ': ' . $sub_attribute['label'];

							if ( $sub_attribute['value'] > 1 ) {
								$option_value_html .= ' x' . $sub_attribute['value'];
							}
						} else {
							$option_value_html .= $sub_attribute['label'] . ': ' . $sub_attribute['value'];
						}
						
						$option_value_html .= $sub_attribute['label'] . ': ' . $sub_attribute['value'];
					}

					if ( 'hide' !== $show_option_prices ) {
						$price = isset( $sub_attribute['price'] ) ? $sub_attribute['price'] : 0;
						$option_group_price += $price;
					}
					
					if ( $show_option_notes && isset( $sub_attribute['note'] ) ) {
						$option_value_html .= '<br><small>' . $sub_attribute['note'] . '</small>';
					}

					if ( $sub_index < ( count( $option['value'] ) - 1 ) ) {
						$option_value_html .= '<br>';
					}
				}

				$price_col = '';
				if ( 'hide' !== $show_option_prices ) {
					$price_html = '';
					if ( 0 != $option_group_price ) {
						$price_html = get_option_price_html_safe( $option_group_price, -1, $inc_price_label );
					}
					$price_col = '<td class="details-option-price">' . $price_html . '</td>';
				}

				if ( '' !== $option_value_html ) {
					$option_html .= '<table class="pdf-content-' . $template . ' pdf-product-content-details table_content">
						<tr class="table_row clearfix">
							<td class="details-option-name">' . $formatted_option_name . '</td>
							<td>' . $option_value_html . '</td>
							' . $price_col . '
						</tr>
					</table>';
				}

			} else {

				if ( '0' == $option['value'] ) {
					continue;
				}
				if ( isset( $option['product_qty'] ) && '0' == $option['product_qty'] ) {
					continue;
				}

				/**
				 * Single value
				 */
				$note_html = '';
				if ( $show_option_notes && isset( $option['note'] ) ) {
					$note_html .= '<br><small>' . $option['note'] . '</small>';
				}

				if ( strpos( $option['value'], 'base64' ) ) {
					$image_parts = explode( '|', $option['value'] );
					$image_name  = $image_parts[0];
					$image_url   = $image_parts[1];
	
					if ( preg_match( '/^data:image\/(\w+);base64,/', $image_url, $type ) ) {
						$image_html = '<br><img src="' . $image_url . '" style="height: 60px; width: auto;">';
					} else {
						$image_html = '';
					}

					if ( $show_option_skus ) {
						if ( isset( $option['sku'] ) && '' !== $option['sku'] ) {
							$image_name .= ' (' . $option['sku'] . ')'; 
						}
					}

					$price_col = '';
					if ( 'hide' !== $show_option_prices ) {
						$price = isset( $option['price'] ) ? $option['price'] : 0;
						$price_html = '';
						if ( 0 != $price ) {
							$price_html = get_option_price_html_safe( $price, -1, $inc_price_label );
						}
						$price_col = '<td class="details-option-price">' . $price_html . '</td>';
					}

					$option_html .= '<table class="pdf-content-' . $template . ' pdf-product-content-details table_content">
						<tr class="table_row clearfix">
							<td class="details-option-name">' . $formatted_option_name . '</td>
							<td>' . $image_name . $image_html . $note_html . '</td>
							' . $price_col . '
						</tr>
					</table>';
				} else {
					$value = $option['value'];

					if ( isset( $option['product'] ) && is_numeric( $option['value'] ) && 'title_label' === $product_attr_display ) {
						$value = $formatted_option_name;

						if ( $option['value'] > 1 ) {
							$value .= ' x' . $option['value'];
						}

						$formatted_option_name = $option['step_title'];
					}

					if ( $show_option_skus ) {
						if ( isset( $option['sku'] ) && '' !== $option['sku'] ) {
							$value .= ' (' . $option['sku'] . ')'; 
						}
					}

					$price_col = '';
					if ( 'hide' !== $show_option_prices ) {
						$price = isset( $option['price'] ) ? $option['price'] : 0;
						$price_html = '';
						if ( 0 != $price ) {
							$price_html = get_option_price_html_safe( $price, -1, $inc_price_label );
						}
						$price_col = '<td class="details-option-price">' . $price_html . '</td>';
					}

					$option_html .= '<table class="pdf-content-' . $template . ' pdf-product-content-details table_content">
						<tr class="table_row clearfix">
							<td class="details-option-name">' . $formatted_option_name . '</td>
							<td>' . $value . $note_html . '</td>
							' . $price_col . '
						</tr>
					</table>';
				}
			}

			$current_row++;
		}

		$theme_id        = $this->get_theme_id( $product_id );
		$pdf_totals_html = '';
		$display_price   = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
		if ( staggs_get_theme_option( 'sgg_pdf_hide_price_totals' ) ) {
			$display_price = 'hide';
		}
		if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
			$display_price = 'hide';
		}
		
		if ( 'hide' !== $display_price ) {
			$tax_label = __( staggs_get_theme_option( 'sgg_product_tax_label' ), 'staggs' ) ?: '';
			if ( '' !== $tax_label ) {
				$tax_label = ' <small>' . $tax_label . '</small>';
			}

			$total_price  = $product_values['product_price'];
			$totals_label = __( 'Total:', 'staggs' );
			if ( staggs_get_theme_option( 'sgg_pdf_table_price_total_label' ) ) {
				$totals_label = staggs_get_theme_option( 'sgg_pdf_table_price_total_label' );
			}
			else if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_label' ) ) {
				$totals_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_label' );
			}

			if ( 'product' === get_post_type( $product_id ) && 'yes' === get_option( 'woocommerce_calc_taxes' ) ) {
				$product = wc_get_product( $product_id );
				$tax_price_display = staggs_get_theme_option( 'sgg_pdf_total_price_tax' );

				global $staggs_price_settings;
				if ( ! $staggs_price_settings ) {
					staggs_define_price_settings();
				}

				if ( 'no' === $staggs_price_settings['include_tax'] && 'incl' === $tax_price_display ) {
					$total_price = wc_get_price_including_tax( $product, array( 'price' => $total_price ) );
				} else if ( 'yes' === $staggs_price_settings['include_tax'] && 'excl' === $tax_price_display ) {
					$total_price = wc_get_price_excluding_tax( $product, array( 'price' => $total_price ) );
				}
			}

			$total_config_price = staggs_format_price( $total_price ) . $tax_label;
			$totals_price =  apply_filters( 'staggs_pdf_total_configuration_price', $total_config_price );

			if ( 'both' === $tax_price_display ) {
				$price_label = __( 'Price excl. VAT:', 'staggs' );
				if ( staggs_get_theme_option( 'sgg_pdf_table_price_ex_tax_label' ) ) {
					$price_label = staggs_get_theme_option( 'sgg_pdf_table_price_ex_tax_label' );
				}
				$tax_label = __( 'VAT:', 'staggs' );
				if ( staggs_get_theme_option( 'sgg_pdf_table_price_tax_label' ) ) {
					$tax_label = staggs_get_theme_option( 'sgg_pdf_table_price_tax_label' );
				}

				$price = wc_get_price_excluding_tax( $product, array( 'price' => $total_price ) );
				$total_price = wc_get_price_including_tax( $product, array( 'price' => $total_price ) );
				$tax = $total_price - $price;

				$pdf_totals_html = '<tr><td class="totals_label">' . $price_label . '</td><td class="totals_price">' . staggs_format_price( $price ) . '</td></tr>';
				$pdf_totals_html .= '<tr><td class="totals_label">' . $tax_label . '</td><td class="totals_price">' . staggs_format_price( $tax ) . '</td></tr>';
				$pdf_totals_html .= '<tr><td class="totals_label">' . $totals_label . '</td><td class="totals_price">' . staggs_format_price( $total_price ) . '</td></tr>';
			} else {
				$pdf_totals_html = '<tr><td class="totals_label">' . $totals_label . '</td><td class="totals_price">' . $totals_price . '</td></tr>';
			}
		}

		$pdf_price_col = '';
		if ( 'hide' !== $show_option_prices ) {
			$price_heading = staggs_get_theme_option( 'sgg_pdf_table_price_heading' ) ?: __( 'Price', 'staggs' );
			$pdf_price_col = '<th class="details-option-price">' . $price_heading . '</th>';
		}

		$pdf_configuration = sprintf(
			'<h3 id="pdf-product-content-heading">%1$s</h3>
			<table id="table" class="pdf-content-' . $template . ' pdf-product-content-details">
				<thead id="table_header" class="clearfix">
					<th>%2$s</th>
					<th>%3$s</th>
					%4$s
				</thead>
			</table>
			%5$s
			<table id="totals" class="pdf-content-' . $template . ' pdf-product-content-details">
				%6$s
			</table>',
			staggs_get_theme_option( 'sgg_pdf_options_heading' ) ?: __( 'Configuration', 'staggs' ),
			staggs_get_theme_option( 'sgg_pdf_table_step_heading' ) ?: __( 'Step', 'staggs' ),
			staggs_get_theme_option( 'sgg_pdf_table_value_heading' ) ?: __( 'Value', 'staggs' ),
			$pdf_price_col,
			$option_html,
			apply_filters( 'staggs_pdf_totals_html', $pdf_totals_html, $product_values ),
		);
		
		return apply_filters( 'staggs_pdf_configuration_html', $pdf_configuration, $product_id, $product_values );
	}

	/**
	 * Render PDF header html
	 *
	 * @since    1.3.1
	 */
	public function get_pdf_header( $pdf_data ) {
		// Format header address.
		$address = '<div id="address"><strong>' . staggs_get_theme_option( 'sgg_company_name' ) . '</strong><br />';

		// The main address pieces:/
		$store_address     = get_option( 'woocommerce_store_address' );
		$store_address_2   = get_option( 'woocommerce_store_address_2' );
		$store_city        = get_option( 'woocommerce_store_city' );
		$store_postcode    = get_option( 'woocommerce_store_postcode' );
		// The country/state
		$store_raw_country = get_option( 'woocommerce_default_country' );
		// Split the country/state
		$split_country = explode( ":", $store_raw_country );
		// Country and state separated:
		$store_country = '';
		$store_state   = '';
		if ( isset( $split_country[0] ) ) {
			$store_country = $split_country[0];
		}
		if ( isset( $split_country[1] ) ) {
			$store_state = $split_country[1];
		}

		$address .= $store_address . "<br />";
		$address .= ( $store_address_2 ) ? $store_address_2 . "<br />" : '';
		$address .= $store_city . ', ' . $store_state . ' ' . $store_postcode . "<br />";
		$address .= $store_country;
		$address .= '</div>';

		if ( staggs_get_theme_option( 'sgg_pdf_set_custom_header_address' ) ) {
			$address = '<div id="address">';
			$address .= wpautop( wp_kses( staggs_get_theme_option( 'sgg_pdf_custom_header_address' ), 'post' ) );
			$address .= '</div>';
		}

		$include_customer_data = staggs_get_theme_option( 'sgg_order_pdf_include_customer_details' );
		if ( isset( $pdf_data['customer_address'] ) && $include_customer_data ) {
			$address = '<table id="header_contact"><tr><td>' . $address . '</td><td>';
			$address .= '<div id="customer">';
			$address .= '<strong>' . __('Customer', 'woocommerce') . '</strong><br>';
			$address .= $pdf_data['customer_address'];
			if ( isset( $pdf_data['customer_email'] ) && '' !== $pdf_data['customer_email'] ) {
				$address .= '<br>' . $pdf_data['customer_email'];
			}
			if ( isset( $pdf_data['customer_phone'] ) && '' !== $pdf_data['customer_phone'] ) {
				$address .= '<br>' . $pdf_data['customer_phone'];
			}
			$address .= '</div></td></tr></table>';
		}

		$image_url = wp_get_attachment_image_url( staggs_get_theme_option( 'sgg_logo' ), 'full' );

		$content_left  = '<img src="' . $image_url . '" width="200px">';
		$content_right = $address;
		if ( 'logo_left' === staggs_get_theme_option( 'sgg_pdf_header_layout' ) ) {
			$content_right = '<img src="' . $image_url . '" width="200px">';
			$content_left  = $address;
		}

		$pdf_header_html = sprintf(
			'<tr id="header">
				<td>
					<table id="header_row">
						<tr id="header_row_inner">
							<td id="header_left">
								%3$s
							</td>
							<td id="header_right">
								%2$s
							</td>
						</tr>
					</table>
				</td>
			</tr>',
			get_site_url(),
			$content_left,
			$content_right
		);

		return apply_filters( 'staggs_pdf_header_html', $pdf_header_html );
	}

	/**
	 * Render PDF footer html
	 *
	 * @since    1.3.1
	 */
	public function get_pdf_footer( $product_values ) {

		$pdf_footer_html = '';
		$include_online_link = staggs_get_theme_option( 'sgg_pdf_include_online_link' );

		if ( isset( $product_values['link'] ) && $product_values['product_id'] && $include_online_link ) {
			$new_contents = json_decode(str_replace('\\', '', $product_values['link']));

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
	
			$link = trailingslashit( get_permalink( $product_values['product_id'] ) ) . '?configuration=' . $config_name;
			$link_label = __( 'View online:', 'staggs' );
			if ( staggs_get_theme_option( 'sgg_pdf_include_online_link_label' ) ) {
				$link_label = staggs_get_theme_option( 'sgg_pdf_include_online_link_label' );
			}
			$link_html = '<a href="' . $link . '">' . $link . '</a>';

			$pdf_footer_html = sprintf(
				'<tr>
					<td id="footer">
						<table id="footer_column">
							<tr>
								<td>%s %s</td>
							</tr>
						</table>
					</td>
				</tr>',
				$link_label,
				$link_html
			);
		}

		$theme_id = $this->get_theme_id( $product_values['product_id'] );
		$include_gallery = staggs_get_post_meta( $theme_id, 'sgg_configurator_generate_pdf_images' );

		if ( isset( $product_values['product_gallery'] ) && $include_gallery ) {
			$gallery_html = '<tr>';
			foreach ( $product_values['product_gallery'] as $index => $image_url ) {
				if ( $index % 2 == 0 ){
					$gallery_html .= '</tr><tr>';
				}
				$gallery_html .= '<td><img src="' . $image_url . '"></td>';
			}
			$gallery_html .= '</tr>';

			$pdf_footer_html .= sprintf(
				'<tr>
					<td id="gallery">
						<table id="gallery_images">
							%s
						</table>
					</td>
				</tr>',
				$gallery_html
			);
		}

		$pdf_footer_html = apply_filters( 'staggs_pdf_footer_html', $pdf_footer_html );

		return $pdf_footer_html;
	}

	/**
	 * Render PDF styles css
	 *
	 * @since    1.3.1
	 */
	public function get_pdf_styles() {
		$primary_color   = sanitize_text_field( staggs_get_theme_option( 'sgg_pdf_primary_color' ) ) ?: '#FAF5EF';
		$secondary_color = sanitize_text_field( staggs_get_theme_option( 'sgg_pdf_secondary_color' ) ) ?: '#FFFFFF';
		$text_color      = sanitize_text_field( staggs_get_theme_option( 'sgg_pdf_text_color' ) ) ?: '#000000';
		$text_transform  = sanitize_text_field( staggs_get_theme_option( 'sgg_pdf_text_style' ) );
		$price_align     = sanitize_text_field( staggs_get_theme_option( 'sgg_pdf_option_prices_align' ) );

		if ( ! $text_transform || 'default' === $text_transform ) {
			$text_transform = 'inherit';
		}

		$pdf_styles = '
		@page {
			margin: 0;
		}
		
		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 13px;
			line-height: 16px;
			font-weight: 400;
			color: ' . $text_color . ';
			background: ' . $primary_color . ';
			margin: 0;
			padding: 60px 0;
			position: relative;
		}
		
		img {
			max-width: 100% !important;
			height: auto;
		}

		td {
			position: relative;
			overflow: hidden;
		}

		td.details-option-name {
			text-transform: ' . $text_transform . ';
		}

		.pdf-content-header {
			position: relative;
			margin-top: -60px;
			background: ' . $secondary_color . ';
			padding: 20px 0;
			width: 100%;
			z-index: 1;
		}
		
		#header,
		#header_row,
		#header_row_inner {
			width: 100%;
		}
		#header_left,
		#header_right {
			width: 50%;
		}
		#header_right {
			text-align: right;
		}
		#header_row img {
			max-height: 70px;
			width: auto;
		}
		#header_contact {
			width: 100%;
		}
		#header_contact td {
			vertical-align: top;
			width: 50%;
		}
		#header #address p {
			margin: 0;
		}
		#header #customer p {
			margin: 0;
		}

		h3 {
			display: block;
			text-transform: uppercase;
			font-weight: 400;
			padding: 0;
			margin: 0;
			padding-top: 50px;
			border-bottom: 1px solid ' . $text_color . ';
		}

		#details {
			width: 100%;
		}
		#details_title h1 {
			font-size: 20px;
		}
		#details_price {
			text-align: right;
			font-size: 20px;
		}
		#details_price .amount {
			font-size: 24px;
		}
		#details_image {
			text-align: center;
		}

		#table,
		.table_content {
			width: 100%;
			border-spacing: 0;
			border-collapse: collapse;
		}
		#table_header th,
		.table_content td {
			width: 50%;
			text-align: left;
		}
		#table_header th,
		.table_content td {
			padding: 10px 15px;
			background-color: ' . $secondary_color . ';
		}
		.table_content tr td {
			border-top: 1px solid ' . $text_color . ';
		}

		#table_header th.details-option-price,
		.table_content td.details-option-price {
			text-align: ' . $price_align . ';
		}

		#totals {
			padding-top: 30px;
			width: 100%;
			font-size: 20px;
		}
		#totals .totals_label {
			width: 50%;
			padding: 5px 15px;
		}
		#totals .totals_price {
			width: 50%;
			padding: 5px 15px;
			text-align: right;
		}

		#footer {
			padding-top: 60px;
		}
		#footer_column {
			width: 100%;
			background-color: ' . $secondary_color . ';
			padding: 30px 60px;
			font-size: 14px;
		}
		#footer_column, #footer_column a {
			color: ' . $text_color . ';
		}

		#gallery_images {
			width: 100%;
			padding: 0 60px;
			vertical-align: top;
		}
		#gallery_images td {
			width: 50%;
		}

		.pdf-content-small {
			width: 100%;
		}
		.pdf-content-small #header_left {
			padding-left: 60px;
		}
		.pdf-content-small #header_right {
			padding-right: 60px;
		}
		.pdf-content-small #details_intro {
			padding: 0 60px 10px;
		}
		.pdf-content-small h3 {
			margin-left: 60px;
			margin-right: 60px;
		}
		.pdf-content-small #details_title {
			padding-left: 60px;
		}
		.pdf-content-small #details_price {
			padding-right: 60px;
		}
		.pdf-content-small #details_image {
			padding-left: 60px;
			padding-right: 60px;
		}
		#pdf-product-content-heading {
			margin: 0 60px 15px;
		}
		.pdf-product-content-details {
			padding: 0 60px;
		}

		.pdf-content-wide {
			width: 100%;
		}
		.pdf-content-wide #header_left {
			padding-left: 60px;
		}
		.pdf-content-wide #header_right {
			padding-right: 60px;
		}
		.pdf-content-wide.pdf-content-main {
			padding: 0 60px;
			width: 100%;
		}
		.pdf-content-wide.pdf-content-main td {
			vertical-align: top;
			width: 50%;
		}
		.pdf-content-wide .pdf-product-content-image {
			position: relative;
			padding-right: 30px;
			width: 100%;
			overflow: hidden;
		}
		.pdf-content-wide #details_intro {
			padding: 0 0 10px;
		}
		.pdf-content-wide #pdf-product-content-heading {
			margin-left: 30px;
			margin-right: 0;
		}
		.pdf-content-wide .pdf-product-content-details {
			padding-left: 30px;
			padding-right: 0;
			width: 100%;
		}
		';

		return apply_filters( 'staggs_pdf_styles', $pdf_styles );
	}
}
