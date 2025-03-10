<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_featured_product extends Widget_Base {
	
	public function get_style_depends() {
    	wp_enqueue_style( 'mt-addons-featured-product', MT_ADDONS_PUBLIC_ASSETS.'css/featured-product.css');
        return [
            'mt-addons-featured-product',
        ];
    }
	public function get_name() {
		return 'mtfe-featured-product';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__('MT - Featured Product','mt-addons');
	}
	
	public function get_icon() {
		return 'eicon-products';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}
	
	protected function register_controls() {
        $this->section_featured_product();
        $this->section_help_settings();
    }

    private function section_featured_product() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Content', 'mt-addons' ),
			]
		);
		$this->add_control(
	    	'select_product',
	        [
	            'label' 			=> esc_html__('Write Product ID', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT
	        ]
	    );
	    $this->add_control(
			'custom_image',
			[
				'label' 			=> esc_html__( 'Custom Product Image', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Yes', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'No', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
	    $this->add_control(
			'product_image',
			[
				'label' 			=> esc_html__( 'Product Image', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::MEDIA,
				'default' 			=> [
					'url' 			=> \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' 		=> [
					'custom_image' 	=> 'yes',
				],
			]
		);
		$this->add_control(
	    	'subtitle_product',
	        [
	            'label' 			=> esc_html__('Write Subtitle Product', 'mt-addons'),
	            'type' 				=> Controls_Manager::TEXT,
	            'default' 			=> esc_html__('SALE', 'mt-addons'),
	        ]
	    );
	    $this->add_control( 
			'button_text',
			[
				'type' 				=> \Elementor\Controls_Manager::TEXT,
				'label' 			=> esc_html__( 'Button text', 'mt-addons' ),
				'default' 			=> esc_html__('Read More', 'mt-addons'),
			]
		);
        $this->end_controls_tab();
		$this->end_controls_section();
		$this->start_controls_section(
            'style_product',
            [
                'label' 			=> esc_html__( 'Styling', 'mt-addons' ),
                'tab'   			=> Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 				=> 'title_typography',
				'label' 			=> esc_html__( 'Title Typography', 'mt-addons' ),
				'selector' 			=> '{{WRAPPER}} .mt-addons-featured-product-name a',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 				=> 'subtitle_typography',
				'label' 			=> esc_html__( 'Subtitle Typography', 'mt-addons' ),
				'selector' 			=> '{{WRAPPER}} .mt-addons-featured-product-categories',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 				=> 'desc_typography',
				'label' 			=> esc_html__( 'Description Typography', 'mt-addons' ),
				'selector' 			=> '{{WRAPPER}} .mt-addons-featured-product-description',
			]
		);
		$this->add_control(
			'divider',
			[
				'type' 				=> \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' 				=> 'container_background',
				'label' 			=> esc_html__( 'Container Background', 'mt-addons' ),
				'types' 			=> [ 'classic', 'gradient'],
				'fields_options' 	=> [
					'background' 	=> [
                		'default' 		=> 'classic',
            		],
				    'image' 		=> [
					    'default' 		=> ['url'	=> MT_ADDONS_ASSETS.'featured-product.png',],
					],
			    ],
				'selector' 			=> '{{WRAPPER}} .mt-addons-featured-product',
			]
		);
		$this->add_control(
			'box_shadow',
			[
				'label' 			=> esc_html__( 'Container Shadow?', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'Yes', 'mt-addons' ),
				'label_off' 		=> esc_html__( 'No', 'mt-addons' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
			]
		);
		$this->add_control(
			'container_shadow',
			[
				'label' 			=> esc_html__( 'Box Shadow', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-featured-product' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
				'condition' 		=> [
					'box_shadow' 		=> 'yes',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 				=> 'container_border',
				'selector' 			=> '{{WRAPPER}} .mt-addons-featured-product',
			]
		);
		$this->add_control(
			'divider_2',
			[
				'type' 				=> \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'category_text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Category Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} h3.mt-addons-featured-product-categories' => 'color: {{VALUE}};',
                ],
                'default' 			=> '#3247FF',
			]
		);
		$this->add_control(
			'product_name_text_color',  
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Name Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-featured-product-name a' => 'color: {{VALUE}} !important;',
                ],
                'default' 			=> '#000000',
			]
		);
		$this->add_control(
			'price_text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Price Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-featured-product-price' => 'color: {{VALUE}} !important;',
                ],
                'default' 			=> '#000000',
			]
		);
		$this->add_control(
			'divider_3',
			[
				'type' 				=> \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'button_padding',
			[
				'label' 			=> esc_html__( 'Button Padding', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 		=> [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' 			=> [
					'top' 			=> 12,
					'right' 		=> 12,
					'bottom' 		=> 30,
					'left' 			=> 30,
					'unit' 			=> 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .mt-addons-featured-product-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 				=> 'button_typography',
				'label' 			=> esc_html__( 'Button Typography', 'mt-addons' ),
				'selector' 			=> '{{WRAPPER}} .mt-addons-featured-product-button',
			]
		);
		$this->add_control(
			'button_background_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Background Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-featured-product-button' => 'background-color: {{VALUE}};',
                ],
                'default' 			=> '#3247FF',
			]
		); 
		$this->add_control(
			'button_text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Text Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-featured-product-button' => 'color: {{VALUE}};',
                ],
                'default' 			=> '#ffffff',
			]
		);
		$this->add_control(
			'button_background_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Background Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-featured-product-button:hover' => 'background-color: {{VALUE}};',
                ],
                'default' 			=> '#000000',
			]
		); 
		$this->add_control(
			'button_text_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Text Color', 'mt-addons' ),
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-featured-product-button:hover' => 'color: {{VALUE}};',
                ],
                'default' 			=> '#ffffff',
			]
		);
	$this->end_controls_section();

	}
      
	protected function render() {
        $settings 					= $this->get_settings_for_display();
        $select_product 			= $settings['select_product'];
        $custom_image               = $settings['custom_image'];
        $subtitle_product 			= $settings['subtitle_product'];
        $button_text                = $settings['button_text'];
 
        global $woocommerce;
	    $product 		= wc_get_product($select_product);

	    if(!empty($select_product) || $select_product != '') {
	    	$content_post	= get_post($product->get_id());
	    	$content 		= $content_post->post_content;
	    	?>
      
		  	<div class="mt-addons-featured-product col-md-12">
		      	<div class="mt-addons-featured-product-details-holder col-md-6">
		        	<h3 class="mt-addons-featured-product-categories"><?php echo esc_html($subtitle_product); ?></h3>
		        	<h2 class="mt-addons-featured-product-name">
		          		<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo esc_html__(get_the_title($select_product)); ?></a>
		        	</h2>
		        	<h4 class="mt-addons-featured-product-price">
		          		<?php echo wp_kses($product->get_price_html(), 'price'); ?>
		        	</h4>
		        	<div class="mt-addons-featured-product-description">
		          		<?php echo wp_kses_post($content); ?>
		        	</div>
		        	<a class="mt-addons-featured-product-button" href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo esc_html__($button_text); ?></a>
		      	</div>
		      	<div class="mt-addons-image-holder col-md-6">
		       		<?php if($custom_image == 'no') { ?>
						<?php if ( has_post_thumbnail( $select_product ) ) {
							$attachment_ids[0] = get_post_thumbnail_id( $select_product );
							$attachment = wp_get_attachment_image_src($attachment_ids[0], 'full' );
							?>
							<img class="mt-addons-ifeatured-product-image" src="<?php echo esc_url($attachment[0]); ?>" alt="<?php echo esc_attr(get_the_title($select_product)); ?>" />
						<?php } ?>
		       		<?php } else { 
	 					$product_image = $settings['product_image']['url'];
				    	?>
				    	<img class="mt-addons-ifeatured-product-image" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr(get_the_title($select_product)); ?>" />
		       		<?php } ?>
		      	</div>
		    </div>
    	<?php
    	}
	}
	protected function content_template() {

    }
}