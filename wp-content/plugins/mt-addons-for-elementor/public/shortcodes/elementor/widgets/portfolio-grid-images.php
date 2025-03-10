<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_portfolio_images extends Widget_Base {
    
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-portfolio-grid-images', MT_ADDONS_PUBLIC_ASSETS.'css/portfolio-grid-images.css');
        return [
            'mt-addons-portfolio-grid-images',
        ];
    }
    public function get_name() {
        return 'mtfe-portfolio-grid-images';
    }
    use ContentControlHelp;
    public function get_title() {
        return esc_html__('MT - Portfolio Grid Images','mt-addons');
    }
    public function get_icon() {
        return 'eicon-tabs';
    }
    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    } 

    protected function register_controls() {
        $this->section_portfolio_grid();
        $this->section_help_settings();
    }

    private function section_portfolio_grid() {
        $this->start_controls_section(
            'section_title',
            [
                'label'                 => esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'title',
            [
                'label'                 => esc_html__( 'Tab Title', 'mt-addons' ),
                'label_block'           => true,
                'type'                  => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'image_1', 
            [
                'label'                 => esc_html__( 'Image 1', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::MEDIA,
                'default'               => [
                    'url'               => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'image_1_url',
            [
                'label'                 => esc_html__( 'Image Url', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::URL,
                'options'               => [ 'url', 'is_external', 'nofollow' ],
                'default'               => [
                    'url'                   => '',
                    'is_external'           => true,
                    'nofollow'              => true,
                ],
                'label_block'           => true,
            ]
        );
        $repeater->add_control(
            'image_2', 
            [
                'label'                 => esc_html__( 'Image 2', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::MEDIA,
                'default'               => [
                    'url'               => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'image_2_url',
            [
                'label'                 => esc_html__( 'Image Url', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::URL,
                'options'               => [ 'url', 'is_external', 'nofollow' ],
                'default'               => [
                    'url'                   => '',
                    'is_external'           => true,
                    'nofollow'              => true,
                ],
                'label_block'           => true,
            ]
        );
        $repeater->add_control(
            'image_3', 
            [
                'label'                 => esc_html__( 'Image 3', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::MEDIA,
                'default'               => [
                    'url'               => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'image_3_url',
            [
                'label'                 => esc_html__( 'Image Url', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::URL,
                'options'               => [ 'url', 'is_external', 'nofollow' ],
                'default'               => [
                    'url'                   => '',
                    'is_external'           => true,
                    'nofollow'              => true,
                ],
                'label_block'           => true,
            ]
        );
        $repeater->add_control(
            'image_4', 
            [
                'label'                 => esc_html__( 'Image 4', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::MEDIA,
                'default'               => [
                    'url'               => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'image_4_url',
            [
                'label'                 => esc_html__( 'Image Url', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::URL,
                'options'               => [ 'url', 'is_external', 'nofollow' ],
                'default'               => [
                    'url'                   => '',
                    'is_external'           => true,
                    'nofollow'              => true,
                ],
                'label_block'           => true,
            ]
        );
        $this->add_control(
            'portfolio_category_tabs',
            [
                'label'                 => esc_html__('Tabs Items', 'mt-addons'),
                'type'                  => Controls_Manager::REPEATER,
                'fields'                => $repeater->get_controls(),
                'default'               => [
                    [
                        'title'         => esc_html__( 'Art Direction', 'mt-addons' ),
                        'tab_link'      => '#',
                    ],
                    [
                        'title'         => esc_html__( 'Ecommerce', 'mt-addons' ),
                        'tab_link'      => '#',
                    ],
                    [
                        'title'         => esc_html__( 'Branding', 'mt-addons' ),
                        'tab_link'      => '#',
                    ],
                    [
                        'title'         => esc_html__( 'Business Strategy', 'mt-addons' ),
                        'tab_link'      => '#',
                    ],
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'selector'              => '{{WRAPPER}} .mt-portfolio-grid-images-hover-target',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'                 => esc_html__( 'Color', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .mt-portfolio-grid-images-hover-target' => 'color: {{VALUE}}',
                ],
                'default'               => '#000000',
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'                 => esc_html__( 'Hover Color', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .mt-portfolio-grid-images-hover-target:hover' => 'color: {{VALUE}}',
                ],
                'default'               => '#DDD',
            ]
        );
        $this->add_control(
            'item_spacing',
            [
                'label'                 => esc_html__( 'Item Spacing', 'mt-addons' ),
                'type'                  => \Elementor\Controls_Manager::NUMBER,
                'min'                   => 1,
                'max'                   => 999,
                'step'                  => 1,
                'selectors'             => [
                    '{{WRAPPER}} .mt-portfolio-grid-images-hover-target' => 'margin-bottom: {{VALUE}}px',
                ],
                'default'               => 20,
            ]
        );
        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $portfolio_category_tabs = $settings['portfolio_category_tabs'];
        ?> 

        <div class='mt-portfolio-grid-image-cursor' id="mt-portfolio-grid-image-cursor"></div>
        <div class='mt-portfolio-grid-image-cursor2' id="mt-portfolio-grid-image-cursor2"></div>
        <div class='mt-portfolio-grid-image-cursor3' id="mt-portfolio-grid-image-cursor3"></div> 

        <div class="mt-portfolio-grid-images-section">
            <ul class="mt-portfolio-grid-images-case-study-wrapper"> 
                <?php if ($portfolio_category_tabs) { ?>
                    <?php foreach ($portfolio_category_tabs as $portfolio_tab) { 
                        $title  = $portfolio_tab['title'];
                        $url    = $portfolio_tab['tab_link']; ?>  
                        <li class="mt-portfolio-grid-images-name">
                            <a href="#" class="mt-portfolio-grid-images-hover-target"><?php echo esc_html($title);?></a>
                        </li> 
                    <?php } ?>
                <?php } ?>
            </ul>

            <ul class="mt-portfolio-grid-images">
                <?php if ($portfolio_category_tabs) { ?>
                    <?php foreach ($portfolio_category_tabs as $portfolio_tab) { 
                        $image_1        = $portfolio_tab['image_1']['url'];
                        $image_1_url    = $portfolio_tab['image_1_url']['url'];
                        $image_2        = $portfolio_tab['image_2']['url'];
                        $image_2_url    = $portfolio_tab['image_2_url']['url'];
                        $image_3        = $portfolio_tab['image_3']['url'];
                        $image_3_url    = $portfolio_tab['image_3_url']['url'];
                        $image_4        = $portfolio_tab['image_4']['url'];
                        $image_4_url    = $portfolio_tab['image_4_url']['url'];

                        if ( ! empty( $portfolio_tab['image_url_1']['url'] ) ) {
                            $this->add_link_attributes( 'image_url_1', $portfolio_tab['image_url_1'] );
                        }
                        if ( ! empty( $portfolio_tab['image_url_2']['url'] ) ) {
                            $this->add_link_attributes( 'image_url_2', $portfolio_tab['image_url_2'] );
                        }
                          if ( ! empty( $portfolio_tab['image_url_3']['url'] ) ) {
                            $this->add_link_attributes( 'image_url_3', $portfolio_tab['image_url_3'] );
                        }
                          if ( ! empty( $portfolio_tab['image_url_4']['url'] ) ) {
                            $this->add_link_attributes( 'image_url_4', $portfolio_tab['image_url_4'] );
                        }
                        ?>
                        <li>
                            <div class="mt-portfolio-grid-images-hero">
                                <a href="<?php echo esc_url($image_1_url); ?>">
                                    <img src="<?php echo esc_url($image_1); ?>" alt='<?php echo esc_html($title); ?>'>
                                </a> 
                                <a href="<?php echo esc_url($image_2_url); ?>">
                                    <img src="<?php echo esc_url($image_2); ?>" alt='<?php echo esc_html($title); ?>'>
                                </a> 
                                <a href="<?php echo esc_url($image_3_url); ?>">
                                    <img src="<?php echo esc_url($image_3); ?>" alt='<?php echo esc_html($title); ?>'>
                                </a> 
                                <a href="<?php echo esc_url($image_4_url); ?>">
                                    <img src="<?php echo esc_url($image_4); ?>" alt='<?php echo esc_html($title); ?>'>
                                </a> 
                            </div> 
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>   
        </div>
    <?php }
    protected function content_template() {

    }
}