<?php
class Modeltheme_Knowledgebase_Search extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-knowledgebase-search', plugin_dir_url( __FILE__ ).'css/knowledgebase-search.css');
        return [
            'modeltheme-knowledgebase-search',
        ];
    }

    public function get_name() {
        return 'modeltheme-search-bar';
    }

    public function get_title() {
        return esc_html__('Knowledgebase - Search Bar', 'modeltheme');
    }

    public function get_icon() {
        return 'fab fa-elementor';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Content', 'modeltheme' ),
            ]
        );
        $this->add_responsive_control(
            'form_width',
            [
                'label' => esc_html__( 'Form Width', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 9999,
                'step' => 1,
                'default' => 'fit-content',
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-knowledge-search-input' => 'width: {{VALUE}}px',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .modeltheme-knowledge-search-input',
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-knowledge-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-knowledge-search form button i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__( 'Icon Color_Hover', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-knowledge-search form button:hover i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    }


    protected function render() {
        $settings         = $this->get_settings_for_display();
        
        ?>
        <div class="modeltheme-knowledge-search">
        <form role="search" method="get" id="modeltheme_knowledge_searchform" autocomplete="off" class="clearfix" action="<?php echo esc_url(get_site_url() ); ?>">
            <i class="fas fa-search knowledge-search-icon"></i>
            <input type="hidden" name="post_type" value="mt-knowledgebase">
            <input class="modeltheme-knowledge-search-input" placeholder="Search Knowledge Base" type="text" name="s" id="modeltheme_keyword" onkeyup="fetch()">
            <button type="submit" id="modeltheme_searchsubmit"><i class="fas fa-arrow-right"></i></button>
        </form>
        <div id="modeltheme_datafetch"></div> 
        </div>
        <?php
    }
    protected function _content_template() {

    }
}