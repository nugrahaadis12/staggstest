<?php
/**
 * @package wildnest
 */

if ( ! function_exists( 'wildnest_is_builder_row_display' ) ) {
	function wildnest_is_builder_row_display( $builder_id, $row_id = false, $post_id = false ) {
		$show = true;
		if ( $row_id && $builder_id ) {
			$key     = $builder_id . '_' . $row_id;
			$disable = get_post_meta( $post_id, '_wildnest_disable_' . $key, true );
			if ( $disable ) {
				$show = false;
			}
		}
		return apply_filters( 'wildnest_is_builder_row_display', $show, $builder_id, $row_id, $post_id );
	}
}

if ( ! function_exists( 'wildnest_body_classes' ) ) {
    function wildnest_body_classes( $classes ) {

        if ( is_customize_preview() ) {
            $classes[] = 'customize-previewing';
        }
        return $classes;
    }
}
add_filter( 'body_class', 'wildnest_body_classes' );