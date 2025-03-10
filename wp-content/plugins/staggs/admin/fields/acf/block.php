<?php

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
    "key" => "group_12dcc64889b9e",
    "title" => "STAGGS Configurator",
    "fields"=> array(
        array(
            "key" => "field_12dcc6581bb20",
            "label" => "Configurable product",
            "name" => "staggs_product_id",
			"aria-label" => "",
			"type" => "select",
			"instructions" => "",
			"required" => 0,
			"conditional_logic" => 0,
			"wrapper" => array(
				"width" => "",
				"class" => "",
				"id" => ""
			),
			"choices" => array(),
			"default_value" => "h2",
			"return_format" => "value",
			"multiple" => 0,
			"allow_null" => 0,
			"ui" => 0,
			"ajax" => 0,
			"placeholder" => ""
        )
    ),
    "location"=> array(
        array(
            array(
                "param" => "block",
                "operator" => "==",
                "value" => "acf/block-staggs"
            )
        )
    ),
    "menu_order" => 0,
    "position" => "normal",
    "style" => "default",
    "label_placement" => "top",
    "instruction_placement" => "label",
    "hide_on_screen" => "",
    "active" => true,
    "description" => "",
    "show_in_rest" => 0,
) );
