<?php

class Wildnest_Builder_Item_HTML {

	public $id = 'html';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'HTML 1', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_html',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		// Render callback function.
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_html',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 200,
				'title'    => esc_html__( 'HTML 1', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_header_html',
				'type'            => 'textarea',
				'section'         => 'header_html',
				'selector'        => '.builder-header-html-item',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'default'         => esc_html__( 'Add custom text here or remove it', 'wildnest' ),
				'title'           => esc_html__( 'HTML', 'wildnest' ),
				'description'     => esc_html__( 'Arbitrary HTML code.', 'wildnest' ),
			),

			array(
				'name'       => 'wildnest_header_html_typo',
				'type'       => 'typography',
				'section'    => 'header_html',
				'selector'   => '.builder-header-html-item.item--html p, .builder-header-html-item.item--html',
				'css_format' => 'typography',
				'title'      => esc_html__( 'Typography Setting', 'wildnest' ),
			),

		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'header_html' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$content = Wildnest()->get_setting( 'wildnest_header_html' );
		echo '<div class="builder-header-html-item item--html">';
			echo apply_filters( 'wildnest_the_content', wp_kses_post( $content, true ) );
		echo '</div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_HTML() );
