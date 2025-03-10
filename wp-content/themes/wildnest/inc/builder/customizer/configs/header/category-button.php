<?php

class Wildnest_Builder_Category_Button {

	public $id = 'category_button';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Category Button', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_category_button',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_category_button',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'Category Button', 'wildnest' ),
			),

			array(
				'name'    => 'header_category_button_heading',
				'type'    => 'heading',
				'section' => 'header_category_button',
				'title'   => esc_html__( 'The Category Navigation can be populated from Appearance - Menus - Display location - Category Button', 'wildnest' )
			),
			array(
				'name'            => 'wildnest_category_button_placeholder',
				'type'            => 'text',
				'section'         => 'header_category_button',
				'render_callback' => $fn,
				'label'           => esc_html__( 'Placeholder', 'wildnest' ),
				'default'         => esc_html__( 'Catalog', 'wildnest' ),
				'priority'        => 10,
			),

			array(
				'name'            => 'wildnest_category_button_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_category_button',
				'selector'        => ".wildnest_category_button .category_button_wrap",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Button Width', 'wildnest' ),
				'description'     => esc_html__( 'Note: The width can not greater than grid width.', 'wildnest' ),
				'priority'        => 15,
			),

			array(
				'name'            => 'wildnest_category_button_height',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_category_button',
				'min'             => 25,
				'step'            => 1,
				'max'             => 100,
				'selector'        => ".wildnest_category_button .category_button_wrap",
				'css_format'      => 'height: {{value}};',
				'label'           => esc_html__( 'Button Height', 'wildnest' ),
				'priority'        => 20,
			),

			array(
				'name'        => 'wildnest_category_button_font_size',
				'type'        => 'typography',
				'section'     => 'header_category_button',
				'selector'    => ".wildnest_category_button .category_button_title",
				'css_format'  => 'typography',
				'label'       => esc_html__( 'Button Text Typography', 'wildnest' ),
				'priority'    => 35,
			),

			array(
				'name'        => 'wildnest_category_button_styling',
				'type'        => 'styling',
				'section'     => 'header_category_button',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Button Styling', 'wildnest' ),
				'selector'    => array(
					'normal'            	=> ".wildnest_category_button .category_button_title",
					'hover'             	=> ".wildnest_category_button .category_button_wrap:hover",
					'normal_text_color' 	=> ".wildnest_category_button .category_button_title",
					'hover_text_color' 		=> ".wildnest_category_button .menu-item > a:hover",
					'normal_bg_color' 		=> ".wildnest_category_button .category_button_wrap",
					'normal_border_style' 	=> ".wildnest_category_button .category_button_wrap",
					'normal_border_width' 	=> ".wildnest_category_button .category_button_wrap",
					'normal_border_color' 	=> ".wildnest_category_button .category_button_wrap",
					'normal_border_radius' 	=> ".wildnest_category_button .category_button_wrap",
					'normal_box_shadow' 	=> ".wildnest_category_button .category_button_wrap",
				),
				'default'     => array(
					'normal' => array(
						'text_color' => '#fff',
						'bg_color'	 => '#5ab210'
					),
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'border_radius' => false,
					),
				),
				'priority'        => 40,
			),

		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'header_category_button' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$placeholder = Wildnest()->get_setting( 'wildnest_category_button_placeholder' );
		$placeholder = sanitize_text_field( $placeholder );

		echo '<div class="wildnest_category_button">';
                echo '<button class="category_button_wrap">';
                echo '<span class="category_button_title">'.esc_html($placeholder).'</span></button>';
				echo '<ul class="button_dropdown">';
				if ( has_nav_menu( 'hb-category-button' ) ) {
				    // Using a cleaner and more maintainable approach
				    if ( has_nav_menu( $theme_location ) ) {
				        // User has assigned a menu to this location; output it
				        wp_nav_menu( array( 
				            'theme_location' => $theme_location, 
				            'menu_class' => 'nav', 
				            'container' => '' 
				        ) );
				    } else {
				        // Existing defaults setup for 'hb-category-button'
				        $defaults = array(
				            'menu'            => '',
				            'container'       => false,
				            'container_class' => '',
				            'container_id'    => '',
				            'menu_class'      => 'menu',
				            'menu_id'         => '',
				            'echo'            => true,
				            'fallback_cb'     => false,
				            'before'          => '',
				            'after'           => '',
				            'link_before'     => '',
				            'link_after'      => '',
				            'items_wrap'      => '%3$s',
				            'depth'           => 0,
				            'walker'          => '',
				            'theme_location'  => 'hb-category-button'
				        );
				        wp_nav_menu( $defaults );
				    }
				}
				echo '</ul>';

        echo '</div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Category_Button() );
