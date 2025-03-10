<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Utils;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_category_card extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-category-card', MT_ADDONS_PUBLIC_ASSETS.'./css/category-card.css');
        return [
            'mt-addons-category-card',
        ];
    }

    public function get_name()
    {
        return 'mtfe-category-card';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Category Card', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-product-categories';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'category', 'card', 'highlight', 'custom' ];
    }

    protected function register_controls() {
        $this->section_category_card();
        $this->section_help_settings();
    }

    private function section_category_card() {
        $this->start_controls_section(
            'category_info',
            [
                'label'             => esc_html__('Category Info', 'mt-addons'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'category_title',
            [
                'label'             => esc_html__( 'Title', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( 'Backpacks', 'mt-addons' ),
                'placeholder'       => esc_html__( 'Type your title here', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Title Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-category-name' => 'color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->add_control(
            'products_number',
            [
                'label'             => esc_html__( 'No. Of Products', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 0,
                'max'               => 100000,
                'step'              => 1,
                'default'           => 10,
            ]
        );
        $this->add_control(
            'products_color',
                [
                'label'             => esc_html__( 'Products Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-category-count strong' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mt-addons-category-count' => 'color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->add_control(
            'card_link',
            [
                'label'             => esc_html__( 'Link', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::URL,
                'placeholder'       => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'options'           => [ 'url', 'is_external', 'nofollow' ],
                'default'           => [
                    'url'           => '#',
                    'is_external'   => true,
                    'nofollow'      => true,
                ],
                'label_block'       => true,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'              => 'card_background',
                'label'             => esc_html__( 'Background', 'mt-addons' ),
                'types'             => [ 'classic', 'gradient', 'video' ],
                'selector'          => '{{WRAPPER}} .mt-addons-card-content',
                'default'           => 'classic',
            ]
        );
        $this->add_control(
            'card_background_hover',
            [
                'label'             => esc_html__( 'Background Hover', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-category-overlay:hover' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#ffe2e2e6',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $card_link          = $settings['card_link']['url'];
        $category_title     = $settings['category_title'];
        $products_number    = $settings['products_number'];

        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_link_attributes( 'button_link', $settings['button_link'] );
        }

        ?>
        <div class="mt-addons-card-content">
            <a class="mt-addons-product-link" href="<?php echo esc_url($card_link); ?>">
                <span class="mt-addons-category-overlay">
                    <span class="mt-addons-category-name"><?php echo esc_html($category_title); ?></span>
                    <span class="mt-addons-category-count">
                        <strong>
                            <?php echo esc_attr($products_number); ?>
                        </strong>
                        <?php echo esc_html__('Items Available', 'mt-addons'); ?>
                    </span>
                </span>
            </a>
        </div>
        <?php
    }

    protected function content_template() {}
}

