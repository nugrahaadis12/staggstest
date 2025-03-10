<?php
/**
 * Maybe Header builder version.
 * Beacause the version 2 easier to use than version 1.
 * You can swicth to version whenever you want by manual.
 *
 * @TODO: Change header builder to version 2
 *
 * @since 0.2.9
 */
function wildnest_maybe_change_header_version() {
	$current_ver = get_theme_mod( 'header_builder_version' );
	if ( 'v2' == $current_ver ) {
		set_theme_mod( 'hide_header_builder_switcher', 'yes' );
		return;
	}
	$ver1_data = get_theme_mod( 'header_builder_panel' );
	// If data of version 1 do not exists.
	if ( ! $ver1_data || empty( $ver1_data ) ) {
		set_theme_mod( 'header_builder_version', 'v2' );
		set_theme_mod( 'hide_header_builder_switcher', 'yes' );
	}
}

/**
 * Display Header Layout
 */
function wildnest_customize_render_header() {

	/**
	 * @since 0.2.9
	 */
	wildnest_maybe_change_header_version();
	$config = Wildnest_Customize_Layout_Builder()->get_builder( 'header' )->get_config();
	$control_id = 'header_builder_panel';
	$version = false;

	if ( isset( $config['version_id'] ) ) {
		$version = Wildnest()->get_setting( $config['version_id'] );
	}

	if ( $version && isset( $config['versions'] ) ) {
		$control_id = $config['versions'][ $version ]['control_id'];
	}

	$list_items = Wildnest_Customize_Layout_Builder()->get_builder_items( 'header' );

	$fn = 'Wildnest_Layout_Builder_Frontend';
	if ( $version ) {
		if ( function_exists( $fn . '_' . strtoupper( $version ) ) ) {
			$fn = $fn . '_' . strtoupper( $version );
		}
	}

	/**
	 * @var Wildnest_Layout_Builder_Frontend $builder
	 */
	$builder = call_user_func_array( $fn, array() );

	$header_classes = array( 'site-header', 'header-' . $version );

	echo wp_kses_post($builder->close_icon( ' close-panel close-sidebar-panel' ) );
	/**
	 * Hook before header
	 *
	 * @since 0.2.2
	 * @since 0.2.9
	 */
	do_action( 'wildnest/before-header' );
	echo '<header id="masthead" class="' . join( ' ', $header_classes ) . '">';
		echo '<div id="masthead-inner" class="site-header-inner">';
			$builder->set_id( 'header' );
			$builder->set_control_id( $control_id );
			$builder->set_config_items( $list_items );
			$builder->render();
			$builder->render_mobile_sidebar();
		echo '</div>';
	echo '</header>';
	/**
	 * Hook after header
	 *
	 * @since 0.2.2
	 */
	do_action( 'wildnest/after-header' );
}

/**
 * Display Footer Layout
 */
function wildnest_customize_render_footer() {
	/**
	 * Hook before footer
	 *
	 * @since 0.2.2
	 */
	do_action( 'wildnest/before-footer' );
	if (Wildnest()->get_setting('wildnest_backtotop_status') == 1) {
    	get_template_part( 'templates/back-to-top/back-to-top');
    }
	echo '<footer class="site-footer" id="site-footer">';
	Wildnest_Customize_Layout_Builder_Frontend()->set_id( 'footer' );
	Wildnest_Customize_Layout_Builder_Frontend()->set_control_id( 'footer_builder_panel' );
	$list_items = Wildnest_Customize_Layout_Builder()->get_builder_items( 'footer' );
	Wildnest_Customize_Layout_Builder_Frontend()->set_config_items( $list_items );
	Wildnest_Customize_Layout_Builder_Frontend()->render();
	echo '</footer>';
	/**
	 * Hook before footer
	 *
	 * @since 0.2.2
	 */
	do_action( 'wildnest/after-footer' );
}
