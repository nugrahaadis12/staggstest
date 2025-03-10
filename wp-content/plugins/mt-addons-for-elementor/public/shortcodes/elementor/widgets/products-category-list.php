<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_products_category_list extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-collectors-list', MT_ADDONS_PUBLIC_ASSETS.'css/products-category-list.css');

        return [
            'mt-addons-collectors-list',
        ];
    }
	public function get_name() {
		return 'mtfe-products-category-list';
	} 
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Products Category List','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-editor-list-ul';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_prod_category_list();
        $this->section_help_settings();
    }

    private function section_prod_category_list() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> esc_html__( 'Title', 'mt-addons' ),
			]
		);
		$this->add_control(
			'number',
			[
				'label' 		=> esc_html__( 'Number', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::NUMBER,
				'default' 		=> 4,
			]
		);
		$this->add_control(
			'number_of_columns',
			[
				'label' 		=> esc_html__( 'Columns', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 					=> esc_html__( 'Select', 'mt-addons' ),
					'col-md-12' 		=> '1',
					'col-md-6'		    => '2',
					'col-md-4' 		    => '3',
					'col-md-3' 		    => '4',
				]
			]
		);
		$this->add_control(
			'order',
			[
				'label' 		=> esc_html__( 'Order', 'mt-addons' ),
				'label_block' 	=> true,
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'' 				=> esc_html__( 'Select', 'mt-addons' ),
					'recent' 		=> esc_html__( 'Recent', 'mt-addons' ),
					'oldest'		=> esc_html__( 'Oldest', 'mt-addons' ),
					'alpha' 		=> esc_html__( 'Alphabetical', 'mt-addons' ),
				]
			]
		);
		$this->add_control(
			'title_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Title Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-single-category-title' => 'color: {{VALUE}};',
                ],
                'default' 		=> '#000000',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Subtitle Color', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-single-category-subtitle' => 'color: {{VALUE}};',
                ],
                'default' 		=> '#666666',
			]
		);
		$this->add_control(
			'color_number',
			[
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'label' 		=> esc_html__( 'Number Color ', 'mt-addons' ),
				'label_block' 	=> true,
				'selectors' 	=> [
                    '{{WRAPPER}} .mt-count-number' => 'color: {{VALUE}};',
                ],
                'default' 		=> '#f0f0f0',
			]
		);
		$this->add_control(
			'placeholder_img',
			[
				'label' 		=> esc_html__( 'Placeholder Image', 'mt-addons' ),
				'type' 			=> \Elementor\Controls_Manager::MEDIA,
				'default' 		=> [
					'url' 		=> \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

	}
	
	protected function render() {
        $settings 			= $this->get_settings_for_display();
        $number 			= $settings['number'];
        $number_of_columns 	= $settings['number_of_columns'];
        $order 				= $settings['order'];
        $placeholder_img    = $settings['placeholder_img']['url'];

        if($order == 'alpha' or $order == '') {
	      	$args = array(
	          	'number'     => $number,
	          	'orderby'    => 'title',
	          	'order'      => 'ASC'
	    	);
	    } else if($order == 'recent') {
	      	$args = array(
	          	'number'     => $number,
	          	'orderby'    => 'id',
	          	'order'      => 'DESC'
	      	);
	    } else if($order == 'oldest') {
	      	$args = array(
	          	'number'     => $number,
	          	'orderby'    => 'id',
	          	'order'      => 'ASC'
	      	);
	    }

	    $product_categories = get_terms( 'product_cat', $args );
	    $count_number = 01; ?>
	    
	    <div class="mt-categories-wrapper mtfe-row">
	    	<?php foreach( $product_categories as $category ) { 
	      		$img_id = get_term_meta( $category->term_id, 'thumbnail_id', true );  
	      		$thumbnail_src = wp_get_attachment_image_src( $img_id, 'mt_addons_70x70' ); 
	      		?>

	       		<div class="mt-single-category <?php echo esc_attr($number_of_columns);?>">
	        		<div class="mt-single-category-wrap">
	            		<a href="<?php echo get_term_link($category->slug, 'product_cat'); ?>">
		              		<?php if($thumbnail_src) { ?>
		                		<img class="cat-image" alt="cat-image" src="<?php echo esc_url($thumbnail_src[0]);?>">
		              		<?php } else { ?>
		                		<img class="cat-image" alt="cat-image" src="<?php echo esc_url($placeholder_img); ?>">
		              		<?php } ?>
	            		</a>
	            		<div class="mt-single-category-info">
	              			<a class="mt-single-category-title" href="<?php echo get_term_link($category->slug, 'product_cat'); ?>"><?php echo esc_attr($category->name);?></a>
	              			<span class="mt-single-category-subtitle"><?php echo esc_attr($category->count);?> <?php  echo esc_html__('items','mt-addons'); ?></span> 
	            		</div>
	            		<span class="mt-count-number"><?php echo esc_html($count_number);?></span>
	          		</div>
	        	</div> 
	   		<?php $count_number++; } ?>
	   	</div>     
   		<?php
	}
	protected function content_template() {}
}