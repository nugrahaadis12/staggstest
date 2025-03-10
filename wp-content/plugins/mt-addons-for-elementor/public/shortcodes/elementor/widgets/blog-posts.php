<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_blog_posts extends Widget_Base {
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-blog-posts', MT_ADDONS_PUBLIC_ASSETS.'css/blog-posts.css');
      	wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');

        return [
            'mt-addons-blog-posts', 
            'swiper-bundle',
        ];
    }
    public function get_script_depends() {
        
        wp_register_script( 'swiper', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/swiperjs/swiper-bundle.min.js');
        wp_register_script( 'mt-addons-swiper', MT_ADDONS_PUBLIC_ASSETS.'js/swiper.js');
        
        return [ 'jquery', 'elementor-frontend', 'swiper', 'mt-addons-swiper' ];
    }
	use ContentControlSlider;
	use ContentControlHelp;
	public function get_name() {
		return 'mtfe-blog-posts';
	}
	
	public function get_title() {
		return esc_html__('MT - Blog Posts');
	}
	
	public function get_icon() {
		return 'eicon-post-list';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {

        $this->section_title();
        $this->section_slider_hero_settings();
        $this->section_help_settings();
    }
    private function section_title() {

        $this->start_controls_section(
            'section_title',
            [
                'label' 		=> esc_html__( 'Content', 'mt-addons' ),
            ]
        );	

		$this->add_control(
			'number',
			[
				'label' 		=> esc_html__( 'Number', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'default' 		=> 3,
			]
		);
	    $post_category_tax 	= get_terms('category');
	    $post_category 		= array();
	    $post_category[''] 	= esc_html__('- Select Category -', 'mt-addons');
	    if ($post_category_tax) {
	      foreach ( $post_category_tax as $term ) {
	        $post_category[$term->slug] = $term->name;
	      }
	    }
	    $this->add_control(
			'category',
			[
				'label' 		=> esc_html__( 'Category (Optional)', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> $post_category,
				'default' 		=> '',
			]
		);
		$this->add_control(
			'featured_image_size',
			[
				'label' 		=> esc_html__( 'Featured Image size', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> mt_addons_image_sizes_array(),
				'default' 		=> 'large',
			]
		);
		$this->add_control(
			'comments_blog',
			[
				'label' 		=> esc_html__( 'Comments', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 	=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
		$this->add_control(
			'excerpt_blog',
			[
				'label' 		=> esc_html__( 'Excerpt', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 	=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 	=> 'yes',
				'default'		=> 'yes',
			]
		);
		$this->add_control(
			'excerpt_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Excerpt text Color', 'mt-addons' ),
				'label_block' 	=> true,
				'condition' 	=> [
					'excerpt_blog' => 'yes',
				],
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-excerpt p' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'date_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Date text Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-carousel-date, {{WRAPPER}} .mt-addons-blog-posts-carousel-date a' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'image_post',
			[
				'label' 		=> esc_html__( 'Image', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 	=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'title_tab',
			[
				'label' 		=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		$this->add_control(
			'title_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Title color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-carousel-post-name a' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Title Color Hover ', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-carousel-post-name a:hover' => 'color: {{VALUE}};',
    			],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 		=> esc_html__( 'Title Typography', 'mt-addons' ),
				'name' 			=> 'title_typography',
				'selector' 		=> '{{WRAPPER}} .mt-addons-blog-posts-carousel-post-name',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'container_tab',
			[
				'label' 		=> esc_html__( 'Container', 'mt-addons' ),
			]
		);
		$this->add_control(
			'container_bg_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Background color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-carousel-single-post-wrapper' => 'background-color: {{VALUE}};',
    			],
				'default' 		=> '#ffffff',
			]
		);
		$this->add_control(
            'container_padding',
	        [
	            'label' 		=> esc_html__( 'Padding', 'mt-addons' ),
	            'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	            'size_units' 	=> [ 'px', '%', 'em' ],
	            'selectors' 	=> [
	                '{{WRAPPER}} .mt-addons-blog-posts-carousel-head-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	            'default' 		=> [
	                'unit' 		=> 'px',
	                'size' 		=> 0,
	            ],
	        ]
	    );
	    $this->add_control(
            'container_radius',
	        [
	            'label' 		=> esc_html__( 'Border Radius', 'mt-addons' ),
	            'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	            'size_units' 	=> [ 'px', '%', 'em' ],
	            'selectors' 	=> [
	                '{{WRAPPER}} .mt-addons-blog-posts-carousel-head-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	        	],
	        	'default' 		=> [
	            	'unit' 		=> 'px',
	            	'size' 		=> 0,
	        	],
	        ]
	    );
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     		=> 'container_border',
                'label'    		=> esc_html__( 'Border', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .mt-addons-blog-posts-carousel-head-content',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     		=> 'container_box_shadow',
                'selector' 		=> '{{WRAPPER}} .mt-addons-blog-posts-carousel-single-post-wrapper',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
			'button_tab',
			[
				'label' 		=> esc_html__( 'Button', 'mt-addons' ),
			]
		);
		$this->add_control(
			'read_more_btn',
			[
				'label' 		=> esc_html__( 'Button Text', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> esc_html__('View More','mt-addons'),
			]
		);
		$this->add_control(
			'button_background',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Button Background', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-carousel-content-inside' => 'background-color: {{VALUE}};',
    			],
				'default' 		=> '#000000',
			]
		);
		$this->add_control(
			'button_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Button text Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
        			'{{WRAPPER}} .mt-addons-blog-posts-carousel-custom a' => 'color: {{VALUE}};',
    			],
				'default' 		=> '#ffffff',
			]
		);
		$this->end_controls_section();

	}
	
	protected function render() {
		global $wp_query;
       	$settings 					= $this->get_settings_for_display();
        $number 					= $settings['number'] ?? '';
        $category 					= $settings['category'] ?? '';
        $featured_image_size 		= $settings['featured_image_size'] ?? '';
        $read_more_btn 				= $settings['read_more_btn'] ?? '';
        $comments_blog 				= $settings['comments_blog'] ?? '';
        $excerpt_blog 				= $settings['excerpt_blog'] ?? '';
        $image_post 				= $settings['image_post'] ?? '';
        $autoplay 					= $settings['autoplay'] ?? '';
        $delay 					    = $settings['delay'] ?? '';
        $items_desktop 				= $settings['items_desktop'] ?? '';
        $items_mobile 				= $settings['items_mobile'] ?? '';
        $items_tablet 				= $settings['items_tablet'] ?? '';
        $space_items 				= $settings['space_items'] ?? '';
        $touch_move 				= $settings['touch_move'] ?? '';
        $effect 					= $settings['effect'] ?? '';
        $grab_cursor 				= $settings['grab_cursor'] ?? '';
        $infinite_loop 				= $settings['infinite_loop'] ?? '';
        $columns 					= $settings['columns'] ?? '';
        $layout 					= $settings['layout'] ?? '';
        $centered_slides 			= $settings['centered_slides'] ?? '';
        $navigation_position 		= $settings['navigation_position'] ?? '';
        $nav_style 					= $settings['nav_style'] ?? '';
        $navigation_color 			= $settings['navigation_color'] ?? '';
        $navigation_bg_color 		= $settings['navigation_bg_color'] ?? '';
        $navigation_bg_color_hover 	= $settings['navigation_bg_color_hover'] ?? '';
        $navigation_color_hover 	= $settings['navigation_color_hover'] ?? '';
        $pagination_color 			= $settings['pagination_color'] ?? '';
        $navigation 				= $settings['navigation'] ?? '';
        $pagination 				= $settings['pagination'] ?? '';

		$args_posts = array(
      		'posts_per_page'        => $number,
      		'post_type'             => 'post',
      		'post_status'           => 'publish' 
    	);

    	if ($category) {
      		$args_posts['tax_query'] = array(
        		array(
          			'taxonomy' => 'category',
          			'field'    => 'slug',
          			'terms'    => $category 
        		)
      		);
    	}
    	$posts = new \WP_Query( $args_posts );

    	if ($read_more_btn) {
        	$button_text_value = $read_more_btn;
    	}else{
        	$button_text_value = esc_html__('Read More', 'mt-addons');
    	}

    	$id = 'mt-addons-swipper-'.uniqid();
    	$carousel_item_class = $columns;
	    $carousel_holder_class = '';
	    $swiper_wrapped_start = '';
	    $swiper_wrapped_end = '';
	    $swiper_container_start = '';
	    $swiper_container_end = '';
	    $html_post_swiper_wrapper = '';

    	if ($layout == "carousel" or $layout == "") {
      		$carousel_holder_class = 'mt-addons-swipper swiper';
      		$carousel_item_class = 'swiper-slide';

      		$swiper_wrapped_start = '<div class="swiper-wrapper">';
      		$swiper_wrapped_end = '</div>';

        	$swiper_container_start = '<div class="mt-addons-swiper-container">';
        	$swiper_container_end = '</div>';

      		if($navigation == "yes") { 
        		// next/prev
        		$html_post_swiper_wrapper .= '
        			<i class="fas fa-arrow-left swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'" style="color:'.esc_attr($navigation_color).'; background:'.esc_attr($navigation_bg_color).';"></i>
        			<i class="fas fa-arrow-right swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'" style="color:'.esc_attr($navigation_color).'; background:'.esc_attr($navigation_bg_color).';"></i>';
      		}

      		if($pagination == "yes") { 
          		// next/prev
        		$html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
      		}
    	} ?>

    	<?php //swiper container start ?>
    	<?php echo wp_kses_post($swiper_container_start); ?>
      	<div class="mt-swipper-carusel-position">
        	<div id="<?php echo esc_attr($id); ?>" 
          		<?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?>
          		class="mt-addons-blog-posts-carousel mtfe-row <?php echo esc_attr($carousel_holder_class); ?>">

          		<?php //swiper wrapped start ?>
          		<?php echo wp_kses_post($swiper_wrapped_start); ?> 
                   
            	<?php if ( $posts->have_posts() ) : ?>
                	<?php /* Start the Loop */ ?>
                	<?php
                	while ( $posts->have_posts() ) : $posts->the_post(); 

                  		$image_size = 'medium';
                  		if ($featured_image_size) {
                    		$image_size = $featured_image_size;
                  		}
                  		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );
                  		$comments_count = wp_count_comments(get_the_ID());
                  		$post_content = get_post_field('post_content', get_the_ID()); ?>

                  		<div class="mt-addons-blog-posts-carousel-single-post <?php echo esc_attr($carousel_item_class); ?>">
                    		<div class="mt-addons-blog-posts-carousel-single-post-wrapper">
	                    		<?php if($image_post == 'yes') { ?>
	                      			<div class="mt-addons-blog-posts-carousel-custom"> 
	                        			<div class="mt-addons-blog-posts-carousel-thumbnail">
	                            		<?php if($thumbnail_src) { ?>
	                              			<div class="mt-addons-blog-featured-image">
	                                			<img src="<?php echo esc_url($thumbnail_src[0]);?>" alt="<?php echo esc_attr(get_the_title());?>" />
	                                			<div class="mt-addons-blog-posts-carousel-button">
	                                  				<div class="mt-addons-blog-posts-carousel-content-inside">
	                                    				<a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="relative"><?php echo esc_html($button_text_value); ?></a>
	                                  				</div>
	                                			</div>
	                              			</div>
	                            		<?php } ?>
	                        			</div>
	                      			</div>
	                 			<?php } ?>
	                      		<div class="mt-addons-blog-posts-carousel-head-content">
	                        		<div class="mt-addons-blog-posts-carousel-date">
	                          			<span><?php echo get_the_time(get_option('date_format'), get_the_ID());?></span>
	                          				<?php if(($comments_blog == "yes") || $comments_blog == "true") { ?>
	                            				| <a href="<?php echo get_comments_link(get_the_ID()); ?>"><span><?php echo sprintf( _n( '%s Comment', '%s Comments', $comments_count->approved, 'mt-addons' ), number_format_i18n( $comments_count->approved ) ); ?></span></a>
	                          				<?php } ?>
	                        		</div>
	                        		<h3 class="mt-addons-blog-posts-carousel-post-name"><a href="<?php echo esc_url(get_permalink(get_the_ID()));?>"><?php the_title(); ?></a></h3>
	                        		<?php if($excerpt_blog == "yes") { ?>
	                           			<div class="mt-addons-blog-posts-excerpt"><p><?php echo strip_tags(mt_addons_excerpt_limit($post_content, 15));?>...</p></div>
	                        		<?php }else { ?>
	                          			<?php if ($excerpt_blog == "true") { ?>
	                            			<div class="mt-addons-blog-posts-excerpt"><p><?php echo strip_tags(mt_addons_excerpt_limit($post_content, 15));?>...</p></div>
	                          			<?php } ?>
	                        		<?php } ?>
	                      		</div>
                    		</div>
                  		</div>

                		<?php endwhile; ?>
                		<?php wp_reset_postdata(); ?>
            		<?php else : ?>
                		<?php //no posts found ?>
            	<?php endif; ?>
		        <?php //swiper wrapped end ?>
		        <?php echo wp_kses_post($swiper_wrapped_end); ?>
		        <?php //pagination/navigation ?>
		        <?php echo wp_kses_post($html_post_swiper_wrapper); ?>
        	</div>
      	</div>
    	<?php //swiper container end ?>
    	<?php echo wp_kses_post($swiper_container_end);
	}
	protected function content_template() {

    }
}