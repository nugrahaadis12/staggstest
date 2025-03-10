<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_category_tabs extends Widget_Base {
	public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-category-tabs', MT_ADDONS_PUBLIC_ASSETS.'css/category-tabs.css');
        return [
            'mt-addons-category-tabs',
        ];
    }
	public function get_name() {
		return 'mtfe-category-tabs'; 
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__( 'MT - Category Tabs', 'mt-addons' );
	}
	
	public function get_icon() {
		return 'eicon-tabs';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	} 

	protected function register_controls() {
        $this->section_category_tabs();
        $this->section_help_settings();
    }

    private function section_category_tabs() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
  		$product_category = array();
	    if ( class_exists( 'WooCommerce' ) ) {
	      $product_category_tax = get_terms( 'product_cat', array(
	        'parent'      => 0,
	      ));
	      if ($product_category_tax) {
	        foreach ( $product_category_tax as $term ) {
	          if ($term) {
	             $product_category[$term->slug] = $term->name.' ('.$term->count.')';
	          }
	        }
	      }
	    }
 		$repeater = new Repeater();
 		$repeater->add_control(
			'category',
			[
				'label' 		=> esc_html__( 'Category', 'mt-addons' ),
          		'description' 	=> esc_html__('Select Category', 'mt-addons'),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'uncategorized',
				'options' 		=> $product_category,
			]
		);
 		$repeater->add_control(
			'image',
			[
				'label' 		=> esc_html__( 'Category Image', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::MEDIA,
				'default' 		=> [
					'url' 		=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
	 	$repeater->add_control(
	    	'title',
	        [
	            'label' 		=> esc_html__('Title', 'mt-addons'),
	            'type' 			=> Controls_Manager::TEXT
	        ]
	    );
	    $this->add_control(
	        'category_tabs',
	        [
	            'label' 		=> esc_html__('Items', 'mt-addons'),
	            'type' 			=> Controls_Manager::REPEATER,
	            'fields' 		=> $repeater->get_controls(),
	            'default' 		=> [
                    [
                        'title' 	=> esc_html__( 'Home Decor', 'mt-addons' ),
                        'category' 	=> esc_html__( 'uncategorized', 'mt-addons' ),
                    ],
                    [
                        'title' 	=> esc_html__( 'Electronics', 'mt-addons' ),
                        'category' 	=> esc_html__( 'uncategorized', 'mt-addons' ),
                    ],
                    [
                        'title' 	=> esc_html__( 'Toys', 'mt-addons' ),
                        'category' 	=> esc_html__( 'uncategorized', 'mt-addons' ),
                    ],
                ],
	        ]
	    );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' 		=> esc_html__( 'Price Typography', 'mt-addons' ),
				'name' 			=> 'price_typography',
				'selector' 		=> '{{WRAPPER}} .woocommerce-Price-amount bdi',
			]
		);
	    $this->add_control(
			'background_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Tab Backgroung (active)', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-category-nav' => 'background: {{VALUE}}',
                ],
                'default' 		=> '#C9762E',
			]
		);
		$this->add_control(
			'price_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Price Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-addons-category-tabs ul.products li.product .price' => 'color: {{VALUE}}',
                ],
                'default' 		=> '#c9762d',
			]
		);
		$this->end_controls_section();
	}
	              
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $category_tabs 				= $settings['category_tabs'];
        $background_color 			= $settings['background_color'];
        $price_color 				= $settings['price_color'];

		?>
	    <div class="mt-addons-category-tabs">
	    	<nav>
		        <ul class="mt-addons-category-nav"> 
		        	<?php $tab_id = 1; ?>
		        	<?php if ($category_tabs) { ?>
		            	<?php foreach ($category_tabs as $tab) {
				            $image = $tab['image']['url'];

				            if (!array_key_exists('title', $tab)) {
				            	$title = $tab['category'];
				            }else{
				                $title = $tab['title'];
				            }
			              	?>
				            <li>
				            	<a href="#mt-addons-section-<?php echo esc_attr($tab_id);?>"> 
				            		<img class="mt-addons-icon" src="<?php echo esc_url($image); ?>" alt="mt-addons-icon">
				            		<h5 class="mt-addons-title"><?php echo esc_html($title);?></h5>
				            	</a>
				            </li> 
		              		<?php $tab_id++; ?>
		           		<?php } ?>
		          	<?php } ?>
		        </ul>
	     	</nav>
		    <div class="mt-addons-products-wrap">
		        <?php $content_id = 1; ?>
		        <?php if ($category_tabs) { ?>
		        	<?php foreach ($category_tabs as $tab) { ?>
		            	<?php $category = $tab['category']; ?>
		            	<section id="mt-addons-section-<?php echo esc_attr($content_id);?>">
			            	<div class="mtfe-row">
			                	<div class="col-md-12">
			                  		<?php echo do_shortcode('[product_category category="'.esc_attr($category).'" columns="3" number_of_products_by_category="9"]'); ?>
			                	</div>
			              	</div>                     
		            	</section>
		            	<?php $content_id++; ?>
		          	<?php } ?>
		        <?php } ?>
		    </div>
	    </div>
	    <?php
	}
	protected function content_template() {

    }
}