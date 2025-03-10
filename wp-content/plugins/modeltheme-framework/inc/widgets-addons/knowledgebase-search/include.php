<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_knowledgebase_search_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/knowledgebase-search/class-knowledgebase-search-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Knowledgebase_Search() ); 
}
add_action( 'elementor/widgets/register', 'modeltheme_knowledgebase_search_widget_register' );
