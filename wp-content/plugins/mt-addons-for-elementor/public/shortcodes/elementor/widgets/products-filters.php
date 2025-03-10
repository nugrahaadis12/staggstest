<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_products_filters extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-product-filters', MT_ADDONS_PUBLIC_ASSETS.'css/product-filters.css');
        return [
            'mt-addons-product-filters',
        ];
    }
	public function get_name() {
		return 'mtfe-products-filters'; 
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__( 'MT - Product Filters', 'mt-addons' );
	}
	
	public function get_icon() {
		return 'eicon-filter';
	} 
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	public function get_script_depends() {
    	
    	wp_enqueue_script( 'mt-addons-filters-main', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/filters/filters-main.js');
    	wp_enqueue_script( 'mixitup', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/mixitup/mixitup.min.js');
        
        return [ 'jquery', 'elementor-frontend', 'mt-addons-filters-main', 'mixitup' ];
    }
	
	protected function register_controls() {
        $this->section_products_filters();
        $this->section_help_settings();
    }

    private function section_products_filters() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$all_attributes = array();
	    if (function_exists('wc_get_attribute_taxonomies')) {
	        $attribute_taxonomies = wc_get_attribute_taxonomies();
	        if ( $attribute_taxonomies ) {
	          foreach ( $attribute_taxonomies as $tax ) {
	            $all_attributes[$tax->attribute_name ] = $tax->attribute_name;
	          }
	        }
	    }
	    $this->add_control(
			'number',
			[
				'label' 		=> esc_html__( 'Number of products', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
                'default'	 	=> 15,
			]
		);
		$this->add_control(
			'attribute',
			[
				'label' 		=> esc_html__( 'Select Products Attributes?', 'mt-addons' ),
          		'description' 	=> esc_html__('The selected attributes will be used to filter the products from the left side', 'mt-addons'),
				'type' 			=> Controls_Manager::SELECT,
       			'options' 		=> $all_attributes,
			]
		);
		$this->add_control(
            'filters_background_color',
            [
                'label' 		=> esc_html__( 'Filters Background Color', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::COLOR,
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-sidebar::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-sidebar.filter-is-visible .mt-addons-sidebar-close' => 'background-color: {{VALUE}}',
                ],
                'default' 		=> '#f56300',
            ]
        );
        $this->add_control(
            'placeholder_background_color',
            [
                'label' 		=> esc_html__( 'Placeholder Background Color', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::COLOR,
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-filter-block input[type="search"]' => 'background-color: {{VALUE}}',
                ],
                'default' 		=> '#f3f3f3',
            ]
        );
        $this->add_control(
            'placeholder_color',
            [
                'label' 		=> esc_html__( 'Placeholder Color', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::COLOR,
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-filter-block input[type="search"]' => 'color: {{VALUE}}',
                ],
                'default' 		=> '#111111',
            ]
        );
        $this->add_control(
            'placeholder_border_radius', 
            [
                'label' 		=> esc_html__( 'Placeholder Border Radius', 'mt-addons' ),
                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' 		=> [
                    'top' 			=> 30,
                    'right' 		=> 30, 
                    'bottom' 		=> 30,
                    'left' 			=> 30,
                    'unit' 			=> 'px',
                ],
                'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-filter-block input[type="search"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
		$this->add_control(
			'search_placeholder',
			[
				'label' 		=> esc_html__( 'Search placeholder', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> esc_html__( 'Search...', 'mt-addons' ),
			]
		);
		$search_filter = array( 
			'Choose' 				=> esc_html__('Choose','mt-addons'),
			'search_on' 			=> esc_html__('Search Enabled','mt-addons'), 
			'search_off' 			=> esc_html__('Search Disabled','mt-addons'),
		);
		$this->add_control(
			'searchfilter',
			[
				'label' 			=> esc_html__( 'Enable or disable search on filter sidebar', 'mt-addons' ),
				'label_block'	 	=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'search_on',
       			'options' 			=> $search_filter,
			]
		);
		$categories_filter = array(
			'Choose' 				=> esc_html__('Choose','mt-addons'),
			'categories_on' 		=> esc_html__('Categories Enabled','mt-addons'), 
			'categories_off' 		=> esc_html__('Categories Disabled','mt-addons')
		);
		$this->add_control(
			'categoriesfilter',
			[
				'label' 			=> esc_html__( 'Enable or disable categories on filter sidebar', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'categories_off',
				'options' 			=> $categories_filter,
			]
		);
		$tags_filter = array(
			'Choose' 				=> esc_html__('Choose','mt-addons'),
			'tags_on' 				=> esc_html__('Tags Enabled','mt-addons'), 
			'tags_off' 				=> esc_html__('Tags Disabled','mt-addons')
		);
		$this->add_control(
			'tagsfilter',
			[
				'label' 			=> esc_html__( 'Enable or disable tags on filter sidebar', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'tags_off',
				'options' 			=> $tags_filter,
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 				=> 'border',
				'label' 			=> esc_html__( 'Products Border', 'mt-addons' ),
				'fields_options' 	=> [
					'border' 		=> [
						'default' 		=> 'solid',
					],
					'width' 		=> [
						'default' 		=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' 		=> [
						'default' 		=> '#ddd',
					],
				],
				'selector' => '{{WRAPPER}} .mt-addons-content-wrapper li .mt-addons-product-wrapper',
			]
		);
        $this->add_control(
			'border_wrapper_color_hover',
			[
				'label'     		=> esc_html__( 'Border Color Hover', 'mt-addons' ),
				'type'     		 	=> \Elementor\Controls_Manager::COLOR,
				'default' 			=> '#ffa626',
				'condition' 		=> [
					'border_border!' 	=> '',
				],
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-content-wrapper li .mt-addons-product-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
            'product_wrapper_border_radius', 
            [
                'label' 			=> esc_html__( 'Border Radius Products', 'mt-addons' ),
                'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' 		=> [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' 			=> [
                    'top' 				=> 20,
                    'right' 			=> 20, 
                    'bottom' 			=> 20,
                    'left' 				=> 20,
                    'unit' 				=> 'px',
                ],
                'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-content-wrapper li .mt-addons-product-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     		=> 'products_box_shadow',
                'label' 		=> esc_html__( 'Box Shadow', 'mt-addons' ),
                'selector' 		=> '{{WRAPPER}} .price-table-container',
                'fields_options' =>[],
            ]
        );
		$this->end_controls_section();
	}
	              
	protected function render() {
        $settings 						= $this->get_settings_for_display();
        $number 						= $settings['number'];
        $attribute 						= $settings['attribute'];
        $search_placeholder 			= $settings['search_placeholder'];
        $searchfilter 					= $settings['searchfilter'];
        $categoriesfilter 				= $settings['categoriesfilter'];
        $tagsfilter 					= $settings['tagsfilter'];
        $placeholder_background_color 	= $settings['placeholder_background_color'];
        $placeholder_border_radius 		= $settings['placeholder_border_radius'];

	    $args_blogposts = array(
	      'posts_per_page'   => $number,
	      'order'            => 'DESC',
	      'post_type'        => 'product',
	      'post_status'      => 'publish' 
	    ); 
	    $blogposts = get_posts($args_blogposts);
	   
	    $prod_categories = get_terms( 'product_cat', array(
	      'number'        => 10,
	      'hide_empty'    => true,
	      'parent' => 0
	    ));
        $product_categories = get_terms( 'product_cat', array(
    		'orderby' => 'count',
    		'order' => 'DESC', 
    		'hide_empty' => true
    	));
    	$product_tags = get_terms( 'product_tag', array(
    		'orderby' => 'count',
    		'order' => 'DESC', 
    		'hide_empty' => true
    	));
 		?>

	    <div class="mt-addons-product-filters">
	      	<div class="mtfe-row">
	        	<main class="mt-addons-product-filters-content">
	          		<div class="mt-addons-product-filters-header">
	           			<div class="mt-addons-filter filter-is-visible">
	              			<ul class="mt-addons-filters">
	                			<li class="placeholder"><a data-type="all"><?php esc_html_e('All','mt-addons'); ?></a></li>
	                			<li class="filter"><a class="selected" data-type="all"><?php esc_html_e('All','mt-addons'); ?></a></li>     
	                  				<?php foreach( $prod_categories as $prod_cat ) { ?>
	                    				<li class="filter" data-filter=".<?php echo esc_attr($prod_cat->slug); ?>">
	                      					<a href="#0" data-type="<?php echo esc_attr($prod_cat->slug); ?>"><?php echo esc_html($prod_cat->name); ?><span></span></a>
	                    				</li>
	                 				<?php } ?>
	              			</ul>
	            		</div>
	          		</div>

	          		<section class="mt-addons-content-wrapper filter-is-visible">
	            		<ul>
			              	<?php 
			              	// ALL WOOCOMMERCE AVAILABLE ATTRIBUTES
			              	$all_available_attributes = array();
			              	$taxonomy_terms = array();
			              	$attribute_taxonomies = wc_get_attribute_taxonomies();
			              	if ( $attribute_taxonomies ){
			                	foreach ( $attribute_taxonomies as $tax ){
			                  	array_push($all_available_attributes, $tax->attribute_name);
			                	}
			              	}

			              	$attributes_to_list = array();
			              	if ($attribute) {
			                	$attributes_to_list = explode(",", $attribute);
			              	}

	              			foreach ($blogposts as $blogpost) { 
	                			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $blogpost->ID ), 'medium' );
				                $categories_list = wp_get_post_terms($blogpost->ID, 'product_cat');
				                $cat_slugs = implode(' ',wp_list_pluck($categories_list,'slug'));
				                $tags_list = wp_get_post_terms($blogpost->ID, 'product_tag');
				                $tags_slugs = implode(' ',wp_list_pluck($tags_list,'slug'));

				                global $product;
				                $product = wc_get_product( $blogpost->ID );
				                $attributes_final = '';
				                $all_product_attr = get_post_meta($blogpost->ID, '_product_attributes', true);
				                if ($all_product_attr) {
				                  	foreach ($all_product_attr as $attr) {
				                    	$attributes = wc_get_product_terms( $blogpost->ID, $attr['name'], array( 'fields' => 'all' ) );
				                    	if ($attributes) {
				                      		foreach ($attributes as $single_attr_value) {
				                        		$attributes_final .=  $single_attr_value->slug.' ';
				                      		}
				                    	}
				                  	}
				                } ?>

	                			<li id="product-id-<?php echo esc_attr($blogpost->ID); ?>" class="mix <?php echo esc_attr($attributes_final); ?> <?php echo esc_attr($cat_slugs); ?> <?php echo esc_attr($blogpost->post_title); ?> <?php echo esc_attr($tags_slugs); ?>"> 
	                  				<div class="col-md-12 post">
	                    				<div class="mt-addons-product-wrapper">
					                      	<?php if ($thumbnail_src) { ?>
					                        	<div class="mt-addons-thumbnail">
						                          	<a class="woo_catalog_media_images" title="<?php echo esc_html($blogpost->post_title); ?>" href="<?php echo esc_url(get_permalink($blogpost->ID)); ?>">
						                            	<img class="mt_addons_filters_post_image" src="<?php echo esc_url($thumbnail_src[0]); ?>" alt="<?php echo esc_url($blogpost->post_title); ?>" />
						                          	</a>
					                        	</div>
					                      	<?php } ?>

	                      					<div class="mt-addons-title-metas">
	                        					<h3 class="mt-addons-product-title">
						                          	<a href="<?php echo esc_url(get_permalink($blogpost->ID)); ?>" title="<?php echo esc_html($blogpost->post_title); ?>"><?php echo esc_html($blogpost->post_title); ?></a>
						                        </h3>
	                        					<?php if($product->get_price_html()) { ?>
	                          						<p><?php echo wp_kses($product->get_price_html(), 'price'); ?></p>
	                        					<?php } ?>
	                      					</div>  
	                    				</div>
	                  				</div>                     
	                			</li>       
	              			<?php } ?>
	              		</ul>
	              		<div class="mt-addons-fail-message"><?php esc_html_e('No results found','mt-addons'); ?></div>
	            	</section>

	            	<div class="mt-addons-sidebar filter-is-visible">
	              		<form>
		                	<?php
		                	// SIDEBAR: SEARCH FORM
	                		if($searchfilter == 'search_on') { ?>
	                  			<div class="mt-addons-filter-block">
				                    <h4><?php echo esc_html__('Search','mt-addons'); ?></h4>
				                    <div class="mt-addons-filter-content">
	                      				<?php if($search_placeholder) { ?>
	                        				<input type="search" placeholder="<?php echo esc_attr($search_placeholder); ?>...">
	                      				<?php } else { ?>
	                        				<input type="search" placeholder="<?php esc_attr_e('Search...','mt-addons'); ?>">
	                      				<?php } ?>
	                    			</div>
	                  			</div>
	                		<?php } ?>
	                		<?php 
	                		// SIDEBAR: ATTRIBUTES
	                		if($attribute) { ?>
	                  			<div class="mt-addons-filter-block">
	                    			<?php $attributes_taxonomies = wc_get_attribute_taxonomies();
	                    			foreach ( $attributes_taxonomies as $tax ) {
	                      				if (in_array($tax->attribute_name, $attributes_to_list)) { ?>
	                        				<h4><?php echo esc_html($tax->attribute_label); ?></h4>
	                        				<ul class="mt-addons-filter-content mt-addons-filters list">
						                        <?php $attributes_array = array();
						                        $taxonomies_terms = array();
						                        if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ){
						                          	$attributes_array[ $tax->attribute_name ] = $tax->attribute_name;                                    
						                          	$taxonomies_terms[$tax->attribute_name] = get_terms( wc_attribute_taxonomy_name($tax->attribute_name));
						                        }
						                        foreach ($attributes_array as $key ) {
						                          	foreach ($taxonomies_terms[$key] as $term) { ?>
						                            	<li>
						                              		<input class="filter" data-filter=".<?php echo esc_attr($term->slug); ?>" type="checkbox" id="<?php echo esc_attr($term->slug); ?>">
						                              		<label class="checkbox-label" for="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></label>
						                            	</li>
						                          	<?php }
						                        }?>
	                      					</ul>
	                    				<?php } 
	                    			} ?>
	                  			</div>  
	                		<?php } ?>

	                		<?php
	                		// SIDEBAR: CATEGORIES
	                		if($categoriesfilter == 'categories_on') { ?>
	                  			<div class="mt-addons-filter-block">
				                    <h4><?php echo esc_html__('Categories','mt-addons'); ?></h4>
				                    <ul class="mt-addons-filter-content mt-addons-filters list">               
				                      	<?php foreach($product_categories as $category){ ?>
				                        	<li>
				                          		<input class="filter" data-filter=".<?php echo esc_attr($category->slug); ?>" type="checkbox" id="<?php echo esc_attr($category->slug); ?>">
				                          		<label class="checkbox-label" for="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></label>
				                        	</li>                
				                      	<?php } ?>    
	                    			</ul>
	                  			</div>
	                		<?php }

	                		// SIDEBAR: TAGS
	                		if($tagsfilter == 'tags_on') { ?>
	                  			<div class="mt-addons-filter-block">
	                    			<h4><?php echo esc_html__('Most used Tags','mt-addons'); ?></h4>
	                    			<ul class="mt-addons-filter-content mt-addons-filters list">             
	                      				<?php foreach($product_tags as $tag){ ?>
	                        				<li>
	                          					<input class="filter" data-filter=".<?php echo esc_attr($tag->slug); ?>" type="checkbox" id="<?php echo esc_attr($tag->slug); ?>">
	                          					<label class="checkbox-label" for="<?php echo esc_attr($tag->slug); ?>"><?php echo esc_html($tag->name); ?></label>
	                        				</li>                 
	                      				<?php } ?>    
	                    			</ul> 
	                  			</div>  
	                		<?php } ?>

	              		</form>
	              		<a class="mt-addons-sidebar-close"><?php esc_html_e('Close','mt-addons'); ?></a>
	            	</div>

	          		<a class="mt-addons-sidebar-trigger filter-is-visible"><?php esc_html_e('Filters','mt-addons'); ?></a>
	        	</main>
	      	</div>
	    </div>
	    <?php
	}
	protected function content_template() {

    }
}