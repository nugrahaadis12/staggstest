<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_search_forms_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/search-forms/class-search-forms-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Search_Forms() ); 
}
add_action( 'elementor/widgets/register', 'modeltheme_search_forms_widget_register' );
