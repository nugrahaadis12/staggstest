<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_knowledgebase_list_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/knowledgebase-list/class-knowledgebase-list-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Knowledgebase_List() ); 
}
add_action( 'elementor/widgets/register', 'modeltheme_knowledgebase_list_widget_register' );
