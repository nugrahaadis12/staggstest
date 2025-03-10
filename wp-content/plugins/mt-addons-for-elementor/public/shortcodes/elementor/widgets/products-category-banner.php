<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_products_category_banner extends Widget_Base {
	
	public function get_style_depends() {
   	 	wp_enqueue_style( 'mt-addons-products-category-banner', MT_ADDONS_PUBLIC_ASSETS.'css/products-category-banner.css');
        return [
            'mt-addons-products-category-banner',
        ];
    }
	public function get_name() {
		return 'mtfe-products-category-banner';
	}
	
	use ContentControlHelp;

	public function get_title() {
		return esc_html__( 'MT - Products with Category Banner', 'mt-addons' );
	}
	
	public function get_icon() {
		return 'eicon-banner';
	}
	
	public function get_categories() {
		return [ 'mt-addons-widgets' ];
	}

	protected function register_controls() {
        $this->section_prod_category_banner();
        $this->section_help_settings();
    }

    private function section_prod_category_banner() {

		$this->start_controls_section(
			'section_title',
			[
				'label' 			=> esc_html__( 'Products', 'mt-addons' ),
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
		$this->add_control(
			'category',
			[
				'label' 			=> esc_html__( 'Products Category', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::SELECT,
              	'description' 		=> esc_html__('Select WooCommerce Category', 'mt-addons'),
				'default' 			=> 'uncategorized',
				'options' 			=> $product_category,
			]
		); 

		$this->add_control(
			'number_of_products_by_category',
			[
				'label' 			=> esc_html__( 'Number', 'mt-addons' ),
				'default' 			=> '3',
				'type' 				=> \Elementor\Controls_Manager::NUMBER,
			]
		);
		$this->add_control(
			'number_of_columns',
			[
				'label' 			=> esc_html__( 'Per column', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> '3',
				'options' 			=> [
					''     				=> esc_html__( 'Select Option', 'mt-addons' ),
					'1'    				=> esc_html__( '1', 'mt-addons' ),
					'2'    				=> esc_html__( '2', 'mt-addons' ),
					'3'    				=> esc_html__( '3', 'mt-addons' ),
					'4'    				=> esc_html__( '4', 'mt-addons' ),
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 				=> 'border_product',
				'label'				=> esc_html__( 'Border', 'mt-addons' ),
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
				'selector' 			=> '{{WRAPPER}} ul.products.columns-3 li',
			]
		);
        $this->add_control(
			'border_product_button_color_hover',
			[
				'label'     		=> esc_html__( 'Border Color Hover', 'mt-addons' ),
				'type'     	 		=> \Elementor\Controls_Manager::COLOR,
				'default' 			=> '#CD6',
				'condition' 		=> [
					'border_border!' 	=> '',
				],
				'selectors' 		=> [
					'{{WRAPPER}} ul.products.columns-3 li:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
            'products_padding',
            [
                'label'  			=>  esc_html__('Product Padding', 'mt-addons'),
                'type'  			=>  \Elementor\Controls_Manager::DIMENSIONS,
                'separator' 		=>  'before',
                'size_units' 		=> ['px', '%', 'em'],
                'default'   		=> [
                    'top' 				=> 15,
                    'right' 			=> 15,
                    'bottom' 			=> 15,
                    'left' 				=> 15,
                    'unit' 				=> 'px',
                    'isLinked' 			=> false,
                ],
                'selectors' 		=> [
                    '{{WRAPPER}} ul.products.columns-3 li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
            'button_product_border_radius',
            [
                'label'      		=> esc_html__( 'Product Border Radius', 'mt-addons' ),
                'type'       		=> Controls_Manager::DIMENSIONS,
                'size_units' 		=> ['px', '%', 'em'],
				'default' 			=> [
					'top' 				=> 10,
					'right' 			=> 10,
					'bottom' 			=> 10,
					'left' 				=> 10,
					'unit' 				=> 'px',
					'isLinked' 			=> false,
				],
                'selectors'  		=> [
                    '{{WRAPPER}} ul.products.columns-3 li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
			'text_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-banner-subtitle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-banner-subtitle strong' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-banner-title' => 'color: {{VALUE}}',
                ],
				'default' 			=> '#fff',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_banner',
			[
				'label' 			=> esc_html__( 'Banner', 'mt-addons' ),
			]
		);
		$this->add_control(
            'bg_img_heading',
            [
                'label'    		 	=> esc_html__( 'Image Background', 'mt-addons' ),
                'type'      		=> Controls_Manager::HEADING,
                'separator' 		=> 'before',
            ]
        );
		$this->add_control(
            'bg_type_image',
            [
                'label'   			=> esc_html__( 'Type', 'mt-addons' ),
                'type'    			=> Controls_Manager::CHOOSE,
                'options' 			=> [
                    'color'    			=> [
                        'title' 		=> esc_html__( 'Color', 'mt-addons' ),
                        'icon'  		=> 'eicon-global-colors',
                    ],
                    'image'    		=> [
                        'title' 		=> esc_html__( 'Image', 'mt-addons' ),
                        'icon'  		=> 'eicon-image',
                    ],
                    'gradient' 		=> [
                        'title' 		=> esc_html__( 'Gradient', 'mt-addons' ),
                        'icon'  		=> 'eicon-barcode',
                    ],
                ],
                'default' 			=> 'image',
                'toggle'  			=> false,
            ]
        );
        $this->add_control(
			'banner_color_bg',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Background Color', 'mt-addons' ),
				'label_block' 		=> true,
				'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-banner-wrapper' => 'background-color: {{VALUE}}',
                ],
				'default' 			=> '#242221',
				'condition' 		=> [
                    'bg_type_image' 	=> 'color',
                ],
			]
		);
		$this->add_control(
            'banner_image',
            [
                'label'     		=> esc_html__( 'Choose Image', 'mt-addons' ),
                'type'     			=> Controls_Manager::MEDIA,
                'default'   		=> [
                    'url' 				=> Utils::get_placeholder_image_src(),
                ],
                'selectors' 		=> [
                	'{{WRAPPER}} .mt-addons-banner-wrapper' => 'background-image: url( {{URL}} );',
                ],
                'condition' 		=> [
                    'bg_type_image' 	=> 'image',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' 				=> 'image',
				'default' 			=> 'large',
				'selectors' 		=> [
                	'{{WRAPPER}} .mt-addons-banner-wrapper' => 'background-image: url( {{URL}} );',
                ],
				'condition' 		=> [
                    'bg_type_image' 	=> 'image',
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'        		=> 'banner_gradient_bg',
                'label'       		=> esc_html__( 'Gradient', 'mt-addons' ),
                'description' 		=> esc_html__( 'Create gradient background using this control.', 'mt-addons' ),
                'types'       		=> ['gradient'],
                'selector'    		=> '{{WRAPPER}} .mt-addons-banner-wrapper',
                'condition'   		=> [
                    'bg_type_image' 	=> 'gradient',
                ],
            ]
        );
		$this->add_control(
			'banner_pos',
			[
				'label' 			=> esc_html__( 'Position', 'mt-addons' ),
				'label_block' 		=> true,
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'float-left',
				'options' 			=> [
					''       	 	 	=> esc_html__( 'Select Option', 'mt-addons' ),
					'float-left'     	=> esc_html__( 'Left', 'mt-addons' ),
					'float-right' 	 	=> esc_html__( 'Right', 'mt-addons' ),
				],
			]
		);
		$this->add_control(
			'products_label_text',
			[
				'label' 			=> esc_html__( 'Replace "Products" label', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::TEXT,
				'default' 			=> esc_html__( 'Products', 'mt-addons' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_button',
			[
				'label' 			=> esc_html__( 'Button', 'mt-addons' ),
			]
		);
		$this->add_control(
			'button_text',
			[
				'label' 			=> esc_html__( 'Text', 'mt-addons' ),
				'type' 				=> \Elementor\Controls_Manager::TEXT,
				'default' 			=> esc_html__( 'View All Items', 'mt-addons' ),
			]
		);
		$this->add_control(
			'button_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Text Color', 'mt-addons' ),
				'label_block' 		=> true,
				 'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-banner-button a' => 'color: {{VALUE}}',
                ],
				'default' 			=> '#ffffff',
			]
		);
		$this->add_control(
			'button_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Text Color Hover', 'mt-addons' ),
				'label_block' 		=> true,
				 'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-banner-button a.button:hover' => 'color: {{VALUE}}',
                ],
				'default' 			=> '#111111',
			]
		);
		$this->add_control(
			'button_bg_color',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Background Color', 'mt-addons' ),
				'label_block' 		=> true,
				 'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-banner-button a' => 'background-color: {{VALUE}}',
                ],
				'default' 			=> '#111111',
			]
		);
		$this->add_control(
			'button_bg_color_hover',
			[
				'type' 				=> \Elementor\Controls_Manager::COLOR,
				'label' 			=> esc_html__( 'Button Background Color Hover', 'mt-addons' ),
				'label_block' 		=> true,
				 'selectors' 		=> [
                    '{{WRAPPER}} .mt-addons-banner-button a.button:hover' => 'background-color: {{VALUE}}',
                ],
				'default' 			=> '#ffffff',
			]
		);
        $this->add_control(
            'button_padding',
            [
                'label'  			=>  esc_html__('Button Padding', 'mt-addons'),
                'type'  			=>  \Elementor\Controls_Manager::DIMENSIONS,
                'separator' 		=>  'before',
                'size_units' 		=> ['px', '%', 'em'],
                'default'   		=> [
                    'top'				=> 15,
                    'right' 			=> 25,
                    'bottom' 			=> 15,
                    'left' 				=> 25,
                    'unit' 				=> 'px',
                    'isLinked' 			=> false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-banner-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' 				=> 'button_border',
				'label' 			=> esc_html__( 'Button Border', 'mt-addons' ),
				'fields_options' 	=> [
					'border' 			=> [
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
						'default' 		=> '#fff',
					],
				],
				'selector' 			=> '{{WRAPPER}} .mt-addons-banner-button a',
			]
		);
        $this->add_control(
			'border_button_color_hover',
			[
				'label'     		=> esc_html__( 'Border Color Hover', 'mt-addons' ),
				'type'      		=> \Elementor\Controls_Manager::COLOR,
				'default' 			=> '#111111',
				'condition' 		=> [
					'border_border!' 	=> '',
				],
				'selectors' 		=> [
					'{{WRAPPER}} .mt-addons-banner-button a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
            'button_border_radius',
            [
                'label'      		=> esc_html__( 'Button Border Radius', 'mt-addons' ),
                'type'       		=> Controls_Manager::DIMENSIONS,
                'size_units' 		=> ['px', '%', 'em'],
				'default' 			=> [
					'top' 				=> 30,
					'right' 			=> 30,
					'bottom' 			=> 30,
					'left' 				=> 30,
					'unit' 				=> 'px',
					'isLinked' 			=> false,
				],
                'selectors'  		=> [
                    '{{WRAPPER}} .mt-addons-banner-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
		$this->end_controls_section();
	}
	           
	protected function render() {
        $settings 							= $this->get_settings_for_display();
        $category 							= $settings['category'];
        $number_of_products_by_category 	= $settings['number_of_products_by_category'];
        $number_of_columns 					= $settings['number_of_columns'];
        $banner_pos 						= $settings['banner_pos'];
        $products_label_text 				= $settings['products_label_text'];
        $button_text 						= $settings['button_text'];
        $banner_image 						= $settings['banner_image']['url'];
        $bg_type_image 						= $settings['bg_type_image'];


	    if ($button_text) {
	        $button_text_value = $button_text;
	    }else{
	        $button_text_value = esc_html__('View All Items', 'mt-addons');
	    }

	    if ($products_label_text) {
	        $products_label_text_value = $products_label_text;
	    }else{
	        $products_label_text_value = esc_html__('Products', 'mt-addons');
	    }

	    $cat = get_term_by('slug', $category, 'product_cat');
		?>
	    <?php if ($cat) { ?>
	      	<div class="mt-addons-banner-simple">
	        	<div class="mt-addons-product-category">
	          		<div class="mt-addons-banner col-md-3 <?php echo esc_attr($banner_pos);?>">
	            		<div class="mt-addons-banner-wrapper">
	              			<a class="#categoryid_<?php echo esc_attr($cat->term_id);?>"><span class="mt-addons-banner-title"><?php echo esc_html($cat->name);?></span></a><br>
	              			<span class="mt-addons-banner-subtitle"> <strong><?php echo esc_html($cat->count);?></strong> <?php echo esc_html($products_label_text_value);?></span><br>
	              			<div class="mt-addons-banner-button">
	                			<a href="<?php echo esc_url(get_term_link($cat->slug, 'product_cat'));?>" class="button" title="<?php esc_html_e('View more', 'mt-addons');?>" ><span><?php echo esc_html($button_text_value);?></span></a>
	              			</div>
	            		</div>    
	          		</div>
	          		<div id="categoryid_<?php echo esc_attr($cat->term_id);?>" class="col-md-9 mt-addons-products <?php echo esc_attr($cat->name);?>"><?php echo do_shortcode('[product_category columns="'.esc_attr($number_of_columns).'" per_page="'.esc_attr($number_of_products_by_category).'" category="'.esc_attr($category).'"]'); ?></div>
	        	</div>
	      	</div>
	      	<div class="clearfix"></div>
	    <?php }
	}
	
	protected function content_template() {

    }
}