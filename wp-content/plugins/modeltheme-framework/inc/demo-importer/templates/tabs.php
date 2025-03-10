<?php

$tab     = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : '';
$general_class = array();
if ( empty( $tab ) ) {
    $tab = 'demos';
}
if ( 'demos' === $tab ) {
        $general_class[] = 'nav-tab-active';
}
$theme_class = array();
if ( empty( $tab ) ) {
    $tab = 'demos';
}
if ( 'demos' === $tab ) {
    $theme_class[] = '';
}
$plugin_class = array();
if ( empty( $tab ) ) {
    $tab = 'activator';
}
if ( 'activator' === $tab ) {
    $plugin_class[] = 'nav-tab-active';
}

?>

<div class="nav-tab-wrapper">
	<div class="nav-tab-container">
		<?php
		echo '<a href="#general" class="panel-tab '.esc_attr(implode(' ',$general_class)).'">'.esc_html__( 'About', 'modeltheme' ).'</a>';
        echo '<a href="#demos" data-id="demos" class="panel-tab '.esc_attr(implode(' ',$theme_class)).'">'.esc_html__('Demos','modeltheme').'</a>';
		?>
	</div>
</div>
