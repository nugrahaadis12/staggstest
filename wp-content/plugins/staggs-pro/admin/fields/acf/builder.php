<?php

/**
 * Provide a admin-facing view for the Product Builder Fields form of the plugin
 *
 * This file is used to markup the admin-facing product builder form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.5.0
 *
 * @package    Staggs
 * @subpackage Staggs/admin/fields
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

$sgg_select_two = staggs_get_theme_option( 'sgg_admin_enable_select_two' ) ? 1 : 0;

acf_add_local_field_group( array(
	'key' => 'group_64c55393b75f2',
	'title' => 'Staggs Configurator Builder',
	'fields' => array(
		array(
			'key' => 'field_64c554de9479c',
			'label' => 'Configurator Template',
			'name' => 'sgg_product_configurator_theme_id',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => 'Choose your Staggs configurator template.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(),
			'default_value' => false,
			'return_format' => 'value',
			'multiple' => 0,
			'allow_null' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_64c5539494791',
			'label' => 'Product Configurator Type',
			'name' => 'sgg_configurator_type',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => 'Choose your configurator type',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'image' => 'Image',
			),
			'default_value' => false,
			'return_format' => 'value',
			'multiple' => 0,
			'allow_null' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_64c5539494798',
			'label' => 'Product Configurator Min Price',
			'name' => 'sgg_configurator_min_price',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'Optionally set fixed price (0.00) or enter comma separated list of attributes',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_64c5539494799',
			'label' => 'Product Configurator Max Price',
			'name' => 'sgg_configurator_max_price',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'Fixed price or list. Control display format in Staggs -> Settings -> WooCommerce',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_64c555129479d',
			'label' => 'Product Attributes',
			'name' => 'sgg_configurator_attributes',
			'aria-label' => '',
			'type' => 'flexible_content',
			'instructions' => 'Build your product configurator with the created attributes.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layouts' => array(
				'layout_64c5552ac6acd' => array(
					'key' => 'layout_64c5552ac6acd',
					'name' => 'separator',
					'label' => 'Separator',
					'display' => 'row',
					'sub_fields' => array(
						array(
							'key' => 'field_64c5553a9479e',
							'label' => 'Attribute separator title',
							'name' => 'sgg_step_separator_title',
							'aria-label' => '',
							'type' => 'text',
							'instructions' => 'Title as displayed above attributes',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
						array(
							'key' => 'field_64c5555f9479f',
							'label' => 'Make attribute separator collapsible',
							'name' => 'sgg_step_separator_collapsible',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => 'Will add collapsible icon when enabled',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
							'ui' => 1,
						),
						array(
							'key' => 'field_64c55583947a0',
							'label' => 'Choose default state',
							'name' => 'sgg_step_collapsible_state',
							'aria-label' => '',
							'type' => 'select',
							'instructions' => 'Choose to show or hide attributes by default',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_64c5555f9479f',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'open' => 'Opened',
								'collapsed' => 'Collapsed',
							),
							'default_value' => false,
							'return_format' => '',
							'multiple' => 0,
							'allow_null' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
				'layout_64c5552ac6acg' => array(
					'key' => 'layout_64c5552ac6acg',
					'name' => 'tabs',
					'label' => 'Tabs',
					'display' => 'row',
					'sub_fields' => array(
						array(
							'key' => 'field_64c5563d947ad',
							'label' => 'Tabs',
							'name' => 'sgg_step_tab_options',
							'aria-label' => '',
							'type' => 'repeater',
							'instructions' => 'Define the attribute tabs and link to the attribute',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'layout' => 'table',
							'min' => 0,
							'max' => 0,
							'collapsed' => '',
							'button_label' => 'Add tab',
							'rows_per_page' => 20,
							'sub_fields' => array(
								array(
									'key' => 'field_64c55657947a1',
									'label' => 'Attribute tab title',
									'name' => 'sgg_step_tab_title',
									'aria-label' => '',
									'type' => 'text',
									'instructions' => 'Title as displayed in the tab.',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '33',
										'class' => 'conditional-tab-title',
										'id' => '',
									),
									'default_value' => '',
									'maxlength' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'parent_repeater' => 'field_64c5563d947ad',
								),
								array(
									'key' => 'field_64c55657947a4',
									'label' => 'Tab Make Slide Active',
									'name' => 'sgg_step_tab_preview_slide',
									'aria-label' => '',
									'type' => 'text',
									'instructions' => 'Index of product image slide to show when clicking this tab.',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '33',
										'class' => 'conditional-tab-preview',
										'id' => '',
									),
									'default_value' => '',
									'maxlength' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'parent_repeater' => 'field_64c5563d947ad',
								),
								array(
									'key' => 'field_64c5568e947a2',
									'label' => 'Tab linked attribute',
									'name' => 'sgg_step_tab_attribute',
									'aria-label' => '',
									'type' => 'select',
									'instructions' => 'Select your attribute group that will be shown when tab is active.',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '33',
										'class' => 'conditional-tab-attribute',
										'id' => '',
									),
									'choices' => array(),
									'default_value' => false,
									'return_format' => 'value',
									'multiple' => 1,
									'allow_null' => 0,
									'ui' => 1,
									'ajax' => 0,
									'placeholder' => '',
									'parent_repeater' => 'field_64c5563d947ad',
								),
							),
						),
					),
					'min' => '',
					'max' => '',
				),
				'layout_64c555b0947a1' => array(
					'key' => 'layout_64c555b0947a1',
					'name' => 'attribute',
					'label' => 'Attribute',
					'display' => 'row',
					'sub_fields' => array(
						array(
							'key' => 'field_64c555b0947a2',
							'label' => 'Select attribute',
							'name' => 'sgg_step_attribute',
							'aria-label' => '',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'base-attribute-select',
								'id' => '',
							),
							'choices' => array(),
							'default_value' => false,
							'return_format' => 'value',
							'multiple' => 0,
							'allow_null' => 0,
							'ui' => $sgg_select_two,
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_64c555b0947a5',
							'label' => 'Hide attribute',
							'name' => 'sgg_step_attribute_hidden',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => 'Hides the attribute in configurator when enabled.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
							'ui' => 1,
						),
						array(
							'key' => 'field_64c555b0947ac',
							'label' => 'Set default attribute option',
							'name' => 'sgg_step_attribute_default_value',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => 'Allows you to change the default attribute option for the given attribute.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => 'default-attribute-value-checkbox',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
							'ui' => 1,
						),
						array(
							'key' => 'field_64c555b0947ad',
							'label' => 'Select default option',
							'name' => 'sgg_step_attribute_value',
							'aria-label' => '',
							'type' => 'select',
							'instructions' => 'Select your attribute default option',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_64c555b0947ac',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => 'base-attribute-option-select',
								'id' => '',
							),
							'choices' => array(),
							'default_value' => false,
							'return_format' => 'value',
							'multiple' => 0,
							'allow_null' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_64c555b0947a3',
							'label' => 'Make attribute collapsible',
							'name' => 'sgg_step_attribute_collapsible',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => 'Will add collapsible icon when enabled.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
							'ui' => 1,
						),
						array(
							'key' => 'field_64c555b0947a4',
							'label' => 'Choose default state',
							'name' => 'sgg_step_attribute_state',
							'aria-label' => '',
							'type' => 'select',
							'instructions' => 'Choose to show or hide attribute by default',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_64c555b0947a3',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'open' => 'Opened',
								'collapsed' => 'Collapsed',
							),
							'default_value' => false,
							'return_format' => 'value',
							'multiple' => 0,
							'allow_null' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
				'layout_64c5592ac6adc' => array(
					'key' => 'layout_64c5592ac6adc',
					'name' => 'summary',
					'label' => 'Summary',
					'display' => 'row',
					'sub_fields' => array(),
					'min' => '',
					'max' => '',
				),
				'layout_64c5592ac6edf' => array(
					'key' => 'layout_64c5592ac6edf',
					'name' => 'shortcode',
					'label' => 'Shortcode',
					'display' => 'row',
					'sub_fields' => array(
						array(
							'key' => 'field_64c2dbbfc9890',
							'label' => 'Shortcode',
							'name' => 'sgg_step_shortcode',
							'aria-label' => '',
							'type' => 'text',
							'instructions' => 'Enter any shortcode',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
				'layout_64c5592ac6abd' => array(
					'key' => 'layout_64c5592ac6abd',
					'name' => 'html',
					'label' => 'HTML',
					'display' => 'row',
					'sub_fields' => array(
						array(
							'key' => 'field_64c2dbbfc9840',
							'label' => 'Custom HTML',
							'name' => 'sgg_step_html',
							'aria-label' => '',
							'type' => 'textarea',
							'instructions' => 'Enter any HTML contents',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'rows' => '',
							'placeholder' => '',
							'new_lines' => '',
						),
					),
					'min' => '',
					'max' => '',
				)
			),
			'min' => '',
			'max' => '',
			'button_label' => 'Add new',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'sgg_product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
