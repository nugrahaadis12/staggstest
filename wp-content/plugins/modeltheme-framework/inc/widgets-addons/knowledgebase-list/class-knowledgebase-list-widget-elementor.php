<?php
class Modeltheme_Knowledgebase_List extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-knowledgebase-list', plugin_dir_url( __FILE__ ).'css/knowledgebase-list.css');
        return [
            'modeltheme-knowledgebase-list',
        ];
    }

    public function get_name()
    {
        return 'modeltheme-knowledgebase-list';
    }

    public function get_title()
    {
        return esc_html__('MT - Knowledgebase List', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'knowledgebase list', 'list' ];
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
            'version',
            [
                'label' => esc_html__( 'Knowledgebase List version', 'modeltheme' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'description' => esc_html__( 'Choose the Knowledgebase List version', 'modeltheme' ),
                'options' => [
                    '1' => esc_html__( 'Version 1', 'modeltheme' ),
                    '2' => esc_html__( 'Version 2', 'modeltheme' ),
                ]
            ]
        );

        $knowledgebase_category_tax = get_terms('mt-knowledgebase-category');
        $knowledgebase_category = array();
        if ($knowledgebase_category_tax) {
            foreach ( $knowledgebase_category_tax as $term ) {
                $knowledgebase_category[$term->term_id] = $term->name;
            }
        }

        $this->add_control(
            'category_id',
            [
                'label' => esc_html__( 'Category', 'modeltheme' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'description' => esc_html__( 'Select the category', 'modeltheme' ),
                'options' => $knowledgebase_category,
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__( 'Knowledgebase Posts Number', 'modeltheme' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '5',
                'description' => esc_html__( 'Type here the number of Knowledgebase posts to be displayed', 'modeltheme' ),
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style', 'modeltheme' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'modeltheme' ),
                'selector' => '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-heading',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'label' => esc_html__( 'Item Typography', 'modeltheme' ),
                'selector' => '{{WRAPPER}} .modeltheme-post_title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-heading' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'item_color',
            [
                'label' => esc_html__( 'Item Color', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-post_title a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'List Icon Color', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-post_title i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'item_color_hover',
            [
                'label' => esc_html__( 'Item Color', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-post_title:hover a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-post_title:hover i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_text_hover',
            [
                'label' => esc_html__( 'Button Text Color Hover', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-count-link:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__( 'Button Bg Color Hover', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-count-link:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_border_hover',
            [
                'label' => esc_html__( 'Button Border Color Hover', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme_knowledge-list .modeltheme-count-link:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $category_id        = $settings['category_id'];
        $version            = $settings['version'];
        $number             = $settings['number'];

        $args_knowledgebase = array(
            'posts_per_page'   => $number,
            'post_type'        => 'mt-knowledgebase',
            'tax_query' => array(
                array(
                    'taxonomy' => 'mt-knowledgebase-category',
                    'field' => 'term_id',
                    'terms' => $category_id
                )
            ),
            'post_status' => 'publish'
        );

        $query_knowledgebase = new \WP_Query($args_knowledgebase);
        $category_term = get_term($category_id);

        if (is_wp_error($category_term)) {
            error_log($category_term->get_error_message());
            return;
        }

        if ($category_term && !is_wp_error($category_term)) {
            $category_title = $category_term->name;
        } else {
            error_log("The term with ID $category_id does not exist.");
            return;
        }

        ?>

        <div class="modeltheme_knowledge-list <?php echo esc_attr($version); ?>">
            <div class="modeltheme-heading-submenu">
                <h3 class="modeltheme-heading">
                    <?php if ($version == '2'): ?>
                        <a class="modeltheme-heading-link" href="<?php echo esc_url(get_term_link($category_term)); ?>">
                            <?php echo esc_html($category_title); ?>
                        </a>
                    <?php elseif ($version == '1'): ?>
                        <?php echo esc_html($category_title); ?>
                    <?php endif; ?>
                </h3>
                <ul class="modeltheme-submenu">
                    <?php if ($query_knowledgebase->have_posts()): ?>
                        <?php while ($query_knowledgebase->have_posts()): $query_knowledgebase->the_post(); ?>
                            <li class="modeltheme-post_title">
                                <i class="fas fa-file-alt"></i>
                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php echo esc_html(get_the_title()); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </ul>
            </div>

            <?php if ($version == '2'): ?>
                <?php $knowledgebase_count = $query_knowledgebase->post_count; ?>
                <a class="modeltheme-count-link" href="<?php echo esc_url(get_term_link($category_term)); ?>">
                    <?php echo sprintf(esc_html(_n('%s Article in this category', '%s Articles in this category', $knowledgebase_count, 'modeltheme')), number_format_i18n($knowledgebase_count)); ?>
                </a>
            <?php elseif ($version == '1'): ?>
                <a class="modeltheme-count-link" href="<?php echo esc_url(get_term_link($category_term)); ?>">
                    <?php esc_html_e('View all', 'modeltheme'); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php
    }

    protected function content_template() {

    }
}


