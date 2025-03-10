<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_stacked_photos_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/stacked-photos/class-stacked-photos-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Stacked_Photos() );
}
add_action( 'elementor/widgets/register', 'modeltheme_stacked_photos_widget_register' );
