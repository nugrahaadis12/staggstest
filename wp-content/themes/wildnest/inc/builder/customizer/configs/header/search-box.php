<?php

class Wildnest_Builder_Item_Search_Box {
	public $id = 'search_box';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Search Form', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '1',
			'section' => 'search_box',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		// Render callback function.
		$fn       = array( $this, 'render' );
		$selector = ".header-{$this->id}-item";

		$icon_postion_css = "$selector .search-submit{margin-left: {{value}};} $selector .woo_bootster_search .search-submit{margin-left: {{value}};} $selector .header-search-form button.search-submit{margin-left:{{value}};}";
		if ( is_rtl() ) {
			$icon_postion_css = ".rtl $selector .search-submit{margin-right: {{value}}; margin-left:auto;} .rtl $selector .woo_bootster_search .search-submit{margin-left: {{value}};margin-left:auto;} .rtl $selector .header-search-form button.search-submit{margin-left: {{value}};margin-left:auto;}";
		}

		$config   = array(
			array(
				'name'  => 'search_box',
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => esc_html__( 'Search Form', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_box_placeholder',
				'type'            => 'text',
				'section'         => 'search_box',
				'selector'        => "$selector",
				'render_callback' => $fn,
				'label'           => esc_html__( 'Placeholder', 'wildnest' ),
				'default'         => esc_html__( 'Search in...', 'wildnest' ),
				'priority'        => 10,
			),
			array(
				'name'            => 'wildnest_search_box_scope',
				'type'            => 'select',
				'section'         => 'search_box',
				'default'         => 'post',
				'title'           => esc_html__( 'Search in:', 'wildnest' ),
				'choices'         => array(
					'post' => esc_html__( 'Blog Posts (Articles)', 'wildnest' ),
					'product'  => esc_html__( 'Products', 'wildnest' ),
				),
			),
			array(
				'name'            => 'wildnest_search_box_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_box',
				'selector'        => "$selector .search-form-fields",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Search Form Width', 'wildnest' ),
				'description'     => esc_html__( 'Note: The width can not greater than grid width.', 'wildnest' ),
				'priority'        => 15,
			),

			array(
				'name'            => 'wildnest_search_box_height',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_box',
				'min'             => 25,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-form-fields, $selector .search-form-fields .search-field",
				'css_format'      => 'height: {{value}};',
				'label'           => esc_html__( 'Input Height', 'wildnest' ),
				'priority'        => 20,
			),

			array(
				'name'            => 'wildnest_search_box_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_box',
				'min'             => 5,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-submit svg,$selector .header-search-form button.search-submit svg",
				'css_format'      => 'height: {{value}}; width: {{value}};',
				'label'           => esc_html__( 'Icon Size', 'wildnest' ),
				'priority'        => 25,
			),

			array(
				'name'            => 'wildnest_search_box_icon_pos',
				'type'            => 'slider',
				'device_settings' => true,
				'default'         => array(
					'desktop' => array(
						'value' => - 47,
						'unit'  => 'px',
					),
					'tablet'  => array(
						'value' => - 47,
						'unit'  => 'px',
					),
					'mobile'  => array(
						'value' => - 47,
						'unit'  => 'px',
					),
				),
				'section'         => 'search_box',
				'min'             => - 150,
				'step'            => 1,
				'max'             => 90,
				'selector'        => 'format',
				'css_format'      => $icon_postion_css,
				'label'           => esc_html__( 'Icon Position', 'wildnest' ),
				'priority'        => 30,
			),

			array(
				'name'        => 'wildnest_search_box_font_size',
				'type'        => 'typography',
				'section'     => 'search_box',
				'selector'    => "$selector .search-form-fields",
				'css_format'  => 'typography',
				'label'       => esc_html__( 'Input Text Typography', 'wildnest' ),
				'description' => esc_html__( 'Typography for search input', 'wildnest' ),
				'priority'    => 35,
			),

			array(
				'name'        => 'wildnest_search_box_input_styling',
				'type'        => 'styling',
				'section'     => 'search_box',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Input Styling', 'wildnest' ),
				'description' => esc_html__( 'Search input styling', 'wildnest' ),
				'selector'    => array(
					'normal'            => "{$selector} .search-form-fields",
					'hover'             => "{$selector} .search-form-fields",
					'normal_text_color' => "{$selector} .search-form-fields,
											{$selector} .search-form-fields input.search-field::placeholder
											",
					'normal_bg_color' => "{$selector} .search-form-fields",
					'normal_border_style' => "{$selector} .search-form-fields",
					'normal_border_width' => "{$selector} .search-form-fields",
					'normal_border_color' => "{$selector} .search-form-fields",
					'normal_border_radius' => "{$selector} .search-form-fields",
					'normal_box_shadow' => "{$selector} .search-form-fields",
				),
				'default'     => array(
					'normal' => array(
						'border_style' => 'solid',
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

			array(
				'name'        => 'wildnest_search_box_icon_styling',
				'type'        => 'styling',
				'section'     => 'search_box',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Icon Styling', 'wildnest' ),
				'description' => esc_html__( 'Search input styling', 'wildnest' ),
				'selector'    => array(
					'normal' => "{$selector} .header-search-form button.search-submit",
					'hover'  => "{$selector} .header-search-form button.search-submit:hover",
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'border_radius' => false,
					),
				),
				'priority'        => 45
			),

		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'search_box' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$form_extra_class = apply_filters( 'wildnest/builder_item/search-box/form_extra_class', array() );
		$scope = Wildnest()->get_setting( 'wildnest_search_box_scope' );
		$placeholder = Wildnest()->get_setting( 'wildnest_search_box_placeholder' );
		$placeholder = sanitize_text_field( $placeholder );

		do_action( 'wildnest/builder_item/search-box/before_html' );

		echo '<div class="header-search_box-item item--search_box">';
		?>
		<form class="header-search-form <?php echo esc_attr( implode( ' ', $form_extra_class ) ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="search-form-fields">
				<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'wildnest' ); ?></span>
				<?php
				do_action( 'wildnest/builder_item/search-box/html_content/before_input' );
				do_action('wildnest_search_form_before');
				?>

				<input type="hidden" value="<?php echo esc_attr($scope); ?>" name="post_type" />
				<input type="search" autocomplete="off" class="search-field" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'wildnest' ); ?>" />

				<?php
				do_action( 'wildnest/builder_item/search-box/html_content/after_input' );
				?>
			</div>
			<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Submit Search', 'wildnest' ) ?>">
				<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21">
					<path fill="currentColor" fill-rule="evenodd" d="M12.514 14.906a8.264 8.264 0 0 1-4.322 1.21C3.668 16.116 0 12.513 0 8.07 0 3.626 3.668.023 8.192.023c4.525 0 8.193 3.603 8.193 8.047 0 2.033-.769 3.89-2.035 5.307l4.999 5.552-1.775 1.597-5.06-5.62zm-4.322-.843c3.37 0 6.102-2.684 6.102-5.993 0-3.31-2.732-5.994-6.102-5.994S2.09 4.76 2.09 8.07c0 3.31 2.732 5.993 6.102 5.993z"></path>
				</svg>
			</button>
		</form>
		<?php
		echo '</div>';
		do_action( 'wildnest/builder_item/search-box/after_html' );
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Search_Box() );
