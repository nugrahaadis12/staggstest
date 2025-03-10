<?php
class Modeltheme_Search_Forms extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-search-forms', plugin_dir_url( __FILE__ ).'css/search-forms.css');
        return [
            'modeltheme-search-forms',
        ];
    }

    public function get_name()
    {
        return 'mtfe-search-forms';
    }

    public function get_title()
    {
        return esc_html__('MT - Search Forms', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'search forms', 'search' ];
    }

    protected function register_controls() {
        $this->all_controls();
    }

    private function all_controls() {
        $this->start_controls_section(
            'category_info',
            [
                'label'             => esc_html__('Content', 'modeltheme'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'category_status',
            [
                'label' => esc_html__( 'Show Category', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'modeltheme' ),
                'label_off' => esc_html__( 'Hide', 'modeltheme' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            'post_type', 
            [
                'label' => __( 'Style', 'modeltheme' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'product_cat',
                'options' => [
                    ''              => __( 'Select', 'modeltheme' ),
                    'product_cat'   => __( 'Products', 'modeltheme' ),
                    'post_cat'      => __( 'Posts ', 'modeltheme' ),
                    'course_cat'    => __( 'Course ', 'modeltheme' ),
                ]
            ]
        );
        $this->add_control(
            'search_width',
            [
                'label' => esc_html__( 'Width', 'modeltheme' ),
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
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-form' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'search_result_position',
            [
                'label' => esc_html__( 'Search Result Position', 'modeltheme' ),
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
                    'unit' => '%',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-search-bar div#datafetch .search-result' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'search_padding',
            [
                'label' => esc_html__( 'Padding Search', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 0,
                    'right' => 0, 
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'search_border',
            [
                'label' => esc_html__( 'Border Radius', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 5,
                    'right' => 5, 
                    'bottom' => 5,
                    'left' => 5,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'block_box_shadow',
                'selector' => '{{WRAPPER}} .modeltheme-form',
                'fields_options' =>
                    [
                        'box_shadow_type' =>
                        [ 
                            'default' =>'yes' 
                        ],
                        'box_shadow' => [
                            'default' =>
                                [
                                    'horizontal' => 0,
                                    'vertical' => 0,
                                    'blur' => 25,
                                    'spread' => 0,
                                    'color' => 'rgba(0,0,0,0.20)'
                                ]
                        ]
                    ]
            ]
        );
        $this->add_control(
            'form_bg_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__( 'Form Background Color', 'modeltheme' ),
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-form' => 'background-color: {{VALUE}}',
                ],
                'default' => '#ffffff',
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__( 'Button Background Color', 'modeltheme' ),
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-search-submit.submit button' => 'background: {{VALUE}}',
                ],
                'default' => '#111111',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $post_type          = $settings['post_type'];
        $category_status    = $settings['category_status'];
        
        if($post_type == "product_cat") {
          $category_select = "product_cat";
        } elseif ($post_type == "post_cat"){
          $category_select = "post_cat";
        } else {
          $category_select = "course_cat";
        }
        if ($category_status == "yes") { 
           $mt_addons_search_post = '<div class="modeltheme-search-post">';
        } else {
           $mt_addons_search_post = '<div class="modeltheme-search-post">';
        }
        ?>
        <div class="modeltheme-search-bar">
            <div class="modeltheme-search-bar-wrapper">
                <form name="modeltheme-form" method="GET" class="modeltheme-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ($category_status == "yes") { ?>
                        <div class="modeltheme-select-categories col-md-3">  
                            <select name="<?php echo esc_attr($post_type); ?>" class="modeltheme-select form-control">
                            <?php if($post_type == "product_cat") {
                                if(isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
                                    $optsetlect=$_REQUEST['product_cat'];
                                } else {
                                    $optsetlect=0;  
                                }
                                $terms_c = get_terms( 'product_cat' ); ?>
                                <option value=''><?php echo esc_html__('Categories','modeltheme'); ?></option>
                                <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                                    <?php foreach ($terms_c as $term) { ?>
                                        <option value='<?php echo esc_attr($term->slug);?>'><?php echo esc_html($term->name); ?></option>
                                    <?php } ?>
                               <?php } ?>
                            <?php } elseif ($post_type == "product_cat") { 
                            $cat_args = array(
                                'post_type' => 'post_cat', 
                            ); 
                           $terms_c = get_categories(); ?>
                            <option value=''><?php echo esc_html__('Categories','modeltheme'); ?></option>
                            <?php foreach ($terms_c as $term) { ?>
                                <option value='<?php echo esc_attr($term->slug);?>'><?php echo esc_html($term->name); ?></option>
                              <?php } ?>
                            <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <?php echo wp_kses_post($mt_addons_search_post); ?>
                    <input type="search" class="search-field form-control" id="datafetch" placeholder="<?php echo esc_html__( 'Find your course','modeltheme' );?>" value="<?php echo get_search_query();?>" name="s" onkeyup="fetch_products()" />
                    </div>
                    <div class="modeltheme-search-submit submit">
                        <button type="submit" class="form-control btn"><i class="fas fa-search"></i></button>
                    </div>
                    <?php if ($post_type == "product_cat") { ?>
                        <input type="hidden" name="post_type" value="product" />
                    <?php } else if ($post_type == "post_cat") { ?>
                        <input type="hidden" name="post_type" value="post" />
                    <?php } else { ?>
                        <input type="hidden" name="post_type" value="lp_course" />
                    <?php } ?>
                </form>
            </div>
        </div> 
        <?php
        add_action( 'wp_footer', 'mt_addons_search_form_ajax_fetch' );
        if (!function_exists('mt_addons_search_form_ajax_fetch')) {
            function mt_addons_search_form_ajax_fetch() { ?>
                <script type="text/javascript">
                    function fetch_products(){
                        jQuery.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'post',
                            data: { action: 'mt_addons_search_form_data_fetch', keyword: jQuery('#keyword').val() },
                            success: function(data) {
                                jQuery('#datafetch').html( data );
                            }
                        });
                    }
                </script>
              <?php
            }
        }
        // the ajax function
        if (!function_exists('mt_addons_search_form_data_fetch')) {
            function mt_addons_search_form_data_fetch(){
            if (  $_POST['keyword'] == null ) { die(); }
                    $the_query = new WP_Query( array( 
                        'post_type'      => 'product', 
                        'posts_per_page' => 4, 
                        's'              => sanitize_text_field( $_POST['keyword'] ) 
                    ) );
                    $count_tax = 0;
                    if( $the_query->have_posts() ) : ?>
                        <ul class="search-result">           
                            <?php while( $the_query->have_posts() ): $the_query->the_post();  $post_type = get_post_type_object( get_post_type() ); ?>   
                                <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'thumbnail' ); ?>             
                                <li>
                                    <a href="<?php echo esc_url( post_permalink() ); ?>">
                                        <?php if($thumbnail_src) { ?>
                                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                                        <?php } ?>
                                        <?php the_title(); ?>
                                    </a>
                                </li>             
                            <?php endwhile; ?>
                        </ul>       
                        <?php wp_reset_postdata();  
                    endif;
                die();
            }  
        }
        add_action('wp_ajax_mt_addons_search_form_data_fetch' , 'mt_addons_search_form_data_fetch');
        add_action('wp_ajax_nopriv_mt_addons_search_form_data_fetch', 'mt_addons_search_form_data_fetch');

    }

    protected function content_template() {}
}


