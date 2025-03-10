<?php

/**
 * Provide a admin-facing view for the General Settings Fields form of the plugin
 *
 * This file is used to markup the admin-facing settings form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.4.4
 *
 * @package    Staggs
 * @subpackage Staggs/admin/fields
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$repeater_labels = array(
	'plural_name' => __( 'Currencies', 'staggs' ),
	'singular_name' => __( 'Currency', 'staggs' ),
);
$conditional_labels = array(
	'plural_name' => __( 'New', 'staggs' ),
	'singular_name' => __( 'New', 'staggs' ),
);
$rule_labels = array(
	'plural_name' => __( 'Conditional Rules', 'staggs' ),
	'singular_name' => __( 'Conditional Rule', 'staggs' ),
);

$price_fields = array(
	Field::make( 'separator', 'sgg_setting_price_tab_label', __( 'Price settings', 'staggs' ) ),
);

if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	array_push( $price_fields, 
		Field::make( 'select', 'sgg_price_currency_pos', __( 'Currency position', 'staggs' ) )
			->set_help_text( __( 'Select the position of the currency symbol', 'staggs' ) )
			->set_width( 20 )
			->add_options( array(
				'left_space' => __( 'Left with a space', 'staggs' ),
				'left' => __( 'Left', 'staggs' ),
				'right_space' => __( 'Right with a space', 'staggs' ),
				'right' => __( 'Right', 'staggs' ),
			)),
		Field::make( 'text', 'sgg_price_currency_symbol', __( 'Currency symbol', 'staggs' ) )
			->set_help_text( __( 'Optionally enter your currency symbol', 'staggs' ) )
			->set_width( 80 ),
		Field::make( 'text', 'sgg_price_thousand_sep', __( 'Thousand separator', 'staggs' ) )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_price_decimal_sep', __( 'Decimal separator', 'staggs' ) )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_price_decimal_number', __( 'Number of decimals', 'staggs' ) )
			->set_width( 33 )
			->set_attribute( 'placeholder', '2' ),
	);
} else {
	array_push( $price_fields,
		Field::make( 'html', 'sgg_product_price_settings' )
			->set_html( '<p>Configure product price settings in WooCommerce -> Settings -> Currency options.</p>' ),
	);
}

array_push( $price_fields, 
	Field::make( 'complex', 'sgg_product_multi_currencies', __( 'Multi currencies', 'staggs' ) )
		->set_help_text( __( 'Define the exchange rates based on your base currency', 'staggs' ) )
		->setup_labels( $repeater_labels )
		->add_fields( array(
			Field::make( 'text', 'currency_id', __( 'Currency Identifier', 'staggs' ) )
				->set_help_text( __( 'Select your unique currency identifier, like USD, CAD, etc', 'staggs' ) )
				->set_width(33),
			Field::make( 'text', 'exchange_rate', __( 'Exchange Rate', 'staggs' ) )
				->set_width(33)
				->set_help_text( __( 'Set your unique currency exchange rate', 'staggs' ) ),
			Field::make( 'select', 'exchange_rounding', __( 'Exchange Rounding', 'staggs' ) )
				->set_width(33)
				->set_help_text( __( 'Select the rounding precision', 'staggs' ) )
				->set_options( array(
					'2' => '0.01',
					'1' => '0.10',
					'0.25' => '0.25',
					'0.50' => '0.50',
					'0.00' => '1.00',
					'-1' => '10.00',
					'-2' => '100.00',
					'-3' => '1,000.00',
				))
		)),
);

$settings = Container::make( 'theme_options', __( 'Settings', 'staggs' ) )
	->set_page_parent( 'edit.php?post_type=sgg_attribute' )
	->set_page_file( 'appearance' )
	->set_layout( 'tabbed-vertical' )
	->add_tab( __( 'Brand', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_brand_tab_label', __( 'Brand', 'staggs' ) ),
		Field::make( 'image', 'sgg_logo', __( 'Company Logo', 'staggs' ) )
			->set_help_text( __( 'Note: please keep image sizes lower than 2 MB to maintain the configurator performance.', 'staggs' ) ),
		Field::make( 'text', 'sgg_company_name', __( 'Company Name', 'staggs' ) ),
		Field::make( 'text', 'sgg_font_family', __( 'Font Family', 'staggs' ) )
			->set_help_text( __( 'If you need a custom font, you should enter the font family name here (e.g. Helvetica).', 'staggs' ) )
			->set_width(33),
		Field::make( 'text', 'sgg_font_weight', __( 'Font Weight', 'staggs' ) )
			->set_help_text( __( 'Enter the font weight here. Use CSS units (e.g. 700 or bold).', 'staggs' ) )
			->set_width(33),
		Field::make( 'select', 'sgg_font_style', __( 'Font Style', 'staggs' ) )
			->set_options( array(
				'normal' => 'Normal',
				'italic' => 'Italic',
			))
			->set_help_text( __( 'Select the font style here', 'staggs' ) )
			->set_width(33),
		Field::make( 'footer_scripts', 'sgg_footer_scripts', __( 'Footer Scripts', 'staggs' ) )
			->set_help_text( __( 'If you need to add scripts to your footer (like Google Fonts), you should enter them here.', 'staggs' ) )
			->set_hook_name( 'wp_footer' ),
	))
	->add_tab( __( 'Labels', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_labels_tab_label', __( 'Labels', 'staggs' ) ),

		Field::make( 'text', 'sgg_gallery_fullscreen_label', __( 'Fullscreen button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Toggle fullscreen mode', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_gallery_camera_label', __( 'Camera button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Capture configuration image', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_gallery_wishlist_label', __( 'Wishlist button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Add to my configurations', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_gallery_pdf_label', __( 'PDF button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Download to PDF', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_gallery_share_label', __( 'Share button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Get configuration link', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_gallery_reset_label', __( 'Reset button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Reset configuration', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_gallery_instructions_label', __( 'Instructions button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Show viewer instructions', 'staggs' )),

		Field::make( 'html', 'sgg_configurator_summary_labels' )
			->set_html( '<p><strong>Summary Labels</strong></p>' ),

		Field::make( 'text', 'sgg_configurator_summary_intro', __( 'Summary page intro', 'staggs' ) )
			->set_width( 33 )
			->set_attribute( 'placeholder', 'Thank you for using our configurator. Here is an overview of your options:' ),
		Field::make( 'text', 'sgg_configurator_summary_table_title', __( 'Product total label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Your configuration' )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_configurator_summary_table_total_label', __( 'Table total label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Your price:' )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_configurator_summary_table_step_label', __( 'Table step label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Step' )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_configurator_summary_table_value_label', __( 'Table value label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Value' )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_configurator_summary_table_price_label', __( 'Table price label', 'staggs' ) )
			->set_attribute( 'placeholder', 'Price' )
			->set_width( 33 ),

		Field::make( 'text', 'sgg_configurator_summary_share_link_label', __( 'Configuration summary link', 'staggs' ) )
			->set_width( 33 )
			->set_attribute( 'placeholder', 'Share configuration or continue later?' ),
		Field::make( 'text', 'sgg_configurator_summary_share_link_intro', __( 'Configuration summary link description', 'staggs' ) )
			->set_attribute( 'placeholder', 'Copy the following link to return to your configuration:' )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_configurator_summary_share_link_button', __( 'Configuration summary link button', 'staggs' ) )
			->set_attribute( 'placeholder', 'Copy' )
			->set_width( 33 ),

		Field::make( 'text', 'sgg_configurator_summary_pdf_label', __( 'Configuration summary pdf', 'staggs' ) )
			->set_width( 33 )
			->set_attribute( 'placeholder', 'Download to PDF' ),
		Field::make( 'text', 'sgg_configurator_summary_pdf_intro', __( 'Configuration summary pdf description', 'staggs' ) )
			->set_attribute( 'placeholder', 'Save configuration page to PDF' )
			->set_width( 33 ),
		Field::make( 'text', 'sgg_configurator_summary_pdf_button', __( 'Configuration summary pdf button', 'staggs' ) )
			->set_attribute( 'placeholder', 'Generate PDF' )
			->set_width( 33 ),

		Field::make( 'checkbox', 'sgg_configurator_summary_enable_mail', __( 'Allow customer to mail configuration link to himself', 'staggs' ) ),

		Field::make( 'text', 'sgg_configurator_summary_mail_link_label', __( 'Configuration summary mail', 'staggs' ) )
			->set_attribute( 'placeholder', 'Mail configuration' )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_enable_mail',
				'value' => true
			))),
		Field::make( 'text', 'sgg_configurator_summary_mail_link_intro', __( 'Configuration summary mail description', 'staggs' ) )
			->set_attribute( 'placeholder', 'Send the configuration link to your mailadres:' )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_enable_mail',
				'value' => true
			))),
		Field::make( 'text', 'sgg_configurator_summary_mail_link_placeholder', __( 'Configuration summary mail placeholder', 'staggs' ) )
			->set_attribute( 'placeholder', 'name@email.com' )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_enable_mail',
				'value' => true
			))),
		Field::make( 'text', 'sgg_configurator_summary_mail_link_button', __( 'Configuration summary mail button', 'staggs' ) )
			->set_attribute( 'placeholder', 'Send' )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_summary_enable_mail',
				'value' => true
			))),

		Field::make( 'html', 'sgg_configurator_notice_labels' )
			->set_html( '<p><strong>Notice Labels</strong></p>' ),

		Field::make( 'text', 'sgg_product_share_notice_label', __( 'Share notice label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Configuration succesfully saved', 'staggs' ))
			->set_help_text( __( 'Optionally override share notice label.', 'staggs' ) ),
		Field::make( 'text', 'sgg_product_share_notice_button', __( 'Share notice button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Copy link', 'staggs' ))
			->set_help_text( __( 'Optionally override share notice button label.', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_share_notice_copied', __( 'Share notice button copied label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Copied!', 'staggs' ))
			->set_help_text( __( 'Optionally override share notice button label when copied.', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'text', 'sgg_product_wishlist_notice', __( 'Wishlist notice label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Configuration succesfully added to "My Configurations"', 'staggs' ))
			->set_help_text( __( 'Optionally override wishlist notice label.', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_wishlist_button', __( 'Wishlist notice button text', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'View my configurations', 'staggs' ))
			->set_help_text( __( 'Optionally override wishlist notice button label.', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_wishlist_delete_notice', __( 'Wishlist notice delete message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Do you want to remove this item from your wishlist?', 'staggs' ))
			->set_help_text( __( 'Optionally override wishlist delete confirm message.', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_wishlist_empty_notice', __( 'Wishlist empty message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'You have not saved any configurations yet.', 'staggs' ))
			->set_help_text( __( 'Optionally override wishlist empty table message.', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'text', 'sgg_product_required_error_message', __( 'Required configuration error message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Please fill out all required fields!', 'staggs' ))
			->set_help_text( __( 'Optionally override required error message.', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_invalid_error_message', __( 'Invalid configuration error message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Please make sure all fields are filled out correctly!', 'staggs' ))
			->set_help_text( __( 'Optionally override invalid error message.', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'text', 'sgg_product_required_field_message', __( 'Required configuration field message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'This field is required.', 'staggs' ))
			->set_help_text( __( 'Optionally override required field message.', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_invalid_field_message', __( 'Invalid configuration field message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'This field is invalid.', 'staggs' ))
			->set_help_text( __( 'Optionally override invalid field message.', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'html', 'sgg_configurator_page_titles' )
			->set_html( '<p><strong>Page Titles</strong></p>' ),

		Field::make( 'text', 'sgg_account_configurations_page_title', __( 'My configurations page title', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'My configurations', 'staggs' ))
			->set_help_text( __( 'Optionally override my configurations account page.', 'staggs' ) ),

		Field::make( 'text', 'sgg_account_configurations_table_heading', __( 'My configurations table heading', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Configuration details', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_account_configurations_table_price', __( 'My configurations table price label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Total price', 'staggs' ))
			->set_width( 50 ),
	) )
	->add_tab( __( 'Icons', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_icons_tab_label', __( 'Icons', 'staggs' ) ),

		Field::make( 'image', 'sgg_slider_arrow_left', __( 'Gallery Arrow Left', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_slider_arrow_left_dark', __( 'Gallery Arrow Left (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_slider_arrow_right', __( 'Gallery Arrow Right', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_slider_arrow_right_dark', __( 'Gallery Arrow Right (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_select_arrow', __( 'Select Arrow Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_select_arrow_dark', __( 'Select Arrow Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_checkmark', __( 'Checkmark Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_checkmark_dark', __( 'Checkmark Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_close_icon', __( 'Close Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_close_icon_dark', __( 'Close Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_close_icon', __( 'Panel Close Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_close_icon_dark', __( 'Panel Close Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_plus_icon', __( 'Description Plus Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_plus_icon_dark', __( 'Description Plus Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_minus_icon', __( 'Description Minus Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_minus_icon_dark', __( 'Description Minus Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_info_icon', __( 'Info Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_info_icon_dark', __( 'Info Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_pdf_icon', __( 'PDF Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_pdf_icon_dark', __( 'PDF Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_save_icon', __( 'Save Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_group_save_icon_dark', __( 'Save Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_popup_back_icon', __( 'Popup Back Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_popup_back_icon_dark', __( 'Popup Back Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_separator_collapse_icon', __( 'Separator Collapse Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_separator_collapse_icon_dark', __( 'Separator Collapse Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_calendar_icon', __( 'Calendar Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_calendar_icon_dark', __( 'Calendar Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_mobile_ar_icon', __( 'AR Button Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_mobile_ar_icon_dark', __( 'AR Button Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_fullscreen_icon', __( 'Fullscreen Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_fullscreen_icon_dark', __( 'Fullscreen Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_fullscreen_close_icon', __( 'Fullscreen Close Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_fullscreen_close_icon_dark', __( 'Fullscreen Close Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_camera_icon', __( 'Camera Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_camera_icon_dark', __( 'Camera Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_wishlist_icon', __( 'Wishlist Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_wishlist_icon_dark', __( 'Wishlist Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_wishlist_delete_icon', __( 'Wishlist Delete Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_wishlist_delete_icon_dark', __( 'Wishlist Delete Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_zoom_icon', __( 'Image Zoom Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_zoom_icon_dark', __( 'Image Zoom Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_loader_icon', __( 'Button Loader Icon', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'image', 'sgg_loader_icon_dark', __( 'Button Loader Icon (Dark Theme)', 'staggs' ) )
			->set_width( 25 ),
	))
	->add_tab( __( 'Attributes', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_attributes_tab_label', __( 'Attributes', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_dropdown_disable_placeholder', __( 'Disable dropdown placeholders', 'staggs' ) )
			->set_help_text( __( 'Disable dropdown placeholders for non-required dropdowns.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_dropdown_disable_mobile_ui', __( 'Disable mobile native dropdown UI', 'staggs' ) )
			->set_help_text( __( 'Displays dropdowns in same style as on desktop devices.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_step_allow_uncheck_default_option', __( 'Allow checked optional options to be unchecked', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_url_option_disable_click', __( 'Disable click for URL options', 'staggs' ) )
			->set_help_text( __( 'Removes the default click handler for URL options so you can handle the link your own way.', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_included_text', __( 'Included Option Price label', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_additional_price_sign', __( 'Show sign for additional prices', 'staggs' ) )
			->set_help_text( __( 'Displays a plus sign before the option price to indicate additional charges (+$99).', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_price_trim_decimals', __( 'Trim price decimals on full prices', 'staggs' ) )
			->set_help_text( __( 'Display prices that ends on ",00" in a format of ",-"', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_price_hide_sale_price', __( 'Hide sale price display', 'staggs' ) )
			->set_help_text( __( 'Hide from price when product on discount. Show final price only', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_price_show_difference_only', __( 'Show price difference only for option prices', 'staggs' ) )
			->set_help_text( __( 'Dynamically update difference in price options based on current selected option', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_price_unit_min_based', __( 'Base unit price calculations on minimum value', 'staggs' ) )
			->set_help_text( __( 'Perceive minimum input value as 0 for unit price calculations.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_show_individual_error_messages', __( 'Display individual error messages for each attribute', 'staggs' ) )
			->set_help_text( __( 'Adds error messages to all invalid fields instead of one general alert.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_show_invalid_conditional_options', __( 'Keep invalid conditional options visible for user', 'staggs' ) )
			->set_help_text( __( 'Gray out invalid conditional options and show to customer', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_track_conditional_values', __( 'Remember selected options of conditional attributes', 'staggs' ) )
			->set_help_text( __( 'Makes the last selected option active when conditional field is visible.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_product_track_global_conditional_values', __( 'Remember selected options of conditional attributes across all attributes', 'staggs' ) )
			->set_help_text( __( 'Remember selected options across all different attributes.', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_add_label', __( 'Related products add label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Add', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'text', 'sgg_product_remove_label', __( 'Related products remove label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Remove', 'staggs' ))
			->set_width( 50 ),

		Field::make( 'checkbox', 'sgg_product_summary_hide_duplicate_titles', __( 'Hide duplicate attribute titles in summary widget', 'staggs' ) )
			->set_help_text( __( 'If multi select is active, show attribute title for first option only.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_number_input_show_icons', __( 'Include button controls in number inputs', 'staggs' ) )
			->set_help_text( __( 'Shows plus and minus button icons for number input fields.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_disable_system_file_upload', __( 'Override browser file input', 'staggs' ) )
			->set_help_text( __( 'Override default browser file input with custom button and label.', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_file_upload_button_label', __( 'File upload button label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Browse', 'staggs' ))
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_disable_system_file_upload',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_product_file_upload_label', __( 'File upload label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'No file selected', 'staggs' ))
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_disable_system_file_upload',
				'value' => true,
			))),
	))
	->add_tab( __( 'Conditional rules', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_conditionals_tab_label', __( 'Conditional rules', 'staggs' ) ),
		Field::make( 'complex', 'sgg_global_conditional_attributes', __( 'Conditional attributes', 'staggs' ) )
			->set_help_text( __( 'Set global conditional rules for attributes', 'staggs' ) )
			->setup_labels( $conditional_labels )
			->add_fields( array(
				Field::make( 'select', 'sgg_global_attribute', __( 'Select attribute', 'staggs' ) )
					->set_help_text( __( 'Select your attribute group', 'staggs' ) )
					->set_classes( 'global-attribute-select' )
					->add_options( 'get_configurator_attribute_values' ),

				Field::make( 'complex', 'sgg_global_conditional_rules', __( 'Conditional rules', 'staggs' ) )
					->set_help_text( __( 'Add conditional rules', 'staggs' ) )
					->set_classes( 'global-attribute-display-rules' )
					->setup_labels( $rule_labels )
					->add_fields( array(

						Field::make( 'select', 'sgg_global_conditional_step', __( 'Step name', 'staggs' ) )
							->set_classes('conditional-step-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'IN',
							))),
						Field::make( 'select', 'sgg_global_conditional_input', __( 'Input name', 'staggs' ) )
							->set_classes('conditional-step-input')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_inputs' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_global_conditional_compare', __( 'Compares to', 'staggs' ) )
							->add_options( array(
								'=' => 'Is equal to',
								'!=' => 'Is not equal to',
								'<' => 'Is less than',
								'>' => 'Is greater than',
								'<=' => 'Is less than or equal to',
								'>=' => 'Is greater than or equal to',
								'empty' => 'Is empty',
								'!empty' => 'Is not empty',
								'contains' => 'Contains',
								'!contains' => 'Not contains',
							))
							->set_width( 20 )
							->set_classes('conditional-compare-select'),
						Field::make( 'select', 'sgg_global_conditional_value', __( 'Step value', 'staggs' ) )
							->set_classes('conditional-value-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_item_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=' ),
								'compare' => 'IN',
							))),
						Field::make( 'text', 'sgg_global_conditional_input_value', __( 'Input value', 'staggs' ) )
							->set_classes('conditional-value-input')
							->set_width( 25 )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_global_conditional_relation', __( 'Relation', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'or' => 'OR',
								'and' => 'AND',
							))
							->set_classes('conditional-relation-select'),
						Field::make( 'select', 'sgg_global_conditional_link', __( 'Start new ruleset', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'no' => 'No',
								'yes' => 'Yes',
							))
							->set_classes('conditional-relation-link'),
				))
			)),

		Field::make( 'complex', 'sgg_global_option_conditional_display', __( 'Option conditional display', 'staggs' ) )
			->set_help_text( __( 'Add option conditional display rules', 'staggs' ) )
			->setup_labels( $conditional_labels )
			->add_fields( array(

				Field::make( 'select', 'sgg_global_attribute', __( 'Select attribute', 'staggs' ) )
					->set_help_text( __( 'Select your attribute group', 'staggs' ) )
					->set_classes( 'global-attribute-select' )
					->set_width( 50 )
					->add_options( 'get_configurator_attribute_conditional_values' ),

				Field::make( 'select', 'sgg_global_conditional_option', __( 'Select option', 'staggs' ) )
					->set_help_text( __( 'Select your attribute option to apply display logic to', 'staggs' ) )
					->set_classes( 'global-attribute-option-select' )
					->set_width( 50 )
					->add_options( 'get_configurator_attribute_item_values' ),

				Field::make( 'complex', 'sgg_global_option_conditional_rules', __( 'Conditional rules', 'staggs' ) )
					->set_help_text( __( 'Add conditional rules', 'staggs' ) )
					->set_classes( 'global-attribute-option-rules' )
					->setup_labels( $rule_labels )
					->add_fields( array(

						Field::make( 'select', 'sgg_global_conditional_step', __( 'Step name', 'staggs' ) )
							->set_classes('conditional-step-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'IN',
							))),
						Field::make( 'select', 'sgg_global_conditional_input', __( 'Input name', 'staggs' ) )
							->set_classes('conditional-step-input')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_inputs' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_global_conditional_compare', __( 'Compares to', 'staggs' ) )
							->add_options( array(
								'=' => 'Is equal to',
								'!=' => 'Is not equal to',
								'<' => 'Is less than',
								'>' => 'Is greater than',
								'<=' => 'Is less than or equal to',
								'>=' => 'Is greater than or equal to',
								'empty' => 'Is empty',
								'!empty' => 'Is not empty',
								'contains' => 'Contains',
								'!contains' => 'Not contains',
							))
							->set_width( 20 )
							->set_classes('conditional-compare-select'),
						Field::make( 'select', 'sgg_global_conditional_value', __( 'Step value', 'staggs' ) )
							->set_classes('conditional-value-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_item_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=' ),
								'compare' => 'IN',
							))),
						Field::make( 'text', 'sgg_global_conditional_input_value', __( 'Input value', 'staggs' ) )
							->set_classes('conditional-value-input')
							->set_width( 25 )
							->set_conditional_logic( array( array(
								'field' => 'sgg_global_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_global_conditional_relation', __( 'Relation', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'or' => 'OR',
								'and' => 'AND',
							))
							->set_classes('conditional-relation-select'),
						Field::make( 'select', 'sgg_global_conditional_link', __( 'Start new ruleset', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'no' => 'No',
								'yes' => 'Yes',
							))
							->set_classes('conditional-relation-link'),
				))
			))
	))
	->add_tab( __( 'WooCommerce', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_woocommerce_tab_label', __( 'WooCommerce', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_prefix_label', __( 'Price prefix', 'staggs' ) )
			->set_help_text( __( 'Optionally display price prefix label on archives. E.g. From:', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'text', 'sgg_product_loop_cart_label', __( 'Configurator loop add to cart button label', 'staggs' ) )
			->set_help_text( __( 'Optionally override add to cart text display on archives.', 'staggs' ) )
			->set_width( 50 ),

		Field::make( 'text', 'sgg_product_price_format', __( 'Price format', 'staggs' ) )
			->set_help_text( __( 'Optionally override price display on archives. E.g. {min_price} - {max_price}. Available placeholders: {price}, {sale_price}, {min_price}, {max_price}', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_exclude_base_price', __( 'Exclude product base price in totals', 'staggs' ) )
			->set_help_text( __( 'Exclude WooCommerce product price from total price calculation.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_show_price_logged_in_users', __( 'Show prices for logged in users only', 'staggs' ) )
			->set_help_text( __( 'Hide pricings for website visitors. Show prices to logged in customers', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_redirect_visitors_to_login_page', __( 'Redirect visitors to login page', 'staggs' ) )
			->set_help_text( __( 'Redirects visitors to the login page when clicking the main configuration button.', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_tax_label', __( 'Main price tax suffix', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Incl. VAT', 'staggs' ))
			->set_help_text( __( 'Optionally display price tax suffix in configurator totals for main price.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_totals_show_tax', __( 'Show product price including and excluding tax', 'staggs' ) )
			->set_help_text( __( 'Also shows price including tax if price is excluding tax and vice versa.', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_totals_alt_tax_label', __( 'Price tax label in totals', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Total tax:', 'staggs' ))
			->set_width( 50 )
			->set_help_text( __( 'Optionally override price tax label in price totals list.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_totals_show_tax',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_product_alt_tax_label', __( 'Second price tax suffix', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Excl. VAT', 'staggs' ))
			->set_width( 50 )
			->set_help_text( __( 'Optionally display price tax suffix for alternative price.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_totals_show_tax',
				'value' => true,
			))),

		Field::make( 'checkbox', 'sgg_product_totals_show_weight', __( 'Show product weight in configurator totals', 'staggs' ) )
			->set_help_text( __( 'Shows weight of current product in configurator totals section.', 'staggs' ) ),

		Field::make( 'text', 'sgg_product_totals_weight_label', __( 'Product weight label', 'staggs' ) )
			->set_help_text( __( 'Optionally override product weight label', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Product weight:', 'staggs' ))
			->set_width(50)
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_totals_show_weight',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_product_totals_weight_decimal_sep', __( 'Product weight decimal separator', 'staggs' ) )
			->set_attribute( 'placeholder', __( '.', 'staggs' ))
			->set_width(25)
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_totals_show_weight',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_product_totals_weight_decimals', __( 'Product weight decimals', 'staggs' ) )
			->set_attribute( 'placeholder', __( '2', 'staggs' ))
			->set_width(25)
			->set_conditional_logic( array( array(
				'field' => 'sgg_product_totals_show_weight',
				'value' => true,
			))),
	))
	->add_tab( __( 'Price settings', 'staggs' ), $price_fields )
	->add_tab( __( 'Stock', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_stock_tab_label', __( 'Stock', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_option_hide_out_of_stock', __( 'Hide attribute options when out of stock?', 'staggs' ) )
			->set_option_value( 'yes' ),
		Field::make( 'text', 'sgg_option_out_of_stock_message', __( 'Out of stock message', 'staggs' ) )
			->set_attribute( 'placeholder', __( 'Out of stock', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_option_hide_out_of_stock',
				'value' => false
			))),
		Field::make( 'checkbox', 'sgg_send_notifications', __( 'Send Email Notifications', 'staggs' ) ),
		Field::make( 'text', 'sgg_notification_email', __( 'Email Address', 'staggs' ) )
			->set_help_text( __( 'Admin email address will be used by default.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_send_notifications',
				'value' => true,
			))),
		Field::make( 'text', 'sgg_low_stock_qty', __( 'Low Stock Quantity', 'staggs' ) )
			->set_help_text( __( 'Send a notification when the stock quantity has reached this amount.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_send_notifications',
				'value' => true,
			))),
	))
	->add_tab( __( 'PDF', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_pdf_tab_label', __( 'PDF', 'staggs' ) ),

		Field::make( 'radio_image', 'sgg_pdf_layout', __( 'PDF Layout', 'staggs' ) )
			->add_options( array(
				'default' => STAGGS_BASE_URL . 'admin/img/pdf-default.png',
				'wide' => STAGGS_BASE_URL . 'admin/img/pdf-wide.png',
			)),
		Field::make( 'select', 'sgg_pdf_header_layout', __( 'PDF Header Layout', 'staggs' ) )
			->add_options( array(
				'logo_right' => __( 'Display logo right', 'staggs' ),
				'logo_left' => __( 'Display logo left', 'staggs' ),
			)),

		Field::make( 'checkbox', 'sgg_pdf_include_product_description', __( 'Include product short description in PDF header intro', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_pdf_set_custom_header_address', __( 'Override PDF header address text', 'staggs' ) ),
		Field::make( 'rich_text', 'sgg_pdf_custom_header_address', __( 'PDF header address text', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_pdf_set_custom_header_address',
				'value' => true
			))),

		Field::make( 'rich_text', 'sgg_pdf_custom_intro', __( 'PDF header intro', 'staggs' ) )
			->set_help_text( __( 'Write general intro text to show underneath product title', 'staggs' ) ),

		Field::make( 'color', 'sgg_pdf_primary_color', __( 'Primary Color', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'color', 'sgg_pdf_secondary_color', __( 'Secondary Color', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'color', 'sgg_pdf_text_color', __( 'Text Color', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'select', 'sgg_pdf_text_style', __( 'Text Transform', 'staggs' ) )
			->set_width( 25 )
			->add_options(array(
				'default' =>  __( 'Capitalize first character', 'staggs' ),
				'capitalize' =>  __( 'Capitalize all words', 'staggs' ),
				'lowercase' =>  __( 'All lowercase', 'staggs' ),
				'uppercase' =>  __( 'All uppercase', 'staggs' ),
			)),
		Field::make( 'text', 'sgg_pdf_product_heading', __( 'Product section title', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'text', 'sgg_pdf_options_heading', __( 'Configuration section title', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'text', 'sgg_pdf_table_step_heading', __( 'Table step title', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'text', 'sgg_pdf_table_value_heading', __( 'Table value title', 'staggs' ) )
			->set_width( 25 ),
		Field::make( 'text', 'sgg_pdf_table_price_heading', __( 'Table price title', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_pdf_table_price_total_label', __( 'Table price total label', 'staggs' ) )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_pdf_table_price_ex_tax_label', __( 'Table price total ex tax label', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_pdf_total_price_tax',
				'value' => 'both'
			))),
		Field::make( 'text', 'sgg_pdf_table_price_tax_label', __( 'Table price total tax label', 'staggs' ) )
			->set_width( 50 )
			->set_conditional_logic( array( array(
				'field' => 'sgg_pdf_total_price_tax',
				'value' => 'both'
			))),
		Field::make( 'text', 'sgg_pdf_forbidden_option_labels', __( 'Forbidden option labels', 'staggs' ) )
			->set_help_text( __( 'Optionally enter labels of attributes as displayed in PDF that should not be included (comma separated)', 'staggs' ) )
			->set_attribute( 'placeholder', 'Label, Label two' )
			->set_width( 50 ),
		Field::make( 'text', 'sgg_pdf_image_width', __( 'Product image width', 'staggs' ) )
			->set_help_text( __( 'Width of the product image in the PDF (numeric)', 'staggs' ))
			->set_width( 50 ),
		Field::make( 'checkbox', 'sgg_pdf_hide_product_image', __( 'Exclude product image from PDF', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_pdf_hide_price_totals', __( 'Hide price totals in the PDF template', 'staggs' ) ),
		Field::make( 'select', 'sgg_pdf_total_price_tax', __( 'Total price tax display', 'staggs' ) )
			->add_options( array(
				'inherit' => __( 'Default', 'staggs' ),
				'incl' => __( 'Including tax', 'staggs' ),
				'excl' => __( 'Excluding tax', 'staggs' ),
				'both' => __( 'Including and excluding tax', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_pdf_hide_price_totals',
				'value' => false
			))),
		Field::make( 'checkbox', 'sgg_pdf_show_option_prices', __( 'Show option prices in PDF template', 'staggs' ) ),
		Field::make( 'select', 'sgg_pdf_option_prices_align', __( 'Option prices column alignment', 'staggs' ) )
			->add_options( array(
				'inherit' => __( 'Default', 'staggs' ),
				'right' => __( 'Right', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_pdf_show_option_prices',
				'value' => true
			))),
		Field::make( 'checkbox', 'sgg_pdf_show_option_skus', __( 'Show option SKUs in PDF template', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_pdf_show_option_notes', __( 'Show option notes in PDF template', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_pdf_include_default_attributes', __( 'Include default attributes in PDF template', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_pdf_include_online_link', __( 'Include web link in PDF to view the configuration online', 'staggs' ) ),
		Field::make( 'text', 'sgg_pdf_include_online_link_label', __( 'Online link label', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_pdf_include_online_link',
				'value' => true
			))),
	))
	->add_tab( __( 'Cart', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_cart_tab_label', __( 'Cart', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_cart_enable_dynamic_pricing', __( 'Enable dynamic pricing for cart items', 'staggs' ) )
			->set_help_text( __( 'Dynamically calculate pricings for cart items instead of saving calculated price to cart item.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_cart_show_option_skus', __( 'Display attribute option SKUs in cart', 'staggs' ) )
			->set_help_text( __( 'Display option SKUs in cart items.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_checkout_exclude_product_addons', __( 'Save related products as separate cart line items', 'staggs' ) )
			->set_help_text( __( 'Removes the product addons from original configuration line item and adds them as separate line items. This also means they can be controlled separately.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_checkout_exclude_linked_products', __( 'Save attribute linked WooCommerce products as separate cart line items', 'staggs' ) )
			->set_help_text( __( 'Removes the linked product attribute items from original configuration line item and adds them as separate line items.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_checkout_bundle_product_lines', __( 'Bundle separate cart line items together', 'staggs' ) )
			->set_help_text( __( 'When one product in bundle is removed from cart, all related products will be removed too.', 'staggs' ) )
			->set_conditional_logic( array( 
				'relation' => 'OR', 
				array(
					'field' => 'sgg_checkout_exclude_product_addons',
					'value' => true,
				), array(
					'field' => 'sgg_checkout_exclude_linked_products',
					'value' => true,
				)
			)),
		Field::make( 'checkbox', 'sgg_checkout_exclude_product_base', __( 'Exclude base product from cart lines', 'staggs' ) )
			->set_help_text( __( 'Only adds the linked products as cart line items. Not the base product.', 'staggs' ) )
			->set_conditional_logic( array( 
				'relation' => 'OR', 
				array(
					'field' => 'sgg_checkout_exclude_product_addons',
					'value' => true,
				), array(
					'field' => 'sgg_checkout_exclude_linked_products',
					'value' => true,
				)
			)),
		Field::make( 'radio', 'sgg_checkout_file_upload_display', __( 'Choose how to display uploaded files in cart and checkout', 'staggs' ) )
			->set_options( array(
				'filename' => __('Filename', 'staggs'),
				'preview' => __('Image preview', 'staggs'),
			)),
		Field::make( 'radio', 'sgg_product_attribute_value_display', __( 'Choose how to display products attribute values', 'staggs' ) )
			->set_options( array(
				'label_value' => __('Label: Quantity', 'staggs'),
				'title_label' => __('Title: Label', 'staggs'),
			)),
		Field::make( 'checkbox', 'sgg_checkout_enable_tax_calculation', __( 'Enable STAGGS tax calculation for cart items', 'staggs' ) ),
	))
	->add_tab( __( 'Checkout', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_checkout_tab_label', __( 'Checkout', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_order_save_attribute_prices', __( 'Save attribute option prices to order items', 'staggs' ) )
			->set_help_text( __( 'Saves the individual option prices to the attributes in the order item for later reference.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_order_save_attribute_skus', __( 'Save attribute SKUs to order items', 'staggs' ) )
			->set_help_text( __( 'Saves the individual option SKUs to the attributes in the order item for later reference.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_order_exclude_attribute_parent_skus', __( 'Exclude attribute parent SKUs in order items', 'staggs' ) )
			->set_help_text( __( 'Exclude attribute main SKU in order lines. Save attribute option SKUs only.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_order_save_attribute_qty', __( 'Save attribute quantities to order items', 'staggs' ) )
			->set_help_text( __( 'Saves the individual option quantity to the attributes in the order item for later reference.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_order_save_pdf_attachment', __( 'Save order line item PDFs', 'staggs' ) )
			->set_help_text( __( 'Generates a PDF for each order line item and saves it for later reference.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_order_pdf_include_order_id', __( 'Include order ID in order line item PDFs', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_order_save_pdf_attachment',
				'value' => true,
			))),
		Field::make( 'checkbox', 'sgg_order_pdf_include_customer_details', __( 'Include customer billing details in order line item PDFs', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_order_save_pdf_attachment',
				'value' => true,
			))),

		Field::make( 'text', 'sgg_checkout_image_width', __( 'Product image width', 'staggs' ) )
			->set_default_value( 70 )
			->set_width( 50 )
			->set_help_text( __( 'Enter the width value of the preview image in pixels (px).', 'staggs' ) ),
		Field::make( 'text', 'sgg_checkout_image_height', __( 'Product image height', 'staggs' ) )
			->set_default_value( 70 )
			->set_width( 50 )
			->set_help_text( __( 'Enter the height value of the preview image in pixels (px).', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_checkout_display_image', __( 'Display generated product image on checkout page', 'staggs' ) )
			->set_help_text( __( 'Displays product image in table on checkout page when enabled. Applies to all products.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_view_order_display_image', __( 'Display generated product image on order pages', 'staggs' ) )
			->set_help_text( __( 'Displays product image in tables on order pages when enabled. Applies to all products.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_confirmation_email_display_image', __( 'Display generated product image in order emails', 'staggs' ) )
			->set_help_text( __( 'Displays product image in WooCommerce order emails when enabled. Applies to all products.', 'staggs' ) ),
	))
	->add_tab( __( 'Advanced', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_advanced_tab_label', __( 'Advanced', 'staggs' ) ),
		
		Field::make( 'text', 'sgg_desktop_image_capture_scale', __( 'Image capture scale', 'staggs' ) )
			->set_help_text( __( 'Image capture scale on desktop. Defaults to 1 (displayed image size).', 'staggs' ) )
			->set_width(33),
		Field::make( 'text', 'sgg_tablet_image_capture_scale', __( 'Image capture scale (tablet)', 'staggs' ) )
			->set_help_text( __( 'Image capture scale on tablet. Defaults to 1.5 (displayed image size * 1.5).', 'staggs' ) )
			->set_width(33),
		Field::make( 'text', 'sgg_mobile_image_capture_scale', __( 'Image capture scale (mobile)', 'staggs' ) )
			->set_help_text( __( 'Image capture scale on mobile. Defaults to 2 (displayed image size * 2).', 'staggs' ) )
			->set_width(33),

		Field::make( 'checkbox', 'sgg_configurator_smart_nodes_lookup', __( 'Activate smart 3D node lookup', 'staggs' ) )
			->set_help_text( __( 'Switch from fixed level of nodes to dynamic node level.', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_product_list_include_configurators', __( 'Include Staggs configurable products in list', 'staggs' ) )
			->set_help_text( __( 'Includes Staggs configurable products in admin product selection list. Note: linking configurable products to other configurators is strongly discouraged.', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_admin_display_edit_links', __( 'Enable inline edit links in attribute titles', 'staggs' ) )
			->set_help_text( __( 'Display edit links in attribute title in configurator for site administrators to edit attributes quickly.', 'staggs' ) ),

		// Field::make( 'checkbox', 'sgg_admin_enable_select_two', __( 'Enable Select2 library for improved attribute searches', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_admin_complex_groups_collapsed', __( 'Collapse attribute groups on load by default', 'staggs' ) ),
		Field::make( 'checkbox', 'sgg_admin_complex_subgroups_collapsed', __( 'Collapse attribute subgroups on load by default', 'staggs' ) ),

		Field::make( 'checkbox', 'sgg_enable_garbage_collector', __( 'Enable garbage collector', 'staggs' ) )
			->set_help_text( __( 'Remove files after certain period of time.', 'staggs' ) ),
		Field::make( 'text', 'sgg_garbage_collector_days', __( 'Garbage collector days', 'staggs' ) )
			->set_help_text( __( 'Enter number of days after which files should be deleted.', 'staggs' ) )
			->set_attribute( 'placeholder', '30' )
			->set_conditional_logic( array( array(
				'field' => 'sgg_enable_garbage_collector',
				'value' => true,
			))),
		Field::make( 'set', 'sgg_analytics_order_statusses', __( 'Analytics Order statusses', 'staggs' ) )
			->set_help_text( __( 'Define the order statusses that analytics should display.', 'staggs' ) )
			->add_options( 'get_all_woocommerce_order_statusses' )
			->set_default_value( array( 'wc-processing', 'wc-completed' )),
	))
	->add_tab( __( 'Custom CSS', 'staggs' ), array(
		Field::make( 'separator', 'sgg_setting_custom_css_tab_label', __( 'Custom CSS', 'staggs' ) ),
		
		Field::make( 'textarea', 'sgg_custom_css', __( 'Custom Styles', 'staggs' ) )
			->set_classes( 'cf-header-scripts-custom-css' )
			->set_help_text( __( 'If you need to add custom styling, you should enter the CSS here.', 'staggs' ) ),
	));
