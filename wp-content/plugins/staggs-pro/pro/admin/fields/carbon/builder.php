<?php

/**
 * Provide a admin-facing view for the Product Builder Fields form of the plugin
 *
 * This file is used to markup the admin-facing product builder form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.4.4
 *
 * @package    Staggs
 * @subpackage Staggs/admin/fields
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$step_labels = array(
	'plural_name' => __( 'Steps', 'staggs' ),
	'singular_name' => __( 'Step', 'staggs' ),
);
$attribute_labels = array(
	'plural_name' => __( 'New', 'staggs' ),
	'singular_name' => __( 'New', 'staggs' ),
);
$tab_labels = array(
	'plural_name' => __( 'Tabs', 'staggs' ),
	'singular_name' => __( 'Tab', 'staggs' ),
);
$repeater_labels = array(
	'plural_name' => __( 'Attributes', 'staggs' ),
	'singular_name' => __( 'Attribute', 'staggs' ),
);
$rule_labels = array(
	'plural_name' => __( 'Conditional Rules', 'staggs' ),
	'singular_name' => __( 'Conditional Rule', 'staggs' ),
);
$option_labels = array(
	'plural_name' => __( 'Options', 'staggs' ),
	'singular_name' => __( 'Option', 'staggs' ),
);

$sgg_groups_collapsed = staggs_get_theme_option( 'sgg_admin_complex_groups_collapsed' ) ? 1 : 0;
$sgg_subgroups_collapsed = staggs_get_theme_option( 'sgg_admin_complex_subgroups_collapsed' ) ? 1 : 0;

/**
 * Builder meta
 */

