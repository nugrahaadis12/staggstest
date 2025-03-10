<?php

class Wildnest_Builder_Header_Templates {
	public $id = 'header_templates';

	function customize() {
		$section = 'header_templates';
		$prefix  = 'header_templates_';

		$id          = 'header';
		$theme_name  = wp_get_theme()->get( 'Name' );
		$option_name = "{$theme_name}_{$id}_saved_templates";

		$saved_templates = get_option( $option_name );
		if ( ! is_array( $saved_templates ) ) {
			$saved_templates = array();
		}

		$saved_templates = array_reverse( $saved_templates );

		$n = count( $saved_templates );

		$html = '';
		$html .= '<span class="customize-control-title">' . esc_html__( 'Saved Templates', 'wildnest' ) . '</span>';
		$html .= '<ul class="list-saved-templates list-boxed ' . ( $n > 0 ? 'has-templates' : 'no-templates' ) . '">';
		if ( count( $saved_templates ) > 0 ) {
			foreach ( $saved_templates as $key => $tpl ) {
				$tpl = wp_parse_args(
					$tpl,
					array(
						'name' => '',
						'data' => '',
					)
				);
				if ( ! $tpl['name'] ) {
					$name = esc_html__( 'Untitled', 'wildnest' );
				} else {
					$name = $tpl['name'];
				}
				$html .= '<li class="saved_template li-boxed" data-control-id="' . esc_attr( $prefix . 'save' ) . '" data-id="' . esc_attr( $key ) . '" data-data="' . esc_attr( json_encode( $tpl['data'] ) ) . '">' . esc_html( $name ) . ' <a href="#" class="load-tpl">' . esc_html__( 'Load', 'wildnest' ) . '</a><a href="#" class="remove-tpl">' . esc_html__( 'Remove', 'wildnest' ) . '</a></li>'; // phpcs:ignore
			}
		}

		$html .= '<li class="no_template">' . esc_html__( 'No saved templates.', 'wildnest' ) . '</li>';

		$html .= '</ul>';
		$html .= '</div>';

		return array(
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 299,
				'title'    => esc_html__( 'Templates', 'wildnest' ),
			),

			array(
				'name'           => $prefix . 'save',
				'type'           => 'custom_html',
				'section'        => $section,
				'theme_supports' => '',
				'title'          => esc_html__( 'Save Template', 'wildnest' ),
				'description'    => '<div class="save-template-form"><input type="text" data-builder-id="header" data-control-id="' . esc_attr( $prefix . 'save' ) . '" class="template-input-name change-by-js"><button class="button button-secondary save-builder-template" type="button">' . esc_html__( 'Save', 'wildnest' ) . '</button></div>' . $html,
			),
		);
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Header_Templates() );
