<?php
if ( ! function_exists( 'wildnest_customizer_404_config' ) ) {
	function wildnest_customizer_404_config( $configs ) {

		$section = 'wildnest_not_found';

		$config = array(
			array(
				'name'     => 'not_found_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( '404 Page Settings', 'wildnest' ),
			),

			// Image.
			array(
				'name'  => "wildnest_not_found_404",
				'type'  => 'section',
				'panel' => 'not_found_panel',
				'title' => esc_html__( '404 Image', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_not_found_404_img',
				'type'            => 'image',
				'section'         => 'wildnest_not_found_404',
				'title'           => esc_html__( 'Image for 404 Not found page', 'wildnest' ),
			),

			// Content.
			array(
				'name'  => "wildnest_not_found_404_content",
				'type'  => 'section',
				'panel' => 'not_found_panel',
				'title' => esc_html__( '404 Content', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_page_404_heading',
				'type'            => 'textarea',
				'section'         => 'wildnest_not_found_404_content',
				'title'           => esc_html__( 'Heading', 'wildnest' ),
				'default'         => esc_html__( 'Sorry, this page does not exist!', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_page_404_paragraph',
				'type'            => 'textarea',
				'section'         => 'wildnest_not_found_404_content',
				'title'           => esc_html__( 'Paragraph (sub-heading)', 'wildnest' ),
				'default'         => esc_html__( 'The link you clicked might be corrupted, or the page may have been removed.', 'wildnest' ),
			),

		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'wildnest/customizer/config', 'wildnest_customizer_404_config' );
