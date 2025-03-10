<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_niche_categories extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-niche-categories', MT_ADDONS_PUBLIC_ASSETS.'css/niche-categories.css');
        return [
            'mt-addons-niche-categories',
        ];
    }

    public function get_name()
    {
        return 'mtfe-niche-categories';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__( 'MT - Niche categories', 'mt-addons' );
    }

    public function get_icon() {
        return 'eicon-circle';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'niche', 'categories', 'category' ];
    }

    protected function register_controls() {
        $this->section_niche_categories();
        $this->section_help_settings();
    }

    private function section_niche_categories() {
            $this->start_controls_section(
                'columns_section',
                [
                    'label'             => esc_html__( 'Layout of cards', 'mt-addons' ),
                    'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'padding_card',
                [
                    'label'             => esc_html__( 'Padding card', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'        => [ 'px', '%', 'em' ],
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-card-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'border-radius',
                [
                    'label'             => esc_html__( 'Border Radius', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'        => [ 'px', '%', 'em' ],
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-card-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'padding_title',
                [
                    'label'             => esc_html__( 'Padding Title', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'        => [ 'px', '%', 'em' ],
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-card-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'columns',
                [
                    'label'             => esc_html__( 'Nr. Of Columns', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::SELECT,
                    'options'           => [
                        ''                                        => esc_html__( 'Default', 'mt-addons' ),
                        'col-12 col-sm-12 col-md-12 col-lg-12'    => esc_html__( '1', 'mt-addons' ),
                        'col-12 col-sm-12 col-md-6 col-lg-6'      => esc_html__( '2', 'mt-addons' ),
                        'col-12 col-sm-12 col-md-4 col-lg-4'      => esc_html__( '3', 'mt-addons' ),
                        'col-12 col-sm-12 col-md-3 col-lg-3'      => esc_html__( '4', 'mt-addons' ),
                        'col-12 col-sm-12 col-md-2 col-lg-2'      => esc_html__( '6', 'mt-addons' ),                  
                    ],
                    'default'           => 'col-12 col-sm-12 col-md-3 col-lg-3',
                ]
            );
            $this->end_controls_section();
            $this->start_controls_section(
                'repeater_section',
                [
                    'label'             => esc_html__( 'List', 'mt-addons' ),
                    'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label'             => esc_html__( 'Color', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::COLOR,
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-card-title' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'image_section',
                [
                    'label'             => esc_html__( 'Choose Image', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::MEDIA,
                    'default'           => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                'card_link',
                [
                    'label'             => esc_html__( 'Link', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::URL,
                    'placeholder'       => esc_html__( 'https://your-link.com', 'mt-addons' ),
                    'options'           => [ 'url', 'is_external', 'nofollow' ],
                    'default'           => [
                        'url'           => '',
                        'is_external'   => true,
                        'nofollow'      => true,
                    ],
                    'label_block'       => true,
                ]
            );
            $repeater->add_control(
                'main_title',
                [
                    'label'             => esc_html__( 'Title', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::TEXT,
                ]
            );
            $repeater->add_control(
                'card_color',
                [
                    'label'             => esc_html__( 'Background Card', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::COLOR,
                    'selectors'         => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}}',

                    ],
                    
                ]
            );
            $repeater->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'              => 'title_typography',
                    'selector'          => '{{WRAPPER}} .mt-addons-niche-categories-card-title',
                ]
            );
            $this->add_control(
                'list',
                [
                    'label'             => esc_html__( 'List Items', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::REPEATER,
                    'fields'            => $repeater->get_controls(),
                    'title_field'       => '',
                    'default'           => [
                        [
                            'main_title'        => esc_html__( 'Fashion', 'mt-addons' ),
                            'card_link'         => esc_attr( '#', 'mt-addons' ),
                            'card_color'        => esc_attr( '#7AB37F', 'mt-addons' ),
                        ],
                        [
                            'main_title'        => esc_html__( 'Electronics', 'mt-addons' ),
                            'card_link'         => esc_attr( '#', 'mt-addons' ),
                            'card_color'        => esc_attr( '#C8C6BD', 'mt-addons' ),
                        ],                        
                        [
                            'main_title'        => esc_html__( 'Toys & Games', 'mt-addons' ),
                            'card_link'         => esc_attr( '#', 'mt-addons' ),
                            'card_color'        => esc_attr( '#DE8D0C', 'mt-addons' ),
                        ],
                        [
                            'main_title'        => esc_html__( 'Sunglasses', 'mt-addons' ),
                            'card_link'         => esc_attr( '#', 'mt-addons' ),
                            'card_color'        => esc_attr( '#EBCC09', 'mt-addons' ),
                        ],
                    ],
                ]
            );
            $this->end_controls_section();

            $this->start_controls_section(
                'section_image',
                [
                    'label'             => esc_html__( 'Image options', 'mt-addons' ),
                    'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'image_size',
                [
                    'label'             => esc_html__( 'Image size', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::SLIDER,
                    'size_units'        => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'range'             => [
                        'px'            => [
                            'min'           => 0,
                            'max'           => 1000,
                            'step'          => 5,
                        ],
                        '%'             => [
                            'min'           => 0,
                            'max'           => 100,
                        ],
                    ],
                    'default'           => [
                        'unit'              => 'px',
                        'size'              => 80,
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-image-section' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'image_bottom',
                [
                    'label'             => esc_html__( 'Image bottom', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::NUMBER,
                    'default'           => esc_html__( '-10', 'mt-addons' ),
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-image-section' => 'bottom: {{VALUE}}px',
                    ],
                ]
            );
            $this->add_control(
                'image_right',
                [
                    'label'             => esc_html__( 'Image right', 'mt-addons' ),
                    'type'              => \Elementor\Controls_Manager::NUMBER,
                    'default'           => esc_html__( '-5', 'mt-addons' ),
                    'selectors'         => [
                        '{{WRAPPER}} .mt-addons-niche-categories-image-section' => 'right: {{VALUE}}px',
                    ],
                ]
            );
            $this->end_controls_section();
        }
        protected function render() {
            $settings       = $this->get_settings_for_display();
            $list           = $settings['list'];
            $image_size     = $settings['image_size'];
            $image_bottom   = $settings['image_bottom'];
            $image_right    = $settings['image_right'];
            $columns        = $settings['columns'];
        ?>
        <div class="mt-addons-niche-categories-gallery_columns mtfe-row">
            <?php foreach (  $list as $item ) {
                $main_title  = $item['main_title'];
                $card_link   = $item['card_link']['url'];
                $card_color  = $item['card_color'];

                $image_section = $item['image_section']['url']; 
                $img_atts = wp_get_attachment_image_src( $image_section, 'thumbnail' );
                if ( ! empty( $item['card_link']['url'] ) ) {
                    $this->add_link_attributes( 'card_link', $item['card_link'] );
                } ?>
                <a id="mt-addons-niche-categories" href="<?php echo esc_url($card_link); ?>" class="<?php echo esc_attr($columns); ?>">
                    <div class="mt-addons-niche-categories-card-container elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                        <div class="mt-addons-niche-categories-card-title">
                            <?php echo esc_html($main_title); ?>
                        </div>
                        <div class="mt-addons-niche-categories-image-section">
                            <div class="mt-addons-niche-categories-card-img-wrapper">
                                <img src="<?php echo esc_url($image_section); ?>" alt="<?php echo esc_attr($main_title); ?>" />
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php
    }

    protected function content_template() {}
}