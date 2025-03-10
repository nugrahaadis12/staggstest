<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_countdown_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/countdown/class-countdown-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Countdown() );
}
add_action( 'elementor/widgets/register', 'modeltheme_countdown_widget_register' );
