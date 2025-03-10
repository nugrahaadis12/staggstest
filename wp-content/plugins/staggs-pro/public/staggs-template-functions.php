<?php

/**
 * The main functions of this plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.0
 *
 * @package    Staggs
 * @subpackage Staggs/includes
 */

if ( ! function_exists( 'staggs_product_configurator_wrapper' ) ) {
	/**
	 * Product configurator wrapper.
	 *
	 * @return void
	 */
	function staggs_product_configurator_wrapper() {
		echo '<div class="staggs-container">';
	}
}

if ( ! function_exists( 'staggs_product_configurator_wrapper_close' ) ) {
	/**
	 * Product configurator wrapper close.
	 *
	 * @return void
	 */
	function staggs_product_configurator_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_message_content_wrapper' ) ) {
	/**
	 * Product configurator top content wrapper
	 *
	 * @return void
	 */
	function staggs_output_message_content_wrapper() {
		$theme_id = staggs_get_theme_id();
		$template = staggs_get_configurator_page_template( $theme_id );
		if ( $template !== 'staggs' ) {
			return;
		}

		$wrapper_class = '';
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
			$wrapper_class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
		}

		if ( 'popup' === staggs_get_post_meta( $theme_id, 'sgg_configurator_view' ) || 'default' === $template ) {
			$wrapper_class .= ' inline';
		}

		echo '<div class="staggs-message-wrapper' . esc_attr( $wrapper_class ) . '"></div>';
	}
}

if ( ! function_exists( 'staggs_output_content_wrapper' ) ) {
	/**
	 * Product configurator content wrapper
	 *
	 * @return void
	 */
	function staggs_output_content_wrapper() {
		$staggs_class = 'staggs-configurator-main';

		$theme_id = staggs_get_theme_id();
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
			$staggs_class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_layout' ) ) {
			$staggs_class .= ' align-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_layout' );
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_nav_position' ) ) {
			$staggs_class .= ' steps-position-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_step_nav_position' );
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_totals_display_required' ) ) {
			$staggs_class .= ' hide-disabled-buttons';
		}
		if ( 'image_height' === staggs_get_post_meta( $theme_id, 'sgg_configurator_template_height' ) ) {
			$staggs_class .= ' staggs-configurator-height-auto';
		}

		if ( 'inline' === staggs_get_post_meta( $theme_id, 'sgg_mobile_gallery_display' ) ) {
			$staggs_class .= ' gallery-inline';
		} else {
			$staggs_class .= ' gallery-sticky';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_stretch_bg_image' ) ) {
			$staggs_class .= ' staggs-gallery-stretched';
		}

		$view_layout = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_view' ) );
		if ( 'classic' === $view_layout ) {
			$staggs_class .= ' staggs-contained';
		} elseif ( 'floating' === $view_layout ) {
			$staggs_class .= ' staggs-floating';
		} elseif ( 'steps' === $view_layout ) {
			$staggs_class .= ' staggs-stepper';
		} elseif ( 'splitter' === $view_layout ) {
			$staggs_class .= ' staggs-splitter';
		} else {
			$staggs_class .= ' staggs-full';
		}

		echo '<div class="' . esc_attr( $staggs_class ) . '">';
	}
}

if ( ! function_exists( 'staggs_output_content_wrapper_close' ) ) {
	/**
	 * Product configurator content wrapper
	 *
	 * @return void
	 */
	function staggs_output_content_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_topbar_wrapper' ) ) {
	/**
	 * Product configurator content wrapper
	 *
	 * @return void
	 */
	function staggs_output_topbar_wrapper() {
		$topbar_class = '';
		$theme_id = staggs_get_theme_id();
		if ( 'inline' === staggs_get_post_meta( $theme_id, 'sgg_mobile_gallery_display' ) ) {
			$topbar_class .= ' mobile-inline';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_separator_nav' ) ) {
			$topbar_class .= ' has-nav';
		}

		echo '<div class="staggs-configurator-topbar' . esc_attr( $topbar_class ) . '">';
	}
}

if ( ! function_exists( 'staggs_output_topbar_wrapper_close' ) ) {
	/**
	 * Product configurator content wrapper
	 *
	 * @return void
	 */
	function staggs_output_topbar_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_topbar_buttons' ) ) {
	/**
	 * Product configurator top bar buttons
	 *
	 * @return void
	 */
	function staggs_output_topbar_buttons() {
		echo '<div class="bar-action-buttons">';

		do_action( 'staggs_topbar_buttons' );

		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_company_logo' ) ) {
	/**
	 * Product configurator content wrapper
	 * 
	 * @return void
	 */
	function staggs_output_company_logo() {
		$theme_id = staggs_get_theme_id();
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_show_logo' ) ) {
			return;
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_show_logo_options' ) ) {
			return;
		}

		$logo_id = '';
		if ( staggs_get_theme_option( 'sgg_logo' ) ) {
			// Fallback.
			$logo_id = esc_attr( staggs_get_theme_option( 'sgg_logo' ) );
		}

		if ( $logo_id ) :
			$logo_url = esc_url( home_url() );
			if ( staggs_get_post_meta( $theme_id, 'sgg_back_page_url' ) ) {
				$logo_url = esc_url( staggs_get_post_meta( $theme_id, 'sgg_back_page_url' ) );
			}
			?>
			<a href="<?php echo esc_url( $logo_url ); ?>" class="logo-wrapper">
				<span class="logo">
					<?php echo wp_get_attachment_image( esc_attr( $logo_id ), 'full' ); ?>
				</span>
			</a>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_product_single_options_logo' ) ) {
	/**
	 * Product configurator content wrapper
	 * 
	 * @return void
	 */
	function staggs_product_single_options_logo() {
		$theme_id = staggs_get_theme_id();
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_show_logo' ) ) {
			return;
		}
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_show_logo_options' ) ) {
			return;
		}

		$logo_id = '';
		if ( staggs_get_theme_option( 'sgg_logo' ) ) {
			$logo_id = esc_attr( staggs_get_theme_option( 'sgg_logo' ) );
		}

		if ( $logo_id ) :
			$logo_url = esc_url( home_url() );
			if ( staggs_get_post_meta( $theme_id,'sgg_back_page_url' ) ) {
				$logo_url = esc_url( staggs_get_post_meta( $theme_id,'sgg_back_page_url' ) );
			}
			?>
			<a href="<?php echo esc_url( $logo_url ); ?>" class="logo-wrapper">
				<span class="logo">
					<?php echo wp_get_attachment_image( esc_attr( $logo_id ), 'full' ); ?>
				</span>
			</a>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_product_single_options_back_button' ) ) {
	/**
	 * Product configurator content back button
	 * 
	 * @return void
	 */
	function staggs_product_single_options_back_button() {
		$theme_id = staggs_get_theme_id();
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_show_close_button' ) ) {
			return;
		}
		
		$close_url = esc_url( home_url() );
		if ( staggs_get_post_meta( $theme_id,'sgg_back_page_url' ) ) {
			$close_url = esc_url( staggs_get_post_meta( $theme_id,'sgg_back_page_url' ) );
		}

		echo '<a href="' . esc_url( $close_url ) . '" class="back-button"';
		if ( staggs_get_post_meta( $theme_id,'sgg_show_close_button_message' ) ) {
			$exit = staggs_get_post_meta( $theme_id, 'sgg_close_button_message' ) ?: __( 'Do you want to exit?', 'staggs' );
			echo ' data-message="' . esc_attr( $exit ) . '"';
		}
		echo '>';
		echo wp_kses(
			staggs_get_icon( 'sgg_close_icon', 'close' ),
			staggs_get_icon_kses_args()
		);
		echo '</a>';
	}
}

if ( ! function_exists( 'staggs_output_gallery_section' ) ) {
	/**
	 * Main product configurator gallery section wrapper
	 * 
	 * @return void
	 */
	function staggs_output_gallery_section() {
		$theme_id = staggs_get_theme_id();

		$class = ' staggs-product-view-' . staggs_get_post_meta( get_the_ID(), 'sgg_configurator_type' );
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
			$class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
		}
		if ( 'inline' === staggs_get_post_meta( $theme_id, 'sgg_mobile_gallery_display' ) ) {
			$class .= ' mobile-inline';
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_scale_mobile_display' ) ) {
			$class .= ' fix-mobile-view';
		}
		$view_layout = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_view' ) );
		if ( 'classic' === $view_layout && staggs_get_post_meta( $theme_id, 'sgg_configurator_gallery_sticky' ) ) {
			$class .= ' staggs-product-view-sticky';
		}

		echo '<section class="staggs-product-view' . esc_attr( $class ) . '">';
		echo '<div class="product-view-inner">';
	}
}

