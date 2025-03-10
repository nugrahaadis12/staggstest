<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_knowledgebase_accordion_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/knowledgebase-accordion/class-knowledgebase-accordion-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Knowledgebase_Accordion() );
}
add_action( 'elementor/widgets/register', 'modeltheme_knowledgebase_accordion_widget_register' );
