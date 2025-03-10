<?php

class Wildnest_Builder_Footer_Item_Copyright {
	public $id = 'footer_copyright';
	public $section = 'footer_copyright';
	public $name = 'footer_copyright';
	public $label = '';

	/**
	 * Optional construct
	 */
	function __construct() {
		$this->label = esc_html__( 'Copyright', 'wildnest' );
	}

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Copyright', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '6',
			'section' => $this->section,
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn = array( $this, 'render' );

		$config = array(
			array(
				'name'  => $this->section,
				'type'  => 'section',
				'panel' => 'footer_settings',
				'title' => $this->label,
			),

			array(
				'name'            => $this->name,
				'type'            => 'textarea',
				'section'         => $this->section,
				'selector'        => '.builder-footer-copyright-item',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'default'         => esc_html__( 'Copyright © Wildnest. All Rights Reserved - Powered by Wildnest.', 'wildnest' ),
				'title'           => esc_html__( 'Copyright Text', 'wildnest' ),
			),

			array(
				'name'       => $this->name . '_typography',
				'type'       => 'typography',
				'section'    => $this->section,
				'title'      => esc_html__( 'Copyright Text Typography', 'wildnest' ),
				'selector'   => '.builder-item--footer_copyright, .builder-item--footer_copyright p',
				'css_format' => 'typography',
				'default'    => array(),
			),
			array(
				'name'            => $this->name . '_alignment',
				'type'            => 'text_align_no_justify',
				'section'    	  => $this->section,
				'title'           => esc_html__( 'Alignment', 'wildnest' ),
				'default'		  => 'left',
				'selector'        => '.footer-copyright',
				'css_format' 	  => 'text-align: {{value}};',	
			),
		);

		return array_merge( $config, wildnest_footer_layout_settings( $this->id, $this->section ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$tags = array(
			'current_year' => date_i18n( 'Y' ),
			'site_title'   => get_bloginfo( 'name' ),
			'theme_author' => sprintf( '<a rel="nofollow" href="https://modeltheme.com">%1$s</a>', 'Wildnest' ), // Brand name.
		);

		$content = Wildnest()->get_setting( $this->name );

		foreach ( $tags as $k => $v ) {
			$content = str_replace( '{' . $k . '}', $v, $content );
		}

		echo '<div class="builder-footer-copyright-item footer-copyright">';
		echo apply_filters( 'wildnest_the_content', wp_kses_post( $content, true ) ); // WPCS: XSS OK.
		echo '</div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'footer', new Wildnest_Builder_Footer_Item_Copyright() );