if ( ! function_exists( 'staggs_output_gallery_section_close' ) ) {
	/**
	 * Main product configurator gallery section wrapper close
	 * 
	 * @return void
	 */
	function staggs_output_gallery_section_close() {
		echo '</div>';
		echo '</section>';
	}
}

if ( ! function_exists( 'staggs_output_preview_gallery_wrapper' ) ) {
	/**
	 * Product configurator gallery wrapper
	 * 
	 * @return void
	 */
	function staggs_output_preview_gallery_wrapper() {
		$bg_image_data = '';
		$gallery_class = 'staggs-view-gallery';
		$theme_id = staggs_get_theme_id();
		$image_ids = staggs_get_image_ids();

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
			$gallery_class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
		}

		if ( '3dmodel' !== staggs_get_post_meta( get_the_ID(), 'sgg_configurator_type' ) || $image_ids > 0 ) {
			$gallery_class .= ' swiper';
		}

		echo '<figure id="staggs-preview" class="' . esc_attr( $gallery_class ) . '"';

		if ( '3dmodel' !== staggs_get_post_meta( get_the_ID(), 'sgg_configurator_type' ) || $image_ids > 0 ) {
			$bg_image_urls = get_configurator_background_urls();
			
			if ( count( $bg_image_urls ) > 0 ) {
				echo ' data-backgrounds="' . esc_attr( implode( '|', $bg_image_urls ) ) . '"';
			}
		}
		
		if ( staggs_get_post_meta( $theme_id, 'sgg_capture_bg_image' ) ) {
			echo ' data-include-bg="1"';
		}

		echo '>';

		if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_fullscreen_display' )
			|| staggs_get_post_meta( $theme_id, 'sgg_gallery_camera_display' )
			|| staggs_get_post_meta( $theme_id, 'sgg_gallery_wishlist_display' )
			|| staggs_get_post_meta( $theme_id, 'sgg_gallery_pdf_display' )
			|| staggs_get_post_meta( $theme_id, 'sgg_gallery_share_display' )
			|| staggs_get_post_meta( $theme_id, 'sgg_gallery_reset_display' ) ) {

			echo '<div class="staggs-preview-actions">';

			// Check that Weglot is active and that we can access its services
            if (function_exists('weglot_get_service')) {
                $language_services = weglot_get_service('Language_Service_Weglot');
                $request_url_services = weglot_get_service('Request_Url_Service_Weglot');

                if ($language_services && $request_url_services) {
                    $current_language = $request_url_services->get_current_language();
                    $original_language = $language_services->get_original_language();
                    $destination_languages = $language_services->get_destination_languages(true);
                    $weglot_url = $request_url_services->get_weglot_url();

                    if (!empty($destination_languages)) {
                        // Invisible container for links with the non-translation attribute
                        echo '<div id="weglot-links-container" style="display:none;" data-wg-notranslate="">';
                        
                        foreach ($language_services->get_original_and_destination_languages(true) as $language) {
                            $link_button = $request_url_services->get_weglot_url()->getForLanguage($language);
                            if ($link_button) {
                                echo sprintf(
                                    '<a class="weglot-language-%s" data-wg-notranslate="" href="%s"></a>',
                                    esc_attr($language->getExternalCode()),
                                    esc_url($link_button)
                                );
                            }
                        }
                        echo '</div>';

                        // Language selector with non-translation attribute
                        echo '<button class="preview-action language-selector-wrapper" data-wg-notranslate="">';
                        echo '<select class="language-selector" data-wg-notranslate="" onchange="if(this.value){const link=document.querySelector(\'.weglot-language-\'+this.value);if(link)window.location.href=link.href;}">';

                        // Current language
                        if ($current_language) {
                            echo sprintf(
                                '<option value="%s" selected data-wg-notranslate="">%s</option>',
                                esc_attr($current_language->getExternalCode()),
                                esc_html(strtoupper($current_language->getExternalCode()))
                            );
                        }

                        // Original language if different
                        if ($original_language && $original_language->getExternalCode() !== $current_language->getExternalCode()) {
                            echo sprintf(
                                '<option value="%s" data-wg-notranslate="">%s</option>',
                                esc_attr($original_language->getExternalCode()),
                                esc_html(strtoupper($original_language->getExternalCode()))
                            );
                        }

                        // Destination languages
                        foreach ($destination_languages as $language) {
                            if ($language->getExternalCode() !== $current_language->getExternalCode()) {
                                echo sprintf(
                                    '<option value="%s" data-wg-notranslate="">%s</option>',
                                    esc_attr($language->getExternalCode()),
                                    esc_html(strtoupper($language->getExternalCode()))
                                );
                            }
                        }

                        echo '</select>';
                        echo '</button>';
					}
				}
			}
			
			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_fullscreen_display' ) ) {
				// Display request invoice as main button for cart button is disabled.
				$fullscreen_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_fullscreen_label' ) );
				if ( '' === $fullscreen_text ) {
					$fullscreen_text = __( 'Toggle fullscreen mode', 'staggs' );
				}

				echo '<button class="preview-action fullscreen"><span class="expand-fullscreen">';
				echo wp_kses(
					staggs_get_icon( 'sgg_fullscreen_icon', 'fullscreen' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="close-fullscreen">';
				echo wp_kses(
					staggs_get_icon( 'sgg_fullscreen_close_icon', 'fullscreen-close' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $fullscreen_text ) . '</span></button>';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_camera_display' ) ) {
				// Display request invoice as main button for cart button is disabled.
				$camera_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_camera_label' ) );
				if ( '' === $camera_text ) {
					$camera_text = __( 'Capture configuration image', 'staggs' );
				}

				echo '<button class="preview-action capture-image"><span class="image-icon">';
				echo wp_kses(
					staggs_get_icon( 'sgg_camera_icon', 'camera' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $camera_text ) . '</span></button>';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_wishlist_display' ) ) {
				// Display request invoice as main button for cart button is disabled.
				$wishlist_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_wishlist_label' ) );
				if ( '' === $wishlist_text ) {
					$wishlist_text = __( 'Add to my configurations', 'staggs' );
				}

				echo '<button class="preview-action wishlist-toggle" data-product="' . esc_attr( get_the_ID() ) . '"><span class="wishlist-icon">';
				echo wp_kses(
					staggs_get_icon( 'sgg_wishlist_icon', 'heart' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $wishlist_text ) . '</span></button>';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_pdf_display' ) ) {
				// Display request invoice as main button for cart button is disabled.
				$invoice_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_request_invoice_text' ) );
				if ( '' === $invoice_text ) {
					$invoice_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_pdf_label' ) );
				}
				if ( '' === $invoice_text ) {
					$invoice_text = __( 'Download to PDF', 'staggs' );
				}

				echo '<form action="' . esc_url( get_permalink( get_the_ID() ) ) . '?generate_pdf=' . esc_attr( get_the_ID() ) . '" method="post">
					<button id="download_pdf" data-product="' . esc_attr( get_the_ID() ) . '" class="preview-action download-pdf">
					<span class="pdf-icon">';
				echo wp_kses(
					staggs_get_icon( 'sgg_group_pdf_icon', 'invoice' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $invoice_text ) . '</span>
					</button>
				</form>';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_share_display' ) ) {
				$save_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_save_button_text' ) );
				if ( '' === $save_text ) {
					$save_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_share_label' ) );
				}
				if ( '' === $save_text ) {
					$save_text = __( 'Get configuration link', 'staggs' );
				}

				echo '<button class="preview-action share-link"><span class="link-icon">';
				echo wp_kses(
					staggs_get_icon( 'sgg_group_save_icon', 'save' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $save_text ) . '</span></button>';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_reset_display' ) ) {
				// Display request invoice as main button for cart button is disabled.
				$reset_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_reset_label' ) );
				if ( '' === $reset_text ) {
					$reset_text = __( 'Reset configuration', 'staggs' );
				}

				echo '<button class="preview-action reset-toggle" data-product="' . esc_attr( get_the_ID() ) . '"><span class="reset-icon">';
				echo wp_kses(
					staggs_get_icon( 'sgg_reset_icon', 'reset' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $reset_text ) . '</span></button>';
			}

			if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_info_display' ) ) {
				// Display request invoice as main button for cart button is disabled.
				$info_text = sanitize_text_field( staggs_get_theme_option( 'sgg_gallery_instructions_label' ) );
				if ( '' === $info_text ) {
					$info_text = __( 'Show viewer instructions', 'staggs' );
				}

				echo '<button class="preview-action show-instructions"><span class="image-icon">';
				echo wp_kses(
					staggs_get_icon( 'sgg_info_icon', 'panel-info' ),
					staggs_get_icon_kses_args()
				);
				echo '</span><span class="button-label">' . esc_attr( $info_text ) . '</span></button>';
			}

			echo '</div>';
		}
	}
}

if ( ! function_exists( 'staggs_output_preview_gallery_wrapper_close' ) ) {
	/**
	 * Product configurator gallery wrapper close
	 * 
	 * @return void
	 */
	function staggs_output_preview_gallery_wrapper_close() {
		echo '</figure>';
	}
}

if ( ! function_exists( 'staggs_output_preview_gallery' ) ) {
	/**
	 * Product configurator gallery
	 * 
	 * @return void
	 */
	function staggs_output_preview_gallery() {
		global $product, $image_ids, $sanitized_steps;

		/**
		 * Regular image slides.
		 */
		$image_ids = staggs_get_image_ids();

		if ( count( $image_ids ) > 0 ) {
			echo '<div class="staggs-view-gallery__images swiper-wrapper">';

			foreach ( $image_ids as $index => $image_id ) {
				// $url = wp_get_attachment_image_url( $image_id, 'full' );
				// if ( strpos( $url, '.svg' ) !== -1 ) {
				// 	$img = file_get_contents( str_replace( get_site_url(), ABSPATH, $url ) );
				// } else {
				// 	$img = '<img id="preview_' . esc_attr( $index ) . '_preview" src="' . $url . '">';
				// }

				echo '<div class="swiper-slide">
					<div id="preview_slide_' . esc_attr( $index ) . '" class="staggs-view-gallery__image">
						<img id="preview_' . esc_attr( $index ) . '_preview" src="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">
					</div>
				</div>';
			}
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'staggs_output_preview_gallery_thumbnails' ) ) {
	/**
	 * Product configurator gallery thumbnails
	 * 
	 * @return void
	 */
	function staggs_output_preview_gallery_thumbnails() {
		global $image_ids;

		$theme_id     = staggs_get_theme_id();
		$nav_location = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails_align' ) );
		$nav_position = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails_position' ) );	
		$nav_layout   = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails_layout' ) );
		$nav_class    = '';
		if ( '' !== $nav_location ) {
			$nav_class .= ' product-view-nav--' . $nav_location;
		}
		if ( '' !== $nav_position ) {
			$nav_class .= ' product-view-nav--' . $nav_position;
		}
		if ( '' !== $nav_layout ) {
			$nav_class .= ' product-view-nav--show-' . $nav_layout;
		}

		if ('thumbnails' !== staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails' )) {
			return;
		}

		// Check if multiple preview images set.
		if ( '3dmodel' === staggs_get_post_meta( $theme_id, 'sgg_configurator_gallery_type' ) ) {
			$nav_labels = staggs_get_post_meta( $theme_id, 'sgg_configurator_model_controls' );

			$properties = array(
				'target' => 'sgg_control_target',
				'orbit' => 'sgg_control_orbit',
				'fov' => 'sgg_control_fov',
				'background' => 'sgg_control_background',
				'exposure' => 'sgg_control_exposure'
			);
			?>
			<div class="product-view-nav product-view-nav--thumbnails<?php echo esc_attr( $nav_class ); ?>">
				<div class="view-nav-buttons">
					<?php
					foreach ( $nav_labels as $index => $label ) {
						if ( isset( $label['sgg_control_thumbnail'] ) && '' !== $label['sgg_control_thumbnail'] ) {
							$image_id = sanitize_key( $label['sgg_control_thumbnail'] );

							echo '<button data-key="' . esc_attr( $index ) . '"';

							foreach ( $properties as $data_key => $prop ) {
								if ( isset( $label[ $prop ] ) && '' !== $label[ $prop ] ) {
									echo ' data-' . esc_attr( $data_key ) . '="' . esc_attr( $label[ $prop ] ) . '"';
								}
							}

							echo '><img src="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '"></button>';
						}
					}
					?>
				</div>
			</div>
			<?php
		} else {
			// No image previews set.
			if ( ! is_array( $image_ids ) ) {
				return;
			}

			if ( count( $image_ids ) > 1 ) {
				?>
				<div class="product-view-nav product-view-nav--thumbnails<?php echo esc_attr( $nav_class ); ?>">
					<div class="view-nav-buttons">
						<?php
						foreach ( $image_ids as $index => $image_id ) {
							echo '<button id="preview_nav_' . esc_attr( $index ) . '" data-key="' . esc_attr( $index ) . '">
								<img id="button_preview_' . esc_attr( $index ) . '_preview" src="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">
							</button>';
						}
						?>
					</div>
				</div>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'staggs_output_preview_gallery_nav' ) ) {
	/**
	 * Product configurator gallery contents
	 * 
	 * @return void
	 */
	function staggs_output_preview_gallery_nav() {
		global $image_ids;

		// No image previews set.
		if ( ! is_array( $image_ids ) ) {
			return;
		}

		$theme_id = staggs_get_theme_id();
		if ( 'labels' === staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails' ) ) {
			$nav_location = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails_align' ) );
			$nav_position = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails_position' ) );	
			$nav_layout   = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnails_layout' ) );
			$nav_class    = '';
			if ( '' !== $nav_location ) {
				$nav_class .= ' product-view-nav--' . $nav_location;
			}
			if ( '' !== $nav_position ) {
				$nav_class .= ' product-view-nav--' . $nav_position;
			}
			if ( '' !== $nav_layout ) {
				$nav_class .= ' product-view-nav--show-' . $nav_layout;
			}
			
			$properties = array(
				'target' => 'sgg_control_target',
				'orbit' => 'sgg_control_orbit',
				'fov' => 'sgg_control_fov',
				'background' => 'sgg_control_background',
				'exposure' => 'sgg_control_exposure'
			);

			if ( '3dmodel' ===  staggs_get_post_meta( $theme_id, 'sgg_configurator_gallery_type' ) ) {
				$nav_labels = staggs_get_post_meta( $theme_id, 'sgg_configurator_model_controls' );
				?>
				<div class="product-view-nav product-view-nav--labels<?php echo esc_attr( $nav_class ); ?>">
					<div class="view-nav-buttons">
						<?php
						foreach ( $nav_labels as $index => $label ) {
							echo '<button id="preview_nav_label_' . esc_attr( $index ) . '" data-key="' . esc_attr( $index ) . '"';

							foreach ( $properties as $data_key => $prop ) {
								if ( isset( $label[ $prop ] ) && '' !== $label[ $prop ] ) {
									echo ' data-' . esc_attr( $data_key ) . '="' . esc_attr( $label[ $prop ] ) . '"';
								}
							}

							echo '>' . esc_attr( $label['sgg_control_label'] ) . '</button>';
						}
						?>
					</div>
				</div>
				<?php
			} else {
				$nav_labels = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_thumbnail_labels' ) );
				$nav_labels = explode( ',', $nav_labels );
				?>
				<div class="product-view-nav product-view-nav--labels<?php echo esc_attr( $nav_class ); ?>">
					<div class="view-nav-buttons">
						<?php
						foreach ( $nav_labels as $index => $label ) {
							echo '<button id="preview_nav_label_' . esc_attr( $index ) . '" data-key="' . esc_attr( $index ) . '">' . esc_attr( $label ) . '</button>';
						}
						?>
					</div>
				</div>
				<?php
			}
		}

		// Output arrows by default.
		$arrow_location = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_arrows' ) );
		if ( 'none' !== $arrow_location ) {
			?>
			<div class="swiper-button-prev swiper-button-prev--<?php echo esc_attr( $arrow_location ); ?>"></div>
			<div class="swiper-button-next swiper-button-next--<?php echo esc_attr( $arrow_location ); ?>"></div>
			<?php
		}
	}
}

if ( ! function_exists( 'staggs_product_single_title' ) ) {
	/**
	 * Product configurator title
	 *
	 * @return void
	 */
	function staggs_product_single_title() {
		echo '<h1 class="product_title entry-title">' . esc_attr( get_the_title() ) . '</h1>';
	}
}

if ( ! function_exists( 'staggs_product_single_description' ) ) {
	/**
	 * Product configurator summary
	 *
	 * @return void
	 */
	function staggs_product_single_description() {
		the_content();
	}
}

if ( ! function_exists( 'staggs_output_options_wrapper' ) ) {
	/**
	 * Product configurator options wrapper
	 *
	 * @return void
	 */
	function staggs_output_options_wrapper() {
		global $sanitized_steps, $sgg_minus_button, $sgg_plus_button;
		if ( ! is_array( $sanitized_steps ) ) {	
			$sanitized_steps = Staggs_Formatter::get_formatted_step_content( get_the_ID() );
		}

		$is_basic = false;
		$theme_id = staggs_get_theme_id();
		if ( 'staggs' !== staggs_get_configurator_page_template( $theme_id ) ) {
			$is_basic = staggs_get_post_meta( $theme_id, 'sgg_disable_attribute_styles' );
		}

		$sgg_minus_button = '';
		$sgg_plus_button = '';
		if ( staggs_get_theme_option('sgg_product_number_input_show_icons') ) {
			$sgg_minus_button = staggs_get_icon( 'sgg_group_minus_icon', 'minus' );
			$sgg_plus_button = staggs_get_icon( 'sgg_group_plus_icon', 'plus' );
		}

		if ( $is_basic ) {
			/**
			 * Applies basic attribute styles.
			 */
			echo '<div class="staggs-product-options-basic">';
			echo '<div class="option-group-wrapper-basic">';
		} else {
			/**
			 * Applies full Staggs attribute styles.
			 */
			$aside_class = '';
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_density' ) ) {
				$aside_class .= ' ' . staggs_get_post_meta( $theme_id, 'sgg_configurator_step_density' );
			}
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_text_align' ) ) {
				$aside_class .= ' text-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_text_align' );
			}
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
				$aside_class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
			}
	
			echo '<div class="staggs-product-options' . esc_attr( $aside_class ) .'">';
			echo '<div class="option-group-wrapper">';
		}
	}
}

if ( ! function_exists( 'staggs_output_options_wrapper_close' ) ) {
	/**
	 * Product configurator options wrapper close
	 *
	 * @return void
	 */
	function staggs_output_options_wrapper_close() {
		echo '</div>';
		echo '</div>';
	}
}

add_action( 'staggs_single_product_options_totals', 'staggs_get_inline_form', 20 );

if ( ! function_exists( 'staggs_get_inline_form' ) ) {
	function staggs_get_inline_form() {
		$theme_id  = staggs_get_theme_id();

		if ( 'invoice' !== staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' ) ) {
			return;
		}

		if ( 'inline' !== staggs_get_post_meta( $theme_id, 'sgg_configurator_form_display' ) ) {
			return;
		}

		if ( 'new_page' === staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_location' ) ) {
			return;
		}

		echo do_shortcode( staggs_get_post_meta( $theme_id, 'sgg_configurator_form_shortcode' ) );
	}
}

if ( ! function_exists( 'staggs_output_options_form' ) ) {
	/**
	 * Product configurator options form
	 *
	 * @return void
	 */
	function staggs_output_options_form() {
		global $original_post_id;
		echo '<form method="post" id="configurator-options" enctype="multipart/form-data" autocomplete="off">';

		if ( $original_post_id ) {
			echo '<input type="hidden" name="original_post_id" value="' . esc_attr( $original_post_id ) . '">';
		}
	}
}

if ( ! function_exists( 'staggs_output_options_form_close' ) ) {
	/**
	 * Product configurator options form close
	 *
	 * @return void
	 */
	function staggs_output_options_form_close() {
		echo '</form>';
	}
}

if ( ! function_exists( 'staggs_output_single_product_options' ) ) {
	/**
	 * Product configurator options
	 *
	 * @return void
	 */
	function staggs_output_single_product_options() {
		global $sanitized_steps, $sanitized_step, $step_count, $density, $text_align, $description_type, $sgg_is_admin;

		$theme_id          = staggs_get_theme_id();
		$step_count        = 0;
		$sgg_is_admin      = ( is_user_logged_in() && current_user_can('administrator') ) && staggs_get_theme_option( 'sgg_admin_display_edit_links' );;
		$hide_inline_title = staggs_get_post_meta( $theme_id, 'sgg_step_hide_inline_option_step_title' );
		$hide_inline_label = staggs_get_post_meta( $theme_id, 'sgg_step_hide_nav_step_labels' );
		$separator_type    = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_separator_function' );
		$indicator         = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_indicator' );
		$density           = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_density' );
		$text_align        = staggs_get_post_meta( $theme_id, 'sgg_configurator_text_align' );
		$description_type  = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_description_type' );

		/**
		 * Main Configurable Product Steps.
		 */
		if ( is_array( $sanitized_steps ) && count( $sanitized_steps ) > 0 ) {

			foreach ( $sanitized_steps as $step_key => $step_attribute ) {

				$sanitized_step = $step_attribute;

				if ( 'separator' === $step_attribute['type'] ) {

					$class = '';
					if ( $step_count > 0 ) {
						echo '</div>';
						echo '</div>';
					}

					if ( $step_attribute['collapsible'] ) {
						$class .= ' collapsible';

						if ( 'collapsed' === $step_attribute['state'] && ! $hide_inline_title ) {
							$class .= ' collapsed';
						}
					} else {
						if ( $step_count > 0 && 'stepper' === $separator_type ) {
							$class .= ' hidden';
						}
					}

					$step_count++;

					echo '<div class="option-group-step' . esc_attr( $class ) . '" data-step-group-id="' . esc_attr( $step_attribute['number'] ) . '">';

					if ( ! $hide_inline_title ) {
						echo '<div class="option-group-step-title">';

						echo '<p class="option-group-title">';
						if ( 'one' === $indicator ) {
							if ( $step_attribute['icon'] ) {
								echo '<span class="step-icon">' . wp_get_attachment_image( $step_attribute['icon'], 'full' ) . '</span>';
							} else {
								echo '<span class="step-number">' . esc_attr( $step_attribute['number'] ) . '</span>';
							}

							if ( ! $hide_inline_label ) {
								echo '<span>' . esc_attr( $step_attribute['title'] ) . '</span>';
							}
						} else {
							echo '<span>';

							if ( 'two' === $indicator ) {
								if ( $step_attribute['icon'] ) {
									echo '<span class="step-icon">' . wp_get_attachment_image( $step_attribute['icon'], 'full' ) . '</span>';
								} else {
									echo esc_attr( $step_attribute['number'] );
									echo esc_attr( apply_filters( 'staggs_step_nav_number_mark', '. ' ) );
								}
							}

							if ( ! $hide_inline_label ) {
								echo esc_attr( $step_attribute['title'] );
							}

							echo '</span>';
						}
						echo '</p>';

						if ( $step_attribute['collapsible'] ) {
							$collapse_icon_url = staggs_get_icon( 'sgg_separator_collapse_icon', 'collapse', true );
							echo '<img src="' . esc_url( $collapse_icon_url ) . '" alt="Arrow">';
						}

						echo '</div>';
					}

					echo '<div class="option-group-step-inner">';

				} else if ( 'tabs' === $step_attribute['type'] ) {

					include STAGGS_BASE . 'public/templates/shared/tab.php';

				} else if ( 'repeater' === $step_attribute['type'] ) {
					
					if ( $step_attribute['is_conditional'] && count( $step_attribute['conditional_rules'] ) > 0 ) {
						echo '<div class="conditional-wrapper" data-step-id="repeater-' . esc_attr( staggs_sanitize_title( $step_attribute['text_title'] ) ) . '" data-step-type="repeater" data-step-rules="' . urldecode( str_replace( '"', "'", wp_json_encode( $step_attribute['conditional_rules'] ) ) ) . '">';
						include STAGGS_BASE . 'public/templates/shared/repeater.php';
						echo '</div>';
					} else {
						include STAGGS_BASE . 'public/templates/shared/repeater.php';
					}

				} else if ( 'summary' === $step_attribute['type'] ) {

					echo do_shortcode('[staggs_configurator_summary]');

				} else if ( 'shortcode' === $step_attribute['type'] ) {

					echo do_shortcode( $step_attribute['shortcode'] );

				} else if ( 'html' === $step_attribute['type'] ) {

					echo wp_kses_post( $step_attribute['html'] );

				} else {

					if ( $step_attribute['is_conditional'] && count( $step_attribute['conditional_rules'] ) > 0 ) {
						echo '<div class="conditional-wrapper" data-step-id="' . esc_attr( $step_attribute['id'] ) . '" data-step-rules="' . urldecode( str_replace( '"', "'", wp_json_encode( $step_attribute['conditional_rules'] ) ) ) . '">';
						include 'templates/shared/attribute.php';
						echo '</div>';
					} else {
						include 'templates/shared/attribute.php';
					}
				}
			}

			if ( $step_count > 0 ) {
				echo '</div>';
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'staggs_output_option_group_header' ) ) {
	/**
	 * Product configurator option group header.
	 *
	 * @return void
	 */
	function staggs_output_option_group_header() {
		global $sanitized_step, $text_align, $density, $is_horizontal_popup, $description_type, $sgg_is_admin;

		if ( isset( $sanitized_step['show_title'] ) && 'hide' === $sanitized_step['show_title'] ) {
			return;
		}
		
		if ( ! ( 'true-false' === $sanitized_step['type'] && 'toggle' === $sanitized_step['button_view'] && 'left' === $text_align ) ) :
			?>
			<div class="option-group-header">
				<div class="option-group-title">
					<strong class="title">
						<?php 
						echo esc_attr( $sanitized_step['title'] );
						if ( isset( $sanitized_step['required'] ) && 'yes' === $sanitized_step['required'] ) {
							echo '<span class="required-indicator">*</span>';
						}
						?>
					</strong>
					<?php 
					if ( $sgg_is_admin ) {
						echo '<small><a href="' . esc_url( admin_url( 'post.php' ) ) . '?post=' . esc_attr( $sanitized_step['id'] ) . '&action=edit">(' . esc_attr__( 'Edit', 'staggs' ) . ')</a></small>'; 
					}

					if ( $sanitized_step['description'] ) : 
						if ( 'tooltip' === $description_type ) {
							?>
							<a href="#0" class="show-panel tooltip" aria-label="<?php esc_attr_e( 'Show description', 'staggs' ); ?>">
								<?php
								echo wp_kses( staggs_get_icon( 'sgg_group_info_icon', 'panel-info' ), staggs_get_icon_kses_args() );
								?>
							</a>
							<div class="option-group-tooltip-description">
								<?php echo wp_kses_post( $sanitized_step['description'] ); ?>
							</div>
							<?php
						} else {
							?>
							<a href="#0" class="show-panel" aria-label="<?php esc_attr_e( 'Show description', 'staggs' ); ?>">
								<?php
								echo wp_kses( staggs_get_icon( 'sgg_group_info_icon', 'panel-info' ), staggs_get_icon_kses_args() );
								?>
							</a>
							<?php
						}
				 	endif;

					$show_summary = ( 'show' == $sanitized_step['show_summary'] );
					$show_price = ( 'hide' !== $sanitized_step['show_option_price'] );
					if ( $show_summary && 'compact' === $density ) : 
						?>
						<p class="option-group-summary" data-summary="<?php echo $sanitized_step['show_summary']; ?>">
							<span class="name"></span> 
							<?php if ($show_price) : ?>
								<span class="value"></span>
							<?php endif; ?>
						</p>
						<?php
					endif;
					?>
				</div>
				<?php
				if ( $sanitized_step['short_description'] ) :
					?>
					<div class="option-group-description">
						<?php echo '<p>' . wp_kses_post(  $sanitized_step['short_description'] ) . '</p>'; ?>
					</div>
					<?php 
				endif; 

				if ( isset( $sanitized_step['collapsible'] ) && $sanitized_step['collapsible'] && ! $is_horizontal_popup ) :
					?>
					<div class="option-group-icon">
						<?php 
						echo staggs_get_icon( 'sgg_separator_collapse_icon', 'collapse' );
						?>
					</div>
					<?php 
				endif; 
				?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_output_option_group_content' ) ) {
	/**
	 * Product configurator option group step content.
	 *
	 * @return void
	 */
	function staggs_output_option_group_content() {
		global $step_key, $sanitized_step;

		$file_path = STAGGS_BASE . '/public/partials/' . $sanitized_step['type'] . '.php';
		if ( file_exists( $file_path ) ) {
			include $file_path;
		}
	}
}

if ( ! function_exists( 'staggs_output_option_tab_content' ) ) {
	/**
	 * Product configurator option tab step content.
	 *
	 * @return void
	 */
	function staggs_output_option_tab_content() {
		global $step_key, $sanitized_step;

		$file_path = STAGGS_BASE . '/public/partials/tabs.php';
		if ( file_exists( $file_path ) ) {
			include $file_path;
		}
	}
}

if ( ! function_exists( 'staggs_output_option_group_input_html' ) ) {
	/**
	 * Product configurator single option input html
	 *
	 * @return array
	 */
	function staggs_get_option_group_input_args( $sanitized_step, $option, $key ) {
		$option_args = array(
			'data-step-id' => $sanitized_step['id'],
			'data-option-id' => $option['id'],
			'value' => $option['name'],
		);

		if ( 'yes' === $option['enable_preview'] ) {
			if ( isset( $sanitized_step['preview_ref'] ) && '' !== $sanitized_step['preview_ref'] ) {
				$option_args['data-input-key'] = $sanitized_step['preview_ref'];
			}

			if ( isset( $option['preview_node'] ) && '' !== $option['preview_node'] ) {
				$option_args['data-nodes'] = $option['preview_node'];
			}

			if ( isset( $option['preview_hotspot'] ) && '' !== $option['preview_hotspot'] ) {
				$option_args['data-hotspots'] = $option['preview_hotspot'];
			}

			if ( isset( $option['preview_animation'] ) && '' !== $option['preview_animation'] ) {
				$option_args['data-animation'] = $option['preview_animation'];
			}

			if ( ( ( isset( $sanitized_step['allowed_options'] ) && 'multiple' == $sanitized_step['allowed_options'] ) 
				|| ( $sanitized_step['type'] === 'product' )
				|| ( $sanitized_step['type'] === 'tickboxes' )
			) && isset( $sanitized_step['preview_order'] ) && '' !== $sanitized_step['preview_order'] ) {
				// Multiple options allowed. Set option layer order index.
				$layer = $sanitized_step['preview_order'];
				$layers = explode( ',', $layer );
		
				if ( count( $layers ) > 1 ) {
					// Multi view order
					$option_layers = array();
					foreach ( $layers as $view_layer ) {
						$option_layers[] = ( (int) trim( $view_layer ) + $key );
					}
		
					$option_args['data-order'] = (implode(',', $option_layers));
				} else {
					// Single view order
					$base_layer = (int) $layer;
					$option_args['data-order'] = ( $base_layer + $key );
				}
			}
		}

		if ( isset( $option['preview_ref_selector'] ) && '' !== $option['preview_ref_selector'] ) {
			$option_args['data-preview-selector'] = $option['preview_ref_selector'];
		}

		if ( isset( $option['font_family'] ) && '' !== $option['font_family'] ) {
			$option_args['data-font-family'] = $option['font_family'];
			$option_args['data-font-weight'] = $option['font_weight'];
		}

		if ( isset( $option['field_color'] ) && '' !== $option['field_color'] ) {
			$option_args['data-color'] = $option['field_color'];
		}

		if ( isset( $option['sku'] ) && '' !== $option['sku'] ) {
			$option_args['data-sku'] = $option['sku'];

			if ( str_contains( $option['sku'], '}' ) ) {
				$option_args['data-sku-format'] = $option['sku'];
			}
		}

		if ( isset( $option['weight'] ) && '' !== $option['weight'] ) {
			$option_args['data-weight'] = $option['weight'];
		}

		if ( isset( $option['product_id'] ) && '' !== $option['product_id'] ) {
			$option_args['data-product'] = $option['product_id'];
		}

		if ( $sanitized_step['type'] !== 'product' && isset( $option['product_qty'] ) && '' !== $option['product_qty'] ) {
			$option_args['data-product-qty'] = $option['product_qty'];
		}

		if ( isset( $option['page_url'] ) && '' !== $option['page_url'] ) {
			$option_args['data-page-url'] = $option['page_url'];
		}

		if ( isset( $option['price_formula'] ) && '' !== $option['price_formula'] ) {
			$option_args['data-price-formula'] = $option['price_formula'];
		}

		if ( isset( $option['price_percent'] ) && '' !== $option['price_percent'] ) {
			$option_args['data-price-percent'] = $option['price_percent'];

			if ( isset( $option['price_field'] ) && '' !== $option['price_field'] ) {
				$option_args['data-price-field'] = $option['price_field'];
			}
		}

		if ( isset( $sanitized_step['required'] ) && 'yes' === $sanitized_step['required'] ) {
			$option_args['required'] = 'required';
		}

		$option_args = apply_filters( 'staggs_option_group_input_args', $option_args, $sanitized_step, $option, $key );

		return $option_args;
	}
}

if ( ! function_exists( 'staggs_output_option_group_summary' ) ) {
	/**
	 * Product configurator single option group summary
	 *
	 * @return void
	 */
	function staggs_output_option_group_summary() {
		global $sanitized_step, $density;

		$show_summary = ( 'show' == $sanitized_step['show_summary'] );
		$show_price = ( 'hide' !== $sanitized_step['show_option_price'] );

		if ( $show_summary && 'compact' !== $density ) :
			?>
			<p class="option-group-summary" data-summary="<?php echo $sanitized_step['show_summary']; ?>">
				<span class="name"></span>
				<?php if ($show_price) : ?>
					<span class="value"></span>
				<?php endif; ?>
			</p>
			<?php 
		endif;
	}
}

if ( ! function_exists( 'staggs_option_group_description_panel' ) ) {
	/**
	 * Product configurator options cart button.
	 *
	 * @return void
	 */
	function staggs_option_group_description_panel() {
		global $sanitized_step, $description_type;

		if ( isset( $sanitized_step['description'] ) && $sanitized_step['description'] && 'tooltip' !== $description_type ) :
			?>
			<div id="description-panel-<?php echo esc_attr( $sanitized_step['id'] ); ?>" class="option-group-panel option-group-panel--<?php echo $description_type; ?>">
				<div class="option-group-panel-header">
					<p><strong><?php echo esc_attr( $sanitized_step['title'] ); ?></strong></p>
					<a href="#0" class="close-panel" aria-label="<?php esc_attr_e( 'Hide description', 'staggs' ); ?>">
						<?php
						echo wp_kses(
							staggs_get_icon( 'sgg_group_close_icon', 'panel-close' ),
							staggs_get_icon_kses_args()
						);
						?>
					</a>
				</div>
				<div class="option-group-panel-content">
					<?php echo wp_kses_post(  $sanitized_step['description'] ); ?>
				</div>
			</div>
			<?php 
		endif;
	}
}

if ( ! function_exists( 'staggs_output_description_panels' ) ) {
	/**
	 * Product configurator description panels
	 *
	 * @return void
	 */
	function staggs_output_description_panels() {
		global $sanitized_steps, $sanitized_step;

		if ( is_array( $sanitized_steps ) && count( $sanitized_steps ) > 0 ) {
			echo '<div class="staggs-configurator-panels-wrapper">';

			foreach ( $sanitized_steps as $step_key => $sanitized_step ) {
				// Output description panel.
				staggs_option_group_description_panel();
			}

			echo '</div>';
		}
	}
}

if ( ! function_exists( 'staggs_output_bottom_bar_wrapper' ) ) {
	/**
	 * Product configurator bottom bar wrapper
	 *
	 * @return void
	 */
	function staggs_output_bottom_bar_wrapper() {
		$bottombar_class = '';
		$theme_id = staggs_get_theme_id();
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_sticky_button_mobile' ) ) {
			$bottombar_class .= ' mobile-inline';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_sticky_button_mobile' ) ) {
			echo '<div class="staggs-configurator-bottom-bar-spacer"></div>';
		}

		echo '<div class="staggs-configurator-bottom-bar' . esc_attr( $bottombar_class ) . '">';
	}
}

if ( ! function_exists( 'staggs_output_bottom_bar_wrapper_close' ) ) {
	/**
	 * Product configurator bottom bar wrapper close
	 *
	 * @return void
	 */
	function staggs_output_bottom_bar_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_bottom_bar_info_wrapper' ) ) {
	/**
	 * Product configurator bottom bar info wrapper
	 *
	 * @return void
	 */
	function staggs_output_bottom_bar_info_wrapper() {
		echo '<div class="bottom-bar-info">';
	}
}

if ( ! function_exists( 'staggs_output_bottom_bar_info_wrapper_close' ) ) {
	/**
	 * Product configurator bottom bar info wrapper close
	 *
	 * @return void
	 */
	function staggs_output_bottom_bar_info_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_options_summary_widget' ) ) {
	/**
	 * Product configurator summary widget
	 *
	 * @return void
	 */
	function staggs_output_options_summary_widget() {
		$theme_id = staggs_get_theme_id();
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_display_summary' ) ) {
			return;
		}

		$summary_title = staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_title' );
		if ( '' == $summary_title ) {
			$summary_title = 'Your configuration';
		}

		$hidden_items = staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_hidden_items' ) ?: '';
		?>
		<div class="staggs-summary-widget">
			<strong class="staggs-summary-title"><?php echo esc_attr( $summary_title ); ?></strong>
			<ul class="staggs-summary-items"<?php echo ( $hidden_items ) ? ' data-hidden="' . esc_attr( $hidden_items ) . '"' : ''; ?>></ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'staggs_single_product_options_totals_wrapper' ) ) {
	/**
	 * Product configurator options cart button.
	 *
	 * @return void
	 */
	function staggs_single_product_options_totals_wrapper() {
		global $button_sticky, $totals_display;

		/**
		 * Hook: staggs_before_single_product_options_totals
		 *
		 * @hooked -
		 */
		do_action( 'staggs_before_single_product_options_totals' );	
	
		$theme_id       = staggs_get_theme_id();
		$button_class   = ' total';
		$button_sticky  = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_sticky_button' ) );
		$totals_display = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_totals_display' ) );

		if ( $button_sticky && 'always' === $totals_display ) {
			$button_class .= ' fixed';
		}
		if ( 'end' === $totals_display ) {
			$button_class .= ' hidden';
		}

		echo '<div class="option-group' . esc_attr( $button_class ) . '"';
		if ( 'end' === $totals_display ) {
			echo ' data-show-step="final"';
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_totals_display_required' ) ) {
			echo ' data-step-valid="required"';
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_display_qty_total' ) ) {
			echo ' data-qty-totals="1"';
		}

		if ( 'table' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_calculation' ) ) {
			if ( $table_id = staggs_get_post_meta( get_the_ID(), 'sgg_configurator_total_price_table' ) ) {
				$total_table_id = sanitize_key( $table_id );
			} else {
				$total_table_id = sanitize_key( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_table' ) );
			}

			if ( $total_table_id ) {
				echo ' data-table-id="' . esc_attr( $total_table_id ) . '"';
			}
		}

		if ( 'custom' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_calculation' ) ) {
			$formula = staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_formula' );
			echo ' data-formula="' . esc_attr( $formula ) . '"';
		}

		$qty_input_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_qty_input_label' );
		if ( $qty_input_label ) {
			echo ' data-quantity-id="' . esc_attr( $qty_input_label ) . '"';
		}

		echo '>';
		echo '<div class="option-group-content">';
	}
}

if ( ! function_exists( 'staggs_single_product_options_totals_wrapper_close' ) ) {
	/**
	 * Product configurator options cart button.
	 *
	 * @return void
	 */
	function staggs_single_product_options_totals_wrapper_close() {
		global $button_sticky, $totals_display;

		echo '</div>';

		/**
		 * Hook: staggs_after_single_product_options_totals
		 *
		 * @hooked -
		 */
		do_action( 'staggs_after_single_product_options_totals' );

		echo '</div>';

		if ( $button_sticky && 'always' === $totals_display ) {
			$spacer_class = 'option-group-spacer';

			$usps = staggs_get_post_meta( staggs_get_theme_id(), 'sgg_step_usps' );
			if ( is_array( $usps ) && count( $usps ) > 0 ) {
				$spacer_class .= ' option-group-spacer--tall';
			}

			echo '<div class="' . esc_attr( $spacer_class ) . '"></div>';
		}
	}
}

if ( ! function_exists( 'staggs_output_bottom_bar_totals' ) ) {
	/**
	 * Product configurator bottom bar totals
	 *
	 * @return void
	 */
	function staggs_output_bottom_bar_totals() {
		echo '<div class="bottom-bar-totals-wrapper">';

		do_action( 'staggs_before_bottom_bar_totals' );

		$theme_id = staggs_get_theme_id();
		$totals_display = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_totals_display' ) );

		echo '<div class="bottom-bar-totals option-group total"';

		if ( 'end' === $totals_display ) {
			echo ' data-show-step="final"';

			$button_position = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_totals_button_position' ) );
			if ( 'in_step_controls' === $button_position ) {
				echo ' data-button-position="step-controls"';
			}
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_totals_display_required' ) ) {
			echo ' data-step-valid="required"';
		}

		if ( 'table' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_calculation' ) ) {
			if ( $table_id = staggs_get_post_meta( get_the_ID(), 'sgg_configurator_total_price_table' ) ) {
				$total_table_id = sanitize_key( $table_id );
			} else {
				$total_table_id = sanitize_key( staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_table' ) );
			}

			if ( $total_table_id ) {
				echo ' data-table-id="' . esc_attr( $total_table_id ) . '"';
			}
		}

		if ( 'custom' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_calculation' ) ) {
			$formula = staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_formula' );
			echo ' data-formula="' . esc_attr( $formula ) . '"';
		}

		$qty_input_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_qty_input_label' );
		if ( $qty_input_label ) {
			echo ' data-quantity-id="' . esc_attr( $qty_input_label ) . '"';
		}

		echo '>';

		do_action( 'staggs_bottom_bar_totals' );

		echo '</div>';

		do_action( 'staggs_after_bottom_bar_totals' );

		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_add_to_cart_wrapper' ) ) {
	/**
	 * Product configurator add to cart button wrapper.
	 *
	 * @return void
	 */
	function staggs_output_add_to_cart_wrapper() {
		if ( ! product_is_configurable( get_the_ID() ) ) {
			return;
		}

		$class = '';
		$theme_id = staggs_get_theme_id();
		if ( ! staggs_get_post_meta( $theme_id, 'sgg_theme_disable_cart_styles' ) ) {
			$class .= ' staggs';
		}
		$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
		if ( 'within' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' ) && 'hide' !== $display_price ) {
			$class .= ' inline_price';
		}

		echo '<div class="staggs-cart-form-button' . esc_attr( $class ) . '"';
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_display_qty_input' ) && staggs_get_post_meta( $theme_id, 'sgg_configurator_display_qty_total' ) ) {
			echo ' data-qty-totals="1"';
		}
		echo '>';
	}
}

if ( ! function_exists( 'staggs_output_add_to_cart_wrapper_close' ) ) {
	/**
	 * Product configurator add to cart button wrapper close.
	 *
	 * @return void
	 */
	function staggs_output_add_to_cart_wrapper_close() {
		if ( ! product_is_configurable( get_the_ID() ) ) {
			return;
		}
		
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_product_totals_list' ) ) {
	/**
	 * Product configurator options totals list details.
	 *
	 * @return void
	 */
	function staggs_output_product_totals_list() {
		global $sgg_is_shortcode;

		$theme_id = staggs_get_theme_id();
		$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
		if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
			$display_price = 'hide';
		}

		$totals_class  = '';
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_price_summary_collapse' ) ) {
			$totals_class  = ' collapsible collapsed';
		}

		do_action( 'staggs_before_total_list' );
		echo '<div class="totals-list' . esc_attr( $totals_class ) . '">';
		do_action( 'staggs_before_total_row' );

		if ( staggs_get_theme_option( 'sgg_product_totals_show_weight' ) && ! staggs_get_post_meta( $theme_id, 'sgg_configurator_disable_product_weight' ) ) {
			$weight_label = staggs_get_theme_option( 'sgg_product_totals_weight_label' ) ?: 'Product weight:';
			$weight_sep   = staggs_get_theme_option( 'sgg_product_totals_weight_decimal_sep' ) ?: '.';
			$weight_dec   = staggs_get_theme_option( 'sgg_product_totals_weight_decimals' ) ?: '2';

			echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_weight_label', __( $weight_label, 'staggs' ) ) );
			echo '<span id="product_weight" data-sep="' . esc_attr( $weight_sep ) . '" data-dec="' . esc_attr( $weight_dec ) . '"></span></div>';
		}

		if ( 'hide' !== $display_price ) {
			$template = staggs_get_configurator_page_template( $theme_id );
			$view = staggs_get_configurator_view_layout( $theme_id );

			if ( staggs_get_theme_option( 'sgg_product_totals_show_tax' ) ) {
				$tax_label = staggs_get_theme_option( 'sgg_product_totals_alt_tax_label' ) ?: 'Total tax:';
				echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_tax_label', __( $tax_label, 'staggs' ) ) ) . '<span id="totaltaxprice"></span></div>';	
			}

			if ( 'above' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' ) || 'none' === $template || 'default' === $template ) {
				if ( 'summary' === staggs_get_post_meta( $theme_id, 'sgg_configurator_price_display_template' ) && in_array( $view, array( 'classic', 'floating', 'full' ) ) ) {

					$product_label  = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_product_label' ) ?: __( 'Product total:', 'staggs' );
					$options_label  = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_options_label' ) ?: __( 'Options total:', 'staggs' );
					$combined_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_combined_label' ) ?: __( 'Grand total:', 'staggs' );

					if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_price_summary_collapse' ) ) {
						echo '<div class="totals-row-details">';
					}

					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_product_label', sgg__( $product_label ) ) ) . '<span id="productprice"></span></div>';	
					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_configuration_label', sgg__( $options_label ) ) ) . '<span id="optionsprice"></span></div>';

					do_action( 'staggs_total_row_details' );
					
					if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_price_summary_collapse' ) ) {
						echo '</div>';
					}

					echo '<div class="totals-row totals-row-last">' . esc_attr( apply_filters( 'staggs_total_combined_label', sgg__( $combined_label ) ) );
					echo '<span class="totals-row-price"><span id="totalprice"></span>';

					if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_price_summary_collapse' ) ) {
						echo '<a href="#0" id="totals-list-collapse">' . wp_kses( staggs_get_icon( 'sgg_separator_collapse_icon', 'collapse' ), staggs_get_icon_kses_args() ) . '</a>';
					}

					echo '</span></div>';

				} else {

					$totals_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_totals_label' ) ?: __( 'Total:', 'staggs' );
					echo '<div class="totals-row">' . esc_attr( apply_filters( 'staggs_total_row_label', sgg__( $totals_label ) ) ) . '<span id="totalprice"></span></div>';

				}
			}
		}

		do_action( 'staggs_after_total_row' );
		echo '</div>';
		do_action( 'staggs_after_total_list' );
	}
}

if ( ! function_exists( 'staggs_output_product_main_button' ) ) {
	/**
	 * Product configurator options cart button.
	 *
	 * @return void
	 */
	function staggs_output_product_main_button() {
		global $product;

		$theme_id = staggs_get_theme_id();
		if ( 'none' === staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' )) {
			return; // No action.
		}

		if ( ! is_user_logged_in() && function_exists('wc_get_page_id') && staggs_get_theme_option('sgg_product_redirect_visitors_to_login_page') ) {
			if ( 'new_page' === staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_location' ) ) {
				$button_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_page_button' ) );
				if ( '' === $button_text ) {
					$button_text = __( 'Finish configuration', 'staggs' );
				}
			} else {
				$button_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_add_to_cart_text' ) );
				if ( '' === $button_text ) {
					if ( 'cart' === staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' ) ) {
						$button_text = $product->single_add_to_cart_text();
					} else {
						$button_text = __( 'Request invoice', 'staggs' );
					}
				}
			}

			$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
			if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
				$display_price = 'hide';
			}

			$button_wrapper_class = '';
			if ( 'within' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' )
				&& 'hide' !== $display_price ) {
				$button_wrapper_class = ' inline_price';
			}

			if ( ! staggs_get_post_meta( $theme_id, 'sgg_theme_disable_cart_styles' ) ) {
				$button_wrapper_class .= ' staggs';
			}
			?>
			<div class="button-wrapper">
				<?php
				if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_hide_totals_button' ) ) : 
					$login_page_url = apply_filters( 'sgg_visitor_login_page_url', get_permalink( wc_get_page_id('myaccount') ) );
					?>
					<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
						<a href="<?php echo esc_url( $login_page_url ); ?>" class="button request-invoice">
							<?php
							echo esc_attr( $button_text );

							if ( 'within' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' ) && 'hide' !== $display_price ) {
								echo '<span id="totalprice"></span>';
							}
							?>
						</a>
					</div>
					<?php
				endif;
				?>
			</div>
			<?php
			return;
		}
		
		if ( 'new_page' === staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_location' ) ) :
			// Display view summary as main button
			$summary_button_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_summary_page_button' ) );
			if ( '' === $summary_button_text ) {
				$summary_button_text = __( 'Finish configuration', 'staggs' );
			}

			$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
			if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
				$display_price = 'hide';
			}

			$button_wrapper_class = '';
			if ( 'within' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' ) && 'hide' !== $display_price ) {
				$button_wrapper_class = ' inline_price';
			}
			if ( ! staggs_get_post_meta( $theme_id, 'sgg_theme_disable_cart_styles' ) ) {
				$button_wrapper_class .= ' staggs';
			}
			?>
			<div class="button-wrapper">
				<?php
				if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_hide_totals_button' ) ) : 
					?>
					<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
						<a href="#" data-product="<?php echo esc_attr( get_the_ID() ); ?>" class="button request-invoice open-summary-page" id="staggs-show-summary">
							<?php
							echo esc_attr( $summary_button_text );

							if ( 'within' === staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' ) && 'hide' !== $display_price ) {
								echo '<span id="totalprice"></span>';
							}
							?>
						</a>
					</div>
					<?php
				endif;

				do_action( 'staggs_after_single_add_to_cart' );
				?>
			</div>
			<?php
		else:
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && 'cart' === staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' ) ) {

				if ( ! $product ) {
					$product = wc_get_product( get_the_ID() );
				}
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
						do_action( 'staggs_after_single_add_to_cart' );
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

				$total_price_display = staggs_get_post_meta( $theme_id, 'sgg_configurator_total_price_display' );
				$display_price = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_pricing' );
				if ( staggs_get_theme_option( 'sgg_product_show_price_logged_in_users' ) && ! is_user_logged_in() ) {
					$display_price = 'hide';
				}

				$button_wrapper_class = '';
				if ( 'within' === $total_price_display && 'hide' !== $display_price ) {
					$button_wrapper_class = ' inline_price';
				}
				if ( ! staggs_get_post_meta( $theme_id, 'sgg_theme_disable_cart_styles' ) ) {
					$button_wrapper_class .= ' staggs';
				}

				$page_id = staggs_get_post_meta( $theme_id, 'sgg_configurator_form_page' );
				$button_type = staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' );
				?>
				<div class="button-wrapper">
					<?php
					if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_hide_totals_button' ) ) : 
						if ( 'invoice' === $button_type ) :
							?>
							<form action="<?php echo esc_url( get_permalink( $page_id ) ); ?>" id="invoice" method="get" class="staggs-main-action product-action action-request-invoice">
								<input type="hidden" id="append" name="product_name" value="<?php echo esc_attr( get_the_title() ); ?>">
								<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
									<button 
										type="submit"
										class="button request-invoice"
										id="request-invoice"
										<?php 
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
										<?php
										echo esc_attr( $invoice_text );

										if ( 'within' === $total_price_display && 'hide' !== $display_price ) {
											echo '<span id="totalprice"></span>';
										}
										?>
									</button>
								</div>
							</form>
							<?php
						elseif ( 'pdf' === $button_type ) :
							?>
							<form action="<?php echo esc_url( get_permalink( get_the_ID() ) . '?generate_pdf=' . get_the_ID() ); ?>" data-product="<?php echo esc_attr( get_the_ID() ); ?>" id="staggs_pdf_invoice" method="get" class="staggs-main-action product-action action-request-invoice staggs-main-action-pdf-download">
								<input type="hidden" name="generate_pdf" value="<?php echo esc_attr( get_the_ID() ); ?>"/>
								<?php
								if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_pdf_collect_email' ) ) :
									?>
									<div class="text-input staggs-pdf-email-input">
										<label for="pdf_user_email" class="input-field-wrapper">
											<span class="input-heading">
												<p class="input-title">
													<?php
													$input_label = esc_attr__( 'Your email address', 'staggs' );
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
										<?php 
										echo esc_attr( $invoice_text );

										if ( 'within' === $total_price_display && 'hide' !== $display_price ) {
											echo '<span id="totalprice"></span>';
										}
										?>
									</button>
								</div>
							</form>
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
							<div class="staggs-cart-form-button<?php echo esc_attr( $button_wrapper_class ); ?>">
								<a 
									href="<?php echo esc_url( $mail_link ); ?>" 
									class="button request-invoice send-email<?php echo esc_attr( $class ); ?>"
									id="staggs-send-email"
									target="_blank"
									<?php
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
									<?php
									echo esc_attr( $invoice_text );

									if ( 'within' === $total_price_display && 'hide' !== $display_price ) {
										echo '<span id="totalprice"></span>';
									}
									?>
								</a>
							</div>
							<?php
						endif;
					endif;

					do_action( 'staggs_after_single_add_to_cart' );
					?>
				</div>
				<?php
			}
		endif;
	}
}

