<?php

/**
 * The main hooks of this PRO plugin.
 *
 * @link       https://staggs.app
 * @since      1.3.5
 *
 * @package    Staggs
 * @subpackage Staggs/includes
 */


/**
 * Configurator Single Product Page Gallery
 */

add_action( 'staggs_model_viewer_contents', 'staggs_output_model_ar_button', 10 );
// add_action( 'staggs_model_viewer_contents', 'staggs_output_model_dimensions', 30 );
add_action( 'staggs_after_model_viewer', 'staggs_output_desktop_qr_popup', 10 );

/**
 * Configurator Totals
 */

add_action( 'staggs_single_product_options_totals', 'staggs_output_product_secondary_buttons', 40 );

/**
 * Stepper Template - Topbar
 */

add_action( 'staggs_single_product_topbar', 'staggs_output_topbar_wrapper', 10 );
add_action( 'staggs_single_product_topbar', 'staggs_output_company_logo', 20 );
add_action( 'staggs_single_product_topbar', 'staggs_output_configurator_step_progress', 30 );
add_action( 'staggs_single_product_topbar', 'staggs_output_topbar_buttons', 40 );
add_action( 'staggs_single_product_topbar', 'staggs_output_topbar_wrapper_close', 50 );

add_action( 'staggs_topbar_buttons', 'staggs_output_product_secondary_buttons', 30 );

/**
 * Stepper Template - Bottom bar
 */

add_action( 'staggs_single_product_bottom_bar', 'staggs_output_bottom_bar_wrapper', 10 );
add_action( 'staggs_single_product_bottom_bar', 'staggs_output_steps_navigation_buttons', 20 );
add_action( 'staggs_single_product_bottom_bar', 'staggs_output_bottom_bar_totals', 30 );
add_action( 'staggs_single_product_bottom_bar', 'staggs_output_bottom_bar_wrapper_close', 40 );

add_action( 'staggs_before_bottom_bar_totals', 'staggs_output_product_totals_list', 10 );
add_action( 'staggs_before_bottom_bar_totals', 'staggs_output_steps_navigation_buttons', 20 );

add_action( 'staggs_bottom_bar_totals', 'staggs_output_product_main_button', 20 );

/**
 * Configurator Popup Topbar
 */

add_action( 'staggs_single_product_popup_topbar', 'staggs_output_configurator_step_progress', 30 );
add_action( 'staggs_single_product_popup_topbar', 'staggs_output_topbar_buttons', 40 );
