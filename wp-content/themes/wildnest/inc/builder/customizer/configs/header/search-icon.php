<?php

class Wildnest_Builder_Item_Search_Icon {
	public $id = 'search_icon';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Search Icon', 'wildnest' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '1',
			'section' => 'search_icon',
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
		$config   = array(
			array(
				'name'  => 'search_icon',
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => esc_html__( 'Search Icon', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_icon_in',
				'type'            => 'select',
				'section'         => 'search_icon',
				'default'         => 'post',
				'title'           => esc_html__( 'Search in:', 'wildnest' ),
				'choices'         => array(
					'post' => esc_html__( 'Blog Posts (Articles)', 'wildnest' ),
					'product'  => esc_html__( 'Products', 'wildnest' ),
				),
			),
			array(
				'name'            => 'wildnest_search_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 5,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector svg",
				'css_format'      => 'height: {{value}}; width: {{value}};',
				'label'           => esc_html__( 'Icon Size', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_icon_padding',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 0,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-icon",
				'css_format'      => 'padding: {{value}};',
				'label'           => esc_html__( 'Icon Padding', 'wildnest' ),
			),

			array(
				'name'        => 'wildnest_search_icon_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Icon Styling', 'wildnest' ),
				'description' => esc_html__( 'Search icon styling', 'wildnest' ),
				'selector'    => array(
					'normal'            => "{$selector} .search-icon",
					'hover'             => "{$selector} .search-icon:hover",
					'normal_box_shadow' => "{$selector} .search-icon",
					'normal_text_color' => "{$selector} .search-icon",
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_attachment' => false,
						'bg_repeat'     => false,
						'border_radius' => false,
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name'    => 'wildnest_search_icon_modal_h',
				'type'    => 'heading',
				'section' => 'search_icon',
				'label'   => esc_html__( 'Modal Settings', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_icon_placeholder',
				'type'            => 'text',
				'selector'        => "$selector",
				'render_callback' => $fn,
				'section'         => 'search_icon',
				'label'           => esc_html__( 'Placeholder', 'wildnest' ),
				'default'         => esc_html__( 'Search ...', 'wildnest' ),
			),

			array(
				'name'        => 'wildnest_search_icon_form_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Form Styling', 'wildnest' ),
				'description' => esc_html__( 'Form modal styling', 'wildnest' ),
				'selector'    => array(
					'normal'              => "{$selector} .header-search-modal",
					'normal_bg_color'     => "{$selector} .header-search-modal, {$selector} .header-search-modal:before",
					'normal_border_color' => "{$selector} .header-search-modal, {$selector} .header-search-modal:before",
				),
				'default'     => array(
					'normal' => array(
						'border_style' => 'solid',
					),
				),
				'fields'      => array(
					'normal_fields' => array(
						'text_color'    => false, // disable for special field.
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					),
					'hover_fields'  => false,
				),
			),

			array(
				'name'            => 'wildnest_search_icon_modal_height',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 25,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .header-search-form .search-field",
				'css_format'      => 'height: {{value}};',
				'label'           => esc_html__( 'Input Height', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_icon_modal_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'selector'        => "$selector .header-search-modal",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Search Modal Width', 'wildnest' ),
			),

			array(
				'name'        => 'wildnest_search_icon_modal_font_size',
				'type'        => 'typography',
				'section'     => 'search_icon',
				'selector'    => "$selector .header-search-form .search-field",
				'css_format'  => 'typography',
				'label'       => esc_html__( 'Input Text Typography', 'wildnest' ),
				'description' => esc_html__( 'Typography for search input', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_icon_modal_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 5,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-submit svg",
				'css_format'      => 'height: {{value}}; width: {{value}};',
				'label'           => esc_html__( 'Icon Size', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_search_icon_modal_icon_pos',
				'type'            => 'slider',
				'device_settings' => true,
				'default'         => array(
					'desktop' => array(
						'value' => - 40,
						'unit'  => 'px',
					),
					'tablet'  => array(
						'value' => - 40,
						'unit'  => 'px',
					),
					'mobile'  => array(
						'value' => - 40,
						'unit'  => 'px',
					),
				),
				'section'         => 'search_icon',
				'min'             => - 150,
				'step'            => 1,
				'max'             => 90,
				'selector'        => "$selector .search-submit",
				'css_format'      => 'margin-left: {{value}}; ',
				'label'           => esc_html__( 'Icon Position', 'wildnest' ),
			),

			array(
				'name'        => 'wildnest_search_icon_modal_input_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Input Styling', 'wildnest' ),
				'description' => esc_html__( 'Search input styling', 'wildnest' ),
				'selector'    => array(
					'normal'            => "{$selector} .search-field",
					'hover'             => "{$selector} .search-field:focus",
					'normal_text_color' => "{$selector} .search-field, {$selector} input.search-field::placeholder",
				),
				'default'     => array(
					'normal' => array(
						'border_style' => 'solid',
					),
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
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
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name'        => 'wildnest_search_icon_modal_icon_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Icon Styling', 'wildnest' ),
				'description' => esc_html__( 'Search input styling', 'wildnest' ),
				'selector'    => array(
					'normal' => "{$selector} .search-submit",
					'hover'  => "{$selector} .search-submit:hover",
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
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
						'bg_attachment' => false,
						'border_radius' => false,
					), // disable hover tab and all fields inside.
				),
			),

		);

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, 'search_icon' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {

		$search_in = Wildnest()->get_setting( 'wildnest_search_icon_in' );
		$placeholder = Wildnest()->get_setting( 'wildnest_search_icon_placeholder' );
		$placeholder = sanitize_text_field( $placeholder );

		echo '<div class="header-' . esc_attr( $this->id ) . '-item item--' . esc_attr( $this->id ) . '">';
		?>
		<a class="search-icon" href="#" aria-label="<?php esc_attr_e( 'open search tool', 'wildnest' ) ?>">
			<span class="ic-search">
    			<svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px">    
    				<path d="M 10 2 C 5.5935666 2 2 5.5935666 2 10 C 2 14.406433 5.5935666 18 10 18 C 12.023929 18 13.871701 17.237039 15.283203 15.990234 L 16 16.707031 L 16 18 L 20 22 L 22 20 L 18 16 L 16.707031 16 L 15.990234 15.283203 C 17.237039 13.871701 18 12.023929 18 10 C 18 5.5935666 14.406433 2 10 2 z M 10 4 C 13.325553 4 16 6.6744469 16 10 C 16 13.325553 13.325553 16 10 16 C 6.6744469 16 4 13.325553 4 10 C 4 6.6744469 6.6744469 4 10 4 z M 7 9 A 1 1 0 0 0 6 10 A 1 1 0 0 0 7 11 A 1 1 0 0 0 8 10 A 1 1 0 0 0 7 9 z M 10 9 A 1 1 0 0 0 9 10 A 1 1 0 0 0 10 11 A 1 1 0 0 0 11 10 A 1 1 0 0 0 10 9 z M 13 9 A 1 1 0 0 0 12 10 A 1 1 0 0 0 13 11 A 1 1 0 0 0 14 10 A 1 1 0 0 0 13 9 z"/>
    			</svg>
			</span>
			<span class="ic-close">
				<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="612px" height="612px" viewBox="0 0 612 612" fill="currentColor" style="enable-background:new 0 0 612 612;" xml:space="preserve"><g><g id="cross"><g><polygon points="612,36.004 576.521,0.603 306,270.608 35.478,0.603 0,36.004 270.522,306.011 0,575.997 35.478,611.397 306,341.411 576.521,611.397 612,575.997 341.459,306.011 " /></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
			</span>
			<span class="arrow-down"></span>
		</a>
		<div class="header-search-modal-wrapper">
			<form class="header-search-modal header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label>
					<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'wildnest' ); ?></span>
					<input type="hidden" name="post_type" value="<?php echo esc_attr($search_in); ?>" />
					<input type="search" class="search-field" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'wildnest' ); ?>" />
				</label>
				<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'submit search', 'wildnest' ) ?>">
					<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21">
						<path fill="currentColor" fill-rule="evenodd" d="M12.514 14.906a8.264 8.264 0 0 1-4.322 1.21C3.668 16.116 0 12.513 0 8.07 0 3.626 3.668.023 8.192.023c4.525 0 8.193 3.603 8.193 8.047 0 2.033-.769 3.89-2.035 5.307l4.999 5.552-1.775 1.597-5.06-5.62zm-4.322-.843c3.37 0 6.102-2.684 6.102-5.993 0-3.31-2.732-5.994-6.102-5.994S2.09 4.76 2.09 8.07c0 3.31 2.732 5.993 6.102 5.993z"></path>
					</svg>
				</button>
			</form>
		</div>
		<?php
		echo '</div>';
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Search_Icon() );
