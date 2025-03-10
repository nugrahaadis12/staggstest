<?php

/**
 * Provide a admin-facing view for the Attribute Fields form of the plugin
 *
 * This file is used to markup the admin-facing attribute form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.4.4
 *
 * @package    Staggs
 * @subpackage Staggs/admin/fields
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$item_labels = array(
	'plural_name' => __( 'Attribute items', 'staggs' ),
	'singular_name' => __( 'Attribute item', 'staggs' ),
);

$weight_unit  = get_option( 'woocommerce_weight_unit' ) ?: 'kg';
$option_fields = array(
	Field::make( 'text', 'sgg_option_label', __( 'Label', 'staggs' ) )
		->set_required( true )
		->set_help_text( __( 'Main attribute label', 'staggs' ) ),
	Field::make( 'text', 'sgg_option_note', __( 'Note', 'staggs' ) )
		->set_help_text( __( 'Note is displayed underneath the label', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_step_template',
			'value' => array( 'button-group' ),
			'compare' => 'NOT IN',
		))),
	Field::make( 'rich_text', 'sgg_option_description', __( 'Description', 'staggs' ) )
		->set_help_text( __( 'Extensive description is displayed in a separate panel', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_step_template',
			'value' => array( 'options', 'cards', 'tickboxes', 'product' ),
			'compare' => 'IN',
		), array( 
			'field' => 'parent.sgg_step_include_option_descriptions',
			'value' => 'show',
		))),
	Field::make( 'image', 'sgg_option_image', __( 'Thumbnail', 'staggs' ) )
		->set_help_text( __( 'Note: please keep image sizes lower than 2 MB to maintain the configurator performance.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_step_template',
			'value' => array( 'options', 'cards', 'icons', 'product' ),
			'compare' => 'IN',
		), array( 
			'field' => 'parent.sgg_step_show_image',
			'value' => 'show',
		))),
	Field::make( 'text', 'sgg_option_sku', __( 'SKU', 'staggs' ) )
		->set_help_text( __( 'Optionally enter a SKU for the attribute option', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => array( 'image', 'input', 'color', 'font'),
			'compare' => 'IN',
		))),
	Field::make( 'select', 'sgg_option_field_type', __( 'Input Type', 'staggs' ) )
		->set_classes( 'sgg_option_field_type' )
		->set_help_text( __( 'Select your input type ', 'staggs' ))
		->add_options( array(
			'text'     => 'Text',
			'textarea' => 'Textarea',
			'date'     => 'Date picker',
			'color'    => 'Color picker',
			'number'   => 'Number',
			'range'    => 'Range slider',
			'file'      => 'File',
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input'
		))),
	Field::make( 'select', 'sgg_option_field_required', __( 'Required field', 'staggs' ) )
		->set_help_text( __( 'Select if the input field is required or optional.', 'staggs' ) )
		->add_options( array(
			'no' => __( 'Optional', 'staggs' ),
			'yes' => __( 'Required', 'staggs' ),
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		))),
	Field::make( 'select', 'sgg_option_linked_product_id', __( 'WooCommerce Product', 'staggs' ) )
		->add_options( 'get_woocommerce_simple_product_list' )
		->set_help_text( __( 'Only Non-Configurable WooCommerce Products appear in this list.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'link',
		))),
	Field::make( 'text', 'sgg_option_linked_product_qty', __( 'WooCommerce Product Quantity', 'staggs' ) )
		->set_help_text( __( 'Optionally enter quantity of product that should be included. Defaults to 1', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'link',
		))),
	Field::make( 'text', 'sgg_option_page_url', __( 'Page URL', 'staggs' ) )
		->set_help_text( __( 'Enter full URL of page you want to link to.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'url',
		))),
	Field::make( 'select', 'sgg_option_enable_preview', __( 'Enable Preview', 'staggs' ) )
		->set_help_text( __( 'If enabled, the input value/image will be displayed/updated in the product preview.', 'staggs' ) )
		->add_options( array( 
			'yes' => 'Yes',
			'no' => 'No',
		) ),
	Field::make( 'media_gallery', 'sgg_option_preview', __( 'Main Images', 'staggs' ) )
		->set_duplicates_allowed( false )
		->set_type( array( 'image' ) )
		->set_help_text( __( 'Choose main images to show when this step option is selected. Note: please keep image sizes lower than 2 MB to maintain the configurator performance.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => array( 'image', 'color', 'link' ),
			'compare' => 'IN',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_node', __( '3D model node(s)', 'staggs' ) )
		->set_help_text( __( 'Name(s) of 3D model nodes to display when this item is selected (e.g. node1, node2).', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		), array(
			'field' => 'parent.sgg_step_model_image_type',
			'value' => 'material',
			'compare' => '!='
		), array(
			'field' => 'parent.sgg_gallery_type',
			'value' => '3dmodel',
		))),
	Field::make( 'text', 'sgg_option_preview_hotspot', __( '3D model hotspot(s)', 'staggs' ) )
		->set_help_text( __( 'ID(s) of 3D model hotspots to display when this item is selected (e.g. hotspot1, hotspot2).', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		), array(
			'field' => 'parent.sgg_gallery_type',
			'value' => '3dmodel',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
			'compare' => '!='
		))),
	Field::make( 'text', 'sgg_option_preview_animation', __( '3D model animation', 'staggs' ) )
		->set_help_text( __( 'Play animation once in 3D model when attribute clicked.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		), array(
			'field' => 'parent.sgg_gallery_type',
			'value' => '3dmodel',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
			'compare' => '!='
		))),
	Field::make( 'text', 'sgg_option_preview_top', __( 'Preview Top Position', 'staggs' ) )
		->set_help_text( __( 'Set default preview position from top. Use CSS Units.', 'staggs' ) )
		->set_attribute( 'placeholder', '50%' )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input'
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_left', __( 'Preview Left Position', 'staggs' ) )
		->set_help_text( __( 'Set default preview position from left. Use CSS Units.', 'staggs' ) )
		->set_attribute( 'placeholder', '50%' )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_width', __( 'Preview width', 'staggs' ) )
		->set_help_text( __( 'Set a preview width. Use CSS Units.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_height', __( 'Preview height', 'staggs' ) )
		->set_help_text( __( 'Set a preview height. Use CSS Units.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'select', 'sgg_option_preview_overflow', __( 'Preview overflow', 'staggs' ) )
		->set_help_text( __( 'Set preview overflow behaviour.', 'staggs' ) )
		->add_options( array(
			'hidden' => __( 'Hide contents', 'staggs' ),
			'fittext' => __( 'Fit contents within container', 'staggs' ),
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file',
			'compare' => '!=',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'select', 'sgg_option_preview_image_fill', __( 'Preview image fill', 'staggs' ) )
		->set_help_text( __( 'Enter the desired preview image fill.', 'staggs' ) )
		->set_options( array(
			'contain' => __( 'Contain', 'staggs' ),
			'cover' => __( 'Cover', 'staggs' ),
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'select', 'sgg_option_preview_custom_mobile', __( 'Change preview settings for mobile', 'staggs' ) )
		->set_help_text( __( 'Change preview settings for mobile devices.', 'staggs' ) )
		->add_options( array(
			'no' => 'No',
			'yes' => 'Yes',
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_top_mobile', __( 'Preview Top (Mobile)', 'staggs' ) )
		->set_help_text( __( 'Set default preview position from top. Use CSS Units.', 'staggs' ) )
		->set_attribute( 'placeholder', '50%' )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_preview_custom_mobile',
			'value' => 'yes',
		), array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_left_mobile', __( 'Preview Left (Mobile)', 'staggs' ) )
		->set_help_text( __( 'Set default preview position from left. Use CSS Units.', 'staggs' ) )
		->set_attribute( 'placeholder', '50%' )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_preview_custom_mobile',
			'value' => 'yes',
		), array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'text', 'sgg_option_preview_width_mobile', __( 'Preview Width (mobile)', 'staggs' ) )
		->set_help_text( __( 'Optionally set a preview width. Use CSS Units.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_preview_custom_mobile',
			'value' => 'yes',
		), array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file',
			'compare' => '!=',
		), array(
			'field' => 'sgg_option_enable_preview',
			'value' => 'yes',
		))),
	Field::make( 'select', 'sgg_option_product_quantity', __( 'Allowed quantity', 'staggs' ) )
		->set_help_text( __( 'Are users allowed to order multiple instances of same item?', 'staggs' ) )
		->set_options( array(
			'single' => __( 'Only allow one of this item' ),
			'multiple' => __( 'Allow multiple of this item' ),
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => array( 'image', 'link' ),
			'compare' => 'IN',
		), array(
			'field' => 'parent.sgg_step_template',
			'value' => 'product',
		))),
	Field::make( 'text', 'sgg_option_font_source', __( 'Font Stylesheet URL', 'staggs' ) )
		->set_help_text( __( 'Link to Google Fonts or Adobe Typekit font stylesheet.', 'staggs' ))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'font',
		))),
	Field::make( 'text', 'sgg_option_font_family', __( 'Font Family', 'staggs' ) )
		->set_help_text( __( 'Font family as defined in CSS (e.g. "Helvetica", sans-serif")', 'staggs' ))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'font',
		))),
	Field::make( 'text', 'sgg_option_font_weight', __( 'Font Weight', 'staggs' ) )
		->set_help_text( __( 'Font weight as numeric value (e.g. 400, 700, 900)', 'staggs' ))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'font',
		))),

	Field::make( 'text', 'sgg_option_preview_ref_selector', __( 'Preview Reference Selector', 'staggs' ) )
		->set_help_text( __( 'Enter corresponding CSS property values.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_step_preview_ref',
			'value' => '',
			'compare' => '!=',
		))),

	Field::make( 'text', 'sgg_option_field_key', __( 'Field key', 'staggs' ) )
		->set_help_text( __( 'Unique identifier for given field. Can be used for price calculations or input value previews.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_gallery_type',
			'value' => 'image',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		))),
	Field::make( 'text', 'sgg_option_material_key', __( 'Material key', 'staggs' ) )
		->set_help_text( __( 'Unique name of 3D model material to update.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_gallery_type',
			'value' => '3dmodel',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		))),

	Field::make( 'text', 'sgg_option_allowed_file_types', __( 'Allowed file types', 'staggs' ) )
		->set_help_text( __( 'Optionally filter the allowed file types for the file input (e.g. .jpg, .png, .svg)', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file'
		))),
	Field::make( 'text', 'sgg_option_max_file_size', __( 'Max file size', 'staggs' ) )
		->set_help_text( __( 'Optionally enter the max allowed file size for the file input in MB (numeric)', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file'
		))),

	Field::make( 'text', 'sgg_option_range_increments', __( 'Number increments', 'staggs' ) )
		->set_help_text( __( 'Amount of increments per step. Defaults to 1.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => array( 'range', 'number' ),
			'compare' => 'IN',
		))),

	Field::make( 'select', 'sgg_option_range_bubble', __( 'Show range bubble', 'staggs' ) )
		->set_help_text( __( 'Choose to display range bubble.', 'staggs' ) )
		->set_options( array(
			'no' => __( 'No range value bubble' ),
			'yes' => __( 'Show range value bubble' ),
		))
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'range'
		))),

	Field::make( 'text', 'sgg_option_datepicker_format', __( 'Date format', 'staggs' ) )
		->set_help_text( __( 'Set a date format for the date picker. Defaults to mm/dd/yy.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
		))),

	Field::make( 'text', 'sgg_option_field_min', __( 'Field min', 'staggs' ) )
		->set_help_text( __( 'Minimum text length, date or numeric value for given field.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file',
			'compare' => '!=',
		))),
	Field::make( 'text', 'sgg_option_field_max', __( 'Field max', 'staggs' ) )
		->set_help_text( __( 'Maximum text length, date or numeric value for given field.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file',
			'compare' => '!=',
		))),
	Field::make( 'text', 'sgg_option_field_unit', __( 'Field unit', 'staggs' ) )
		->set_help_text( __( 'Optionally display unit for given field (e.g. cm, inch, gallon, liters)', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => array( 'number', 'range' ),
			'compare' => 'IN',
		))),

	Field::make( 'text', 'sgg_option_field_placeholder', __( 'Placeholder', 'staggs' ) )
		->set_help_text( __( 'Optionally set a placeholder for the input.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input'
		), array(
			'field' => 'sgg_option_field_type',
			'value' => array( 'range', 'file' ),
			'compare' => 'NOT IN',
		))),
	Field::make( 'text', 'sgg_option_field_value', __( 'Value', 'staggs' ) )
		->set_help_text( __( 'Optionally set a default value for the input.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input'
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'file',
			'compare' => '!=',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
			'compare' => '!=',
		))),

	Field::make( 'select', 'sgg_option_datepicker_show_icon', __( 'Show datepicker icon', 'staggs' ) )
		->add_options( array( 
			'yes' => 'Yes',
			'no' => 'No',
		) )
		->set_help_text( __( 'Icon can be managed under Settings.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
		))),
	Field::make( 'select', 'sgg_option_datepicker_show_inline', __( 'Show datepicker inline', 'staggs' ) )
		->set_help_text( __( 'Replaces the input field with the inline datepicker.', 'staggs' ) )
		->add_options( array( 
			'yes' => 'Yes',
			'no' => 'No',
		) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
		))),

	Field::make( 'color', 'sgg_option_field_color', __( 'Color', 'staggs' ) )
		->set_help_text( __( 'Pick a color.', 'staggs' ) )
		->set_required( true )
		->set_conditional_logic( array(
			'relation' => 'OR',
			array(
				'field' => 'parent.sgg_attribute_type',
				'value' => 'color',
			),
			array(
				'field' => 'parent.sgg_step_template',
				'value' => 'swatches',
			)
		)),

	Field::make( 'select', 'sgg_option_calc_price_type', __( 'Price type', 'staggs' ) )
		->set_help_text( __( 'Items marked with option support user selection fields. Items marked with input support user input fields.', 'staggs' ) )
		->add_options( array(
			'single' => 'Fixed price (option, input)',
			'percentage' => 'Percentage price (option)',
			'formula' => 'Formula price (option)',
			'unit' => 'Unit price (input)',
			'table' => 'Table price (input)',
		)),

	Field::make( 'text', 'sgg_option_price', __( 'Price', 'staggs' ) )
		->set_help_text( __( 'Additional cost for this attribute item. Leave empty for no additional cost. Use decimal format (0.00)', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'single',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
			'compare' => '!=',
		))),
	Field::make( 'text', 'sgg_option_sale_price', __( 'Sale Price', 'staggs' ) )
		->set_help_text( __( 'Discounted additional cost for this attribute item. Must be lower than price.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'single',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
			'compare' => '!=',
		))),
	Field::make( 'text', 'sgg_option_percentage', __( 'Price percentage', 'staggs' ) )
		->set_help_text( __( 'Enter numeric percentage value of given price field.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'percentage',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
			'compare' => '!=',
		))),
	Field::make( 'text', 'sgg_option_percentage_field', __( 'Price field', 'staggs' ) )
		->set_help_text( __( 'Enter price field to base percentage on. Leave empty for total configuration price.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'percentage',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
			'compare' => '!=',
		))),
	Field::make( 'text', 'sgg_option_price_formula', __( 'Price formula', 'staggs' ) )
		->set_help_text( __( 'Enter formula to calculate the option price', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'formula',
		), array(
			'field' => 'sgg_option_field_type',
			'value' => 'date',
			'compare' => '!=',
		))),

	Field::make( 'select', 'sgg_option_price_table', __( 'Price table', 'staggs' ) )
		->set_options( 'get_tablepress_tables' )
		->set_help_text( __( 'Leave empty to disable price calculation.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'table',
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		))),
	Field::make( 'text', 'sgg_option_calc_price_value', __( 'Price per unit', 'staggs' ) )
		->set_help_text( __( 'Define fixed price per unit value. Important! Units should match.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'sgg_option_calc_price_type',
			'value' => 'unit'
		), array(
			'field' => 'parent.sgg_attribute_type',
			'value' => 'input',
		))),
	Field::make( 'text', 'sgg_option_weight', sprintf( __( 'Weight (%s)', 'staggs' ), $weight_unit ) )
		->set_help_text( __( 'Additional weight for this item. Use decimal format (0.00).', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => array( 'image', 'color' ),
			'compare' => 'IN'
		))),
	Field::make( 'text', 'sgg_option_stock_qty', __( 'Stock quantity', 'staggs' ) )
		->set_help_text( __( 'Current stock position.', 'staggs' ) )
		->set_conditional_logic( array( array(
			'field' => 'parent.sgg_attribute_type',
			'value' => array( 'image', 'color' ),
			'compare' => 'IN'
		))),
);

$option_fields = apply_filters( 'staggs_attribute_option_fields', $option_fields );

Container::make( 'post_meta', __( 'Attribute details', 'staggs' ) )
	->where( 'post_type', '=', 'sgg_attribute' )
	->set_classes( 'carbon_fields_staggs_attribute_details' )
	->add_tab( __( 'General', 'staggs' ), array(
		Field::make( 'text', 'sgg_step_title', __( 'Title', 'staggs' ) )
			->set_required( true )
			->set_help_text( __( 'This title as shown in the product configurator.', 'staggs' ) ),
		Field::make( 'select', 'sgg_step_template', __( 'Template', 'staggs' ) )
			->set_classes( 'sgg_step_template' )
			->set_help_text( __( 'Select how your attributes will be displayed.', 'staggs' ) )
			->set_default_value( 'image' )
			->add_options( array(
				'dropdown' => __( 'Dropdown', 'staggs' ),
				'options' => __( 'Options list', 'staggs' ),
				'cards' => __( 'Cards', 'staggs' ),
				'icons' => __( 'Image swatches', 'staggs' ),
				'swatches' => __( 'Color swatches', 'staggs' ),
				'button-group' => __( 'Button group', 'staggs' ),
				'tickboxes' => __( 'Tickboxes', 'staggs' ),
				'true-false' => __( 'True / False', 'staggs' ),
				'text-input' => __( 'Text field', 'staggs' ),
				'number-input' => __( 'Numeric field', 'staggs' ),
				'measurements' => __( 'Measurements', 'staggs' ),
				'image-upload' => __( 'Image upload', 'staggs' ),
				'product' => __( 'Related products', 'staggs' ),
			)),
		Field::make( 'select', 'sgg_attribute_type', __( 'Type', 'staggs' ) )
			->set_classes( 'sgg_attribute_type' )
			->set_help_text( __( 'Select attribute type to be used in the template. <a href="https://staggs.app/attribute-support-table" target="_blank">View attribute support table</a>', 'staggs' ) )
			->add_options( array(
				'image' => __( 'Image', 'staggs' ),
				'input' => __( 'Input', 'staggs' ),
				'color' => __( 'Color', 'staggs' ),
				'font'  => __( 'Font Family', 'staggs' ),
				'url'   => __( 'URL', 'staggs' ),
				'link'  => __( 'Product', 'staggs' ),
			)),
		Field::make( 'select', 'sgg_step_allowed_options', __( 'Option selection', 'staggs' ) )
			->set_help_text( __( 'Choose to allow single or multiple option selection', 'staggs' ) )
			->add_options( array(
				'single' => __( 'Single option', 'staggs' ),
				'multiple' => __( 'Multiple options', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'options', 'cards', 'icons', 'swatches', 'button-group' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_include_option_descriptions', __( 'Enable description for each individual option', 'staggs' ) )
			->set_help_text( __( 'Displays description field in each option to add extensive description', 'staggs' ) )
			->add_options( array(
				'hide' => __( 'No option descriptions', 'staggs' ),
				'show' => __( 'Enable option descriptions', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'options', 'cards', 'tickboxes', 'product' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_field_required', __( 'Required field', 'staggs' ) )
			->set_help_text( __( 'Select if the attribute is required or optional.', 'staggs' ) )
			->add_options( array(
				'no' => __( 'Optional', 'staggs' ),
				'yes' => __( 'Required', 'staggs' ),
			)),
		Field::make( 'text', 'sgg_step_field_placeholder', __( 'Dropdown placeholder', 'staggs' ) )
			->set_help_text( __( 'Optionally override placeholder text. Defaults to "- field label -"', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'dropdown'
			))),
		Field::make( 'complex', 'sgg_attribute_items', __( 'Items', 'staggs' ) )
			->set_max( 30 )
			->set_help_text( __( 'We support max. 30 options per attribute. Please install and migrate to ACF PRO if you want more options.', 'staggs' ) )
			->setup_labels( $item_labels )
			->add_fields( $option_fields )
		->set_header_template( '
			<% if (sgg_option_label) { %>
				<%- sgg_option_label %>
			<% } %>
		' )
	) )
	->add_tab( __( 'Presentation', 'staggs' ), array(
		Field::make( 'rich_text', 'sgg_step_short_description', __( 'Short description', 'staggs' ) )
			->set_help_text( __( 'Short description as shown below the title', 'staggs' ) ),
		Field::make( 'rich_text', 'sgg_step_description', __( 'Long Description (Panel):', 'staggs' ) )
			->set_help_text( __( 'Extensive description that will be displayed in popout panel.', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_sku', __( 'SKU', 'staggs' ) )
			->set_help_text( __( 'Optionally enter a SKU for the attribute', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_custom_class', __( 'Custom class', 'staggs' ) )
			->set_help_text( __( 'Optionally enter custom HTML class(es) for the attribute', 'staggs' ) ),
		Field::make( 'text', 'sgg_step_shared_group', __( 'Shared group name', 'staggs' ) )
			->set_help_text( __( 'Share attribute options with other attributes with same name.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'options', 'cards', 'icons', 'swatches', 'button-group' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_field_info', __( 'Show field info', 'staggs' ) )
			->set_help_text( __( 'Show min/max field value info label underneath input fields.', 'staggs' ) )
			->set_options( array(
				'yes' => __( 'Display field info labels', 'staggs' ),
				'no' => __( 'Hide field info labels', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_attribute_type',
				'value' => 'input',
			), array(
				'field' => 'sgg_step_template',
				'value' => 'image-upload',
				'compare' => '!='
			))),
		Field::make( 'select', 'sgg_step_style', __( 'Style', 'staggs' ) )
			->set_help_text( __( 'Modify the style setting for individual attributes display', 'staggs' ) )
			->add_options( array(
				'inherit' => __( 'Inherit from theme', 'staggs' ),
				'rounded' => __( 'Rounded', 'staggs' ),
				'squared' => __( 'Squared', 'staggs' ),
			)),
		Field::make( 'select', 'sgg_step_show_image', __( 'Display thumbnails', 'staggs' ) )
			->set_help_text( __( 'Display thumbnails in options', 'staggs' ) )
			->add_options( array(
				'show' => __( 'Show thumbnails', 'staggs' ),
				'hide' => __( 'Hide thumbnails', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'options', 'cards', 'product' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_option_layout', __( 'Cards width', 'staggs' ) )
			->set_help_text( __( 'Choose amount of cards next to each other.', 'staggs' ) )
			->add_options( array(
				'two' => __( '2 cards per row', 'staggs' ),
				'three' => __( '3 cards per row', 'staggs' ),
				'four' => __( '4 cards per row', 'staggs' ),
				'five' => __( '5 cards per row', 'staggs' ),
				'six' => __( '6 cards per row', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'cards',
			))),
		Field::make( 'select', 'sgg_step_card_template', __( 'Card template', 'staggs' ) )
			->set_help_text( __( 'Choose to show image inside card or not.', 'staggs' ) )
			->add_options( array(
				'default' => __( 'Show image inside card', 'staggs' ),
				'full' => __( 'Show image on top of card', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'cards',
			), array(
				'field' => 'sgg_step_show_image',
				'value' => 'show',
			))),
		Field::make( 'select', 'sgg_step_show_summary', __( 'Display summary', 'staggs' ) )
			->set_help_text( __( 'Display summary of selected option', 'staggs' ) )
			->add_options( array(
				'show' => __( 'Show summary', 'staggs' ),
				'show_all' => __( 'Show summary including notes', 'staggs' ),
				'hide' => __( 'Hide summary', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'dropdown', 'options', 'cards', 'icons', 'swatches', 'button-group' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_show_title', __( 'Display title', 'staggs' ) )
			->set_help_text( __( 'Choose to show or hide attribute title', 'staggs' ) )
			->add_options( array(
				'show' => __( 'Show title', 'staggs' ),
				'hide' => __( 'Hide title', 'staggs' ),
			) ),
		Field::make( 'select', 'sgg_step_show_input_label', __( 'Display input labels', 'staggs' ) )
			->set_help_text( __( 'Choose to show or hide input field labels', 'staggs' ) )
			->add_options( array(
				'show' => __( 'Show attribute input labels', 'staggs' ),
				'hide' => __( 'Hide attribute input labels', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'text-input', 'number-input', 'measurements', 'image-upload' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_show_tick_all', __( 'Enable tick all options', 'staggs' ) )
			->set_help_text( __( 'Display button to (de)select all options at once', 'staggs' ) )
			->add_options( array(
				'hide' => __( 'Hide tick all option', 'staggs' ),
				'show' => __( 'Show tick all option', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'tickboxes'
			))),
		Field::make( 'text', 'sgg_step_tick_all_label', __( 'Tick all options label', 'staggs' ) )
			->set_help_text( __( 'Label to display in tick all option.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_show_tick_all',
				'value' => 'show',
			),array(
				'field' => 'sgg_step_template',
				'value' => 'tickboxes'
			))),
		Field::make( 'select', 'sgg_step_show_option_price', __( 'Display option price', 'staggs' ) )
			->set_help_text( __( 'Optionally choose to hide prices for the customer.', 'staggs' ) )
			->add_options( array(
				'show' => __( 'Show prices', 'staggs' ),
				'hide' => __( 'Hide prices', 'staggs' ),
			) ),
		Field::make( 'select', 'sgg_step_swatch_size', __( 'Choose swatch size', 'staggs' ) )
			->set_help_text( __( 'Choose the size of your swatches', 'staggs' ) )
			->add_options( array(
				'inherit' => __( 'Default', 'staggs' ),
				'small' => __( 'Small', 'staggs' ),
				'regular' => __( 'Regular', 'staggs' ),
				'medium' => __( 'Medium', 'staggs' ),
				'large' => __( 'Large', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'icons', 'swatches' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_swatch_style', __( 'Swatch border position', 'staggs' ) )
			->set_help_text( __( 'Choose to show border inside or outside when checked', 'staggs' ) )
			->add_options( array(
				'outside' => __( 'Outside', 'staggs' ),
				'inside' => __( 'Inside', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'icons', 'swatches' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_show_swatch_label', __( 'Display inline swatch label', 'staggs' ) )
			->set_help_text( __( 'Shows label of swatch inline', 'staggs' ) )
			->add_options( array(
				'hide' => __( 'Hide inline labels', 'staggs' ),
				'show' => __( 'Show inline labels', 'staggs' ),
				'show_note' => __( 'Show inline notes', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'icons', 'swatches' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_show_tooltip', __( 'Display swatch tooltip', 'staggs' ) )
			->set_help_text( __( 'Show tooltip with value on hover', 'staggs' ) )
			->add_options( array(
				'show' => __( 'Show tooltip', 'staggs' ),
				'hide' => __( 'Hide tooltip', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'icons', 'swatches' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_tooltip_template', __( 'Tooltip display', 'staggs' ) )
			->set_help_text( __( 'Choose what is included in the tooltip', 'staggs' ) )
			->add_options( array(
				'simple' => __( 'Show label and price', 'staggs' ),
				'extended' => __( 'Show icon, label and price', 'staggs' ),
				'text' => __( 'Show label, note and price', 'staggs' ),
				'full' => __( 'Show icon, label, note and price', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'icons', 'swatches' ),
				'compare' => 'IN',
			), array(
				'field' => 'sgg_step_show_tooltip',
				'value' => 'show',
			))),
		Field::make( 'select', 'sgg_step_enable_zoom', __( 'Enable zoom function', 'staggs' ) )
			->set_help_text( __( 'Show zoom icon on hover to enlarge the image', 'staggs' ) )
			->add_options( array(
				'hide' => __( 'No zoom function', 'staggs' ),
				'show' => __( 'Enable zoom function', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'options', 'cards', 'icons', 'product' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_product_template', __( 'Product display', 'staggs' ) )
			->set_help_text( __( 'Choose how to display the product', 'staggs' ) )
			->add_options( array(
				'option' => __( 'Horizontal display (option style)', 'staggs' ),
				'card' => __( 'Vertical display (card style)', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'product',
			))),
		Field::make( 'select', 'sgg_step_button_view', __( 'Button view', 'staggs' ) )
			->set_help_text( __( 'Select how you want the item to be displayed', 'staggs' ) )
			->set_options( array(
				'button' => __( 'Button', 'staggs' ),
				'toggle' => __( 'Toggle', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'true-false',
			))),
		Field::make( 'text', 'sgg_step_button_add', __( 'Button add text', 'staggs' ) )
			->set_help_text( __( 'Enter text when option is not selected.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'true-false',
			))),
		Field::make( 'text', 'sgg_step_button_del', __( 'Button remove text', 'staggs' ) )
			->set_help_text( __( 'Enter text when option is selected.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => 'true-false',
			))),
		Field::make( 'text', 'sgg_step_shared_option_min', __( 'Shared option min', 'staggs' ) )
			->set_help_text( __( 'Optionally enter minimum allowed option selection.', 'staggs' ) )
			->set_conditional_logic( array(
				'relation' => 'OR',
				array(
					'field' => 'sgg_step_allowed_options',
					'value' => 'multiple',
				),
				array(
					'field' => 'sgg_step_template',
					'value' => 'tickboxes',
				)
			)),
		Field::make( 'text', 'sgg_step_shared_option_max', __( 'Shared option max', 'staggs' ) )
			->set_help_text( __( 'Optionally enter maximum allowed option selection.', 'staggs' ) )
			->set_conditional_logic( array(
				'relation' => 'OR',
				array(
					'field' => 'sgg_step_allowed_options',
					'value' => 'multiple',
				),
				array(
					'field' => 'sgg_step_template',
					'value' => 'tickboxes',
				)
			)),
		Field::make( 'text', 'sgg_step_shared_field_min', __( 'Shared field min', 'staggs' ) )
			->set_help_text( __( 'Optionally enter shared minimum field value across all attribute inputs.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'number-input', 'measurements', 'product' ),
				'compare' => 'IN',
			))),
		Field::make( 'text', 'sgg_step_shared_field_max', __( 'Shared field max', 'staggs' ) )
			->set_help_text( __( 'Optionally enter shared maximum field value across all attribute inputs.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_template',
				'value' => array( 'number-input', 'measurements', 'product' ),
				'compare' => 'IN',
			))),
	) )
	->add_tab( __( 'Gallery', 'staggs' ), array(

		Field::make( 'select', 'sgg_gallery_type', __( 'Gallery type', 'staggs' ) )
			->set_help_text( __( 'Define configurator gallery type.', 'staggs' ) )
			->set_default_value( 'image' )
			->add_options( array(
				'image' => __( 'Image', 'staggs' ),
				'3dmodel' => __( '3D model', 'staggs' ),
			)),
		Field::make( 'text', 'sgg_step_preview_order', __( 'Image Layer Order:', 'staggs' ) )
			->set_help_text( __( 'Higher numbers will be displayed on top.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			))),
		Field::make( 'text', 'sgg_step_preview_index', __( 'Display Images On Slides:', 'staggs' ) )
			->set_attribute( 'placeholder', 'e.g. 1, 2, 5' )
			->set_help_text( __( 'Slides the main image will appear on. Defaults to first slide (1).', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			))),
		Field::make( 'text', 'sgg_step_preview_slide', __( 'Make Slide Active:', 'staggs' ) )
			->set_help_text( __( 'Index of product image slide to show when viewing this step.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			))),
		Field::make( 'text', 'sgg_step_preview_ref', __( 'Gallery Preview Reference:', 'staggs' ) )
			->set_help_text( __( 'Gallery preview reference. Use for text or image preview updates (supports comma separated values)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			))),
		Field::make( 'text', 'sgg_step_preview_ref_props', __( 'Gallery Preview Properties:', 'staggs' ) )
			->set_help_text( __( 'Enter preview CSS properties, like color, width or height (supports comma separated values)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			))),
		Field::make( 'select', 'sgg_step_preview_bundle', __( 'Gallery Preview Bundle:', 'staggs' ) )
			->set_help_text( __( 'This will bundle all input previews together in the first defined position.', 'staggs' ) )
			->set_options( array(
				'no' => __( 'No', 'staggs' ),
				'yes' => __( 'Yes', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			), array(
				'field' => 'sgg_attribute_type',
				'value' => 'input',
			))),
		Field::make( 'text', 'sgg_step_preview_height', __( 'Gallery Preview Height:', 'staggs' ) )
			->set_help_text( __( 'Optionally define the allowed height of all input previews together. Use CSS units.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => 'image',
			), array(
				'field' => 'sgg_attribute_type',
				'value' => 'input',
			), array(
				'field' => 'sgg_step_preview_bundle',
				'value' => 'yes',
			))),
		Field::make( 'text', 'sgg_step_model_group', __( '3D Model Group Label:', 'staggs' ) )
			->set_help_text( __( '3D model material label(s). Supports comma separated values.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'select', 'sgg_step_model_image_type', __( '3D Model Part:', 'staggs' ) )
			->set_help_text( __( 'Part of the 3D model to update.', 'staggs' ) )
			->set_options( array(
				'variant' => __( 'Model variant', 'staggs' ),
				'node' => __( 'Model node', 'staggs' ),
				'material' => __( 'Model material', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'select', 'sgg_step_model_image_material', __( '3D Model Material Type:', 'staggs' ) )
			->set_help_text( __( 'Select how to update the part.', 'staggs' ) )
			->set_options( array(
				'color' => __( 'Base Color', 'staggs' ),
				'base' => __( 'Base Texture', 'staggs' ),
				'metallic' => __( 'Metallic Texture', 'staggs' ),
				'normal' => __( 'Normal Texture', 'staggs' ),
				'occlusion' => __( 'Occlusion Texture', 'staggs' ),
				'emissive' => __( 'Emissive Texture', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_image_type',
				'value' => 'material',
			))),
		Field::make( 'text', 'sgg_step_model_material_metalness', __( '3D Model Material Metalness:', 'staggs' ) )
			->set_help_text( __( 'Optionally set 3D model material metaless value. Accepts value between 0.00 and 1.00.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_step_model_material_roughness', __( '3D Model Material Roughness:', 'staggs' ) )
			->set_help_text( __( 'Optionally set 3D model material roughness value. Accepts value between 0.00 and 1.00.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_step_model_image_target', __( '3D Model Camera Target:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model camera target when option is selected.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_step_model_image_orbit', __( '3D Model Camera Orbit:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model camera orbit when option is selected.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_step_model_image_view', __( '3D Model Camera Field of View:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model camera field of view when option is selected.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			))),
		Field::make( 'select', 'sgg_step_model_extensions', __( '3D Model Extensions:', 'staggs' ) )
			->set_help_text( __( 'Optionally show advanced control fields for supported 3D model extensions.', 'staggs' ) )
			->set_options( array(
				'hide' => __( 'Hide extension fields', 'staggs' ),
				'show' => __( 'Show extension fields', 'staggs' ),
			) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_image_type',
				'value' => 'material',
			))),
		Field::make( 'text', 'sgg_step_model_ext_ior', __( '3D Model Ior:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model ior extension value. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_clearcoat', __( '3D Model Clearcoat Factor:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model clearcoat factor. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_transmission', __( '3D Model Transmission Factor:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model transmission factor. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_thickness', __( '3D Model Thickness Factor:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model thickness factor. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_specular', __( '3D Model Specular Factor:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model specular factor. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_specular_color', __( '3D Model Specular Color:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model specular color. Enter color string (e.g. #111 or [1, 0.5, 0.5])', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_attenuation_dist', __( '3D Model Attenuation Distance:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model attenuation distance. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_attenuation_color', __( '3D Model Attenuation Color:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model attenuation color. Enter color string (e.g. #111 or [1, 0.5, 0.5])', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_sheen_color', __( '3D Model Sheen Color:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model sheen color. Enter color string (e.g. #111 or [1, 0.5, 0.5])', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
		Field::make( 'text', 'sgg_step_model_ext_sheen_roughness', __( '3D Model Sheen Roughness:', 'staggs' ) )
			->set_help_text( __( 'Change 3D model sheen roughness. Enter float value (e.g. 1.0)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_gallery_type',
				'value' => '3dmodel',
			), array(
				'field' => 'sgg_step_model_extensions',
				'value' => 'show'
			))),
	))
	->add_tab( __( 'Advanced Calculation', 'staggs' ), array(

		Field::make( 'select', 'sgg_step_calc_price_type', __( 'Price type', 'staggs' ) )
			->set_help_text( __( 'Optionally choose to set custom price calculation for this attribute. Choose matrix to pick a price based on two values', 'staggs' ) )
			->add_options( array(
				'none'    => 'Default calculation',
				'formula' => 'Formula',
				'matrix'  => 'Matrix',
				'formula-matrix' => 'Formula + Matrix',
			)),
		Field::make( 'text', 'sgg_step_calc_price_key', __( 'Price key', 'staggs' ) )
			->set_help_text( __( 'Optionally set price key to use in the total price calculation formula', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula', 'formula-matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_calc_price_label_position', __( 'Price label position', 'staggs' ) )
			->set_help_text( __( 'Choose to show price label and calculated price above or below the field.', 'staggs' ) )
			->set_options( array(
				'above' => 'Above attribute field',
				'below' => 'Below attribute field',
				'inside' => 'Replace attribute price',
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula', 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'text', 'sgg_step_calc_price_label', __( 'Price label', 'staggs' ) )
			->set_help_text( __( 'Optionally set price label to show calculated price to user in configuration form.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula', 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			), array(
				'field' => 'sgg_step_calc_price_label_position',
				'value' => 'inside',
				'compare' => '!=',
			))),
		Field::make( 'text', 'sgg_step_price_formula', __( 'Formula', 'staggs' ) )
			->set_help_text( __( 'Describe formula of field keys for price calculation (e.g. A + B * C)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula', 'formula-matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table', __( 'Price table', 'staggs' ) )
			->set_options( 'get_tablepress_tables' )
			->set_help_text( __( 'Leave empty to disable price calculation.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table_sale', __( 'Sale price table', 'staggs' ) )
			->set_options( 'get_tablepress_tables' )
			->set_help_text( __( 'Leave empty to disable table sale price calculation.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table_type', __( 'Price table type', 'staggs' ) )
			->set_options( array(
				'lookup'   => __( 'Look up total price in table', 'staggs' ),
				'multiply' => __( 'Multiply price by total measurement value (A+B)', 'staggs' ),
				'doublemultiply' => __( 'Multiply price by measurement values (A*B)', 'staggs' ),
			) )
			->set_help_text( __( 'Choose price table calculation type.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table_rounding', __( 'Price table roundings', 'staggs' ) )
			->set_options( array(
				'down' => __( 'Round values down', 'staggs' ),
				'up' => __( 'Round values up', 'staggs' ),
			) )
			->set_help_text( __( 'Choose price table roundings behaviour.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table_range', __( 'Price table range', 'staggs' ) )
			->set_options( array(
				'exclude' => __( 'Return empty when value is out of range', 'staggs' ),
				'include' => __( 'Use minimum and maximum values in table when value is out of range', 'staggs' ),
			))
			->set_help_text( __( 'Choose price table value range behaviour.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'text', 'sgg_step_price_table_val_x', __( 'Input value X', 'staggs' ) )
			->set_help_text( __( 'Horizontal matrix value. Use field key or group name (e.g. attribute-name)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table_type_x', __( 'Input type X', 'staggs' ) )
			->set_help_text( __( 'Horizontal matrix value type', 'staggs' ) )
			->set_options( array(
				'numeric' => __( 'Numeric', 'staggs' ),
				'text' => __( 'Text', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'text', 'sgg_step_price_table_val_y', __( 'Input value Y', 'staggs' ) )
			->set_help_text( __( 'Vertical matrix value. Use field key or group name (e.g. attribute-name)', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'select', 'sgg_step_price_table_type_y', __( 'Input type Y', 'staggs' ) )
			->set_help_text( __( 'Vertical matrix value type', 'staggs' ) )
			->set_options( array(
				'numeric' => __( 'Numeric', 'staggs' ),
				'text' => __( 'Text', 'staggs' ),
			))
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
		Field::make( 'text', 'sgg_step_price_table_val_min', __( 'Minimum extra price', 'staggs' ) )
			->set_help_text( __( 'Optionally enter a minimum extra price to charge for this attribute.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_step_calc_price_type',
				'value' => array( 'formula-matrix', 'matrix' ),
				'compare' => 'IN',
			))),
	));