<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_shaped_video_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/shaped-video/class-shaped-video-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Shaped_Video() );
}
add_action( 'elementor/widgets/register', 'modeltheme_shaped_video_widget_register' );
