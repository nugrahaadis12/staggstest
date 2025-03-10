<?php 
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function modeltheme_masonry_gallery_widget_register( $widgets_manager ) {
	// load
  require_once(MODELTHEME_PLUGIN_BASE.'widgets-addons/masonry-gallery/class-masonry-gallery-widget-elementor.php');

	// register
	$widgets_manager->register( new \Modeltheme_Masonry_Gallery() );
}
add_action( 'elementor/widgets/register', 'modeltheme_masonry_gallery_widget_register' );
