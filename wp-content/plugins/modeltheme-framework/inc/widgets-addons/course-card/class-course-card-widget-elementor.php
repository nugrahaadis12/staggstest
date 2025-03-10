<?php
class Modeltheme_Course_Card extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-course-card', plugin_dir_url( __FILE__ ).'css/course-card.css');
        return [
            'modeltheme-course-card',
        ];
    }
    public function get_name()
    {
        return 'mtfe-course-card';
    }

    public function get_title()
    {
        return esc_html__('MT - Course Card', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'course-card', 'modeltheme-course-card' ];
    }

    protected function register_controls() {
        $this->all_controls();
    }
    private function all_controls() {
        $this->start_controls_section(
            'card_info',
            [
                'label'             => esc_html__('Content', 'modeltheme'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'card_url',
            [
                'label'             => esc_html__( 'URL', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::URL,
                'options'           => [ 'url', 'is_external', 'nofollow' ],
                'default'           => [
                    'url'           => '',
                    'is_external'   => true,
                    'nofollow'      => true,
                ],
                'label_block'       => true,
            ]
        );
        $this->add_control(
            'image',
            [
                'label'             => esc_html__( 'Choose Image', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::MEDIA,
                'default'           => [
                    'url'           => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label'             => esc_html__( 'Title', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( 'Default title', 'modeltheme' ),
                'placeholder'       => esc_html__( 'Type your title here', 'modeltheme' ),
            ]
        );
        $this->add_control(
            'price',
            [
                'label'             => esc_html__( 'Price', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( '$35 / 20 hours', 'modeltheme' ),
                'placeholder'       => esc_html__( 'Type your price here', 'modeltheme' ),
            ]
        );
        $this->add_control(
            'lessons',
            [
                'label'             => esc_html__( 'Lessons No.', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 0,
                'max'               => 99999,
                'step'              => 1,
                'default'           => 35,
            ]
        );
        $this->add_control(
            'students',
            [
                'label'             => esc_html__( 'Students No.', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 0,
                'max'               => 99999,
                'step'              => 1,
                'default'           => 35,
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'card_style',
            [
                'label'             => esc_html__('Style', 'modeltheme'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'card_padding',
            [
                'label' => esc_html__( 'Padding', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default' => [
                    'top' => 35,
                    'right' => 35,
                    'bottom' => 35,
                    'left' => 35,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-course-card-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'title_typography',
                'label'             => esc_html__('Title Tipography', 'modeltheme'),
                'selector'          => '{{WRAPPER}} .modeltheme-course-info-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'price_typography',
                'label'             => esc_html__('Price Tipography', 'modeltheme'),
                'selector'          => '{{WRAPPER}} .modeltheme-course-info-price',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'stats_typography',
                'label'             => esc_html__('Stats Tipography', 'modeltheme'),
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-course-lessons',
                    '{{WRAPPER}} .modeltheme-course-lessons i',
                    '{{WRAPPER}} .modeltheme-course-students',
                    '{{WRAPPER}} .modeltheme-course-students i',
                ]
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Title Color', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-course-info-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'price_color',
            [
                'label'             => esc_html__( 'Price Color', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-course-info-price' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'stats_color',
            [
                'label'             => esc_html__( 'Stats Color', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-course-lessons'  => 'color: {{VALUE}}',
                    '{{WRAPPER}} .modeltheme-course-students' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'card_color',
            [
                'label'             => esc_html__( 'Card Color', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-course-card-wrapper' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'card_color_hover',
            [
                'label'             => esc_html__( 'Card Color Hover', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .modeltheme-course-card-wrapper:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $card_url           = $settings['card_url']['url'];
        $image              = $settings['image']['url'];
        $title              = $settings['title'];
        $price              = $settings['price'];
        $lessons            = $settings['lessons'];
        $students           = $settings['students'];


        ?>

        <a href="<?php echo esc_url($card_url); ?>" class="modeltheme-course-card">
            <div class="modeltheme-course-card-wrapper">
                <div class="modeltheme-course-img">
                    <img src="<?php echo esc_url($image); ?>">
                </div>
                <div class="modeltheme-course-info">
                    <p class="modeltheme-course-info-price"><?php echo esc_html($price) ;?></p>
                    <h2 class="modeltheme-course-info-title"><?php echo esc_html($title); ?></h2>
                    <div class="modeltheme-course-stats">
                        <span class="modeltheme-course-lessons">
                            <i class="far fa-file-alt"></i> <?php echo $lessons;?> <?php echo esc_html__('Lessons', 'modeltheme'); ?>
                        </span>
                        <span class="modeltheme-course-students">
                            <i class="fas fa-id-card"></i> <?php echo $students;?> <?php echo esc_html__('Students', 'modeltheme'); ?>
                        </span>
                    </div>
                </div>
            </div>
        </a>
       
        <?php
    }

    protected function content_template() {}
}


