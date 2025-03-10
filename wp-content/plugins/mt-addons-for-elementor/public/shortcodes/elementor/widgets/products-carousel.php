<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_products_carousel extends Widget_Base {
	public function get_style_depends() {
   	 	wp_enqueue_style( 'mt-addons-products-carousel', MT_ADDONS_PUBLIC_ASSETS.'css/products-carousel.css');
      	wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');

        return [
            'mt-addons-products-carousel',
            'swiper-bundle',
        ];
    }
	use ContentControlSlider;
	use ContentControlHelp;
	
	public function get_name() {
		return 'mtfe-products-carousel';
	}
	
	public function get_title() {
		return esc_html__('MT - Product Carousel','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-product-categories';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	public function get_script_depends() {
        wp_register_script( 'swiper', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/swiperjs/swiper-bundle.min.js');
        wp_register_script( 'mt-addons-swiper', MT_ADDONS_PUBLIC_ASSETS.'js/swiper.js');
        
        return [ 'jquery', 'elementor-frontend', 'swiper', 'mt-addons-swiper' ];
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
				'label' 		=> esc_html__( 'Number of products', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'default' 		=> 3,
			]
		);
	    $product_category = array();
	    if ( class_exists( 'WooCommerce' ) ) {
	      $product_category_tax = get_terms( 'product_cat', array(
	        'parent'      => '0'
	      ));
	      if ($product_category_tax) {
	        foreach ( $product_category_tax as $term ) {
	          if ($term) {
                $product_category[$term->slug] = $term->name.' ('.$term->count.')';

	          }
	        }
	      }
	    }
		$this->add_control(
			'category',
			[
				'label' 		=> esc_html__( 'Select Category', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> 'uncategorized',
				'options' 		=> $product_category,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section',
			[
				'label' 		=> esc_html__( 'Style', 'mt-addons' ),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 			=> 'product_border',
				'selector' 		=> '{{WRAPPER}} .mt_addons_product_item',
			]
		);
		$this->add_control(
            'border_radius',
            [
                'label' 		=> esc_html__( 'Border Radius', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%', 'em' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .mt_addons_products_carousel .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' 		=> [
	                'unit' 		=> 'px',
	                'TOP' 		=> 30,
	                'LEFT' 		=> 30,
	                'BOTTOM' 	=> 30,
	                'RIGHT' 	=> 30,
	            ],
            ]
        );
		$this->add_control(
			'div_1',
			[
				'type' 			=> \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 			=> 'title_typography',
				'label' 		=> esc_html__( 'Title', 'mt-addons' ),
				'selector' 		=> '{{WRAPPER}} .mt-addons-products-carousel-archive-product-title a',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 			=> 'price_typography',
				'label' 		=> esc_html__( 'Price', 'mt-addons' ),
				'selector' 		=> '{{WRAPPER}} .mt-addons-products-carousel-price p',
			]
		);
		$this->add_control(
			'div_2',
			[
				'type' 			=> \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' 		=> esc_html__( 'Title Color', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .mt-addons-products-carousel-archive-product-title a' => 'color: {{VALUE}}',
				],
				'default' 		=> '#000000',
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'label' 		=> esc_html__( 'Title Color Hover', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .mt-addons-products-carousel-archive-product-title a:hover' => 'color: {{VALUE}}',
				],
				'default' 		=> '#2F8BFF',
			]
		);
		$this->add_control(
			'price_color',
			[
				'label' 		=> esc_html__( 'Price Color', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .mt-addons-products-carousel-price p' => 'color: {{VALUE}}',
				],
				'default' 		=> '#000000',
			]
		);
		$this->add_control(
			'border_color',
			[
				'label' 		=> esc_html__( 'Border Color', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .mt_addons_products_carousel .mt_addons_product_item' => 'border-color: {{VALUE}}',
				],
				'default' 		=> '#E8DBDA',
			]
		);
		$this->add_control(
			'border_color_hover',
			[
				'label' 		=> esc_html__( 'Border Color Hover', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .mt_addons_products_carousel .mt_addons_product_item:hover' => 'border-color: {{VALUE}}',
				],
				'default' 		=> '#000000',
			]
		);
		$this->end_controls_section();
	}
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $category 					= $settings['category'];
        $number 					= $settings['number'];
        $autoplay 					= $settings['autoplay'];
        $delay 					    = $settings['delay'];
        $items_desktop 				= $settings['items_desktop'];
        $items_mobile 				= $settings['items_mobile'];
        $items_tablet 				= $settings['items_tablet'];
        $space_items 				= $settings['space_items'];
        $touch_move 				= $settings['touch_move'];
        $effect 					= $settings['effect'];
        $grab_cursor 				= $settings['grab_cursor'];
        $infinite_loop 				= $settings['infinite_loop'];
        $columns 					= $settings['columns'];
        $layout 					= $settings['layout'];
        $centered_slides 			= $settings['centered_slides'];
        $navigation_position 		= $settings['navigation_position'];
        $navigation 				= $settings['navigation'];
        $pagination 				= $settings['pagination'];

        $args_products = array(
		    'posts_per_page'   => $number,
		    'order'            => 'DESC',
		    'post_type'        => 'product',
		    'post_status'      => 'publish',
		    'tax_query' => array(
		       array(
		        'taxonomy' => 'product_cat',
		        'field' => 'slug',
		        'terms' => $category
		       )
		     ), 
		  ); 
		$products = get_posts($args_products);

		$id = 'mt-addons-swiper-'.uniqid();
	    $carousel_item_class = $columns;
	    $carousel_holder_class = '';
	    $swiper_wrapped_start = '';
	    $carousel_item_type = '';
	    $swiper_wrapped_end = '';
	    $swiper_container_start = '';
	    $swiper_container_end = '';
	    $html_post_swiper_wrapper = '';

	    if ($layout == "carousel") {
	      	$carousel_holder_class = 'mt-addons-swipper swiper';
	      	$carousel_item_class = 'swiper-slide';
	      	$carousel_item_type = '';

	      	$swiper_wrapped_start = '<div class="swiper-wrapper">';
	      	$swiper_wrapped_end = '</div>';

	      	$swiper_container_start = '<div class="mt-addons-swiper-container">';
	      	$swiper_container_end = '</div>';

		    if($navigation == "true") {
		        // next/prev
		        $html_post_swiper_wrapper .= '
		        <i class="far fa-arrow-left swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></i>
		        <i class="far fa-arrow-right swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></i>';
		    }

		    if ($pagination == "true") {
		        // next/prev
		        $html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
		    }		
		} else {
		  	$carousel_holder_class = 'mtfe-row';
		  	$carousel_item_type = 'grid-item';
		} ?>
		<?php echo wp_kses_post($swiper_container_start); ?>
			<div class="mt-swipper-carusel-position">
			    <div id="<?php echo esc_attr($id); ?>" 
			        <?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?> 
			        class="mt_addons_products_carousel <?php echo esc_attr($carousel_holder_class); ?>">
			          	<?php echo wp_kses_post($swiper_wrapped_start); ?>
			            <?php foreach ($products as $prod) {
			              	global $product;
			              	$product = wc_get_product( $prod->ID );
			              	$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $prod->ID ), 'medium' );
			              	?>
			              	<div id="product-id-<?php echo esc_attr($prod->ID);?>" class="mt_addons_product_item <?php echo esc_attr($carousel_item_class); ?> <?php echo esc_attr($carousel_item_type); ?>">
			                	<div class="mt-addons-products-carousel-slider-wrapper">
			                  		<?php 
			                  		if ($thumbnail_src) { ?>
			                    		<div class="mt-addons-products-carousel-thumbnail-and-details">
			                      			<a class="mt_addons_products_carousel_media_image" title="<?php echo esc_attr($prod->post_title);?>" href="<?php echo esc_url(get_permalink($prod->ID))?>"><img class="mt_addons_products_carousel_post_image" src="<?php echo esc_url($thumbnail_src[0]); ?>" alt="<?php echo esc_attr($prod->post_title); ?>" /></a>
			                    		</div><?php 
			                  		} ?>

			                  		<div class="mt-addons-products-carousel-title-metas">
			                    		<h3 class="mt-addons-products-carousel-archive-product-title">
			                      			<a href="<?php echo esc_url(get_permalink($prod->ID)); ?>" title="<?php echo esc_html($prod->post_title); ?>" ><?php echo esc_html($prod->post_title);?></a>
			                    		</h3>
			                    		<div class="mt-addons-products-carousel-price">
			                      			<?php if($product->get_price_html()) { ?>
			                        			<p><?php echo wp_kses($product->get_price_html(), 'price'); ?></p>
			                      			<?php } ?>
			                    		</div>
			                  		</div>
			                	</div>
			              	</div>
			            <?php } ?>
			          	<?php echo wp_kses_post($swiper_wrapped_end); ?>
			        	<?php echo wp_kses_post($html_post_swiper_wrapper); ?>
			      	</div>
			   		<?php echo wp_kses_post($swiper_container_end); ?>
				</div>
	    <?php
		}	
	protected function content_template() {
    }
}