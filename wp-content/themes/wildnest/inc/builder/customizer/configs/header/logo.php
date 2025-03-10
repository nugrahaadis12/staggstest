<?php

class Wildnest_Builder_Item_Logo {
	public $id = 'logo';

	function item() {
		return array(
			'name'    => esc_html__( 'Logo', 'wildnest' ),
			'id'      => 'logo',
			'width'   => '3',
			'section' => 'title_tagline',
		);
	}

	function customize( $wp_customize ) {
		$section      = 'title_tagline';
		$render_cb_el = array( $this, 'render' );
		$selector     = '.logo.logo-image';
		$fn           = 'wildnest_customize_render_header';
		$config       = array(
			array(
				'name'     		  	=> 'wildnest_logo_heading',
				'type'     		  	=> 'heading',
				'section'  		  	=> $section,
				'title'    		  	=> esc_html__( 'Logo', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_logo_max_width',
				'type'            => 'slider',
				'section'         => $section,
				'default'         => array(),
				'max'             => 400,
				'device_settings' => true,
				'title'           => esc_html__( 'Logo Max Width', 'wildnest' ),
				'selector'        => 'format',
				'css_format'      => "$selector img { max-width: {{value}}; } .cb-row--mobile .logo.logo-image img { width: {{value}}; } ",
			),
			array(
				'name'            => 'wildnest_logo',
				'type'            => 'image',
				'section'         => $section,
				'title'           => esc_html__( 'Logo', 'wildnest' ),
			),
			array(
				'name'            => 'wildnest_logo_sticky',
				'type'            => 'image',
				'section'         => $section,
				'title'           => esc_html__( 'Logo (For Sticky Header)', 'wildnest' ),
			),
			array(
				'name'     		  	=> 'wildnest_favicon_heading',
				'type'     		  	=> 'heading',
				'section'  		  	=> $section,
				'title'    		  	=> esc_html__( 'Favicon', 'wildnest' ),
			),
		);

		$config = apply_filters( 'wildnest/builder/header/logo-settings', $config, $this );

		// Item Layout.
		return array_merge( $config, wildnest_header_layout_settings( $this->id, $section ) );
	}

	function logo() {
		$logo_id = get_theme_mod( 'wildnest_logo' );
		$logo_image = Wildnest()->get_media( $logo_id, 'full' );
		
		$logo_sticky_id = get_theme_mod( 'wildnest_logo_sticky' );
		$logo_sticky_image = Wildnest()->get_media( $logo_sticky_id, 'full' );

		// Metaboxes
        $mt_metabox_header_logo = get_post_meta( get_the_ID(), 'mt_metabox_header_logo', true );
        $mt_metabox_header_logo_sticky = get_post_meta( get_the_ID(), 'mt_metabox_header_logo_sticky', true );
        if (is_page()) {
        	if (isset($mt_metabox_header_logo) && $mt_metabox_header_logo != '') {
        		if($mt_metabox_header_logo) {
        			echo '<a href="'.esc_url(home_url()).'"><img class="wildnest-logo" src="'.esc_url($mt_metabox_header_logo).'" alt="'.esc_attr(get_bloginfo()).'" /></a>';
        			echo '<a href="'.esc_url(home_url()).'"><img class="wildnest-logo-sticky" src="'.esc_url($mt_metabox_header_logo_sticky).'" alt="'.esc_attr(get_bloginfo()).'" /></a>';
                } else { 
                    echo '<a href="'.esc_url(home_url()).'"><img class="wildnest-logo" src="'.esc_url($logo_image).'" alt="'.esc_attr(get_bloginfo()).'" /></a>';
        			echo '<a href="'.esc_url(home_url()).'"><img class="wildnest-logo-sticky" src="'.esc_url($logo_sticky_image).'" alt="'.esc_attr(get_bloginfo()).'" /></a>';
                }
			} else {
				if ( $logo_image ) {
					echo '<a href="'.esc_url(home_url()).'"><img src="'.esc_url($logo_image).'" alt="'.esc_attr(get_bloginfo()).'" /></a>';
				} else {
					echo '<p class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.esc_attr(get_bloginfo()).'</a>
					</p>';
				}
			}
		} else {
			if ( $logo_image ) {
				echo '<a href="'.esc_url(home_url()).'"><img src="'.esc_url($logo_image).'" alt="'.esc_attr(get_bloginfo()).'" /></a>';
			} else {
				echo '<p class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.esc_attr(get_bloginfo()).'</a>
					</p>';
			}
		}
	}

	/**
	 * Render Logo item
	 *
	 * @see get_custom_logo
	 */
	function render() {
		$logo_classes   = array( 'logo logo-image' );
		$logo_classes   = apply_filters( 'wildnest/logo-classes', $logo_classes );
		$tag = is_customize_preview() ? 'h2' : '__site_device_tag__';
		?>

		<div class="<?php echo esc_attr( join( ' ', $logo_classes ) ); ?>">
			<?php $this->logo(); ?>
		</div>
		<?php
	}
}

Wildnest_Customize_Layout_Builder()->register_item( 'header', new Wildnest_Builder_Item_Logo() );
