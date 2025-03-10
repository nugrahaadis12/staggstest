<?php

/**
 * The main functions of this PRO plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.5
 *
 * @package    Staggs
 * @subpackage Staggs/includes
 */

if ( ! function_exists( 'staggs_output_preview_gallery' ) ) {
	/**
	 * Product configurator gallery
	 * 
	 * @return void
	 */
	function staggs_output_preview_gallery() {
		global $post, $product, $image_ids, $sanitized_steps;

		if ( '3dmodel' === staggs_get_post_meta( get_the_ID(), 'sgg_configurator_type' ) ) {
			/**
			 * Get 3D model source and handlers.
			 */
			$theme_id = staggs_get_theme_id();
			$src_id   = staggs_get_post_meta( get_the_ID(), 'sgg_configurator_3d_model' );
			$src      = wp_get_attachment_url( $src_id );
	
			/**
			 * Staggs model viewer before hook.
			 * 
			 * @hooked -
			 */
			do_action( 'staggs_before_model_viewer' );

			/**
			 * Regular image slides.
			 */
			$image_ids = staggs_get_image_ids();
			$disable_slider = staggs_get_post_meta( $theme_id, 'sgg_configurator_model_disable_slider' );

			if ( count( $image_ids ) > 1 && ! $disable_slider ) {
				echo '<div class="staggs-view-gallery__images swiper-wrapper">';
				foreach ( $image_ids as $index => $image_id ) {
					if ( 0 === $index ) {
						echo '<div class="swiper-slide swiper-slide--3dmodel">';
						echo '<div id="preview_slide_' . esc_attr( $index ) . '" class="staggs-view-gallery__image staggs-view-gallery__model" data-base-id="preview_' . esc_attr( $index ) . '_preview" data-base-url="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">';
						echo '<model-viewer id="product-model-view" camera-controls src="' . esc_url( $src ) . '" alt="' . esc_attr( get_the_title( get_the_ID() ) ) . '"';
						staggs_display_3d_viewer_attributes( $theme_id );
						echo '>';
		
						/**
						 * Staggs model viewer contents hook.
						 * 
						 * @hooked staggs_output_model_dimensions - 10
						 */
						do_action( 'staggs_model_viewer_contents' );

						echo '</model-viewer></div></div>';
					} else {
						echo '<div class="swiper-slide">
							<div id="preview_slide_' . esc_attr( $index ) . '" class="staggs-view-gallery__image" data-base-id="preview_' . esc_attr( $index ) . '_preview" data-base-url="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">
								<img id="preview_' . esc_attr( $index ) . '_preview" src="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">
							</div>
						</div>';
					}
					// $url = wp_get_attachment_image_url( $image_id, 'full' );
					// if ( strpos( $url, '.svg' ) !== -1 ) {
					// 	$img = file_get_contents( str_replace( get_site_url(), ABSPATH, $url ) );
					// } else {
					// 	$img = '<img id="preview_' . $index . '_preview" src="' . $url . '">';
					// }
				}

				echo '</div>';

			} else {

				echo '<model-viewer id="product-model-view" camera-controls src="' . esc_url( $src ) . '" alt="' . esc_attr( get_the_title( get_the_ID() ) ) . '"';
				staggs_display_3d_viewer_attributes( $theme_id );
				echo '>';
	
				/**
				 * Staggs model viewer contents hook.
				 * 
				 * @hooked staggs_output_model_dimensions - 10
				 */
				do_action( 'staggs_model_viewer_contents' );

				echo '</model-viewer>';
			}
			
			/**
			 * Staggs model viewer after hook.
			 * 
			 * @hooked 
			 */
			do_action( 'staggs_after_model_viewer' );
			
		} else {

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
					// 	$img = '<img id="preview_' . $index . '_preview" src="' . $url . '">';
					// }
					echo '<div class="swiper-slide">
						<div id="preview_slide_' . esc_attr( $index ) . '" class="staggs-view-gallery__image" data-base-id="preview_' . esc_attr( $index ) . '_preview" data-base-url="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">
							<img id="preview_' . esc_attr( $index ) . '_preview" src="' . esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ) . '">
						</div>
					</div>';
				}
				
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'staggs_output_model_ar_button' ) ) {
	/**
	 * Output product configurator model AR button
	 * 
	 * @return void
	 */
	function staggs_output_model_ar_button() {
		$theme_id = staggs_get_theme_id();
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_display_ar_button' ) ) :
			?>
			<button slot="ar-button" id="ar-button">
				<?php
				$ar_icon_url = staggs_get_icon( 'sgg_mobile_ar_icon', 'ar-icon', true );
				echo '<img src="' . esc_url( $ar_icon_url ) . '" alt="AR icon" width="20" height="20">';

				if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_ar_button_text' ) ) {
					echo '<span>' . esc_attr( staggs_get_post_meta( $theme_id, 'sgg_configurator_ar_button_text' ) ) . '</span>';
				} else {
					echo '<span>' . esc_attr__( 'View in AR', 'staggs' ) . '</span>';
				}
				?>
			</button>
			<?php
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_display_desktop_ar_button' ) ) :
				?>
				<button id="ar-button-desktop">
					<?php
					$ar_icon_url = staggs_get_icon( 'sgg_mobile_ar_icon', 'ar-icon', true );
					echo '<img src="' . esc_url( $ar_icon_url ) . '" alt="AR icon" width="20" height="20">';
					?>
				</button>
				<?php
			endif;
			?>
			<button id="ar-failure">
				<?php esc_attr_e( 'AR is not tracking!', 'staggs' ); ?>
			</button>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_output_desktop_qr_popup' ) ) {
	/**
	 * Output product configurator desktop AR popup
	 * 
	 * @return void
	 */
	function staggs_output_desktop_qr_popup() {
		$theme_id = staggs_get_theme_id();

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_display_desktop_ar_button' ) ) :
			$qr_title = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_desktop_ar_title' ) ?: __( 'QR code', 'staggs' );
			$qr_intro = staggs_get_post_meta( $theme_id, 'sgg_configurator_display_desktop_ar_intro' ) ?: __( 'Scan the QR code below to view product in your room', 'staggs' );
	
			$theme = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_theme' ) );
			$color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_text_color' ) ) ?: '#000';
			$bg_color = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_primary_color' ) ) ?: '#fff';
			if ( 'dark' === $theme ) {
				$bg_color = '#111';
				$color = '#fff';
			} else if ( 'light' === $theme ) {
				$bg_color = '#fff';
			}
			?>
			<div id="staggs-qr-popup" class="option-group-panel option-group-panel--popup">
				<div class="option-group-panel-header">
					<p><strong><?php echo esc_attr( $qr_title ); ?></strong></p>
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
					<p><?php echo $qr_intro; ?></p>
					<div id="staggs-qr-code" data-url="<?php echo get_permalink(); ?>" data-background="<?php echo $color; ?>" data-color="<?php echo $bg_color; ?>"></div>
				</div>
			</div>
			<?php
		endif;

		if ( staggs_get_post_meta( $theme_id, 'sgg_gallery_info_display' ) ) :
			$info_title = staggs_get_post_meta( $theme_id, 'sgg_configurator_viewer_info_title' ) ?: __( 'Viewer instructions', 'staggs' );
			$info_text  = staggs_get_post_meta( $theme_id, 'sgg_configurator_viewer_info_text' ) ?: __( 'Use arrow keys to rotate and mouse to spin model around.', 'staggs' );
			?>
			<div id="staggs-viewer-info-popup" class="option-group-panel option-group-panel--popup">
				<div class="option-group-panel-header">
					<p><strong><?php echo esc_attr( $info_title ); ?></strong></p>
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
					<p><?php echo $info_text; ?></p>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_output_model_dimensions' ) ) {
	/**
	 * Output product configurator model dimensions
	 * 
	 * @return void
	 */
	function staggs_output_model_dimensions() {
		if ( staggs_get_post_meta( get_the_ID(), 'sgg_configurator_display_model_dimensions' ) ) :
			?>
			<button slot="hotspot-dot+X-Y+Z" class="dot" data-position="1 -1 1" data-normal="1 0 0"></button>
			<button slot="hotspot-dim+X-Y" class="dim" data-position="1 -1 0" data-normal="1 0 0"></button>
			<button slot="hotspot-dot+X-Y-Z" class="dot" data-position="1 -1 -1" data-normal="1 0 0"></button>
			<button slot="hotspot-dim+X-Z" class="dim" data-position="1 0 -1" data-normal="1 0 0"></button>
			<button slot="hotspot-dot+X+Y-Z" class="dot" data-position="1 1 -1" data-normal="0 1 0"></button>
			<button slot="hotspot-dim+Y-Z" class="dim" data-position="0 -1 -1" data-normal="0 1 0"></button>
			<button slot="hotspot-dot-X+Y-Z" class="dot" data-position="-1 1 -1" data-normal="0 1 0"></button>
			<button slot="hotspot-dim-X-Z" class="dim" data-position="-1 0 -1" data-normal="-1 0 0"></button>
			<button slot="hotspot-dot-X-Y-Z" class="dot" data-position="-1 -1 -1" data-normal="-1 0 0"></button>
			<button slot="hotspot-dim-X-Y" class="dim" data-position="-1 -1 0" data-normal="-1 0 0"></button>
			<button slot="hotspot-dot-X-Y+Z" class="dot" data-position="-1 -1 1" data-normal="-1 0 0"></button>
			<svg id="dimLines" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" class="dimensionLineContainer">
				<line class="dimensionLine"></line>
				<line class="dimensionLine"></line>
				<line class="dimensionLine"></line>
				<line class="dimensionLine"></line>
				<line class="dimensionLine"></line>
			</svg>
			<?php
		endif;
	}
}

if ( ! function_exists( 'staggs_output_popup_options_bar' ) ) {
	/**
	 * Product configurator options popup nav options
	 *
	 * @return void
	 */
	function staggs_output_popup_options_bar() {
		global $sanitized_steps, $sanitized_step, $steps_nav, $step_count, $is_horizontal_popup, $density, $text_align, $description_type, $sgg_is_admin;

		$theme_id = staggs_get_theme_id();
		$wrapper_class = '';
		if ( 'popup' === staggs_get_post_meta( $theme_id, 'sgg_configurator_view' ) && 'horizontal' === staggs_get_post_meta( $theme_id, 'sgg_configurator_popup_type' ) ) {
			$wrapper_class .= ' swiper swiper-options-nav';
		}

		$is_horizontal_popup = true;
		$description_type    = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_description_type' );

		$sgg_is_admin   = ( is_user_logged_in() && current_user_can('administrator') ) && staggs_get_theme_option( 'sgg_admin_display_edit_links' );
		$steps_nav      = '';
		$step_count     = 0;
		$separator_type = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_separator_function' );
		$indicator      = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_indicator' );
		$density        = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_density' );
		$text_align     = staggs_get_post_meta( $theme_id, 'sgg_configurator_text_align' );
		$hide_inline_label = staggs_get_post_meta( $theme_id, 'sgg_step_hide_nav_step_labels' );

		/**
		 * Main Configurable Product Steps.
		 */
		if ( is_array( $sanitized_steps ) && count( $sanitized_steps ) > 0 ) {
			foreach ( $sanitized_steps as $step_key => $sanitized_step ) {

				if ( 'separator' === $sanitized_step['type'] ) {

					$class = '';
					if ( $step_count > 0 ) {
						echo '</div>';
						echo '</div>';
					}

					$class .= ' collapsible';
					if ( $step_count > 0 ) {
						$class .= ' collapsed';
					}

					$step_count++;

					$steps_nav_item = '<div class="swiper-slide">';
					$steps_nav_item .= '<div class="option-group-step option-group-step-toggler' . $class . '" data-step-group-id="' . $sanitized_step['number'] . '">';
					$steps_nav_item .= '<div class="option-group-step-title">';

					if ( 'one' === $indicator ) {
						if ( $sanitized_step['icon'] ) {
							$steps_nav_item .= '<span class="step-icon">' . wp_get_attachment_image( $sanitized_step['icon'], 'full' ) . '</span>';
						} else {
							$steps_nav_item .= '<span class="step-number">' . $sanitized_step['number'] . '</span>';		
						}
						
						if ( ! $hide_inline_label ) {
							$steps_nav_item .= '<span>' . $sanitized_step['title'] . '</span>';
						}
					} else {
						$steps_nav_item .= '<span>';

						if ( 'two' === $indicator ) {
							if ( $sanitized_step['icon'] ) {
								$steps_nav_item .= '<span class="step-icon">' . wp_get_attachment_image( $sanitized_step['icon'], 'full' ) . '</span>';
							} else {
								$steps_nav_item .= $sanitized_step['number'];
								$steps_nav_item .= apply_filters( 'staggs_step_nav_number_mark', '. ' );
							}
						}

						if ( ! $hide_inline_label ) {
							$steps_nav_item .= $sanitized_step['title'];
						}

						$steps_nav_item .= '</span>';
					}

					$collapse_icon_url = staggs_get_icon( 'sgg_separator_collapse_icon', 'collapse', true );

					$steps_nav_item .= '<img src="' . $collapse_icon_url . '" alt="Arrow">';
					$steps_nav_item .= '</div>';
					$steps_nav_item .= '</div>';
					$steps_nav_item .= '</div>';
					
					$steps_nav .= $steps_nav_item;

					echo '<div class="option-group-step option-group-step-content' . esc_attr( $class ) . '" data-step-group-id="' . esc_attr( $sanitized_step['number'] ) . '">';
					echo '<div class="option-group-step-inner">';

				} else if ( 'tabs' === $sanitized_step['type'] ) {

					include STAGGS_BASE . 'public/templates/shared/tab.php';

				} else if ( isset( $sanitized_step['collapsible'] ) && $sanitized_step['collapsible'] ) {

					$class = ' collapsible';
					if ( $step_key > 0 ) {
						$class .= ' collapsed';
					}

					$steps_nav_item = '<div class="swiper-slide">';
					$steps_nav_item .= '<div class="option-group-step option-group-step-toggler' . $class . '" data-step-group-id="' . $sanitized_step['id'] . '">';
					$steps_nav_item .= '<div class="option-group-step-title">';
					$steps_nav_item .= '<span>' . $sanitized_step['title'] . '</span>';

					$collapse_icon_url = staggs_get_icon( 'sgg_separator_collapse_icon', 'collapse', true );

					$steps_nav_item .= '<img src="' . $collapse_icon_url . '" alt="Arrow">';
					$steps_nav_item .= '</div>';
					$steps_nav_item .= '</div>';
					$steps_nav_item .= '</div>';

					$steps_nav .= $steps_nav_item;

					echo '<div class="option-group-step option-group-step-content' . esc_attr( $class ) . '" data-step-group-id="' . esc_attr( $sanitized_step['id'] ) . '">';
					echo '<div class="option-group-step-inner">';

					if ( $sanitized_step['is_conditional'] && count( $sanitized_step['conditional_rules'] ) > 0 ) {
						echo '<div class="conditional-wrapper" data-step-id="' . esc_attr( $sanitized_step['id'] ) . '" data-step-rules="' . urldecode( str_replace( '"', "'", json_encode( $sanitized_step['conditional_rules'] ) ) ) . '">';
						include STAGGS_BASE . 'public/templates/shared/attribute.php';
						echo '</div>';
					} else {
						include STAGGS_BASE . 'public/templates/shared/attribute.php';
					}

					echo '</div>';
					echo '</div>';

				} else {

					if ( $sanitized_step['is_conditional'] && count( $sanitized_step['conditional_rules'] ) > 0 ) {
						echo '<div class="conditional-wrapper" data-step-id="' . esc_attr( $sanitized_step['id'] ) . '" data-step-rules="' . urldecode( str_replace( '"', "'", json_encode( $sanitized_step['conditional_rules'] ) ) ) . '">';
						include STAGGS_BASE . 'public/templates/shared/attribute.php';
						echo '</div>';
					} else {
						include STAGGS_BASE . 'public/templates/shared/attribute.php';
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

if ( ! function_exists( 'staggs_output_popup_options_bar_nav' ) ) {
	/**
	 * Product configurator options popup nav bar
	 *
	 * @return void
	 */
	function staggs_output_popup_options_bar_nav() {
		global $steps_nav;

		echo '<div class="swiper swiper-options-nav">';
		echo '<div class="swiper-wrapper">';
		echo $steps_nav;
		echo '</div>';
		echo '</div>';
	}
}

if ( ! function_exists( 'staggs_output_configurator_step_progress' ) ) {
	/**
	 * Product configurator step progress
	 *
	 * @return void
	 */
	function staggs_output_configurator_step_progress() {
		global $sanitized_steps;
		// Get fresh items.
		if ( ! is_array( $sanitized_steps ) ) {	
			$sanitized_steps = Staggs_Formatter::get_formatted_step_content( get_the_ID() );
		}

		/**
		 * Main Configurable Product Steps.
		 */
		if ( is_array( $sanitized_steps ) && count( $sanitized_steps ) > 0 ) {
			$theme_id = staggs_get_theme_id();
			$separator_type = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_separator_function' );
			if ( 'stepper' !== $separator_type ) {
				return;
			}

			$has_steps = false;
			foreach ( $sanitized_steps as $step_key => $sanitized_step ) {
				if ( 'separator' === $sanitized_step['type'] ) {
					$has_steps = true;
					break;
				}
			}

			if ( ! $has_steps ) {
				return; // No steps found.
			}

			echo '<nav class="staggs-configurator-steps-nav swiper swiper-nav">';

			$indicator = staggs_get_post_meta( $theme_id, 'sgg_configurator_step_indicator' );
			$hide_inline_label = staggs_get_post_meta( $theme_id, 'sgg_step_hide_nav_step_labels' );

			echo '<ul class="swiper-wrapper steps-links steps-links-' . esc_attr( $indicator ) . '">';
			
			$step_count = 0;
			foreach ( $sanitized_steps as $step_key => $sanitized_step ) {
				if ( 'separator' === $sanitized_step['type'] ) {
					$class = 'configurator-step-link active';
					if ( $step_count > 0 ) {
						$class = 'configurator-step-link';
					}

					echo '<li class="swiper-slide"><a href="#0" class="' . esc_attr( $class ) . '" data-step-number="' . esc_attr( $sanitized_step['number'] ) . '">';

					if ( 'one' === $indicator ) {
						if ( $sanitized_step['icon'] ) {
							echo '<span class="step-icon">' . wp_get_attachment_image( $sanitized_step['icon'], 'full' ) . '</span>';
						} else {
							echo '<span class="step-number">' . esc_attr( $sanitized_step['number'] ) . '</span>';
						}
						
						if ( ! $hide_inline_label ) {
							echo '<span>' . esc_attr( $sanitized_step['title'] ) . '</span>';
						}
					} else {
						echo '<span class="step-content">';

						if ( 'two' === $indicator ) {
							if ( $sanitized_step['icon'] ) {
								echo '<span class="step-icon">' . wp_get_attachment_image( $sanitized_step['icon'], 'full' ) . '</span>';
							} else {
								echo esc_attr( $sanitized_step['number'] );
								echo esc_attr( apply_filters( 'staggs_step_nav_number_mark', '. ' ) );
							}
						}

						if ( ! $hide_inline_label ) {
							echo '<span>' . esc_attr( $sanitized_step['title'] ) . '</span>';
						}

						echo '</span>';
					}

					echo '</a></li>';

					$step_count++;
				}
			}

			echo '</ul>';
			echo '</nav>';
		}
	}
}

if ( ! function_exists( 'staggs_output_steps_navigation_buttons' ) ) {
	/**
	 * Product configurator steps navigation buttons
	 *
	 * @return void
	 */
	function staggs_output_steps_navigation_buttons() {
		global $step_count;

		$theme_id = staggs_get_theme_id();
		$view_layout = staggs_get_configurator_view_layout( $theme_id );
		$separator_type = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_separator_function' ) );

		if ( $step_count > 0 && 'stepper' === $separator_type ) {
			$prev_text = __( 'Previous', 'staggs' );
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_prev_text' ) ) {
				$prev_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_prev_text' ) );
			}

			$next_text = __( 'Next', 'staggs' );
			if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_next_text' ) ) {
				$next_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_configurator_step_next_text' ) );
			}

			$prev_button = apply_filters( 'staggs_previous_step_button_html', '<a href="#0" class="button button-prev staggs-step-prev-button">' . $prev_text . '</a>' );
			$next_button = apply_filters( 'staggs_next_step_button_html', '<a href="#0" class="button button-next staggs-step-next-button">' . $next_text . '</a>' );

			echo '<div class="option-group-step-buttons">';
			echo wp_kses_post( $prev_button );
			echo wp_kses_post( $next_button );
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'staggs_output_product_secondary_buttons' ) ) {
	/**
	 * Product configurator options save buttons.
	 *
	 * @return void
	 */
	function staggs_output_product_secondary_buttons() {

		/**
		 * Display other relevant buttons if enabled.
		 */

		$invoice_link = false;
		$save_link    = false;
		$theme_id     = staggs_get_theme_id();

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_request_invoice_button' ) && ! staggs_get_post_meta( $theme_id, 'sgg_gallery_pdf_display' ) ) {
			$invoice_link = true;
		}
		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_save_button' ) && ! staggs_get_post_meta( $theme_id, 'sgg_gallery_share_display' ) ) {
			$save_link = true;
		}

		if ( ! $invoice_link && ! $save_link ) {
			return; // No links.
		}

		$class = ( $invoice_link && $save_link ) ? 'buttons' : 'button';

		// Start output
		echo '<div class="staggs-secondary-button-wrapper secondary-' . esc_attr( $class ) . '">';

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_request_invoice_button' ) && ! staggs_get_post_meta( $theme_id, 'sgg_gallery_pdf_display' ) ) {
			// Display request invoice as main button for cart button is disabled.
			$invoice_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_request_invoice_text' ) );
			if ( '' === $invoice_text ) {
				$invoice_text = __( 'Download to PDF', 'staggs' );
			}

			echo '<form action="' . esc_url( get_permalink( get_the_ID() ) ) . '?generate_pdf=' . esc_attr( get_the_ID() ) . '" id="request-invoice" method="post" class="product-action action-request-invoice">';
			echo '<input type="hidden" name="generate_pdf" value="' . esc_attr( get_the_ID() ) . '"/><button data-product="' . esc_attr( get_the_ID() ) . '" id="download_pdf"><span class="pdf-icon">';
			echo wp_kses( staggs_get_icon( 'sgg_group_pdf_icon', 'invoice' ), staggs_get_icon_kses_args() );
			echo '</span><span class="button-label">' . esc_attr( $invoice_text ) . '</span></button></form>';
		}

		if ( staggs_get_post_meta( $theme_id, 'sgg_configurator_save_button' ) && ! staggs_get_post_meta( $theme_id, 'sgg_gallery_share_display' ) ) {
			// Display request invoice as main button for cart button is disabled.
			$save_text = sanitize_text_field( staggs_get_post_meta( $theme_id, 'sgg_step_save_button_text' ) );
			if ( '' === $save_text ) {
				$save_text = __( 'Get configuration link', 'staggs' );
			}

			echo '<form action="" id="save-configuration" method="get" class="product-action action-save-configuration"><button><span class="save-icon">';
			echo wp_kses( staggs_get_icon( 'sgg_group_save_icon', 'save' ), staggs_get_icon_kses_args() );
			echo '</span><span class="button-label">' . esc_attr( $save_text ) . '</span></button></form>';
		}

		echo '</div>';
	}
}
