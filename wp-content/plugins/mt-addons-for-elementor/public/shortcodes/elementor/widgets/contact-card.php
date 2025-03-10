<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_contact_card extends Widget_Base {
    
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-contact-card', MT_ADDONS_PUBLIC_ASSETS.'css/contact-card.css');
        return [
            'mt-addons-contact-card',
        ];
    }

    public function get_name()
    {
        return 'mtfe-contact-card';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Contact Card', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-menu-card';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'card', 'service', 'contact', 'custom' ];
    }

    protected function register_controls() {
        $this->section_contact_card();
        $this->section_help_settings();
    }

    private function section_contact_card() {

        $this->start_controls_section(
            'content_section',
            [
                'label'             => esc_html__( 'Card', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'image',
            [
                'label'             => esc_html__( 'Choose Image', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::MEDIA,
                'default'           => [
                    'url'           => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'              => 'thumbnail',
                'exclude'           => [],
                'include'           => [],
                'default'           => 'full',
            ]
        );
        $this->add_control(
            'width',
            [
                'label' => esc_html__( 'Image Width', 'mt-addons' ),
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
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-contact-card-img-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'text-align',
            [
                'label' => esc_html__( 'Alignment', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'mt-addons' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-contact-card-list ul' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .mt-addons-contact-card-list-item a' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .mt-addons-contact-card-list-item a' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'layout',
            [
                'label'             => esc_html__( 'Layout', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SELECT,
                'options'           => [
                    'left'          => esc_html__( 'Left', 'mt-addons' ),
                    'full'          => esc_html__( 'Full', 'mt-addons' ),
                ],
                'default'           => 'left',
            ]
        );
        $this->add_control(
            'card_color',
            [
                'label'             => esc_html__( 'Background', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-contact-card-content' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        );
        $this->add_control(
            'card_padding',
            [
                'label'             => esc_html__( 'Card Padding', 'mt-addons' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', '%', 'em'],
                'default'           => [
                    'top'               => 10,
                    'right'             => 15,
                    'bottom'            => 10,
                    'left'              => 15,
                    'unit'              => 'px',
                    'isLinked'      => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-addons-contact-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'box_shadow',
                'label'             => esc_html__( 'Box Shadow', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mt-addons-card-content',
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
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'show_title',
            [
                'label'             => esc_html__( 'Show Title', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SELECT,
                'default'           => 'show',
                'options'           => [
                    'show'          => esc_html__( 'Show', 'mt-addons' ),
                    'hide'          => esc_html__( 'Hide', 'mt-addons' ),
                ],
            ]
        );
        $repeater->add_control (
            'title', [
                'label'             => esc_html__( 'Title', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( 'Contact Information' , 'mt-addons' ),
                'label_block'       => true,
            ]
        );
        $repeater->add_control (
            'title_tag',
            [
                'label'             => esc_html__('Title Tag', 'mt-addons'),
                'label_block'       => true,
                'type'              => \Elementor\Controls_Manager::SELECT,
                'options'           => [
                    ''              => esc_html__('Select', 'mt-addons'),
                    'h1'            => 'H1',
                    'h2'            => 'H2',
                    'h3'            => 'H3',
                    'h4'            => 'H4',
                    'h5'            => 'H5',
                    'h6'            => 'H6',
                ],
                'default'           => 'h2',
            ]
        );
        $repeater->add_control(
            'title_url',
            [
                'label'             => esc_html__( 'Title Link', 'mt-addons' ),
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
        $repeater->add_control(
            'subtitle', [
                'label'             => esc_html__( 'Subtitle', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( 'List Subtitle' , 'mt-addons' ),
                'label_block'       => true,
            ]
        );
        $repeater->add_control(
            'subtitle_url',
            [
                'label'             => esc_html__( 'Subtitle Link', 'emt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'input_type'        => 'text',
                'placeholder'       => esc_html__( 'https://your-link.com', 'mt-addons' ),
            ]
        );
        $repeater->add_control(
            'subtitle_color_repeater',
            [
                'label' => esc_html__( 'Subtitle Color', 'mt-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                ],
                'default' => '#4C4C4C',
            ]
        );
        $repeater->add_control(
            'show_icon',
            [
                'label'             => esc_html__( 'Show Icon', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SELECT,
                'default'           => 'show',
                'options'           => [
                    'show'          => esc_html__( 'Show', 'mt-addons' ),
                    'hide'          => esc_html__( 'Hide', 'mt-addons' ),
                ],
            ]
        );
        $repeater->add_control(
            'icon',
            [
                'label'             => esc_html__( 'Icon', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::ICONS,
                'default'           => [
                    'value'         => 'fas fa-circle',
                    'library'       => 'solid',
                ],
            ]
        );
        $this->add_control(
            'list',
            [
                'label'             => esc_html__( 'List Items', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::REPEATER,
                'fields'            => $repeater->get_controls(),
                    'default'       => [
                    [
                        'show_title'    => esc_html__( 'show', 'mt-addons' ),
                        'title'         => esc_html__( 'Contact Information', 'mt-addons' ),
                        'subtitle'      => esc_html__( 'Company: XYZ Marketing Solutions', 'mt-addons' ),
                    ],
                    [
                        'show_title'    => esc_html__( 'hide', 'mt-addons' ),
                        'title'         => esc_html__( '', 'mt-addons' ),
                        'subtitle'      => esc_html__( 'Phone: (555) 123-4567', 'mt-addons' ),
                    ],
                    [
                        'show_title'    => esc_html__( 'hide', 'mt-addons' ),
                        'title'         => esc_html__( '', 'mt-addons' ),
                        'subtitle'      => esc_html__( 'Address: 123 Main Street, Cityville,', 'mt-addons' ),
                    ],
                    [
                        'show_title'    => esc_html__( 'show', 'mt-addons' ),
                        'title'         => esc_html__( 'Social Media', 'mt-addons' ),
                        'subtitle'      => esc_html__( 'LinkedIn: linkedin.com/in/johndoe', 'mt-addons' ),
                    ],
                    [
                        'show_title'    => esc_html__( 'hide', 'mt-addons' ),
                        'title'         => esc_html__( '', 'mt-addons' ),
                        'subtitle'      => esc_html__( 'Twitter: @johndoe', 'mt-addons' ),
                    ],  
                ],
                'title_field'       => '',
            ]
        );
        $this->add_control(
            'list_padding',
            [
                'label'             => esc_html__( 'Padding', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default'           => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 15,
                    'bottom'        => 0,
                    'left'          => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-contact-card-list-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'item_margin',
            [
                'label'             => esc_html__( 'Margin', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default'           => [
                    'unit'          => 'px',
                    'top'           => 0,
                    'right'         => 0,
                    'bottom'        => 10,
                    'left'          => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-addons-contact-card-text-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Title Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-contact-card-list-title' => 'color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'title_typography',
                'label'             => esc_html__( 'Title Typography', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mt-addons-contact-card-list-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'content_typography',
                'label'             => esc_html__( 'Subtitle Typography', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mt-addons-contact-card-list-text',
            ]
        );
        $this->add_control(
            'icon_size',
            [
                'label'             => esc_html__( 'Icon Size', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 1,
                'max'               => 100,
                'step'              => 1,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-contact-card-list-icon' => 'font-size: {{VALUE}}px;',
                ],
                'default'           => 6,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'             => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-contact-card-list-icon' => 'color: {{VALUE}}',
                ],
                'default'           => '#3147FF',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $layout     = $settings['layout'];
        $list       = $settings['list'];

        if ( ! empty( $settings['title_url']['url'] ) ) {
            $this->add_link_attributes( 'title_url', $settings['title_url'] );
        }

        if($layout == "left" || $layout == "") {
            $class_img = "col-md-4 col-sm-12 mt-addons-left-layout";
            $class_txt = "col-md-8 col-sm-12 mt-addons-left-layout";
        } else if ($layout == "full"){
            $class_img = "col-12 mt-addons-full-layout";
            $class_txt = "col-12 mt-addons-full-layout";
        }
        ?>

        <div class="mt-addons-contact-card mtfe-container">
            <div class="mt-addons-contact-card-content mtfe-row">
                <div class="<?php echo esc_attr($class_img); ?> mt-addons-thumb-img">
                    <div class="mt-addons-contact-card-img-wrapper">
                        <?php echo wp_kses_post(\Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' )); ?>
                    </div>
                </div>
                <div class="<?php echo esc_attr($class_txt); ?> mt-addons-contact-card-list-section">
                    <div class="mt-addons-contact-card-list">
                        <ul class="mt-addons-contact-card-list-group">
                            <?php foreach (  $list as $card ) {
                                $subtitle       = $card['subtitle'];
                                $icon           = $card['icon']['value'];
                                $subtitle_url   = $card['subtitle_url'];
                                $show_title     = $card['show_title'];
                                $title          = $card['title'];
                                $title_tag      = $card['title_tag'];
                                $show_icon      = $card['show_icon'];

                                if($show_icon == "show" ||$show_icon == "") {
                                    $icon_visible = "d-inline-block";
                                }else if ($show_icon == "hide"){
                                    $icon_visible = "d-none";
                                }

                                if($show_title == "show" ||$show_title == "") {
                                    $title_visible = "d-block";
                                }else if ($show_title == "hide"){
                                    $title_visible = "d-none";
                                }

                                if ($subtitle_url) {
                                    $subtitle_url_attribute = 'href="' . esc_url($subtitle_url) . '"';
                                } else {
                                    $subtitle_url_attribute = '';
                                }
                                ?>
                                <li class="mt-addons-contact-card-list-item">
                                    <a class="<?php echo esc_attr($title_visible); ?>" <?php echo wp_kses($this->get_render_attribute_string( 'title_url' ), 'link'); ?>>
                                        <<?php echo Utils::validate_html_tag( $title_tag ); ?> class="mt-addons-contact-card-list-title">
                                            <?php echo esc_html($title); ?>
                                        </<?php echo Utils::validate_html_tag( $title_tag ); ?>>
                                    </a>
                                    <a class="mt-addons-contact-card-text-item elementor-repeater-item-<?php echo esc_attr($card['_id'])?>" <?php echo htmlspecialchars($subtitle_url_attribute); ?>>
                                        <i class="mt-addons-contact-card-list-icon <?php echo esc_attr($icon_visible); ?> <?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                                        <span class="mt-addons-contact-card-list-text"><?php echo esc_html($subtitle); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}