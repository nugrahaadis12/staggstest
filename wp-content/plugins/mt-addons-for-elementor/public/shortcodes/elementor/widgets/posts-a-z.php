<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_posts_a_z extends Widget_Base {
	
	public function get_style_depends() {
  		wp_enqueue_style( 'mt-addons-posts-a-z', MT_ADDONS_PUBLIC_ASSETS.'css/posts-a-z.css');

        return [
            'mt-addons-posts-a-z',
        ];
    }
	public function get_name() {
		return 'mtfe-posts-a-z';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Posts A-Z','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-post-list';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_posts_az();
        $this->section_help_settings();
    }

    private function section_posts_az() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
    	$all_posts = mt_addons_posts_array('page');
		$this->add_control(
			'post_types',
			[
				'label' 			=> esc_html__( 'Select Post Type', 'mt-addons' ),
          		'description' 		=> esc_html__( 'Only Choose one. If more than one are selected, the A-Z list will only show posts from the 1st selected type.', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SELECT,
				'default' 			=> 'post',
				'options' 			=> [
					'post'    			=> esc_html__( 'Post', 'mt-addons' ),
					'page' 	  			=> esc_html__( 'Page', 'mt-addons' ),
					'product' 			=> esc_html__( 'Product', 'mt-addons' ),
				],
			]
		);
		$this->add_control( 
			'excluded_ids',
			[
				'label' 			=> esc_html__( 'Exclude Items from the list', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SELECT2,
				'multiple' 			=> true,
				'options' 			=> $all_posts,
			]
		);
		$this->end_controls_section();
        $this->start_controls_section(
            'style_posts',
            [
                'label' 			=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'alignment',
            [
                'label'   			=> esc_html__( 'Alignment', 'mt-addons' ),
                'type'    			=> Controls_Manager::CHOOSE,
                'options' 			=> [
                    'left'   		=> [
                        'title' 		=> esc_html__( 'Left', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-left',
                    ],
                    'center' 		=> [
                        'title' 		=> esc_html__( 'Center', 'mt-addons' ),
                        'icon'  		=> 'eicon-text-align-center',
                    ],
                    'right'  		=> [
                        'title' 		=> esc_html__( 'Right', 'mt-addons' ),
                        'icon' 	 		=> 'eicon-text-align-right',
                    ],
                ],
                'default' 			=> 'left',
                'toggle'  			=> false,
                'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-posts-a-z-shortcode' => 'text-align: {{VALUE}};',
                ],  
            ]
        ); 
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'first_letters_typography',
				'label' 			=> esc_html__( 'A-Z Letters Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-posts-a-z-first-letter',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 				=> 'title_typography',
				'label' 			=> esc_html__( 'Title Typography', 'mt-addons' ),
                'selector' 			=> '{{WRAPPER}} .mt-addons-posts-a-z-listings-list a',
            ]
        );
        $this->add_control(
			'az_letters_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'A-Z Letters Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-posts-a-z-first-letter' => 'color: {{VALUE}};',
                ],
                'default' 			=> '#000000',
			]
		);
	    $this->add_control(
			'title_background',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Background', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-posts-a-z-listings-list li' => 'background: {{VALUE}};',
                ],
                'default' 			=> '#7B51AD',
			]
		);
    	$this->add_control(
			'title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-posts-a-z-listings-list a' => 'color: {{VALUE}};',
                ],
                'default' 			=> '#ffffff',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'post_border',
				'selector' => '{{WRAPPER}} .mt-addons-posts-a-z-listings-list li',
			]
		);
		$this->add_control(
            'post_padding',
            [
                'label' 			=> esc_html__( 'Padding', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' 			=> [
                    'top' 				=> 15,
                    'right' 			=> 30, 
                    'bottom' 			=> 15,
                    'left' 				=> 30,
                    'unit' 				=> 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-posts-a-z-listings-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'post_margin', 
            [
                'label' 			=> esc_html__( 'Margin', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' 			=> [
                    'top' 				=> 0,
                    'right' 			=> 0, 
                    'bottom' 			=> 5,
                    'left' 				=> 0,
                    'unit' 				=> 'px',
                ],
                'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-posts-a-z-listings-list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();
	}

	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $post_types 				= $settings['post_types'];
        $excluded_ids 				= $settings['excluded_ids'];
        $alignment 					= $settings['alignment'];
        $post_padding 				= $settings['post_padding'];
        $post_margin 				= $settings['post_margin'];

		$post_types 	= explode(',', $post_types);
		$exclude 		= explode(',', $excluded_ids);

		$sorted 		= array();
		$args_listings 	= array(
		    'numberposts' => -1,
		    'orderby'          => 'title',
		    'order'            => 'ASC',
		    'post_type'        => $post_types[0],
		    'post_status'      => 'publish',
		    'exclude'          => $exclude,
		);

		$posts = get_posts( $args_listings );
		foreach ( $posts as $post ) {
		    setup_postdata( $post );
		    $name = strtolower( $post->post_title );
		    if ($name) {
		      $char = $name[0];
		      if ( ! isset( $sorted[ $char ] ) ) {
		        $sorted[ $char ] = array();
		      }
		      $sorted[ $char ][$post->ID] = $post->post_title;
		    }
		}
		ksort( $sorted );
		?>
		<div class="mt-addons-posts-a-z-shortcode">
	    	<?php foreach ( $sorted as $character => $listings ) { ?>
	     		<span class="mt-addons-posts-a-z-first-letter"><?php echo esc_html($character); ?></span></br>
	    		<ul class="mt-addons-posts-a-z-listings-list">
		        	<?php foreach ( $listings as $listing_id => $listing ) { ?>
		        		<li><a href="<?php echo esc_url(get_permalink($listing_id)); ?>" title="<?php echo esc_attr($listing); ?>"><?php echo esc_html($listing); ?></a></li>
		        	<?php } ?>
	      		</ul>
	    	<?php } ?>
	    	<?php wp_reset_postdata(); ?>
		</div>
	<?php
	}
	protected function content_template() {

    }
}