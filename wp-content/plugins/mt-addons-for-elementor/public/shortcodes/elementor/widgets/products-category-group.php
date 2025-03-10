<?php
namespace Elementor; 

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlSlider;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_products_category_group extends Widget_Base {
	public function get_style_depends() {
   	 	wp_enqueue_style( 'mt-addons-collectors-group', MT_ADDONS_PUBLIC_ASSETS.'css/products-category-group.css');
      	wp_enqueue_style( 'swiper-bundle', MT_ADDONS_PUBLIC_ASSETS.'css/plugins/swiperjs/swiper-bundle.min.css');
        return [
            'mt-addons-collectors-group',
            'swiper-bundle',
        ];
    }
	use ContentControlSlider;
	use ContentControlHelp;
	public function get_name() {
		return 'mtfe-products-category-group';
	}
	
	public function get_title() {
		return esc_html__( 'MT - Product Category Group', 'mt-addons' );
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
                'label' 			=> esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $this->add_control(
			'images_status',
			[
				'label' 			=> esc_html__( 'Disable Images Wrapper', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Show', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'Hide', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
		$this->add_control(
			'number',
			[
				'label' 			=> esc_html__( 'Number of items', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> '4',
				'options' 			=> [
					''         			=> esc_html__( 'Select Option', 'mt-addons' ),
					'one-item' 			=> esc_html__( '1', 'mt-addons' ),
					'2' 	   			=> esc_html__( '2', 'mt-addons' ),
					'4' 	   			=> esc_html__( '4', 'mt-addons' ),
				],
				'condition' 		=> [
					'images_status' 	=> 'yes',
	            ],
			]
		);
		$this->add_control(
			'featured_image_size',
				[
					'label' 		=> esc_html__( 'Featured Image size', 'mt-addons' ),
					'label_block' 	=> true,
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> mt_addons_image_sizes_array(),
					'condition' 	=> [
						'images_status' => 'yes',
		            ],
				]
		);
		$this->add_control(
			'title_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-info-wrapper span.mt-addons-title' => 'color: {{VALUE}};',
				],
				'default' 			=> '#fff',
			]
		);
		$this->add_control(
			'items_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Items Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-subtitle strong' => 'color: {{VALUE}};',
				],
				'default' 			=> '#fff',
			]
		);
		$this->add_control(
			'items_bg_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Items Backgroud Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-subtitle' => 'background: {{VALUE}};',
				],
				'default' 			=> '#111',
			]
		);
	    $product_category = array();
	    if ( class_exists( 'WooCommerce' ) ) {
	      $product_category_tax = get_terms( 'product_cat', array(
	        'parent'      		=> 0,
	        'hide_empty'      	=> 1,
	      ));
	      if ($product_category_tax) {
	        foreach ( $product_category_tax as $term ) {
	          if ($term) {
	             $product_category[$term->slug] = $term->name.' ('.$term->count.')';
	          }
	        }
	      }
	    }
	    $repeater = new \Elementor\Repeater();
	    $repeater->add_control(
			'category',
				[
					'label' 		=> esc_html__( 'Select Category', 'mt-addons' ),
					'label_block' 	=> true,
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> $product_category,
					'default' 		=> 'uncategorized',
				]
		);
	    $repeater->add_control(
			'wrapper_category_bg_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}};',
				],
				'default' 			=> '#0960f0',
			]
		);
		$this->add_control(
	        'collectors_groups',
	        [
	            'label' 			=> esc_html__('Items', 'mt-addons'),
	            'type' 				=> Controls_Manager::REPEATER,
	            'fields' 			=> $repeater->get_controls(),
	            'default' 			=> [
                    [
                        'category' 					=> esc_html__( 'uncategorized', 'mt-addons' ),
                        'wrapper_category_bg_color' => esc_attr( '#ffa341', 'mt-addons' ),
                    ],
                    [
                        'category' 					=> esc_html__( 'uncategorized', 'mt-addons' ),
                        'wrapper_category_bg_color' => esc_attr( '#f08009', 'mt-addons' ),
                    ],
                    [
                        'category' 					=> esc_html__( 'uncategorized', 'mt-addons' ),
                        'wrapper_category_bg_color' => esc_attr( '#C16927', 'mt-addons' ),
                    ],
                ],
	        ]
	    );
		$this->end_controls_section();
	}
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $number 					= $settings['number'];
        $featured_image_size 		= $settings['featured_image_size'];
        $collectors_groups 			= $settings['collectors_groups'];
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
        $nav_style 					= $settings['nav_style'];
        $navigation_color 			= $settings['navigation_color'];
        $navigation_bg_color 		= $settings['navigation_bg_color'];
        $navigation_bg_color_hover 	= $settings['navigation_bg_color_hover'];
        $navigation_color_hover 	= $settings['navigation_color_hover'];
        $pagination_color 			= $settings['pagination_color'];
        $navigation 				= $settings['navigation'];
        $pagination 				= $settings['pagination'];
        $images_status 				= $settings['images_status'];


	    $id = 'mt-addons-carousel-'.uniqid();
	    $carousel_item_class = $columns;
	    $carousel_holder_class = '';
	    $swiper_wrapped_start = '';
	    $swiper_wrapped_end = '';
	    $swiper_container_start = '';
	    $swiper_container_end = '';
	    $html_post_swiper_wrapper = '';

	    if ($layout == "carousel" or $layout == " ") {
	    	$carousel_holder_class = 'mt-addons-swipper swiper';
	    	$carousel_item_class = 'swiper-slide';
	    	$swiper_wrapped_start = '<div class="swiper-wrapper">';
	    	$swiper_wrapped_end = '</div>';
	    	$swiper_container_start = '<div class="mt-addons-swiper-container">';
	    	$swiper_container_end = '</div>';
	      
	    	if($navigation == "yes") { 
	        	// next/prev
	        	$html_post_swiper_wrapper .= '
	        	<i class="fas fa-arrow-left swiper-button-prev '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></i>
	        	<i class="fas fa-arrow-right swiper-button-next '.esc_attr($nav_style).' '.esc_attr($navigation_position).'"></i>';
	      	}
	      	if($pagination == "yes") { 
	        	// pagination
	        	$html_post_swiper_wrapper .= '<div class="swiper-pagination"></div>';
	      	}
	    }
		?>
	    <?php //swiper container start ?>
	    <?php echo wp_kses_post($swiper_container_start); ?>
	    	<div class="mt-swipper-carusel-position relative">
		    	<div id="<?php echo esc_attr($id); ?>" 
		        	<?php mt_addons_swiper_attributes($id, $autoplay, $delay, $items_desktop, $items_mobile, $items_tablet, $space_items, $touch_move, $effect, $grab_cursor, $infinite_loop, $centered_slides); ?> class="mt-addons-collectors-carusel <?php echo esc_attr($carousel_holder_class); ?> mtfe-row">

		        	<?php //swiper wrapped start ?>
		        	<?php echo wp_kses_post($swiper_wrapped_start); ?>
		            	<?php if ($collectors_groups) { ?>
		              		<?php foreach ($collectors_groups as $collector) {
				                $category 	= $collector['category'];
				                $cat 		= get_term_by('slug', $category, 'product_cat');
				                if($cat) {
				                	$cat_link  		= get_term_link( $category, 'product_cat' );
				                	$cat_img_id 	= get_term_meta( $cat->term_id, 'thumbnail_id', true );  
				               		$category_src 	= wp_get_attachment_image_src( $cat_img_id, 'medium' );
					                $args_prods 	= array(
					                    'posts_per_page'   => $number,
					                    'order'            => 'ASC',
					                    'post_type'        => 'product',
					                    'tax_query' => array(
					                      	array(
					                        	'taxonomy' => 'product_cat',
					                        	'field'    => 'slug',
					                        	'terms'    => $category
					                      	)
					                    ),
					                    'post_status'      => 'publish' 
					                ); 
					                $prods 		= get_posts($args_prods); 
					                $image_size = 'medium';
					                if ($featured_image_size) {
					                  $image_size = $featured_image_size;
					                }
				                	?>

					                <div class="mt-addon-cols <?php echo esc_attr($carousel_item_class); ?>">
					                    <?php if ($images_status == "yes") { ?>        
						                	<div class="mt-addons-images-wrapper <?php echo esc_attr($number); ?>">
						                    	<?php foreach ($prods as $prod) {
						                      		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $prod->ID ), $image_size );
						                      		if ($thumbnail_src) { ?>        
						                        		<a class="mt_media_image" title="<?php echo esc_attr($prod->post_title); ?>" href="<?php echo esc_url(get_permalink($prod->ID)); ?>">
						                          		<img class="portfolio_post_image <?php echo esc_attr($number); ?>" src="<?php echo esc_url($thumbnail_src[0]); ?>" alt="<?php echo esc_attr($prod->post_title);?>" />
						                        		</a> 
						                      		<?php }
						                    	} ?>
						                  	</div>
						                <?php } ?>
					                  	<div class="mt-addons-info-wrapper elementor-repeater-item-<?php echo esc_attr( $collector['_id'] ); ?>">
					                    	<a class="#categoryid_<?php echo esc_attr($cat->term_id);?>" href="<?php echo esc_url($cat_link);?>"><span class="mt-addons-title"><?php echo esc_html($cat->name);?></span></a>
						                    <span class="mt-addons-subtitle">
						                      <strong>
						                        <?php 
						                        printf(esc_html(
						                            _n(
						                                '%s item',
						                                '%s items',
						                                $cat->count,
						                                'mt-addons'
						                            )
						                          ),
						                          number_format_i18n($cat->count)
						                        ); ?>
						                      </strong>
						                    </span><br>
					                  	</div> 
					                </div>
					            <?php } ?>
				            <?php } ?>
		            	<?php } ?>
		          	<?php //swiper wrapped end ?>
		          	<?php echo wp_kses_post($swiper_wrapped_end); ?>
			        <?php //pagination/navigation ?>
			    	<?php echo wp_kses_post($html_post_swiper_wrapper); ?>
		      	</div>
	      	<?php //swiper container end ?>
	      	<?php echo wp_kses_post($swiper_container_end); ?>
	 	 </div>
	    <?php
	}
	protected function content_template() {

    }
}