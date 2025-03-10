<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_pricing_comparison_table_widget_register( $widgets_manager ) {
	// load
  	require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/pricing-comparison-table/class-pricing-comparison-table-widget-elementor.php');

	// register
	$widgets_manager->register( new \Modeltheme_Pricing_Comparison_Table() );
}
add_action( 'elementor/widgets/register', 'modeltheme_pricing_comparison_table_widget_register' );
