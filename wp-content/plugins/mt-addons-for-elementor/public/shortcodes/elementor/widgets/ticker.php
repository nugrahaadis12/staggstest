<?php
namespace Elementor;

	class mt_addons_ticker extends Widget_Base {

		public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-ticker', MT_ADDONS_PUBLIC_ASSETS.'css/ticker.css');
        
        return [
            'mt-addons-ticker',
        ];
    }

    public function get_name()
    {
        return 'mtfe-ticker';
    }

    public function get_title()
    {
        return esc_html__('MT - Ticker', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-grow';
    }

    public function get_categories() {
        return [ 'addons-widgets' ];
    }
    public function get_script_depends() {
        
        wp_enqueue_script( 'jquery-webticker', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/webticker/jquery.webticker.min.js');

        return [ 'jquery', 'elementor-frontend', 'mt-addons-webticker', 'jquery-webticker' ];
    }
    public function get_keywords() {
        return [ 'ticker', 'slider', 'back'];
    }

	public function register_controls() {
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'List Area', 'mt-addons' ),
			]
		);
		$this->add_control(
			'direction',
			[
				'type' 				=> \Elementor\Controls_Manager::CHOOSE,
				'label' 			=> esc_html__( 'Direction', 'mt-addons' ),
				'options' 			=> [
					'left' 			=> [
						'title' 		=> esc_html__( 'To Left', 'mt-addons' ),
						'icon' 			=> 'eicon-text-align-left',
					],
					'right' 		=> [
						'title' 		=> esc_html__( 'To Right', 'mt-addons' ),
						'icon' 			=> 'eicon-text-align-right',
					],
				],
				'default' 			=> 'left',
			]
		);
		$this->add_control(
			'disable_hoverpause',
			[
				'label' 			=> esc_html__( 'Hover Pause', 'mt-addons' ),
				'type' 				=> Controls_Manager::SELECT,
				'default' 			=> 'false',
				'options' 			=> [
					'true' 			=> esc_html__( 'Enable', 'mt-addons' ),
					'false' 		=> esc_html__( 'Disable', 'mt-addons' ),
				],
			]
		);
		$this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'mt-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .mt-addons-ticker-img-wrapper img' =>  'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'mt-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .mt-addons-ticker-img-wrapper img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $repeater = new \Elementor\Repeater();
      	$repeater->add_control(
			'show_image',
			[
				'label' => esc_html__( 'Show Image', 'mt-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'mt-addons' ),
				'label_off' => esc_html__( 'Hide', 'mt-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'mt-addons' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'show_image' => 'yes'
				]
			]
		);
        $repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'mt-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-sun',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);
        $repeater->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'mt-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
	        		'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
	    		],
			]
		);
        $repeater->add_control(
	    	'title',
	        [
	            'label' => esc_html__('Main Title', 'mt-addons'),
	            'type' => Controls_Manager::TEXT,
	        ]
	    );
	    $repeater->add_control(
	    	'description',
	        [
	            'label' => esc_html__('Description', 'mt-addons'),
	            'type' => Controls_Manager::TEXT,
	        ]
	    );
	    $this->add_control( 
	        'list',
	        [
	            'label' => esc_html__('Menu Items', 'mt-addons'),
	            'type' => Controls_Manager::REPEATER,
	            'fields' => $repeater->get_controls(),
	            'default' => [
					[
						'title' => esc_html__( 'ANALYZE YOUR AUDIENCE', 'mt-addons' ),
						'icon' => esc_html__( 'fa fa-facebook', 'mt-addons' ),
						'icon_color' => esc_html__( '#fff', 'mt-addons' ),
					],
					[
						'title' => esc_html__( 'KEEP YOUR FOLLOWER ENGAGED', 'mt-addons' ),
						'icon' => esc_html__( 'fa fa-facebook', 'mt-addons' ),
						'icon_color' => esc_html__( '#fff', 'mt-addons' ),
					],
					[
						'title' => esc_html__( 'MAKING MONEY ON SOCIAL', 'mt-addons' ),
						'icon' => esc_html__( 'fa fa-facebook', 'mt-addons' ),
						'icon_color' => esc_html__( '#fff', 'mt-addons' ),
					],
					[
						'title' => esc_html__( 'STANDOUT WITH AN UNIQUE DESIGN', 'mt-addons' ),
						'icon' => esc_html__( 'fa fa-facebook', 'mt-addons' ),
						'icon_color' => esc_html__( '#fff', 'mt-addons' ),
					],
				],
	        ]
	    );
		$this->end_controls_section();

		$this->start_controls_section(
			'container_tab',
			[
				'label' => esc_html__( 'Container', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Title Typography', 'mt-addons' ),
				'name' => 'header_typography',
				'selector' => '{{WRAPPER}} .mt-addons-ticker-list-item',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'mt-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
	        		'{{WRAPPER}} .mt-addons-ticker-title' => 'color: {{VALUE}};',
	    		],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Description Typography', 'mt-addons' ),
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .mt-addons-ticker-description',
			]
		);
		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Description Color', 'mt-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
	        		'{{WRAPPER}} .mt-addons-ticker-description' => 'color: {{VALUE}};',
	    		],
			]
		);
		$this->add_control(
			'background_ticker',
			[
				'label' => esc_html__( 'Background', 'mt-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
	        		'{{WRAPPER}} .mt-addons-ticker' => 'background: {{VALUE}};',
	    		],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Products Border', 'mt-addons' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '3',
							'right' => '0',
							'bottom' => '0',
							'left' => '0',
							'isLinked' => false,
						],
					],
					'color' => [
						'default' => '#FFD500',
					],
				],
				'selector' => '{{WRAPPER}} .mt-addons-ticker',
			]
		);
		$this->add_control(
            'padding_icon',
            [
                'label' => esc_html__( 'Icon Padding', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => false,
				],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-ticker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            	],
         	]
       	);
		$this->end_controls_section();
	}

	protected function render() {
        $settings = $this->get_settings_for_display();
        $list  = $settings['list'];
        $direction = $settings['direction'];
        $disable_hoverpause = $settings['disable_hoverpause'];
	    $id = 'mt-addons-ticker-'.uniqid();

        ?>     		 
		<div class="mt-addons-ticker">
		  <ul class="mt-addons-ticker-list" id="<?php echo esc_attr($id); ?>" data-direction="<?php echo esc_attr($direction); ?>" data-disable-hoverpause="<?php echo esc_attr($disable_hoverpause); ?>">
		  	<?php foreach ( $list as $item ) {
		  	$show_image = $item['show_image'];
		  	$icon = $item['icon'];
        	$title = $item['title'];
        	$icon_color = $item['icon_color'];
        	$description = $item['description'];

        	if (isset($item['image']) && isset($item['image']['url'])) {
    			$image = $item['image']['url'];
			}
         	?>    
			    <li  class="mt-addons-ticker-list-item">
			    	<?php if ($show_image == 'yes') { ?>
						<div class="mt-addons-ticker-img-wrapper">
				    		<img src="<?php echo esc_url($image); ?>" class="mt-addons-ticker-img" alt="image" />
				    	</div>
			    	<?php } ?>
			    	<div class="mt-addons-ticker-icon elementor-repeater-item-<?php echo esc_attr($item['_id'])?>">
			    		<i class="<?php echo esc_attr($item['icon']['value']); ?>"></i>
			    	</div>
			    	<div class="mt-addons-ticker-title">
			    		<?php echo esc_html($title)?>
			    	</div>
			    	<h3 class="mt-addons-ticker-description"><?php echo esc_html($description)?></h3>
			    </li>
		    <?php } ?>
		  </ul>
		</div>
    <?php
	}

    protected function content_template() {}
}