Container::make( 'post_meta', __( 'Staggs Configurator Builder', 'staggs' ) )
	->set_classes( 'carbon_fields_staggs_configurator_builder' )
	->where( 'post_type', 'IN', array( 'product', 'sgg_product' ) )
	->add_fields( array(

		Field::make( 'select', 'sgg_product_configurator_theme_id', __( 'Configurator Theme', 'staggs' ) )
			->set_help_text( __( 'Choose your Staggs configurator template. <br><a href="' . admin_url( '/edit.php?post_type=sgg_theme' ) . '" target="_blank">Manage templates</a>', 'staggs' ) )
			->add_options( 'get_configurator_themes_options' ),

		Field::make( 'select', 'sgg_configurator_type', __( 'Configurator Type', 'staggs' ) )
			->set_help_text( __( 'Choose your configurator type', 'staggs' ) )
			->add_options( array(
				'image' => __( 'Image', 'staggs' ),
				'3dmodel' => __( '3D model', 'staggs' ),
			) ),
		Field::make( 'file', 'sgg_configurator_3d_model', __( '3D model file' ) )
			->set_help_text( __( 'Add your 3D configurator model here', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_type',
				'value' => '3dmodel',
			))),
		Field::make( 'image', 'sgg_configurator_3d_model_poster', __( '3D model loading image' ) )
			->set_help_text( __( 'Displays a loading image when the 3D model is being loaded in. Defaults to product thumbnail.', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_3d_nodes', __( '3D model nodes' ) )
			->set_help_text( __( 'Define nodes to show by default', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_type',
				'value' => '3dmodel',
			))),
		Field::make( 'text', 'sgg_configurator_3d_hotspots', __( '3D model hotspots' ) )
			->set_help_text( __( 'Define 3D model hotspots to show by default', 'staggs' ) )
			->set_conditional_logic( array( array(
				'field' => 'sgg_configurator_type',
				'value' => '3dmodel',
			))),

		Field::make( 'text', 'sgg_configurator_min_price', __( 'Product Configurator Min Price', 'staggs' ) )
			->set_help_text( __( 'Optionally set fixed price (0.00) or enter comma separated list of attributes', 'staggs' ) ),
		Field::make( 'text', 'sgg_configurator_max_price', __( 'Product Configurator Max Price', 'staggs' ) )
			->set_help_text( __( 'Fixed price or list. Control display format in Staggs -> Settings -> WooCommerce', 'staggs' ) ),
		Field::make( 'text', 'sgg_configurator_sku', __( 'Product Configurator SKU', 'staggs' ) )
			->set_help_text( __( 'Optionally enter custom SKU format to generate for this product. (E.g. 400-11-{title1}-{title2})', 'staggs' ) ),
		Field::make( 'select', 'sgg_configurator_total_price_table', __( 'Total Price Table', 'staggs' ) )
			->set_help_text( __( 'Optionally override price table on product level. Needs to be activated in Template > Configurator price.', 'staggs' ) )
			->set_options( 'get_tablepress_tables' ),

		Field::make( 'complex', 'sgg_configurator_attributes', __( 'Product Attributes', 'staggs' ) )
			->setup_labels( $attribute_labels )
			->set_classes( 'staggs-product-builder' )
			->set_collapsed($sgg_groups_collapsed)
			->add_fields( 'separator', array(
				Field::make( 'text', 'sgg_step_separator_title', __( 'Attribute separator title', 'staggs' ) )
					->set_help_text( __( 'Title as displayed above attributes', 'staggs' ) ),
				Field::make( 'image', 'sgg_step_separator_icon', __( 'Attribute separator icon', 'staggs' ) )
					->set_help_text( __( 'Optionally upload step icon. Replaces the step number', 'staggs' ) ),
				Field::make( 'checkbox', 'sgg_step_separator_collapsible', __( 'Make attribute separator collapsible', 'staggs' ) )
					->set_help_text( __( 'Will add collapsible icon when enabled', 'staggs' ) ),
				Field::make( 'radio', 'sgg_step_collapsible_state', __( 'Choose default state', 'staggs' ) )
					->set_help_text( __( 'Choose to show or hide attribute group by default', 'staggs' ) )
					->add_options( array(
						'open' => __( 'Opened', 'staggs' ),
						'collapsed' => __( 'Collapsed', 'staggs' ),
					))
					->set_conditional_logic( array( array(
						'field' => 'sgg_step_separator_collapsible',
						'value' => true
					)))
			))
			->set_header_template( '
				<% if (sgg_step_separator_title) { %>
					<%- sgg_step_separator_title %>
				<% } else { %>
					Separator
				<% }
			' )
			->add_fields( 'tabs', array(
				Field::make( 'complex', 'sgg_step_tab_options', __( 'Tabs', 'staggs' ) )
					->set_help_text( __( 'Define the attribute tabs and link to the attribute', 'staggs' ) )
					->setup_labels( $tab_labels )
					->add_fields( array(
						Field::make( 'text', 'sgg_step_tab_title', __( 'Attribute Tab Title', 'staggs' ) )
							->set_width( 50 )
							->set_help_text( __( 'Title as displayed in the tab', 'staggs' ) )
							->set_classes( 'conditional-tab-title' ),
						Field::make( 'text', 'sgg_step_tab_preview_slide', __( 'Tab Make Slide Active', 'staggs' ) )
							->set_width( 50 )
							->set_help_text( __( 'Index of product image slide to show when clicking this tab', 'staggs' ) )
							->set_classes( 'conditional-tab-preview' ),
						Field::make( 'multiselect', 'sgg_step_tab_attribute', __( 'Tab linked attribute', 'staggs' ) )
							->set_help_text( __( 'Select your attribute group that will be shown when tab is active.', 'staggs' ) )
							->add_options( 'get_configurator_attribute_values' )
							->set_classes( 'conditional-tab-attribute' ),
					))
			))
			->add_fields( 'repeater', array(
				Field::make( 'text', 'sgg_step_repeater_title', __( 'Repeater title', 'staggs' ) )
					->set_help_text( __( 'Title that shows above the repeatable items.', 'staggs' ) )
					->set_required( true ),
				Field::make( 'text', 'sgg_step_repeater_empty_note', __( 'Repeater empty message', 'staggs' ) )
					->set_attribute( 'placeholder', __( 'Click add row to add your first item.', 'staggs' ) )
					->set_help_text( __( 'Message that shows up when repeater has no items.', 'staggs' ) ),
				Field::make( 'text', 'sgg_step_repeater_add_text', __( 'Add button text', 'staggs' ) )
					->set_help_text( __( 'Text on button to add new repeatable group', 'staggs' ) ),
				Field::make( 'complex', 'sgg_step_repeater_attributes', __( 'Attributes', 'staggs' ) )
					->set_help_text( __( 'Define the repeatable attributes', 'staggs' ) )
					->set_collapsed($sgg_subgroups_collapsed)
					->setup_labels( $repeater_labels )
					->add_fields( array(
						Field::make( 'select', 'sgg_step_attribute', __( 'Select attribute', 'staggs' ) )
							->set_help_text( __( 'Select your attribute group', 'staggs' ) )
							->set_classes( 'conditional-repeater-attribute-select' )
							->add_options( 'get_configurator_attribute_values' ),
					)),
				Field::make( 'checkbox', 'sgg_step_conditional_logic', __( 'Set conditional logic', 'staggs' ) )
					->set_help_text( __( 'Enable conditional logic if you want to conditionally show this field', 'staggs' ) )
					->set_option_value( 'yes' ),
				Field::make( 'complex', 'sgg_step_conditional_rules', __( 'Conditional rules', 'staggs' ) )
					->set_help_text( __( 'Add conditional rules', 'staggs' ) )
					->set_classes( 'base-attribute-display-rules' )
					->setup_labels( $rule_labels )
					->set_collapsed($sgg_subgroups_collapsed)
					->add_fields( array(
						Field::make( 'select', 'sgg_step_conditional_step', __( 'Step name', 'staggs' ) )
							->set_classes('conditional-step-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'IN',
							))),
						Field::make( 'select', 'sgg_step_conditional_input', __( 'Input name', 'staggs' ) )
							->set_classes('conditional-step-input')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_inputs' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_step_conditional_compare', __( 'Compares to', 'staggs' ) )
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
								'!contains' => 'Not contains'
							))
							->set_width( 20 )
							->set_classes('conditional-compare-select'),
						Field::make( 'select', 'sgg_step_conditional_value', __( 'Step value', 'staggs' ) )
							->set_classes('conditional-value-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_item_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=' ),
								'compare' => 'IN',
							))),
						Field::make( 'text', 'sgg_step_conditional_input_value', __( 'Input value', 'staggs' ) )
							->set_classes('conditional-value-input')
							->set_width( 25 )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_step_conditional_relation', __( 'Relation', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'or' => 'OR',
								'and' => 'AND',
							))
							->set_classes('conditional-relation-select'),
						Field::make( 'select', 'sgg_step_conditional_link', __( 'Start new ruleset', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'no' => 'No',
								'yes' => 'Yes',
							))
							->set_classes('conditional-relation-link'),
					))
					->set_conditional_logic( array( array(
						'field' => 'sgg_step_conditional_logic',
						'value' => true
					))),

			))
			->set_header_template( '
				<% if (sgg_step_repeater_title) { %>
					<%- sgg_step_repeater_title %>
				<% } else { %>
					Repeater
				<% } %>
			' )
			->add_fields( 'attribute', array(
				Field::make( 'select', 'sgg_step_attribute', __( 'Select attribute', 'staggs' ) )
					->set_help_text( __( 'Select your attribute group', 'staggs' ) )
					->set_classes( 'base-attribute-select' )
					->add_options( 'get_configurator_attribute_values' ),

				Field::make( 'checkbox', 'sgg_step_attribute_hidden', __( 'Hide attribute', 'staggs' ) )
					->set_help_text( __( 'Hides the attribute in configurator when enabled', 'staggs' ) ),

				Field::make( 'checkbox', 'sgg_step_attribute_default_value', __( 'Set default attribute option', 'staggs' ) )
					->set_help_text( __( 'Allows you to change the default attribute option for the given attribute', 'staggs' ) )
					->set_classes( 'default-attribute-value-checkbox' ),

				Field::make( 'select', 'sgg_step_attribute_value', __( 'Select default option', 'staggs' ) )
					->set_help_text( __( 'Select your attribute default option', 'staggs' ) )
					->set_classes( 'base-attribute-option-select' )
					->add_options( 'get_configurator_attribute_item_values' )
					->set_conditional_logic( array( array(
						'field' => 'sgg_step_attribute_default_value',
						'value' => true
					))),

				Field::make( 'checkbox', 'sgg_step_attribute_collapsible', __( 'Make attribute collapsible', 'staggs' ) )
					->set_help_text( __( 'Will add collapsible icon when enabled', 'staggs' ) ),

				Field::make( 'radio', 'sgg_step_attribute_state', __( 'Choose default state', 'staggs' ) )
					->set_help_text( __( 'Choose to show or hide attribute group by default', 'staggs' ) )
					->add_options( array(
						'open' => __( 'Opened', 'staggs' ),
						'collapsed' => __( 'Collapsed', 'staggs' ),
					))
					->set_conditional_logic( array( array(
						'field' => 'sgg_step_attribute_collapsible',
						'value' => true
					))),

				Field::make( 'checkbox', 'sgg_step_conditional_logic', __( 'Set conditional logic', 'staggs' ) )
					->set_help_text( __( 'Enable conditional logic if you want to conditionally show this field', 'staggs' ) )
					->set_option_value( 'yes' ),

				Field::make( 'complex', 'sgg_step_conditional_rules', __( 'Conditional rules', 'staggs' ) )
					->set_help_text( __( 'Add conditional rules', 'staggs' ) )
					->set_classes( 'base-attribute-display-rules' )
					->setup_labels( $rule_labels )
					->set_collapsed($sgg_subgroups_collapsed)
					->add_fields( array(
						Field::make( 'select', 'sgg_step_conditional_step', __( 'Step name', 'staggs' ) )
							->set_classes('conditional-step-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'IN',
							))),
						Field::make( 'select', 'sgg_step_conditional_input', __( 'Input name', 'staggs' ) )
							->set_classes('conditional-step-input')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_conditional_inputs' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_step_conditional_compare', __( 'Compares to', 'staggs' ) )
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
								'!contains' => 'Not contains'
							))
							->set_width( 20 )
							->set_classes('conditional-compare-select'),
						Field::make( 'select', 'sgg_step_conditional_value', __( 'Step value', 'staggs' ) )
							->set_classes('conditional-value-select')
							->set_width( 25 )
							->add_options( 'get_configurator_attribute_item_values' )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=' ),
								'compare' => 'IN',
							))),
						Field::make( 'text', 'sgg_step_conditional_input_value', __( 'Input value', 'staggs' ) )
							->set_classes('conditional-value-input')
							->set_width( 25 )
							->set_conditional_logic( array( array(
								'field' => 'sgg_step_conditional_compare',
								'value' => array( '=', '!=', 'empty', '!empty' ),
								'compare' => 'NOT IN',
							))),
						Field::make( 'select', 'sgg_step_conditional_relation', __( 'Relation', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'or' => 'OR',
								'and' => 'AND',
							))
							->set_classes('conditional-relation-select'),
						Field::make( 'select', 'sgg_step_conditional_link', __( 'Start new ruleset', 'staggs' ) )
							->set_width( 15 )
							->add_options( array(
								'no' => 'No',
								'yes' => 'Yes',
							))
							->set_classes('conditional-relation-link'),
					))
					->set_conditional_logic( array( array(
						'field' => 'sgg_step_conditional_logic',
						'value' => true
					))),

				Field::make( 'checkbox', 'sgg_step_option_conditional_logic', __( 'Set option conditional display', 'staggs' ) )
					->set_help_text( __( 'Enable option conditional logic if you want to conditionally show options in this field', 'staggs' ) )
					->set_classes( 'base-attribute-option-checkbox' ),

				Field::make( 'complex', 'sgg_step_option_conditional_display', __( 'Option conditional display', 'staggs' ) )
					->set_help_text( __( 'Add option conditional display rules', 'staggs' ) )
					->setup_labels( $option_labels )
					->set_collapsed($sgg_subgroups_collapsed)
					->set_min( 1 )
					->set_classes( 'base-attribute-option-rules' )
					->add_fields( array(

						Field::make( 'select', 'sgg_step_conditional_option', __( 'Select option', 'staggs' ) )
							->set_help_text( __( 'Select your attribute option to apply display logic to', 'staggs' ) )
							->set_classes( 'conditional-attribute-option-select' )
							->add_options( 'get_configurator_attribute_item_values' ),

						Field::make( 'checkbox', 'sgg_step_conditional_default_option', __( 'Include option as default value', 'staggs' ) )
							->set_classes('conditional-compare-select')
							->set_conditional_logic( array( array(
								'field' => 'parent.sgg_step_attribute_default_value',
								'value' => true
							))),

						Field::make( 'complex', 'sgg_step_option_conditional_rules', __( 'Conditional rules', 'staggs' ) )
							->set_help_text( __( 'Add conditional rules', 'staggs' ) )
							->set_classes( 'conditional-attribute-option-rules' )
							->setup_labels( $rule_labels )
							->add_fields( array(

								Field::make( 'select', 'sgg_step_conditional_step', __( 'Step name', 'staggs' ) )
									->set_classes('conditional-step-select')
									->set_width( 25 )
									->add_options( 'get_configurator_attribute_conditional_values' )
									->set_conditional_logic( array( array(
										'field' => 'sgg_step_conditional_compare',
										'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
										'compare' => 'IN',
									))),
								Field::make( 'select', 'sgg_step_conditional_input', __( 'Input name', 'staggs' ) )
									->set_classes('conditional-step-input')
									->set_width( 25 )
									->add_options( 'get_configurator_attribute_conditional_inputs' )
									->set_conditional_logic( array( array(
										'field' => 'sgg_step_conditional_compare',
										'value' => array( '=', '!=', 'empty', '!empty', 'contains', '!contains' ),
										'compare' => 'NOT IN',
									))),
								Field::make( 'select', 'sgg_step_conditional_compare', __( 'Compares to', 'staggs' ) )
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
								Field::make( 'select', 'sgg_step_conditional_value', __( 'Step value', 'staggs' ) )
									->set_classes('conditional-value-select')
									->set_width( 25 )
									->add_options( 'get_configurator_attribute_item_values' )
									->set_conditional_logic( array( array(
										'field' => 'sgg_step_conditional_compare',
										'value' => array( '=', '!=' ),
										'compare' => 'IN',
									))),
								Field::make( 'text', 'sgg_step_conditional_input_value', __( 'Input value', 'staggs' ) )
									->set_classes('conditional-value-input')
									->set_width( 25 )
									->set_conditional_logic( array( array(
										'field' => 'sgg_step_conditional_compare',
										'value' => array( '=', '!=', 'empty', '!empty' ),
										'compare' => 'NOT IN',
									))),
								Field::make( 'select', 'sgg_step_conditional_relation', __( 'Relation', 'staggs' ) )
									->set_width( 15 )
									->add_options( array(
										'or' => 'OR',
										'and' => 'AND',
									))
									->set_classes('conditional-relation-select'),
								Field::make( 'select', 'sgg_step_conditional_link', __( 'Start new ruleset', 'staggs' ) )
									->set_width( 15 )
									->add_options( array(
										'no' => 'No',
										'yes' => 'Yes',
									))
									->set_classes('conditional-relation-link'),
						))
					))
					->set_conditional_logic( array( array(
						'field' => 'sgg_step_option_conditional_logic',
						'value' => true
					)))
			))
			->add_fields( 'summary', array(
				Field::make( 'html', 'sgg_configurator_steps_summary')
					->set_html( '<p>Displays a summary of selected configuration items.</p>' )
					->set_help_text( __( 'Configuration summary', 'staggs' ) ),
			))
			->add_fields( 'shortcode', array(
				Field::make( 'text', 'sgg_step_shortcode', __( 'Shortcode', 'staggs' ))
					->set_help_text( __( 'Enter any shortcode', 'staggs' ) ),
			))
			->add_fields( 'html', array(
				Field::make( 'textarea', 'sgg_step_html', __( 'Custom HTML', 'staggs' ))
					->set_help_text( __( 'Enter any HTML contents', 'staggs' ) ),
			))
	));
