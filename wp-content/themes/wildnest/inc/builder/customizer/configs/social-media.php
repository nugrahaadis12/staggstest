<?php
if ( ! function_exists( 'wildnest_customizer_social_media_config' ) ) {
	function wildnest_customizer_social_media_config( $configs ) {

		$section = 'wildnest_social_media';

		$config = array(
			array(
				'name'     => 'social_media_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Social Media', 'wildnest' ),
			),

			// Social Shares Tab.
			array(
				'name'  => "wildnest_social_media_shares",
				'type'  => 'section',
				'panel' => 'social_media_panel',
				'title' => esc_html__( 'Social Shares', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_twitter',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Twitter', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_facebook',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Facebook', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_whatsapp',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Whatsapp', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_pinterest',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Pinterest', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_linkedin',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Linkedin', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_telegram',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Telegram', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_shares_email',
				'type'            => 'checkbox',
				'section'         => 'wildnest_social_media_shares',
				'title'           => esc_html__( 'Email', 'wildnest' ),
			),

			// Social Links Tab.
			array(
				'name'  => "wildnest_social_media_links",
				'type'  => 'section',
				'panel' => 'social_media_panel',
				'title' => esc_html__( 'Social Links', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_social_media_links_twitter',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Twitter', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_facebook',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Facebook', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_youtube',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Youtube', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_pinterest',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Pinterest', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_linkedin',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Linkedin', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_skype',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Skype', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_instagram',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Instagram', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_dribble',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Dribble', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_social_media_links_vimeo',
				'type'            => 'text',
				'section'         => 'wildnest_social_media_links',
				'title'           => esc_html__( 'Vimeo', 'wildnest' ),
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'wildnest/customizer/config', 'wildnest_customizer_social_media_config' );
