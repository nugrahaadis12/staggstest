<?php

/**
 * Provide a admin-facing view for the Staggs Theme form of the plugin
 *
 * This file is used to markup the admin-facing theme form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.4.4
 *
 * @package    Staggs
 * @subpackage Staggs/admin/fields
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$usp_labels = array(
	'plural_name' => __( 'USPs', 'staggs' ),
	'singular_name' => __( 'USP', 'staggs' ),
);
$hotspot_labels = array(
	'plural_name' => __( 'Hotspots', 'staggs' ),
	'singular_name' => __( 'Hotspot', 'staggs' ),
);
$control_labels = array(
	'plural_name' => __( 'Controls', 'staggs' ),
	'singular_name' => __( 'Control', 'staggs' ),
);

/**
 * Settings meta
 */
Container::make( 'post_meta', __( 'Staggs Configurator Template', 'staggs' ) )
	->where( 'post_type', '=', 'sgg_theme' )
	->set_layout( 'tabbed-vertical' )
	->add_tab( __( 'Template', 'staggs' ), array(
		Field::make( 'separator', 'sgg_appearance_panel_general', __( 'Template', 'staggs' ) ),

		Field::make( 'select', 'sgg_configurator_gallery_type', __( 'Configurator Type', 'staggs' ) )
			->add_options( array(
				'regular' => __( 'Image', 'staggs' ),
				'3dmodel' => __( '3D model', 'staggs' ),
			)),

		Field::make( 'radio', 'sgg_configurator_page_template', __( 'Staggs Configurator template', 'staggs' ) )
			->set_options( array(
				'staggs' => __( 'Staggs Product Configurator Template', 'staggs' ), // Let's go Staggs all the way
				'default' => __( 'WooCommerce Page Template', 'staggs' ), // Replaces Woo gallery and adds attributes to cart form
				'none' => __( 'Attributes Only Template', 'staggs' ), // Only adds attributes to cart form
			))
			->set_help_text( __( 'Set to WooCommerce Page Template to use your theme\'s product page or default WooCommerce Product Page template', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_disable_attribute_styles', __( 'Disable default Staggs configurator styles', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_page_template',
				'value' => 'staggs',
				'compare' => '!=',
			))),

		Field::make( 'radio_image', 'sgg_configurator_view', __( 'Template', 'staggs' ) )
			->add_options( array(
				'classic'  => STAGGS_BASE_URL . 'admin/img/classic.png',
				'floating' => STAGGS_BASE_URL . 'admin/img/floating.png',
				'full'     => STAGGS_BASE_URL . 'admin/img/full.png',
				// 'splitter' => STAGGS_BASE_URL . 'admin/img/splitter.png',
				'steps'    => STAGGS_BASE_URL . 'admin/img/steps.png',
				'popup'    => STAGGS_BASE_URL . 'admin/img/popup.png',
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_page_template',
				'value' => 'staggs',
			))),

		Field::make( 'radio_image', 'sgg_configurator_popup_type', __( 'Popup Template', 'staggs' ) )
			->add_options( array(
				'vertical'   => STAGGS_BASE_URL . 'admin/img/popup-vertical.png',
				'horizontal' => STAGGS_BASE_URL . 'admin/img/popup-horizontal.png',
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
			))),

		Field::make( 'text', 'sgg_step_popup_button_text', __( 'Configurator Popup Button Text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
				'compare' => '=',
			))),
		Field::make( 'checkbox', 'sgg_configurator_popup_mobile_inline', __( 'Show contents of popup inline on mobile', 'staggs' ) )
			->set_help_text( __( 'Disable sticky elements in popup on mobile view (natural scroll)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
				'compare' => '=',
			))),

		Field::make( 'checkbox', 'sgg_step_set_included_option_text', __( 'Set Included Option Label', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_included_text', __( 'Included Option Text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_set_included_option_text',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_step_disable_default_option', __( 'Disable default option selection on load', 'staggs' ) )
			->set_help_text( __( 'Disables the automatic selection of the first available option on configurator load', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_theme_disable_cart_styles', __( 'Disable add to cart button styles', 'staggs' ) )
			->set_help_text( __( 'This setting overrides the default Staggs template styles for add to cart button.', 'staggs' ) ),

	))
	->add_tab( __( 'Template options', 'staggs' ), array(
		
		Field::make( 'separator', 'sgg_settings_panel_general', __( 'Template options', 'staggs' ) ),

		Field::make( 'radio', 'sgg_show_theme_header_footer', __( 'Header and Footer display', 'staggs' ) )
			->set_options( array(
				'none' => __( 'Hide header and footer', 'staggs' ),
				'both' => __( 'Show header and footer', 'staggs' ),
				'header' => __( 'Show header only', 'staggs' ),
				'footer' => __( 'Show footer only', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'floating', 'full' ),
				'compare' => 'IN',
			))),

		Field::make( 'radio', 'sgg_configurator_layout', __( 'Layout', 'staggs' ) )
			->add_options( array(
				'right' => __( 'Image Preview Right', 'staggs' ),
				'left' => __( 'Image Preview Left', 'staggs' ),
			))
			->set_width( 50 ),
		Field::make( 'radio', 'sgg_configurator_text_align', __( 'Text Align', 'staggs' ) )
			->add_options( array(
				'center' => __( 'Center', 'staggs' ),
				'left' => __( 'Left', 'staggs' ),
			))
			->set_width( 50 ),
		Field::make( 'radio', 'sgg_configurator_borders', __( 'Borders', 'staggs' ) )
			->add_options( array(
				'rounded' => __( 'Rounded', 'staggs' ),
				'squared' => __( 'Squared', 'staggs' ),
				'pill' => __( 'Circular', 'staggs' ),
			))
			->set_width( 50 ),
		Field::make( 'radio', 'sgg_configurator_step_description_type', __( 'Description type', 'staggs' ) )
			->add_options( array(
				'panel' => __( 'Panel', 'staggs' ),
				'popup' => __( 'Popup', 'staggs' ),
				'tooltip' => __( 'Tooltip', 'staggs' ),
			))
			->set_width( 50 ),

		Field::make( 'checkbox', 'sgg_show_logo', __( 'Show company logo', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_show_logo_options', __( 'Show company logo in options panel', 'staggs' ) )
			->set_help_text( __( 'Displays the company logo above the title.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_show_logo',
				'value' => true,
			), array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'classic', 'floating', 'full' ),
				'compare' => 'IN',
			))),

		Field::make( 'checkbox', 'sgg_configurator_disable_floating_notice', __( 'Disable Staggs floating add to cart notices', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_title', __( 'Disable WooCommerce Product Title', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_description', __( 'Disable WooCommerce Short Description', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_price', __( 'Disable WooCommerce Product Price', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_price_update', __( 'Disable updating the single WooCommerce Product Price', 'staggs' ) )
			->set_help_text( __( 'Updates the default WooCommerce Single Product price to match the total configuration price by default.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_disable_product_price',
				'value' => false,
			) ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_meta', __( 'Disable WooCommerce Product Meta (SKU, Category)', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_weight', __( 'Disable configurator product weight display', 'staggs' ) )
			->set_help_text( __( 'Only applicable when you have enabled Product weight in Staggs Settings.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_tabs_override', __( 'Disable Staggs WooCommerce Product Tabs override', 'staggs' ) )
			->set_help_text( __( 'Enable this option if you do not want the tabs to be relocated.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_product_tabs', __( 'Disable WooCommerce Product Tabs', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_disable_template_override', __( 'Disable WooCommerce Template Override', 'staggs' ) )
			->set_help_text( __( 'Only applicable when you want to output the configurator contents using shortcode(s).', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_show_close_button', __( 'Show close button', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
				'compare' => '!=',
			))),
		Field::make( 'text', 'sgg_back_page_url', __( 'Back page URL', 'staggs' ) )
			->set_help_text( __( 'Configure logo / back button URL. Defaults to home URL.', 'staggs' ) )
			->set_conditional_logic( array(
				'relation' => 'OR',
				 array(
					'field' => 'sgg_show_logo',
					'value' => true,
				),
				array(
				   'field' => 'sgg_show_logo_options',
				   'value' => true,
			   ),
				array(
				   'field' => 'sgg_show_close_button',
				   'value' => true,
			   ),
			)),
		Field::make( 'checkbox', 'sgg_show_close_button_message', __( 'Show close button confirm message', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_show_close_button',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_close_button_message', __( 'Close button confirm message', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_show_close_button_message',
				'value' => true,
			))),

	))
	->add_tab( __( 'Gallery', 'staggs' ), array(
		Field::make( 'separator', 'sgg_appearance_product_display', __( 'Gallery', 'staggs' ) ),

		Field::make( 'radio', 'sgg_configurator_template_height', __( 'Template height', 'staggs' ) )
			->add_options( array(
				'full_height' => __( 'Force full height of screen on desktop', 'staggs' ),
				'image_height' => __( 'Use image height as reference for configurator height', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			))),

		Field::make( 'checkbox', 'sgg_gallery_scale_mobile_display', __( 'Block mobile gallery image overflow', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_configurator_gallery_sticky', __( 'Make Gallery Image Sticky', 'staggs' ) )
			->set_help_text( __( 'Keep image preview in view when scrolling down the options list', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'classic',
			))),

		Field::make( 'radio', 'sgg_mobile_gallery_display', __( 'Gallery Display on Mobile Devices', 'staggs' ) )
			->add_options( array(
				'fixed' => __( 'Fixed', 'staggs' ),
				'inline' => __( 'Inline', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
				'compare' => '!=',
			))),

		Field::make( 'text', 'sgg_configurator_fixed_header_height', __( 'Fixed mobile header offset', 'staggs' ) )
			->set_help_text( __( 'Enter offset of mobile header in pixels. (Enter numeric value)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_mobile_gallery_display',
				'value' => 'fixed',
			), array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
				'compare' => '!=',
			))),

		Field::make( 'radio', 'sgg_preview_image_type', __( 'Preview Type', 'staggs' ) )
			->add_options( array(
				'stacked' => __( 'Stacked Image Preview', 'staggs' ),
				'single' => __( 'Single Image Preview', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			))),

		Field::make( 'checkbox', 'sgg_use_product_image', __( 'Display product featured image', 'staggs' ) )
			->set_help_text( __( 'Use the product featured image as the base layer for the preview.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			), array(
				'field' => 'sgg_preview_image_type',
				'value' => 'stacked',
			))),

		Field::make( 'checkbox', 'sgg_configurator_generate_cart_image', __( 'Generate Active Configuration Image for Cart', 'staggs' ) )
			->set_help_text( __( 'Product featured image will be shown by default.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_store_cart_image', __( 'Store Configuration Previews in Uploads Folder for Later Access', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_generate_cart_image',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_configurator_generate_pdf_images', __( 'Generate Multiple Views For PDF', 'staggs' ) )
			->set_help_text( __( 'Include all image views in the PDF.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			))),
		Field::make( 'checkbox', 'sgg_configurator_model_disable_slider', __( 'Disable 3D model gallery slides', 'staggs' ) )
			->set_help_text( __( 'Disable product gallery slider when multiple gallery images are present.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),

		Field::make( 'checkbox', 'sgg_configurator_initial_view', __( 'Customize initial viewpoint', 'staggs' ) )
			->set_help_text( __( 'Modify the initial viewpoint of the 3D object.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_initial_pos_x', __( 'Initial horizontal camera position', 'staggs' ) )
			->set_help_text( __( 'Modify the horizontal position (yaw value) of the 3D object (e.g. 20deg)', 'staggs' ) )
			->set_required(true)
			->set_width( 25 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_view',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_initial_pos_y', __( 'Initial vertical camera position', 'staggs' ) )
			->set_help_text( __( 'Modify the vertical position (pitch value) of the 3D object (e.g. 120deg)', 'staggs' ) )
			->set_required(true)
			->set_width( 25 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_view',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_initial_zoom', __( 'Initial model zoom', 'staggs' ) )
			->set_help_text( __( 'Modify the initial zoom value of the 3D object (e.g. 3m)', 'staggs' ) )
			->set_required(true)
			->set_width( 25 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_view',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_initial_fov', __( 'Initial model view', 'staggs' ) )
			->set_help_text( __( 'Modify the initial field of view value of the 3D object (e.g. 12deg)', 'staggs' ) )
			->set_required(true)
			->set_width( 25 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_view',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_initial_target', __( 'Customize initial camera target', 'staggs' ) )
			->set_help_text( __( 'Modify the initial target of the 3D viewer camera. Fill out all 3 fields.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_target_x', __( 'Initial horizontal camera target', 'staggs' ) )
			->set_help_text( __( 'Modify the horizontal target of the 3D object (e.g. 1m)', 'staggs' ) )
			->set_width( 33 )
			->set_required(true)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_target',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_target_y', __( 'Initial vertical camera target', 'staggs' ) )
			->set_help_text( __( 'Modify the vertical target of the 3D object (e.g. 1m)', 'staggs' ) )
			->set_width( 33 )
			->set_required(true)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_target',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_target_z', __( 'Initial vertical camera zoom', 'staggs' ) )
			->set_help_text( __( 'Modify the zoom target of the 3D object (e.g. 1m)', 'staggs' ) )
			->set_width( 33 )
			->set_required(true)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_initial_target',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_custom_shadow', __( 'Customize model shadow', 'staggs' ) )
			->set_help_text( __( 'Modify the shadow view of the 3D object', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_shadow_intensity', __( 'Shadow intensity', 'staggs' ) )
			->set_help_text( __( 'Modify the shadow intensity of the 3D object. Enter decimal value between 0 and 2.00', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_custom_shadow',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_shadow_softness', __( 'Shadow softness', 'staggs' ) )
			->set_help_text( __( 'Modify the shadow softness of the 3D object. Enter decimal value between 0 and 1.00', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_custom_shadow',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_custom_view_limits', __( 'Customize model viewer limits', 'staggs' ) )
			->set_help_text( __( 'Apply camera viewer limits for the 3D object viewer', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_counter_clockwise_limit', __( 'Counter-clockwise limit', 'staggs' ) )
			->set_help_text( __( 'Limit the camera rotation. Enter numeric value between -180 and 180', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_custom_view_limits',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_clockwise_limit', __( 'Clockwise limit', 'staggs' ) )
			->set_help_text( __( 'Limit the camera rotation. Enter numeric value between -180 and 180', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_custom_view_limits',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_topdown_limit', __( 'Top-down limit', 'staggs' ) )
			->set_help_text( __( 'Limit the camera rotation. Enter numeric value between 0 and 180', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_custom_view_limits',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_bottomup_limit', __( 'Bottom-up limit', 'staggs' ) )
			->set_help_text( __( 'Limit the camera rotation. Enter numeric value between 0 and 180', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_custom_view_limits',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_auto_rotation', __( 'Auto-rotate model', 'staggs' ) )
			->set_width( 50 )
			->set_help_text( __( 'Automatically rotates the 3D model when idle.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'checkbox', 'sgg_configurator_interaction_prompt', __( 'Show interaction prompt', 'staggs' ) )
			->set_width( 50 )
			->set_help_text( __( 'Shows indicator to rotate the model when idle.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_auto_rotation_delay', __( 'Auto rotation delay', 'staggs' ) )
			->set_help_text( __( 'Optionally enter delay for auto rotation in milliseconds', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_auto_rotation',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_auto_rotation_speed', __( 'Auto rotation speed', 'staggs' ) )
			->set_help_text( __( 'Use negative value to reverse auto rotate direction. Works with degrees, radians and percentage.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_auto_rotation',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_disable_zoom', __( 'Disable model zoom', 'staggs' ) )
			->set_help_text( __( 'Disables ability to zoom in on model.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),

		Field::make( 'text', 'sgg_configurator_min_zoom', __( 'Minimum model zoom', 'staggs' ) )
			->set_help_text( __( 'Limit the minimum zoom level on the model. Enter full value including unit.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_disable_zoom',
				'value' => false,
			))),
		Field::make( 'text', 'sgg_configurator_camera_touch_action', __( 'Mobile touch action', 'staggs' ) )
			->set_help_text( __( 'Optionally change mobile touch action behaviour', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'pan-y', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_disable_zoom',
				'value' => false,
			))),

		Field::make( 'checkbox', 'sgg_configurator_display_ar_button', __( 'Display view in AR button', 'staggs' ) )
			->set_help_text( __( 'Displays a view in AR button for compatible devices.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_ar_button_text', __( 'Mobile AR button text', 'staggs' ) )
			->set_help_text( __( 'Optionally override the default mobile AR button text.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_display_ar_button',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_configurator_disable_ar_zoom', __( 'Disable AR model zoom', 'staggs' ) )
			->set_help_text( __( 'Disable AR scale feature. AR model is shown in original size.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_display_ar_button',
				'value' => true,
			))),
		Field::make( 'radio', 'sgg_configurator_model_placement', __( 'AR Model placement', 'staggs' ) )
			->set_help_text( __( 'Choose your AR model placement.', 'staggs' ) )
			->set_width( 50 )
			->add_options( array(
				'floor' => __( 'Floor', 'staggs' ),
				'wall' => __( 'Wall', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_display_ar_button',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_configurator_display_desktop_ar_button', __( 'Display AR icon on desktop', 'staggs' ) )
			->set_help_text( __( 'Displays an AR icon on desktop to inform user about AR feature.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_display_ar_button',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_display_desktop_ar_title', __( 'Desktop QR popup title', 'staggs' ) )
			->set_help_text( __( 'Optionally override the default QR popup title.', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'QR code', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_display_desktop_ar_button',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_display_desktop_ar_intro', __( 'Desktop QR popup intro', 'staggs' ) )
			->set_help_text( __( 'Optionally override the default QR popup intro.', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Scan the QR code below to view product in your room', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_display_desktop_ar_button',
				'value' => true,
			))),
	))
	->add_tab( __( 'Gallery background', 'staggs' ), array(
		Field::make( 'separator', 'sgg_background_product_display', __( 'Gallery background', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_show_bg_image', __( 'Add Background Image', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_page_template',
				'value' => 'staggs',
			), array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			))),
			
		Field::make( 'media_gallery', 'sgg_bg_image', __( 'Background Image', 'staggs' ) )
			->set_duplicates_allowed( false )
			->set_type( array( 'image' ) )
			->set_help_text( __( 'Select one or more background images. Note: please keep image sizes lower than 2 MB to maintain the configurator performance.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_page_template',
				'value' => 'staggs',
			), array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			), array(
				'field' => 'sgg_show_bg_image',
				'value' => true,
			))),

		Field::make( 'radio', 'sgg_bg_image_size', __( 'Background Image Size', 'staggs' ) )
			->add_options( array(
				'contain' => __( 'Contain', 'staggs' ),
				'cover' => __( 'Cover', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			))),

		Field::make( 'checkbox', 'sgg_stretch_bg_image', __( 'Stretch Background Image Behind Options', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'floating',
			), array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			), array(
				'field' => 'sgg_show_bg_image',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_capture_bg_image', __( 'Capture Background Image In Export', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_page_template',
				'value' => 'staggs',
			), array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			), array(
				'field' => 'sgg_show_bg_image',
				'value' => true,
			))),

		Field::make( 'text', 'sgg_model_env_image', __( 'Environment Image', 'staggs' ) )
			->set_help_text( __( 'Link an HDR image to apply lightning to the model.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'checkbox', 'sgg_show_model_env_image', __( 'Display environment background image', 'staggs' ) )
			->set_help_text( __( 'Display the linked HDR image as the background image.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_env_image_exposure', __( 'Environment image exposure', 'staggs' ) )
			->set_help_text( __( 'Modify the exposure of the environment lightning.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_env_image_height', __( 'Environment image height', 'staggs' ) )
			->set_help_text( __( 'Optionally control the height of the environment image (e.g. 15m)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
	))
	->add_tab( __( 'Gallery controls', 'staggs' ), array(
		Field::make( 'separator', 'sgg_background_controls_display', __( 'Gallery controls', 'staggs' ) ),
		
		Field::make( 'checkbox', 'sgg_gallery_fullscreen_display', __( 'Display button to show gallery fullscreen', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_gallery_camera_display', __( 'Display button to capture configuration image', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_gallery_wishlist_display', __( 'Display button to add configuration to wishlist', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_gallery_pdf_display', __( 'Display button to download PDF button', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_gallery_share_display', __( 'Display button to share configuration link', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_gallery_reset_display', __( 'Display button to reset configuration', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_gallery_info_display', __( 'Display button to show viewer information', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_viewer_info_title', __( 'Viewer instructions title', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_gallery_info_display',
				'value' => true,
			))),
		Field::make( 'rich_text', 'sgg_configurator_viewer_info_text', __( 'Viewer instructions text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_gallery_info_display',
				'value' => true,
			))),

		Field::make( 'radio', 'sgg_configurator_thumbnails', __( 'Gallery Nav Type', 'staggs' ) )
			->add_options( array(
				'none' => __( 'None', 'staggs' ),
				'thumbnails' => __( 'Thumbnails', 'staggs' ),
				'labels' => __( 'Labels', 'staggs' ),
			))
			->set_width( 50 ),
		Field::make( 'radio', 'sgg_configurator_thumbnails_align', __( 'Gallery Thumbnails Align', 'staggs' ) )
			->add_options( array(
				'left' => __( 'Left', 'staggs' ),
				'center' => __( 'Center', 'staggs' ),
				'right' => __( 'Right', 'staggs' ),
			))
			->set_width( 50 ),
		Field::make( 'radio', 'sgg_configurator_thumbnails_position', __( 'Gallery Thumbnails Position', 'staggs' ) )
			->add_options( array(
				'inside' => __( 'Inside main image', 'staggs' ),
				'under' => __( 'Underneath main image', 'staggs' ),
			))
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'classic',
			), array(
				'field' => 'sgg_configurator_thumbnails',
				'value' => 'thumbnails',
			))),
		Field::make( 'radio', 'sgg_configurator_thumbnails_layout', __( 'Gallery Thumbnails Layout', 'staggs' ) )
			->add_options( array(
				'inline' => __( 'Single row of images', 'staggs' ),
				'grid' => __( 'Image grid', 'staggs' ),
			))
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'classic',
			), array(
				'field' => 'sgg_configurator_thumbnails',
				'value' => 'thumbnails',
			), array(
				'field' => 'sgg_configurator_thumbnails_position',
				'value' => 'under',
			))),

		Field::make( 'text', 'sgg_configurator_thumbnail_labels', __( 'Gallery Thumbnail Labels', 'staggs' ) )
			->set_help_text( 'Enter labels in comma-separated format for the image views (e.g. front, back, inside, top)')
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => 'regular',
			), array(
				'field' => 'sgg_configurator_thumbnails',
				'value' => 'labels',
			))),
		Field::make( 'radio_image', 'sgg_configurator_arrows', __( 'Preview arrow controls', 'staggs' ) )
			->add_options( array(
				'none' => STAGGS_BASE_URL . 'admin/img/boxed.png',
				'bottom_right' => STAGGS_BASE_URL . 'admin/img/arrow-bottom-right.png',
				'bottom_left' => STAGGS_BASE_URL . 'admin/img/arrow-bottom-left.png',
				'center' => STAGGS_BASE_URL . 'admin/img/arrow-center.png',
			)),
		Field::make( 'complex', 'sgg_configurator_model_controls', __( '3D viewer controls', 'staggs' ) )
			->setup_labels( $control_labels )
			->add_fields( 'options', array(
				Field::make( 'text', 'sgg_control_label', __( 'Label', 'staggs' ) )
					->set_help_text( __( 'Shows when Gallery Nav Type is set to label', 'staggs' ) )
					->set_width( 33 )
					->set_conditional_logic( array( array(
						'field' => 'parent.sgg_configurator_thumbnails',
						'value' => 'labels',
					))),
				Field::make( 'image', 'sgg_control_thumbnail', __( 'Thumbnail', 'staggs' ) )
					->set_help_text( __( 'Shows when Gallery Nav Type is set to thumbnail', 'staggs' ) )
					->set_width( 33 )
					->set_conditional_logic( array( array(
						'field' => 'parent.sgg_configurator_thumbnails',
						'value' => 'thumbnails',
					))),
				Field::make( 'text', 'sgg_control_background', __( 'Environment Image URL', 'staggs' ) )
					->set_width( 33 ),
				Field::make( 'text', 'sgg_control_exposure', __( 'Environment Image Exposure', 'staggs' ) )
					->set_width( 33 ),
				Field::make( 'text', 'sgg_control_target', __( 'Camera target', 'staggs' ) )
					->set_width( 33 ),
				Field::make( 'text', 'sgg_control_orbit', __( 'Camera orbit', 'staggs' ) )
					->set_width( 33 ),
				Field::make( 'text', 'sgg_control_fov', __( 'Camera field of view', 'staggs' ) )
					->set_width( 33 ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_configurator_thumbnails',
				'value' => 'none',
				'compare' => '!=',
			))),
	))
	->add_tab( __( 'Colors', 'staggs' ), array(

		Field::make( 'separator', 'sgg_theme_panel_general', __( 'Colors', 'staggs' ) ),

		Field::make( 'radio_image', 'sgg_configurator_theme', __( 'Color theme', 'staggs' ) )
			->add_options( array(
				'light' => STAGGS_BASE_URL . 'admin/img/light.png',
				'dark' => STAGGS_BASE_URL . 'admin/img/dark.png',
				'custom' => STAGGS_BASE_URL . 'admin/img/custom.png',
			)),

		Field::make( 'color', 'sgg_accent_color', __( 'Accent Color', 'staggs' ) )
			->set_help_text( __( 'General accent color for configurator elements', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'color', 'sgg_accent_hover_color', __( 'Accent Hover Color', 'staggs' ) )
			->set_help_text( __( 'General hover color for configurator elements', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'color', 'sgg_button_text_color', __( 'Button Text Color', 'staggs' ) )
			->set_help_text( __( 'General text color for configurator buttons to complement the accent color', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'color', 'sgg_button_hover_text_color', __( 'Button Hover Text Color', 'staggs' ) )
			->set_help_text( __( 'General text hover color for configurator buttons to complement the accent color', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'radio', 'sgg_configurator_icon_theme', __( 'Icon Theme', 'staggs' ) )
			->add_options( array(
				'light' => __( 'Light Icons', 'staggs' ),
				'dark' => __( 'Dark Icons', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
			
		Field::make( 'color', 'sgg_primary_color', __( 'Primary Color', 'staggs' ) )
			->set_help_text( __( 'Options panel background color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_secondary_color', __( 'Secondary Color', 'staggs' ) )
			->set_help_text( __( 'Image view background color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_heading_color', __( 'Heading Color', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_text_color', __( 'Text Color', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_tertiary_color', __( 'Options Background', 'staggs' ) )
			->set_help_text( __( 'Options background color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_tertiary_hover_color', __( 'Options Hover Background', 'staggs' ) )
			->set_help_text( __( 'Options background hover color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_tertiary_border_color', __( 'Options Border Color', 'staggs' ) )
			->set_help_text( __( 'Options border color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_tertiary_text_color', __( 'Options Text Color', 'staggs' ) )
			->set_help_text( __( 'Options text color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_tertiary_active_color', __( 'Options Selected Background', 'staggs' ) )
			->set_help_text( __( 'Selected options background color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_tertiary_active_text_color', __( 'Options Selected Text Color', 'staggs' ) )
			->set_help_text( __( 'Selected options text color', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_input_bg_color', __( 'Input Background', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_input_border_color', __( 'Input Border', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_input_active_bg_color', __( 'Input Active Background', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),
		Field::make( 'color', 'sgg_input_active_border_color', __( 'Input Active Border', 'staggs' ) )
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_theme',
				'value' => 'custom',
			))),

	))
	->add_tab( __( 'Spacing', 'staggs' ), array(

		Field::make( 'separator', 'sgg_template_product_spacing', __( 'Spacing', 'staggs' ) ),

		Field::make( 'radio', 'sgg_configurator_step_density', __( 'Step Density', 'staggs' ) )
			->add_options( array(
				'default' => __( 'Default', 'staggs' ),
				'compact' => __( 'Compact', 'staggs' ),
			)),

		Field::make( 'text', 'sgg_template_form_options_width', __( 'Configurator form width', 'staggs' ) )
			->set_help_text( __( 'Optionally override default form options width. Enter CSS units. Defaults to 540px', 'staggs' ) )
			->set_width(50),
		Field::make( 'text', 'sgg_template_form_options_width_tablet', __( 'Configurator form width (tablet)', 'staggs' ) )
			->set_help_text( __( 'Optionally override default form options width for tablets. Enter CSS units. Defaults to 400px', 'staggs' ) )
			->set_width(50),

		Field::make( 'text', 'sgg_template_form_options_padding', __( 'Configurator form spacing', 'staggs' ) )
			->set_help_text( __( 'Optionally override default form options spacing. Enter CSS units. Defaults to 50px', 'staggs' ) )
			->set_width(50),
		Field::make( 'text', 'sgg_template_form_options_padding_tablet', __( 'Configurator form spacing (tablet)', 'staggs' ) )
			->set_help_text( __( 'Optionally override default form options width for tablets. Enter CSS units. Defaults to 40px', 'staggs' ) )
			->set_width(50),

		Field::make( 'text', 'sgg_attribute_spacing_top', __( 'Attribute spacing top', 'staggs' ) )
			->set_help_text( __( 'Optionally override default attribute spacing top. Enter CSS units', 'staggs' ) )
			->set_width(50),
		Field::make( 'text', 'sgg_attribute_spacing_top_mobile', __( 'Attribute spacing top (mobile)', 'staggs' ) )
			->set_help_text( __( 'Optionally override default attribute spacing top for mobile. Enter CSS units', 'staggs' ) )
			->set_width(50),
		Field::make( 'text', 'sgg_attribute_spacing_bottom', __( 'Attribute spacing bottom', 'staggs' ) )
			->set_help_text( __( 'Optionally override default attribute spacing bottom. Enter CSS units', 'staggs' ) )
			->set_width(50),
		Field::make( 'text', 'sgg_attribute_spacing_bottom_mobile', __( 'Attribute spacing bottom (mobile)', 'staggs' ) )
			->set_help_text( __( 'Optionally override default attribute spacing bottom for mobile. Enter CSS units', 'staggs' ) )
			->set_width(50),

		Field::make( 'text', 'sgg_template_form_panel_width', __( 'Configurator panel width', 'staggs' ) )
			->set_help_text( __( 'Optionally override default configurator panel width. Enter CSS units', 'staggs' ) )
			->set_width(50),
		Field::make( 'text', 'sgg_template_form_panel_width_tablet', __( 'Configurator panel width (tablet)', 'staggs' ) )
			->set_help_text( __( 'Optionally override default configurator panel width for tablet. Enter CSS units', 'staggs' ) )
			->set_width(50),

	))
	->add_tab( __( 'Fonts', 'staggs' ), array(

		Field::make( 'separator', 'sgg_configurator_template_fonts', __( 'Fonts', 'staggs' ) ),

		Field::make( 'text', 'sgg_font_family', __( 'Font Family', 'staggs' ) )
			->set_help_text( __( 'If you need a custom font, you should enter the font family name here (e.g. Helvetica).', 'staggs' ) )
			->set_width(33),
		Field::make( 'text', 'sgg_font_weight', __( 'Font Weight', 'staggs' ) )
			->set_help_text( __( 'Enter the font weight in CSS units (e.g. 700 or bold).', 'staggs' ) )
			->set_width(33),
		Field::make( 'select', 'sgg_font_style', __( 'Font Style', 'staggs' ) )
			->set_options( array(
				'normal' => 'Normal',
				'italic' => 'Italic',
			))
			->set_help_text( __( 'Select the font style here.', 'staggs' ) )
			->set_width(33),

		Field::make( 'checkbox', 'sgg_configurator_custom_font', __( 'Change fonts for heading and buttons', 'staggs' ) )
			->set_help_text( __( 'This setting enables you to define custom fonts for the buttons and headings.', 'staggs' ) ),

		Field::make( 'text', 'sgg_heading_font_family', __( 'Heading Font Family', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_heading_font_weight', __( 'Heading Font Weight', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font',
				'value' => true,
			))),
		Field::make( 'select', 'sgg_heading_font_style', __( 'Heading Font Style', 'staggs' ) )
			->set_options( array(
				'normal' => 'Normal',
				'italic' => 'Italic',
			))
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font',
				'value' => true,
			))),

		Field::make( 'text', 'sgg_button_font_family', __( 'Button Font Family', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_button_font_weight', __( 'Button Font Weight', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font',
				'value' => true,
			))),
		Field::make( 'select', 'sgg_button_font_style', __( 'Button Font Style', 'staggs' ) )
			->set_options( array(
				'normal' => 'Normal',
				'italic' => 'Italic',
			))
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font',
				'value' => true,
			))),

		Field::make( 'textarea', 'sgg_header_scripts', __( 'Font Scripts', 'staggs' ) )
			->set_help_text( __( 'If you need to add scripts to your header (like Google Font scripts), you should enter them here.', 'staggs' ) ),

		Field::make( 'separator', 'sgg_configurator_template_font_sizes', __( 'Font sizes', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_configurator_custom_font_sizes', __( 'Specify template font sizes', 'staggs' ) )
			->set_help_text( __( 'This setting enables you to define custom font sizes for the text, buttons and headings.', 'staggs' ) ),

		Field::make( 'text', 'sgg_font_size', __( 'Base Font Size', 'staggs' ) )
			->set_help_text( __( 'Define base font size for desktop (enter CSS units)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_font_size_tb', __( 'Base Font Size (Tablet)', 'staggs' ) )
			->set_help_text( __( 'For tablet devices (enter CSS units)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_font_size_mb', __( 'Base Font Size (Mobile)', 'staggs' ) )
			->set_help_text( __( 'And mobile devices (enter CSS units)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),

		Field::make( 'text', 'sgg_heading_font_size', __( 'Heading Font Size', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_heading_font_size_tb', __( 'Heading Font Size (Tablet)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_heading_font_size_mb', __( 'Heading Font Size (Mobile)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),

		Field::make( 'text', 'sgg_button_font_size', __( 'Button Font Size', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_button_font_size_tb', __( 'Button Font Size (Tablet)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_button_font_size_mb', __( 'Button Font Size (Mobile)', 'staggs' ) )
			->set_width(33)
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_custom_font_sizes',
				'value' => true,
			))),
	))
	->add_tab( __( 'Separator', 'staggs' ), array(

		Field::make( 'separator', 'sgg_settings_panel_general_options', __( 'Separator', 'staggs' ) ),

		Field::make( 'radio_image', 'sgg_configurator_step_indicator', __( 'Separator Template', 'staggs' ) )
			->add_options( array(
				'one'   => STAGGS_BASE_URL . 'admin/img/indicator-one.png',
				'two'   => STAGGS_BASE_URL . 'admin/img/indicator-two.png',
				'three' => STAGGS_BASE_URL . 'admin/img/indicator-three.png',
			)),

		Field::make( 'radio', 'sgg_configurator_step_separator_function', __( 'Separator Function', 'staggs' ) )
			->set_options( array(
				'none' => __( 'Do nothing', 'staggs' ),
				'stepper' => __( 'Create stepper', 'staggs' ),
			)),

		Field::make( 'checkbox', 'sgg_configurator_step_separator_nav', __( 'Show Steps Navigation', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			))),
		Field::make( 'text', 'sgg_configurator_step_prev_text', __( 'Step previous button text', 'staggs' ) )
			->set_help_text( __( 'Optionally override the step navigation previous button text. Defaults to "Previous".', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array(array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			), array(
				'field' => 'sgg_configurator_step_separator_nav',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_step_next_text', __( 'Step next button text', 'staggs' ) )
			->set_help_text( __( 'Optionally override the step navigation next button text. Defaults to "Next".', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			), array(
				'field' => 'sgg_configurator_step_separator_nav',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_configurator_step_disable_scroll_top', __( 'Disable scroll top on step navigation click', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			))),
		Field::make( 'checkbox', 'sgg_step_hide_inline_option_step_title', __( 'Hide Inline Separator Titles', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			))),
		Field::make( 'checkbox', 'sgg_step_hide_nav_step_labels', __( 'Hide Step Labels', 'staggs' ) )
			->set_help_text( __( 'Hides the step labels only. Keeps the numbers/icons.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			))),

	))
	->add_tab( __( 'Summary', 'staggs' ), array(

		Field::make( 'separator', 'sgg_settings_panel_general_summary', __( 'Summary', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_configurator_display_summary', __( 'Display summary of selected configuration options', 'staggs' ) ),
		Field::make( 'text', 'sgg_configurator_summary_title', __( 'Summary title', 'staggs' ) )
			->set_help_text( __( 'Title that is displayed above the selected options list', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Your configuration', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_display_summary',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_summary_empty_message', __( 'Summary empty message', 'staggs' ) )
			->set_help_text( __( 'Message that appears when no option is selected', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'No options selected', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_display_summary',
				'value' => true,
			))),
		Field::make( 'radio', 'sgg_configurator_summary_location', __( 'Summary location', 'staggs' ) )
			->set_help_text( __( 'Choose where the summary should be displayed', 'staggs' ) )
			->add_options( array(
				'before_totals' => __( 'Before configurator totals', 'staggs' ),
				'after_totals'  => __( 'After configurator totals', 'staggs' ),
				'new_page'      => __( 'Replace configurator contents with summary page', 'staggs' ),
				'shortcode'     => __( 'Anywhere using the shortcode', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_display_summary',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_configurator_summary_include_notes', __( 'Include attribute option notes in summary', 'staggs' ) )
			->set_help_text( __( 'Extend summary details by including option notes', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_display_summary',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_configurator_summary_include_prices', __( 'Include attribute option prices in summary', 'staggs' ) )
			->set_help_text( __( 'Extend summary details by including option prices', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_display_summary',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_summary_hidden_items', __( 'Summary hidden attributes', 'staggs' ) )
			->set_help_text( __( 'Optionally enter labels of attributes that should not be included in summary list (comma separated)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_display_summary',
				'value' => true,
			))),

		Field::make( 'text', 'sgg_configurator_summary_page_button', __( 'Summary page button label', 'staggs' ) )
			->set_width( 50 )
			->set_attribute( 'placeholder', 'Finish configuration' )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_location',
				'value' => 'new_page',
			))),
		Field::make( 'text', 'sgg_configurator_summary_page_back_button', __( 'Summary page back button label', 'staggs' ) )
			->set_width( 50 )
			->set_attribute( 'placeholder', '< Back to configurator' )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_location',
				'value' => 'new_page',
			))),
		Field::make( 'text', 'sgg_configurator_summary_page_shortcode', __( 'Summary page shortcode', 'staggs' ) )
			->set_help_text( __( 'Enter shortcode to display contents underneath options form', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_location',
				'value' => 'new_page',
			))),
		Field::make( 'checkbox', 'sgg_configurator_summary_page_disable_buttons', __( 'Summary page disable main buttons', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_location',
				'value' => 'new_page',
			))),

	))
	->add_tab( __( 'Configurator button', 'staggs' ), array(

		Field::make( 'separator', 'sgg_settings_panel_general_totals', __( 'Configurator button', 'staggs' ) ),

		Field::make( 'radio', 'sgg_configurator_button_type', __( 'Configurator Button Type', 'staggs' ) )
			->add_options( array(
				'cart'    => __( 'Add to Cart', 'staggs' ),
				'invoice' => __( 'Request Quote', 'staggs' ),
				'email'   => __( 'Send configuration via email', 'staggs' ),
				'pdf'     => __( 'Download PDF', 'staggs' ),
				'none'    => __( 'No action', 'staggs' ),
			)),

		Field::make( 'checkbox', 'sgg_configurator_pdf_collect_email', __( 'Collect email address for PDF download', 'staggs' ) )
			->set_help_text( __( 'Forces the customer to enter email address before obtaining the PDF file', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'pdf',
			))),
		Field::make( 'text', 'sgg_configurator_pdf_email_label', __( 'Email input label', 'staggs' ) )
			->set_help_text( __( 'Email input field label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Your email address', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'pdf',
			), array(
				'field' => 'sgg_configurator_pdf_collect_email',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_pdf_email_recipient', __( 'Notify email address', 'staggs' ) )
			->set_help_text( __( 'Enter email address the PDF download notification should be sent to. Defaults to admin email.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'pdf',
			), array(
				'field' => 'sgg_configurator_pdf_collect_email',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_pdf_email_subject', __( 'Notification email subject', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'New PDF download', 'staggs' ) )
			->set_help_text( __( 'Subject of the PDF email notification', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'pdf',
			), array(
				'field' => 'sgg_configurator_pdf_collect_email',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_configurator_pdf_email_content', __( 'Notification email content', 'staggs' ) )
			->set_help_text( __( 'Message of the PDF email notification. %s is placeholder for email address.', 'staggs' ) )
			->set_attribute( 'placeholder', __( '%s has downloaded a configuration PDF.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'pdf',
			), array(
				'field' => 'sgg_configurator_pdf_collect_email',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_button_close_popup', __( 'Close popup on totals configurator button click', 'staggs' ) )
			->set_help_text( __( 'Closes the popup and updates product page details based on configured product instead of adding to cart', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
			))),

		Field::make( 'checkbox', 'sgg_configurator_popup_replace_cart_form', __( 'Replace cart form with configure button', 'staggs' ) )
			->set_help_text( __( 'Replaces the single product page add to cart form with configure button', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
			), array(
				'field' => 'sgg_configurator_button_close_popup',
				'value' => false,
			))),

		Field::make( 'text', 'sgg_step_add_to_cart_text', __( 'Configurator Button Text', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_update_cart_text', __( 'Update Cart Button Text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'cart',
			))),

		Field::make( 'checkbox', 'sgg_configurator_hide_totals_button', __( 'Hide total button', 'staggs' ) )
			->set_help_text( __( 'Hides the total button so no action is involved in the configurator. For configuration purposes only.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'invoice',
			))),
		Field::make( 'text', 'sgg_configurator_button_email_recipient', __( 'Email recipient', 'staggs' ) )
			->set_help_text( __( 'Optionally set the email adress of the receiver. Defaults to admin email.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'email',
			))),
		Field::make( 'text', 'sgg_configurator_button_email_subject', __( 'Email subject', 'staggs' ) )
			->set_help_text( __( 'Optionally set a default email subject.', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'email',
			))),
		Field::make( 'checkbox', 'sgg_configurator_button_email_show_product_title', __( 'Include product title in email body', 'staggs' ) )
			->set_help_text( __( 'Includes product title in email contents', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'email',
			))),
		Field::make( 'checkbox', 'sgg_configurator_total_generate_image', __( 'Generate configuration image link', 'staggs' ) )
			->set_help_text( __( 'Generates a configuration image link to be used in form or email contents.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => array( 'email', 'invoice' ),
				'compare' => 'IN',
			))),
		Field::make( 'checkbox', 'sgg_configurator_total_generate_url', __( 'Generate configuration link', 'staggs' ) )
			->set_help_text( __( 'Generates a configuration link to be used in form or email contents.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => array( 'email', 'invoice' ),
				'compare' => 'IN',
			))),
		Field::make( 'checkbox', 'sgg_configurator_total_generate_pdf', __( 'Generate configuration PDF link', 'staggs' ) )
			->set_help_text( __( 'Generates a configuration PDF link to be used in form or email contents.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => array( 'email', 'invoice' ),
				'compare' => 'IN',
			))),

		Field::make( 'radio', 'sgg_configurator_form_display', __( 'Request quote form display', 'staggs' ) )
			->set_options( array(
				'page' => __( 'Separate page', 'staggs' ),
				'inline' => __( 'Inline in form', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'invoice',
			))),
		Field::make( 'select', 'sgg_configurator_form_page', __( 'Form page', 'staggs' ) )
			->add_options( 'get_page_options' )
			->set_help_text( __( 'Page where the form is located (user is redirected to this page).', 'staggs') )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'invoice',
			), array(
				'field' => 'sgg_configurator_form_display',
				'value' => 'page',
			))),
		Field::make( 'text', 'sgg_configurator_form_shortcode', __( 'Form shortcode', 'staggs' ) )
			->set_help_text( __( 'Enter form shortcode.', 'staggs') )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'invoice',
			), array(
				'field' => 'sgg_configurator_form_display',
				'value' => 'inline',
			))),
		Field::make( 'text', 'sgg_configurator_form_configuration_label', __( 'Form configuration label', 'staggs' ) )
			->set_help_text( __( 'Form field label to add configuration to.', 'staggs') )
			->set_width( 50 )
			->set_attribute( 'placeholder', 'configuration' )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'invoice',
			))),

		Field::make( 'radio', 'sgg_configurator_step_totals_display', __( 'Total action button display', 'staggs' ) )
			->set_options( array(
				'always' => __( 'Show configurator button on every step', 'staggs' ),
				'end' => __( 'Only show configurator button in final step', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'popup',
				'compare' => '!=',
			), array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			))),

		Field::make( 'radio', 'sgg_configurator_step_totals_button_position', __( 'Total action button position', 'staggs' ) )
			->set_options( array(
				'after_totals' => __( 'Show button after total price display', 'staggs' ),
				'in_step_controls' => __( 'Replace next button with total action button', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'steps',
			), array(
				'field' => 'sgg_configurator_step_separator_function',
				'value' => 'stepper',
			), array(
				'field' => 'sgg_configurator_step_totals_display',
				'value' => 'end',
			))),

		Field::make( 'checkbox', 'sgg_configurator_step_totals_display_required', __( 'Show totals button when all required options are selected', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_configurator_step_buttons_hide_disabled', __( 'Hide buttons when they are disabled', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_configurator_sticky_button', __( 'Make total action button sticky', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'full', 'floating', 'classic' ),
				'compare' => 'IN'
			), array(
				'field' => 'sgg_configurator_step_totals_display',
				'value' => 'always',
			))),

		Field::make( 'checkbox', 'sgg_configurator_sticky_button_mobile', __( 'Make total action button sticky on mobile', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'popup', 'steps' ),
				'compare' => 'IN'
			))),

	))
	->add_tab( __( 'Configurator price', 'staggs' ), array(

		Field::make( 'separator', 'sgg_settings_panel_general_prices', __( 'Configurator price', 'staggs' ) ),

		Field::make( 'radio', 'sgg_configurator_total_calculation', __( 'Configurator Total Price Calculation', 'staggs' ) )
			->add_options( array(
				'default' => __( 'Default calculation', 'staggs' ),
				'custom' => __( 'Formula calculation', 'staggs' ),
				'table' => __( 'Table calculation', 'staggs' ),
			)),
		Field::make( 'text', 'sgg_configurator_total_price_formula', __( 'Total Price Formula', 'staggs' ) )
			->set_help_text( __( 'Insert custom formula to calculate total price', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_calculation',
				'value' => 'custom',
			))),
		Field::make( 'select', 'sgg_configurator_total_price_table', __( 'Total Price Table', 'staggs' ) )
			->set_help_text( __( 'Select price table to get total price based on quantity', 'staggs' ) )
			->set_options( 'get_tablepress_tables' )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_calculation',
				'value' => 'table',
			))),
		Field::make( 'checkbox', 'sgg_configurator_total_divide_by_quantity', __( 'Divide total configuration price by quantity', 'staggs' ) )
			->set_help_text( __( 'Divide total price by quantity to prevent total price being multiplied twice', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_calculation',
				'value' => 'table',
			))),

		Field::make( 'radio', 'sgg_configurator_display_pricing', __( 'Display Totals', 'staggs' ) )
			->add_options( array( 
				'show' => 'Show totals',
				'hide' => 'Hide totals',
			)),

		Field::make( 'radio', 'sgg_configurator_total_price_display', __( 'Total Price Display', 'staggs' ) )
			->add_options( array( 
				'within' => 'In button',
				'above' => 'Above button',
			))
			->set_conditional_logic( array( 
				'relation' => 'OR',
				array(
					'field' => 'sgg_configurator_button_type',
					'value' => 'cart',
				),
				array(
					'field' => 'sgg_configurator_display_pricing',
					'value' => 'show',
				)
			)),

		Field::make( 'radio', 'sgg_configurator_price_display_template', __( 'Price Display Template', 'staggs' ) )
			->add_options( array( 
				'total' => 'Only total configuration price',
				'summary' => 'Display total configuration price breakdown',
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_price_display',
				'value' => 'above',
			), array(
				'field' => 'sgg_configurator_display_pricing',
				'value' => 'show',
			), array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'classic', 'floating', 'full' ) ,
				'compare' => 'IN',
			))),
		Field::make( 'text', 'sgg_configurator_totals_product_label', __( 'Product total label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Product total:' )
			->set_width( 33 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_price_display',
				'value' => 'above',
			), array(
				'field' => 'sgg_configurator_display_pricing',
				'value' => 'show',
			), array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'classic', 'floating', 'full' ),
				'compare' => 'IN',
			), array(
				'field' => 'sgg_configurator_price_display_template',
				'value' => 'summary',
			))),
		Field::make( 'text', 'sgg_configurator_totals_options_label', __( 'Options total label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Options total:' )
			->set_width( 33 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_price_display',
				'value' => 'above',
			), array(
				'field' => 'sgg_configurator_display_pricing',
				'value' => 'show',
			), array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'classic', 'floating', 'full' ),
				'compare' => 'IN',
			), array(
				'field' => 'sgg_configurator_price_display_template',
				'value' => 'summary',
			))),
		Field::make( 'text', 'sgg_configurator_totals_combined_label', __( 'Grand total label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Grand total:' )
			->set_width( 33 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_price_display',
				'value' => 'above',
			), array(
				'field' => 'sgg_configurator_display_pricing',
				'value' => 'show',
			), array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'classic', 'floating', 'full' ),
				'compare' => 'IN',
			), array(
				'field' => 'sgg_configurator_price_display_template',
				'value' => 'summary',
			))),
		Field::make( 'text', 'sgg_configurator_totals_label', __( 'Total label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Total:' )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_price_display',
				'value' => 'above',
			), array(
				'field' => 'sgg_configurator_display_pricing',
				'value' => 'show',
			), array(
				'field' => 'sgg_configurator_price_display_template',
				'value' => 'total',
			))),

		Field::make( 'checkbox', 'sgg_configurator_price_summary_collapse', __( 'Collapse price summary on mobile', 'staggs' ) )
			->set_help_text( __( 'Make price summary collapsible on mobile devices to save space', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_total_price_display',
				'value' => 'above',
			), array(
				'field' => 'sgg_configurator_display_pricing',
				'value' => 'show',
			), array(
				'field' => 'sgg_configurator_view',
				'value' => array( 'classic', 'floating', 'full' ),
				'compare' => 'IN',
			), array(
				'field' => 'sgg_configurator_price_display_template',
				'value' => 'summary',
			))),

	))
	->add_tab( __( 'Configurator extras', 'staggs' ), array(

		Field::make( 'separator', 'sgg_settings_panel_general_other', __( 'Configurator extras', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_configurator_display_qty_input', __( 'Display Product Quantity Input', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'cart',
			))),
		Field::make( 'text', 'sgg_configurator_qty_input_label', __( 'Product Quantity Input Name', 'staggs' ) )
			->set_help_text( __( 'Optionally enter name of input to function as the main product quantity input', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'cart',
			), array(
				'field' => 'sgg_configurator_display_qty_input',
				'value' => false,
			))),
		Field::make( 'checkbox', 'sgg_configurator_display_qty_total', __( 'Multiply total price by quantity', 'staggs' ) )
			->set_help_text( __( 'When checked the total configurator price will be shown as price * quantity', 'staggs') )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'cart',
			))),

		Field::make( 'checkbox', 'sgg_configurator_request_invoice_button', __( 'Display Download PDF Button', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_request_invoice_text', __( 'Download PDF Button Text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_request_invoice_button',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_save_button', __( 'Display Save Configuration Button', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_save_button_text', __( 'Save Configuration Button Text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_save_button',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_configurator_sticky_cart_bar', __( 'Display sticky add to cart bar', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_view',
				'value' => 'classic',
			), array(
				'field' => 'sgg_configurator_button_type',
				'value' => 'cart',
			))),
		Field::make( 'checkbox', 'sgg_configurator_sticky_cart_bar_usps', __( 'Display USPs in sticky bar', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_sticky_cart_bar',
				'value' => true
			))),

		Field::make( 'radio_image', 'sgg_configurator_usp_location', __( 'USPs location', 'staggs' ) )
			->add_options( array(
				'totals' => STAGGS_BASE_URL . 'admin/img/usp-cart.png',
				'gallery' => STAGGS_BASE_URL . 'admin/img/usp-gallery.png',
			)),
		Field::make( 'complex', 'sgg_step_usps', __( 'Unique Selling Points', 'staggs' ) )
			->set_max( 3 )
			->setup_labels( $usp_labels )
			->add_fields( 'options', array(
				Field::make( 'image', 'sgg_usp_icon', __( 'Icon', 'staggs' ) )
					->set_help_text( __( 'Note: please keep image sizes lower than 2 MB to maintain the configurator performance.', 'staggs' ) )
					->set_width( 50 ),
				Field::make( 'text', 'sgg_usp_title', __( 'Title', 'staggs' ) )
					->set_width( 50 )
			)),
		Field::make( 'complex', 'sgg_model_hotspots', __( '3D model hotspots', 'staggs' ) )
			->setup_labels( $hotspot_labels )
			->add_fields( 'options', array(
				Field::make( 'text', 'sgg_model_hotspot_id', __( 'Hotspot ID', 'staggs' ) )
					->set_width( 50 ),
				Field::make( 'rich_text', 'sgg_model_hotspot_content', __( 'Hotspot content', 'staggs' ) )
					->set_width( 50 ),
				Field::make( 'text', 'sgg_model_hotspot_position', __( 'Hotspot position', 'staggs' ) )
					->set_width( 50 ),
				Field::make( 'text', 'sgg_model_hotspot_normal', __( 'Hotspot position normal', 'staggs' ) )
					->set_width( 50 ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_gallery_type',
				'value' => '3dmodel',
			))),
	))
	->add_tab( __( 'Custom CSS', 'staggs' ), array(

		Field::make( 'separator', 'sgg_theme_panel_css', __( 'Custom CSS', 'staggs' ) ),

		Field::make( 'textarea', 'sgg_configurator_css', __( 'Custom Styles', 'staggs' ) )
			->set_classes( 'cf-header-scripts-custom-css' )
			->set_help_text( __( 'If you need to add custom configurator styling, you should enter the CSS here.', 'staggs' ) ),

	));