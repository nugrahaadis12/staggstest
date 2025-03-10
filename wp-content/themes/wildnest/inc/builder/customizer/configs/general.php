<?php
if ( ! function_exists( 'wildnest_customizer_general_settings_config' ) ) {
	function wildnest_customizer_general_settings_config( $configs ) {

		$section = 'wildnest_general_settings';

		$config = array(
			array(
				'name'     => 'general_settings_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'General Settings', 'wildnest' ),
			),

			// Breadcrumbs
			array(
				'name'  => "wildnest_general_settings_breadcrumbs",
				'type'  => 'section',
				'panel' => 'general_settings_panel',
				'title' => esc_html__( 'Breadcrumbs', 'wildnest' ),
			),

			array(
				'name'            => 'wildnest_enable_breadcrumbs',
				'type'            => 'checkbox',
				'section'         => 'wildnest_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Breadcrumbs', 'wildnest' ),
				'description'     => esc_html__('Enable or disable breadcrumbs', 'wildnest'),
				'default'         => 1
			),
			array(
                'name'       	=> 'wildnest_breadcrumbs_delimitator',
                'type'     		=> 'text',
				'section'         => 'wildnest_general_settings_breadcrumbs',
                'title'    		=> esc_html__('Breadcrumbs delimitator', 'wildnest'),
                'description' 	=> esc_html__('(The theme is also compatible with Breadcrumb NavXT plugin, for an enhanced Breadcrumbs / SEO Ready Breadcrumbs feature. Install it and it will automatically replace the default breadcrumbs feature).', 'wildnest'),
                'default'  		=> '/'
            ),
			array(
				'name'    		=> 'wildnest_breadcrumbs_styling_heading',
				'type'    		=> 'heading',
				'section' 		=> 'wildnest_general_settings_breadcrumbs',
				'title'   		=> esc_html__( 'Styling', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_breadcrumbs_alignment',
				'type'            => 'text_align_no_justify',
				'section'         => 'wildnest_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Alignment', 'wildnest' ),
				'default'		  => 'left'	
			),
			array(
				'name'            => 'wildnest_breadcrumbs_bg_image',
				'type'            => 'image',
				'section'         => 'wildnest_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Background', 'wildnest' ),
				'description' 	  => esc_html__('(Change the background color of the breadcrumbs with an image.)', 'wildnest'),
				'selector'   	  => ".wildnest-breadcrumbs, .youzify-search-landing-image-container",
				'css_format' 	  => 'background-image: url({{value}});',
			),
			array(
				'name'            => 'wildnest_enable_parallax',
				'type'            => 'checkbox',
				'section'         => 'wildnest_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Parallax', 'wildnest' ),
				'description'     => esc_html__('Parallax on background', 'wildnest'),
				'default'         => 0
			),
			array(
				'name'        => 'wildnest_breadcrumbs_styling',
				'type'        => 'styling',
				'section'     => 'wildnest_general_settings_breadcrumbs',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Styling', 'wildnest' ),
				'selector'    => array(
					'normal'            => ".wildnest-breadcrumbs",
					'hover'             => ".wildnest-breadcrumbs:hover"
				),
				'fields'      => array(
					'normal_fields' => array(
						'text_color'    => false,
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
					'hover_fields'  => array(
						'text_color'    => false,
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
				),
			),
			array(
				'name'    		=> 'wildnest_breadcrumbs_title_heading',
				'type'    		=> 'heading',
				'section' 		=> 'wildnest_general_settings_breadcrumbs',
				'title'   		=> esc_html__( 'Breadcrumb Title', 'wildnest' ),
			),
			array(
				'name'       	=> 'wildnest_breadcrumbs_title_color',
				'type'       	=> 'color',
				'section' 		=> 'wildnest_general_settings_breadcrumbs',
				'selector'   	=> 'format',
				'title'      	=> esc_html__( 'Title Color', 'wildnest' ),
				'selector'   	=> ".wildnest-breadcrumbs h2, .wildnest-breadcrumbs h1, .wildnest-breadcrumbs h1 span",
				'css_format' 	=> 'color: {{value}};',
			),
			array(
				'name'        	=> "wildnest_breadcrumbs_title_typo",
				'type'        	=> 'typography',
				'section'     	=> "wildnest_general_settings_breadcrumbs",
				'title'       	=> esc_html__( 'Title Typography', 'wildnest' ),
				'css_format'  	=> 'typography',
				'selector'    	=> ".wildnest-breadcrumbs h2, .wildnest-breadcrumbs h1, .wildnest-breadcrumbs h1 span",
			),
			array(
				'name'    		=> 'wildnest_breadcrumbs_subtitle_heading',
				'type'    		=> 'heading',
				'section' 		=> 'wildnest_general_settings_breadcrumbs',
				'title'   		=> esc_html__( 'Breadcrumb Subtitle', 'wildnest' ),
			),
			array(
				'name'       	=> 'wildnest_breadcrumbs_subtitle_color',
				'type'       	=> 'color',
				'section' 		=> 'wildnest_general_settings_breadcrumbs',
				'selector'   	=> 'format',
				'title'      	=> esc_html__( 'Subtitle Color', 'wildnest' ),
				'selector'   	  => ".wildnest-breadcrumbs .breadcrumb .active, .breadcrumb, .breadcrumb a::after,.wildnest-breadcrumbs .breadcrumb a",
				'css_format' 	  => 'color: {{value}};',
			),
			array(
				'name'        	=> "wildnest_breadcrumbs_subtitle_typo",
				'type'        	=> 'typography',
				'section'     	=> "wildnest_general_settings_breadcrumbs",
				'title'       	=> esc_html__( 'Subtitle Typography', 'wildnest' ),
				'css_format'  	=> 'typography',
				'selector'    	=> ".wildnest-breadcrumbs .breadcrumb .active, .breadcrumb,.wildnest-breadcrumbs .breadcrumb a",
			),
			array(
				'name'    			=> 'wildnest_breadcrumbs_delimitator_heading',
				'type'    			=> 'heading',
				'section' 			=> 'wildnest_general_settings_breadcrumbs',
				'title'   			=> esc_html__( 'Delimitator', 'wildnest' ),
			),
			array(
				'name'       		=> 'wildnest_breadcrumbs_delimitator_color',
				'type'       		=> 'color',
				'section' 			=> 'wildnest_general_settings_breadcrumbs',
				'selector'   		=> 'format',
				'default'			=> 'rgba(0,150,57,0)',
				'title'      		=> esc_html__( 'Delimitator', 'wildnest' ),
				'selector'   	  	=> ".wildnest-breadcrumbs .row",
				'css_format' 	  	=> 'border-color: {{value}};',
			),

			// Preloader
			array(
				'name'  			=> "wildnest_general_settings_preloader",
				'type'  			=> 'section',
				'panel' 			=> 'general_settings_panel',
				'title' 			=> esc_html__( 'Preloader', 'wildnest' ),
			),
			array(
				'name'           	=> 'wildnest_enable_preloader',
				'type'            	=> 'checkbox',
				'section'         	=> 'wildnest_general_settings_preloader',
				'title'           	=> esc_html__( 'Preloader', 'wildnest' ),
				'description'     	=> esc_html__('Enable or disable preloader', 'wildnest'),
				'default'         	=> 0
			),
			array(
				'name'            	=> 'wildnest_preloader_image',
				'type'            	=> 'image',
				'section'         	=> 'wildnest_general_settings_preloader',
				'title'           	=> esc_html__( 'Image', 'wildnest' )
			),
			array(
				'name'            => 'wildnest_preloader_bg_color',
				'type'            => 'color',
				'section'         => 'wildnest_general_settings_preloader',
				'title'           => esc_html__( 'Background Color', 'wildnest' ),
				'default'         => '#000',
				'selector'    	  => ".wildnest_preloader_holder",
				'css_format' 	  => 'background-color: {{value}};'
			),

			// Popup
			array(
				'name'  			=> "wildnest_general_settings_popup",
				'type'  			=> 'section',
				'panel' 			=> 'general_settings_panel',
				'title' 			=> esc_html__( 'Popup', 'wildnest' ),
			),
			array(
				'name'           	=> 'wildnest_enable_popup',
				'type'            	=> 'checkbox',
				'section'         	=> 'wildnest_general_settings_popup',
				'title'           	=> esc_html__( 'Popup', 'wildnest' ),
				'description'     	=> esc_html__('Enable or disable popup', 'wildnest'),
				'default'         	=> 0
			),
			array(
				'name'    			=> 'wildnest_popup_design_heading',
				'type'    			=> 'heading',
				'section' 			=> 'wildnest_general_settings_popup',
				'title'   			=> esc_html__( 'Design', 'wildnest' ),
			),
			array(
				'name'            	=> 'wildnest_popup_image',
				'type'            	=> 'image',
				'section'         	=> 'wildnest_general_settings_popup',
				'title'           	=> esc_html__( 'Image', 'wildnest' ),
				'description' 	  	=> esc_html__('Set your popup image', 'wildnest'),
			),
			array(
				'name'            	=> 'wildnest_popup_content',
				'type'            	=> 'textarea',
				'section'         	=> 'wildnest_general_settings_popup',
				'default'         	=> esc_html__( 'Add custom text here or remove it', 'wildnest' ),
				'title'           	=> esc_html__( 'Content', 'wildnest' ),
				'description'     	=> esc_html__( 'Set texts and images to the content.', 'wildnest' ),
			),
			array(
				'name'    			=> 'wildnest_popup_settings_heading',
				'type'    			=> 'heading',
				'section' 			=> 'wildnest_general_settings_popup',
				'title'   			=> esc_html__( 'Settings', 'wildnest' ),
			),
			array(
                'name'       		=> 'wildnest_popup_url',
                'type'     			=> 'text',
                'title'    			=> esc_html__('URL', 'wildnest'),
                'section'       	=> 'wildnest_general_settings_popup',
            ),
			array(
				'name'            	=> 'wildnest_popup_expiring_cookie',
				'type'            	=> 'select',
				'section'         	=> 'wildnest_general_settings_popup',
				'title'           	=> esc_html__('Expiring Cookie', 'wildnest' ),
				'description'     	=> esc_html__('Select the days for when the cookies to expire.', 'wildnest'),
				'choices'         	=> array(
					'1' 	=> esc_html__( '1 Day', 'wildnest' ),
					'3'  	=> esc_html__( '3 Days', 'wildnest' ),
					'7'  	=> esc_html__( '1 Week', 'wildnest' ),
					'30'  	=> esc_html__( '1 Month', 'wildnest' ),
					'3000' 	=> esc_html__( 'Be Remembered', 'wildnest' ),
				),
				'default'   		=> '1',
			),
			array(
				'name'            	=> 'wildnest_popup_show_time',
				'type'            	=> 'select',
				'section'         	=> 'wildnest_general_settings_popup',
				'title'           	=> esc_html__('Show Popup', 'wildnest' ),
				'description'     	=> esc_html__('Select a specific time to show the popup.', 'wildnest'),
				'choices'         	=> array(
					'5000' 	=> esc_html__( '5 seconds', 'wildnest' ),
					'10000' => esc_html__( '10 seconds', 'wildnest' ),
					'20000' => esc_html__( '20 seconds', 'wildnest' )
				),
				'default'   		=> '5000',
			),

            // Contact Information
			array(
				'name'  => "wildnest_general_settings_contact",
				'type'  => 'section',
				'panel' => 'general_settings_panel',
				'title' => esc_html__( 'Contact Information', 'wildnest' ),
			),

			array(
                'name'       	=> 'wildnest_contact_address',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Address', 'wildnest'),
                'section'       => 'wildnest_general_settings_contact',
            ),
            array(
                'name'       	=> 'wildnest_contact_email',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Email', 'wildnest'),
                'section'       => 'wildnest_general_settings_contact',
            ),
            array(
                'name'       	=> 'wildnest_contact_phone',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Phone', 'wildnest'),
                'section'       => 'wildnest_general_settings_contact',
            ),

			//Back to top
			array(
				'name'  => "wildnest_general_settings_back_to_top",
				'type'  => 'section',
				'panel' => 'general_settings_panel',
				'title' => esc_html__( 'Back to Top', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_backtotop_status',
				'type'            => 'checkbox',
				'section'         => 'wildnest_general_settings_back_to_top',
				'title'           => esc_html__( 'Back to Top Button Status', 'wildnest' ),
				'default'         => 1
			),
			array(
				'name'            => 'wildnest_backtotop_bg_color',
				'type'            => 'color',
				'section'         => 'wildnest_general_settings_back_to_top',
				'title'           => esc_html__( 'Background Color', 'wildnest' ),
				'default'         => '#2695FF',
				'selector'    	  => ".wildnest-back-to-top",
				'css_format' 	  => 'background-color: {{value}};'
			),
			array(
				'name'            => 'wildnest_backtotop_icon_color',
				'type'            => 'color',
				'section'         => 'wildnest_general_settings_back_to_top',
				'title'           => esc_html__( 'Icon Color', 'wildnest' ),
				'default'         => '#FFF',
				'selector'    	  => ".wildnest-back-to-top, .wildnest-back-to-top.wildnest-is-visible:visited",
				'css_format' 	  => 'color: {{value}};'
			),
			array(
				'name'            => 'wildnest_backtotop_bg_color_hover',
				'type'            => 'color',
				'section'         => 'wildnest_general_settings_back_to_top',
				'title'           => esc_html__( 'Background Color (Hover)', 'wildnest' ),
				'default'         => '#222',
				'selector'    	  => ".wildnest-back-to-top:hover",
				'css_format' 	  => 'background-color: {{value}};'
			),
			array(
				'name'            => 'wildnest_backtotop_icon_color_hover',
				'type'            => 'color',
				'section'         => 'wildnest_general_settings_back_to_top',
				'title'           => esc_html__( 'Icon Color (Hover)', 'wildnest' ),
				'default'         => '#FFF',
				'selector'    	  => ".wildnest-back-to-top:hover",
				'css_format' 	  => 'color: {{value}};'
			),
			array(
				'name'            	=> 'wildnest_backtotop_radius',
				'type'            	=> 'css_ruler',
				'section'    		=> 'wildnest_general_settings_back_to_top',
				'device_settings' 	=> true,
				'css_format'      	=> array(
					'top'    => 'border-bottom-right-radius: {{value}};',
					'right'  => 'border-top-right-radius: {{value}};',
					'bottom' => 'border-bottom-left-radius: {{value}};',
					'left'   => 'border-top-left-radius: {{value}};',
				),
				'selector'        	=> "body .wildnest-back-to-top",
				'label'           	=> esc_html__( 'Border Radius', 'wildnest' ),
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'wildnest/customizer/config', 'wildnest_customizer_general_settings_config' );