if ( ! function_exists( 'staggs_output_options_usps' ) ) {
	/**
	 * Product configurator options usps.
	 *
	 * @return void
	 */
	function staggs_output_options_usps() {
		$usps = staggs_get_post_meta( staggs_get_theme_id(), 'sgg_step_usps' );
		if ( is_array( $usps ) && count( $usps ) > 0 ) {
			?>
			<div class="staggs-product-usps product-view-usps">
				<?php
				foreach ( $usps as $usp ) :
					?>
					<div class="usps-item">
						<?php echo wp_get_attachment_image( $usp['sgg_usp_icon'], 'thumbnail' ); ?>
						<p><?php echo esc_attr( $usp['sgg_usp_title'] ); ?></p>
					</div>
					<?php
				endforeach;
				?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'staggs_output_options_credit' ) ) {
	/**
	 * Product configurator options credit message.
	 *
	 * @return void
	 */
	function staggs_output_options_credit() {
		if ( ! sgg_fs()->is_plan_or_trial( 'professional' ) ) :
			?>
			<p class="credit">Powered by <a href="https://staggs.app/" target="_blank" rel="noopener noreferrer">Staggs</a></p>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_output_topbar_product_title' ) ) {
	/**
	 * Product configurator popup topbar title.
	 *
	 * @return void
	 */
	function staggs_output_topbar_product_title() {
		echo '<a href="#" id="close-popup">'
			. wp_kses( staggs_get_icon( 'sgg_popup_back_icon', 'popup-back' ), staggs_get_icon_kses_args() )
			. '<span>' . esc_attr( get_the_title() ) . '</span></a>';
	}
}

if ( ! function_exists( 'staggs_output_popup_bottom_bar' ) ) {
	/**
	 * Product configurator popup bottom bar.
	 *
	 * @return void
	 */
	function staggs_output_popup_bottom_bar() {
		echo '<div class="bottom-bar-left">';

		do_action( 'staggs_output_popup_bottom_bar_left' );

		echo '</div>';
		echo '<div class="bottom-bar-right">';

		do_action( 'staggs_output_popup_bottom_bar_right' );

		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_product_sticky_bar' ) ) {
	/**
	 * Product configurator options save buttons.
	 *
	 * @return void
	 */
	function staggs_output_product_sticky_bar() {
		$usps = array();

		$theme_id = staggs_get_theme_id();
		if ( 'classic' !== staggs_get_configurator_view_layout( $theme_id ) ) {
			return;
		}

		if ( ! staggs_get_post_meta( $theme_id, 'sgg_configurator_sticky_cart_bar' ) ) {
			return;
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_sticky_cart_bar_usps' ) ) {
			$usps = staggs_get_post_meta( $theme_id, 'sgg_step_usps' );
		}

		$wrapper_class = '';
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' ) ) {
			$wrapper_class .= ' border-' . staggs_get_post_meta( $theme_id, 'sgg_configurator_borders' );
		}

		$cart_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_add_to_cart_text' ) );
		if ( '' === $cart_text ) {
			if ( 'cart' === staggs_get_post_meta( $theme_id, 'sgg_configurator_button_type' ) ) {
				$cart_text = __( 'Add to cart', 'staggs' );

				if ( isset( $_GET['sgg_key'] ) && '' !== $_GET['sgg_key'] ) {
					$update_text = staggs_get_post_meta( $theme_id, 'sgg_step_update_cart_text' );
					
					if ( '' !== $update_text ) {
						$cart_text = $update_text;
					}
				}
			} else {
				$cart_text = __( 'Request invoice', 'staggs' );
			}
		}
		?>
		<div class="staggs-configurator-bottom-bar staggs-configurator-sticky-bar<?php echo esc_attr( $wrapper_class ); ?>">
			<div class="staggs-container">
				<div class="staggs-configurator-sticky-bar-inner">
					<div class="staggs-sticky-bar-header">
						<p class="staggs-sticky-bar-title"><?php the_title(); ?></p>
						<?php
						if ( count( $usps ) > 0 ) {
							staggs_output_options_usps();
						}
						?>
					</div>
					<div class="staggs-sticky-bar-totals">
						<div class="sticky-bar-totalprice">
							<?php do_action( 'staggs_before_sticky_bar_total_price' ); ?>
							<span id="totalprice"></span>
						</div>
						<div class="staggs-cart-form-button staggs">
							<button id="staggs-sticky-bar" class="button single_add_to_cart_button">
								<?php echo esc_attr( $cart_text ); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}