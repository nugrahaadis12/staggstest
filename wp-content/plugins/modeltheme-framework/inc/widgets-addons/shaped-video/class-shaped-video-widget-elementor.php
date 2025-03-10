<?php
class Modeltheme_Shaped_Video extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-shaped-video', plugin_dir_url( __FILE__ ).'css/shaped-video.css');
        return [
            'modeltheme-shaped-video',
        ];
    }

    public function get_name()
    {
        return 'mtfe-shaped-video';
    }

    public function get_title()
    {
        return esc_html__('MT - Shaped Video', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-product-categories';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'shaped video', 'video' ];
    }

    protected function register_controls() {
        $this->all_controls();
    }

    private function all_controls() {
        $this->start_controls_section(
            'video_info',
            [
                'label'             => esc_html__('Content', 'modeltheme'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__( 'Choose Placeholder Image', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'shape',
            [
                'label' => esc_html__( 'Choose Shape', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'video_url',
            [
                'label'             => esc_html__( 'Video URL', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::URL,
                'options'           => [ 'url', 'is_external', 'nofollow' ],
                'default'           => [
                    'url'           => 'https://wildnest.modeltheme.com/wp-content/uploads/2024/05/a-cheerful-man-sitting-at-a-laptop-begins-to-laugh-2023-11-27-05-09-22-utc.mp4',
                    'is_external'   => true,
                    'nofollow'      => true,
                ],
                'label_block'       => true,
            ]
        );
        $this->add_control(
            'width',
            [
                'label'             => esc_html__( 'Width', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 0,
                'max'               => 9999,
                'step'              => 1,
                'default'           => 350,
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-shaped-video video' => 'width: {{VALUE}}px;',
                    '{{WRAPPER}} .modeltheme-shaped-video img' => 'width: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'height',
            [
                'label'             => esc_html__( 'Height', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 5,
                   'max'               => 9999,
                'step'              => 1,
                'default'           => 400,
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-shaped-video video' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .modeltheme-shaped-video img' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'mask_color',
            [
                'label'             => esc_html__( 'Mask Color', 'modeltheme' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .modeltheme-shaped-video img' => 'background: {{VALUE}} !important;',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $placeholder        = $settings['placeholder']['url'];
        $shape              = $settings['shape']['url'];
        $video_url          = $settings['video_url']['url'];
        $width              = $settings['width'];
        $height             = $settings['height'];


        ?>
        <div class="modeltheme-shaped-video">
            <video autoplay muted loop preload poster="<?php echo esc_url($placeholder); ?>">
              <source src="<?php echo esc_url($video_url); ?>" />
            </video>
        <img src="<?php echo esc_url($shape); ?>"></div>
        <?php
    }

    protected function content_template() {}
}


