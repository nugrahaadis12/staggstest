<?php
class Modeltheme_Stacked_Photos extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-stacked-photos', plugin_dir_url( __FILE__ ).'css/stacked-photos.css');
        return [
            'modeltheme-stacked-photos',
        ];
    }

    public function get_name()
    {
        return 'mtfe-stacked-photos';
    }

    public function get_title()
    {
        return esc_html__('MT - Stacked Photos dasda', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-product-categories';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'stacked photos', 'photo' ];
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
            'gallery',
            [
                'label' => esc_html__( 'Add Images', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'show_label' => false,
                'default' => [],
            ]
        );
        $this->add_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 5,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-stacked-photos img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .modeltheme-stacked-photos img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'radius',
            [
                'label' => esc_html__( 'Radius', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-stacked-photos img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'margin',
            [
                'label' => esc_html__( 'Margin Left (-)', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-stacked-photos img:not(:first-child)' => 'margin-left: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .modeltheme-stacked-photos img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .modeltheme-stacked-photos img',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        ?>

        <div class="modeltheme-stacked-photos">
            <?php foreach ( $settings['gallery'] as $image ) { ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="title" />
            <?php } ?>
        </div>
        <?php
    }

    protected function content_template() {}
}


