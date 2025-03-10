<?php
if ( ! function_exists( 'wildnest_customizer_blog_config' ) ) {
	function wildnest_customizer_blog_config( $configs ) {

		$section = 'wildnest_blog';

		$config = array(
			// Panel
			array(
				'name'     => 'blog_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Blog Settings', 'wildnest' ),
			),
			// I. Blog Archive
			array(
				'name'    => 'wildnest_blog_layout_h',
				'type'    => 'heading',
				'section' => 'wildnest_blog_archive',
				'title'   => esc_html__( 'Layout', 'wildnest' ),
			),
			array(
				'name'  => "wildnest_blog_archive",
				'type'  => 'section',
				'panel' => 'blog_panel',
				'title' => esc_html__( 'Blog Archive', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_blog_archive_layout',
				'type'            => 'radio_group',
				'section'         => 'wildnest_blog_archive',
				'default'         => 'right-sidebar',
				'title'           => esc_html__( 'Blog Layout', 'wildnest' ),
				'choices'         => array(
					'left-sidebar'  	=> esc_html__( 'Left Sidebar', 'wildnest' ),
					'no-sidebar' 		=> esc_html__( 'Fullwidth', 'wildnest' ),
					'right-sidebar'  	=> esc_html__( 'Right Sidebar', 'wildnest' ),
				),
			),
			array(
				'name'    => 'wildnest_blog_styling_h',
				'type'    => 'heading',
				'section' => 'wildnest_blog_archive',
				'title'   => esc_html__( 'Styling', 'wildnest' ),
			),
			array(
				'name'        => 'wildnest_blog_article_card_styling',
				'type'        => 'styling',
				'section'     => 'wildnest_blog_archive',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Article Card Styling', 'wildnest' ),
				'selector'    => '.wildnest-article-wrapper .wildnest-article-inner',
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					)
				)
			),
			array(
				'name'            => 'wildnest_blog_article_margin_bottom',
				'type'            => 'slider',
				'section'         => 'wildnest_blog_archive',
				'default'         => array(),
				'max'             => 100,
				'device_settings' => true,
				'title'           => esc_html__( 'Space Between Posts', 'wildnest' ),
				'description'           => esc_html__( 'Set the space height between posts', 'wildnest' ),
				'selector'        => 'format',
				'css_format'      => ".wildnest-article-wrapper .wildnest-article-inner { margin-bottom: {{value}}; }",
			),
			array(
				'name'    => 'wildnest_blog_box_h',
				'type'    => 'heading',
				'section' => 'wildnest_blog_archive',
				'title'   => esc_html__( 'Article Elements', 'wildnest' ),
			),

			array(
				'name'           => 'wildnest_blog_featured_image_status',
				'type'           => 'checkbox',
				'section' 		 => 'wildnest_blog_archive',
				'title' 		 => esc_html__( 'Featured Image', 'wildnest' ),
				'description' 	 => esc_html__( 'Article Featured Image Status', 'wildnest' ),
				'default'       => 1,
			),
			array(
				'name'           => 'wildnest_blog_post_title_status',
				'type'           => 'checkbox',
				'section' 		 => 'wildnest_blog_archive',
				'title' 		 => esc_html__( 'Title', 'wildnest' ),
				'description' 	 => esc_html__( 'Article Title Status', 'wildnest' ),
				'default'       => 1,
			),
			array(
				'name'           => 'wildnest_blog_metas_status',
				'type'           => 'checkbox',
				'section' 		 => 'wildnest_blog_archive',
				'title' 		 => esc_html__( 'Metas', 'wildnest' ),
				'description' 	 => esc_html__( 'Author Name, Category, Post Date', 'wildnest' ),
				'default'       => 1,
			),
			array(
				'name'           => 'wildnest_blog_description_status',
				'type'           => 'checkbox',
				'section' 		 => 'wildnest_blog_archive',
				'title' 		 => esc_html__( 'Excerpt', 'wildnest' ),
				'description' 	 => esc_html__( 'Short Description', 'wildnest' ),
				'default'       => 1,
			),
			array(
				'name'           => 'wildnest_blog_readmore_btn_status',
				'type'           => 'checkbox',
				'section' 		 => 'wildnest_blog_archive',
				'title' 		 => esc_html__( 'Button', 'wildnest' ),
				'description' 	 => esc_html__( 'The Read More Button', 'wildnest' ),
				'default'       => 1,
			),

			// II. Single Post
			array(
				'name'  => "wildnest_blog_single",
				'type'  => 'section',
				'panel' => 'blog_panel',
				'title' => esc_html__( 'Blog Single Article', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_blog_single_layout',
				'type'            => 'radio_group',
				'section'         => 'wildnest_blog_single',
				'default'         => 'no-sidebar',
				'title'           => esc_html__( 'Single Blog Layout', 'wildnest' ),
				'choices'         => array(
					'left-sidebar'  	=> esc_html__( 'Left Sidebar', 'wildnest' ),
					'no-sidebar' 		=> esc_html__( 'Fullwidth', 'wildnest' ),
					'right-sidebar'  	=> esc_html__( 'Right Sidebar', 'wildnest' ),
				),
			),
			array(
				'name'            => 'wildnest_blog_single_featured_image',
				'type'            => 'checkbox',
				'section'         => 'wildnest_blog_single',
				'default'         => 1,
				'title'           => esc_html__( 'Featured Image', 'wildnest' ),
				'description'     => esc_html__( 'Show or Hide the featured image from blog post page', 'wildnest' ),
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'wildnest/customizer/config', 'wildnest_customizer_blog_config' );
