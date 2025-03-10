<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.6.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$summary = isset( $_GET['staggs_summary'] ) ? sanitize_text_field( $_GET['staggs_summary'] ) : '';

$upload_dir = wp_get_upload_dir();
$base_dir   = $upload_dir['basedir'];
$save_path  = $base_dir . '/staggs';
if ( ! file_exists( $save_path ) ) {
	mkdir( $save_path, 0777, true );
}

if (file_exists(trailingslashit($save_path) . $summary . '.json')) {
	$summary_object = file_get_contents(trailingslashit($save_path) . $summary . '.json');
	$summary_json   = json_decode( $summary_object, ARRAY_A );

	$theme_id = staggs_get_theme_id( $summary_json['product'] );

	$layout = staggs_get_post_meta( $theme_id, 'sgg_configurator_layout' );
	$border = staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );

	$hidden_labels = array();
	if ( $hidden = staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_hidden_items' ) ) {
		$hidden_labels = array_map( 'trim', explode(',', $hidden ) );
	}
	
	$product_attr_display = staggs_get_theme_option( 'sgg_product_attribute_value_display' ) ?: 'label_value';
	?>
	<div class="staggs-summary-template border-<?php echo esc_attr( $border ); ?> align-<?php echo esc_attr( $layout ); ?>">
		<div class="staggs-summary-template-content">
			<div class="staggs-summary-template-row">
				<div class="staggs-summary-template-gallery">
					<div class="staggs-summary-template-preview">
						<img src="<?php echo wp_kses_post( $summary_json['image'] ); ?>">
					</div>
					<div class="staggs-summary-template-actions">
						<?php
						$share_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

						$share_title = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_share_link_label' ) );
						if ( '' === $share_title ) {
							$share_title = __( 'Share configuration or continue later?', 'staggs' );
						}
						$share_intro = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_share_link_intro' ) );
						if ( '' === $share_intro ) {
							$share_intro = __( 'Copy the following link to return to your configuration:', 'staggs' );
						}
						$share_button = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_share_link_button' ) );
						if ( '' === $share_button ) {
							$share_button = __( 'Copy', 'staggs' );
						}
						?>
						<div class="staggs-summary-template-action-widget share-link">
							<div class="staggs-summary-widget-content">
								<strong><?php echo esc_attr( $share_title ); ?></strong>
								<p><?php echo esc_attr( $share_intro ); ?></p>
								<div class="staggs-summary-widget-action staggs-summary-widget-action-form">
									<input type="text" value="<?php echo esc_url( $share_link ); ?>">
									<button class="share-link staggs-button"><?php echo esc_attr( $share_button ); ?></button>
								</div>
							</div>
						</div>
						<?php
						if ( staggs_get_theme_option( 'sgg_configurator_summary_enable_mail' ) ) {
							$mail_title  = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_mail_link_label' ) );
							if ( '' === $mail_title ) {
								$mail_title = __( 'Mail configuration', 'staggs' );
							}

							$mail_intro  = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_mail_link_intro' ) );
							if ( '' === $mail_intro ) {
								$mail_intro = __( 'Send the configuration link to your mailadres:', 'staggs' );
							}

							$mail_placeholder = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_mail_link_placeholder' ) );
							if ( '' === $mail_placeholder ) {
								$mail_placeholder = __( 'name@email.com', 'staggs' );
							}

							$mail_button  = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_mail_link_button' ) );
							if ( '' === $mail_button ) {
								$mail_button = __( 'Send', 'staggs' );
							}

							if ( isset( $_POST['recipient'] ) ) {
								$email = sanitize_email($_POST['recipient'] );
								$site = esc_attr( get_bloginfo('name') );
								wp_mail( $email, $site . ' - ' . $mail_title, $share_link );
							}
							?>
							<div class="staggs-summary-template-action-widget send-mail">
								<div class="staggs-summary-widget-content">
									<strong><?php echo esc_attr( $mail_title ); ?></strong>
									<p><?php echo esc_attr( $mail_intro ); ?></p>
									<form method="post" action="<?php echo esc_url( $share_link ); ?>" class="staggs-summary-widget-action staggs-summary-widget-action-form">
										<input type="email" name="recipient" placeholder="<?php echo esc_attr( $mail_placeholder ); ?>">
										<button class="send-mail staggs-button">
											<span class="button-label"><?php echo esc_attr( $mail_button ); ?></span>
										</button>
									</form>
								</div>
							</div>
							<?php
						}

						if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_pdf_display' ) || staggs_get_post_meta( $theme_id, 'sgg_configurator_request_invoice_button' ) ) {
							// Display request invoice as main button for cart button is disabled.
							$pdf_title = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_pdf_label' ) );
							if ( '' === $pdf_title ) {
								$pdf_title = __( 'Download to PDF', 'staggs' );
							}
							$pdf_intro = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_pdf_intro' ) );
							if ( '' === $pdf_intro ) {
								$pdf_intro = __( 'Save configuration page to PDF', 'staggs' );
							}
							$pdf_button = sanitize_text_field( staggs_get_theme_option( 'sgg_configurator_summary_pdf_button' ) );
							if ( '' === $pdf_button ) {
								$pdf_button = __( 'Generate PDF', 'staggs' );
							}
							?>
							<div class="staggs-summary-template-action-widget download-summary-pdf">
								<div class="staggs-summary-widget-content">
									<strong><?php echo esc_attr( $pdf_title ); ?></strong>
									<p><?php echo esc_attr( $pdf_intro ); ?></p>
									<form action="<?php echo esc_url( get_permalink( get_the_ID() ) ) . '?generate_pdf=' . esc_attr( get_the_ID() ); ?>" method="post" class="staggs-summary-widget-action">
										<button id="download-summary-pdf" data-product="<?php echo esc_attr( get_the_ID() ); ?>" class="staggs-button"><?php echo esc_attr( $pdf_button ); ?></button>
									</form>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="staggs-summary-template-form">
					<?php
					$back_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_page_back_button' ) );
					if ( '' === $back_text ) {
						$back_text = __( '< Back to configurator', 'staggs' );
					}
					?>
					<div class="intro">
						<a href="#" class="staggs-back-configurator"><?php echo esc_attr( $back_text ); ?></a>
						<h1 class="product_title entry-title"><?php echo esc_attr( get_the_title( $summary_json['product'] ) ); ?></h1>
						<?php
						$intro_text = __( 'Thank you for using our configurator. Here is an overview of your options.', 'staggs' );
						if ( staggs_get_theme_option( 'sgg_configurator_summary_intro' ) ) {
							$intro_text = staggs_get_theme_option( 'sgg_configurator_summary_intro' );
						}
						?>
						<p><?php echo wp_kses_post( $intro_text ); ?></p>
					</div>
					
					<?php
					if ( isset( $summary_json['values'] ) && count( $summary_json['values'] ) > 0 ) :	
						$show_prices = (bool)staggs_get_post_meta($theme_id, 'sgg_configurator_summary_include_prices');
						
						$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
						if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
							$display_price = 'hide';
							$show_prices = false;
						}

						$class = '';
						if ( $show_prices ) {
							$class .= ' table-3-cols';
						}
						?>
						
						<div class="staggs-summary-template-table<?php echo esc_attr( $class ); ?>">
							<?php
							$summary_table_label = __( 'Your configuration', 'staggs' );
							if ( staggs_get_theme_option( 'sgg_configurator_summary_table_title' ) ) {
								$summary_table_label = staggs_get_theme_option( 'sgg_configurator_summary_table_title' );
							}

							$summary_table_step_label = __( 'Step', 'staggs' );
							if ( staggs_get_theme_option( 'sgg_configurator_summary_table_step_label' ) ) {
								$summary_table_step_label = staggs_get_theme_option( 'sgg_configurator_summary_table_step_label' );
							}
							
							$summary_table_value_label = __( 'Value', 'staggs' );
							if ( staggs_get_theme_option( 'sgg_configurator_summary_table_value_label' ) ) {
								$summary_table_value_label = staggs_get_theme_option( 'sgg_configurator_summary_table_value_label' );
							}

							$summary_table_price_label = __( 'Price', 'staggs' );
							if ( staggs_get_theme_option( 'sgg_configurator_summary_table_price_label' ) ) {
								$summary_table_price_label = staggs_get_theme_option( 'sgg_configurator_summary_table_price_label' );
							}
							?>
							<div class="staggs-summary-template-table-head">
								<strong class="staggs-summary-template-table-title">
									<?php echo esc_attr( $summary_table_label ); ?>
								</strong>
								<div class="staggs-summary-template-table-row">
									<strong><?php echo esc_attr( $summary_table_step_label ); ?></strong>
									<strong><?php echo esc_attr( $summary_table_value_label ); ?></strong>
									<?php if ( $show_prices ) : ?>
										<strong><?php echo esc_attr( $summary_table_price_label ); ?></strong>
									<?php endif; ?>
								</div>
							</div>
							<?php
							foreach ( $summary_json['values'] as $summary_json_value ) : 
								if ( in_array( $summary_json_value['label'], $hidden_labels ) ) {
									continue;
								}
								if ( isset( $summary_json_value['value'] ) && is_numeric( $summary_json_value['value'] ) && 0 == $summary_json_value['value'] ) {
									continue;
								}
								if ( isset( $summary_json_value['product_qty'] ) && 0 == $summary_json_value['product_qty'] ) {
									continue;
								}

								if ( isset( $summary_json_value['value'] ) && is_numeric( $summary_json_value['value'] ) && 'title_label' === $product_attr_display ) :
									?>
									<div class="staggs-summary-template-table-row">
										<p><?php echo esc_attr( $summary_json_value['step_title'] ); ?>:</p>
										<p>
											<?php 
											echo esc_attr( $summary_json_value['label'] );

											if ( $summary_json_value['value'] > 1 ) {
												echo ' x' . esc_attr( $summary_json_value['value'] );
											}
											?>
										</p>
										<p>
											<?php 
											if ( $show_prices && isset( $summary_json_value['price'] ) ) {
												echo staggs_format_price( $summary_json_value['price'] );
											}
											?>
										</p>
									</div>
									<?php
								elseif ( isset( $summary_json_value['label'] ) ) :
									?>
									<div class="staggs-summary-template-table-row">
										<p><?php echo esc_attr( $summary_json_value['label'] ); ?>:</p>
										<p><?php echo esc_attr( $summary_json_value['value'] ); ?></p>
										<p>
											<?php 
											if ( $show_prices && isset( $summary_json_value['price'] ) ) {
												echo staggs_format_price( $summary_json_value['price'] );
											}
											?>
										</p>
									</div>
									<?php
								endif;
							endforeach;
							?>
						</div>
						<?php
						if ( 'hide' !== $display_price ) :
							?>
							<div class="staggs-summary-template-totals">
								<div class="staggs-summary-template-table-row">
									<?php
									$summary_price_label = __( 'Your price:', 'staggs' );
									if ( staggs_get_theme_option( 'sgg_configurator_summary_table_total_label' ) ) {
										$summary_price_label = staggs_get_theme_option( 'sgg_configurator_summary_table_total_label' );
									}
									?>
									<strong><?php echo esc_attr( $summary_price_label ); ?></strong>
									<strong class="staggs-summary-template-total-price">
										<?php echo staggs_format_price( $summary_json['total'], '' ); ?>
									</strong>
								</div>
							</div>
							<?php 
						endif;
					else :
						?>
						<div class="staggs-summary-template-empty">
							<p>
								<?php
								$empty_message = staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_empty_message' );
								if ( '' === $empty_message ) {
									$empty_message = __( 'No options selected', 'staggs' );
								}
								echo esc_attr( $empty_message );
								?>
							</p>
						</div>
						<?php
					endif; 

					if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_page_shortcode' ) ) {
						$shortcode = staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_page_shortcode' );
						echo do_shortcode( $shortcode );
					}

					$button_type = staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' );
					if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_page_disable_buttons' ) ) :
						?>
						<div class="staggs-summary-total-buttons staggs-summary-total-buttons--<?php echo esc_attr( $button_type ); ?>">
							<a href="#" class="staggs-back-configurator"><?php echo esc_attr( $back_text ); ?></a>
							<?php
							if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && 'cart' === staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' ) ) {
								global $product;
								$product = wc_get_product( $summary_json['product'] );

								if ( ! $product ) {
									return;
								}

								// WooCommerce product with cart feature.
								if ( $product->is_purchasable() && $product->is_in_stock() ) {
									?>
									<div class="button-wrapper">
										<?php
										// Display add to cart button
										do_action( 'staggs_single_add_to_cart' );
										?>
									</div>
									<?php
								}
							} else {
								// Display request invoice as main button for cart button is disabled.
								$invoice_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_add_to_cart_text' ) );
								if ( '' === $invoice_text ) {
									$invoice_text = __( 'Request invoice', 'staggs' );
								}

								$button_wrapper_class = '';
								if ( ! staggs_get_post_meta( $theme_id, 'sgg_theme_disable_cart_styles' ) ) {
									$button_wrapper_class .= ' staggs';
								}

								$page_id = staggs_get_post_meta( $theme_id, 'sgg_configurator_form_page' );
								if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_hide_totals_button' ) ) :
									if ( 'invoice' === $button_type ) :
										?>
										<div class="button-wrapper">
											<form action="<?php echo esc_url( get_permalink( $page_id ) ); ?>" id="invoice" method="get" class="staggs-main-action product-action action-request-invoice">
												<input type="hidden" id="append" name="product_name" value="<?php echo esc_attr( get_the_title() ); ?>">
												<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
													<button type="submit" class="button request-invoice"<?php 
														if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_generate_pdf' ) ) {
															echo ' data-include_pdf="' . esc_attr( get_the_ID() ) . '"';
														}
														if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_generate_image' ) ) {
															echo ' data-include_image="' . esc_attr( get_the_ID() ) . '"';
														}
														if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_generate_url' ) ) {
															echo ' data-include_url="' . esc_attr( get_the_ID() ) . '"';
														}
														?>>
														<?php echo esc_attr( $invoice_text ); ?>
													</button>
												</div>
											</form>
										</div>
										<?php
									elseif ( 'pdf' === $button_type ) :
										?>
										<div class="option-group-wrapper">
											<div class="option-group total">
												<form action="<?php echo esc_url( get_permalink( get_the_ID() ) ) . '?generate_pdf=' . esc_attr( get_the_ID() ); ?>" data-product="<?php echo esc_attr( get_the_ID() ); ?>" id="staggs_pdf_invoice" method="get" class="staggs-main-action product-action action-request-invoice staggs-main-action-pdf-download">
													<input type="hidden" name="generate_pdf" value="<?php echo esc_attr( get_the_ID() ); ?>"/>
													<?php
													if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_collect_email' ) ) :
														?>
														<div class="text-input staggs-pdf-email-input">
															<label for="pdf_user_email" class="input-field-wrapper">
																<span class="input-heading">
																	<p class="input-title">
																		<?php
																		$input_label = __( 'Your email address', 'staggs' );
																		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_email_label' ) ) {
																			$input_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_email_label' );
																		}

																		echo esc_attr( $input_label );
																		echo ' <span class="required-indicator">*</span>';
																		?>
																	</p>
																</span>
																<span class="input-field">
																	<input type="email" name="pdf_user_email" value="" />
																</span>
															</label>
														</div>
														<?php
														do_action( 'staggs_generate_pdf_form_fields' );
													endif;
													?>
													<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
														<button type="submit" class="button request-invoice" id="invoice_pdf_download">
															<?php echo esc_attr( $invoice_text ); ?>
														</button>
													</div>
												</form>
											</div>
										</div>
										<?php
									elseif ( 'email' === $button_type ) :
										$mail_link = 'mailto:';
										if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_button_email_recipient' ) ) {
											$mail_link .= staggs_get_post_meta( $theme_id, 'sgg_configurator_button_email_recipient' );
										} else {
											$mail_link .= get_option( 'admin_email' );
										}

										if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_button_email_subject' ) ) {
											$mail_link .= '?subject=' . str_replace( ' ', '%20', staggs_get_post_meta( $theme_id, 'sgg_configurator_button_email_subject' ) ) . '&body=';
										} else {
											$mail_link .= '?body=';
										}
										?>
										<div class="button-wrapper button-wrapper-pdf">
											<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
												<a href="<?php echo esc_url( $mail_link ); ?>" class="button request-invoice send-email" id="staggs-send-email"<?php
													if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_button_email_show_product_title' ) ) {
														echo ' data-title="' . esc_attr( get_the_title( get_the_ID() ) ) . '"';
													}
													if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_generate_pdf' ) ) {
														echo ' data-include_pdf="' . esc_attr( get_the_ID() ) . '"';
													}
													if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_generate_image' ) ) {
														echo ' data-include_image="' . esc_attr( get_the_ID() ) . '"';
													}
													if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_generate_url' ) ) {
														echo ' data-include_url="' . esc_attr( get_the_ID() ) . '"';
													}
													?>>
													<?php echo esc_attr( $invoice_text ); ?>
												</a>
											</div>
										</div>
										<?php
									endif;
								endif;
							}
							?>
						</div>
						<?php
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
