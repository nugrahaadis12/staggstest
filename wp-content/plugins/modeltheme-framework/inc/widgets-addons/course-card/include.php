<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_course_card_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/course-card/class-course-card-widget-elementor.php');
	// register
	$widgets_manager->register( new \Modeltheme_Course_Card() );
}
add_action( 'elementor/widgets/register', 'modeltheme_course_card_widget_register' );
